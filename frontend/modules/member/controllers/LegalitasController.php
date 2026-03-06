<?php

namespace frontend\modules\member\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use common\models\UmkmLegalitas;
use common\models\UmkmProfile;
use yii\web\UploadedFile;

class LegalitasController extends Controller
{
    public $layout = 'main'; // Dasbor Khusus UMKM

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['umkm'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    protected function getOwnProfile()
    {
        return UmkmProfile::findOne(['user_id' => Yii::$app->user->id]);
    }

    public function actionIndex()
    {
        $profile = $this->getOwnProfile();
        if (!$profile) {
            Yii::$app->session->setFlash('error', 'Silakan lengkapi profil toko Anda terlebih dahulu sebelum mengunggah dokumen.');
            return $this->redirect(['/member/profile/update']);
        }

        $dataProvider = new ActiveDataProvider([
            'query' => UmkmLegalitas::find()->where(['umkm_profile_id' => $profile->id]),
            'sort' => ['defaultOrder' => ['created_at' => SORT_DESC]],
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCreate()
    {
        $profile = $this->getOwnProfile();
        if (!$profile) {
            return $this->redirect(['/member/profile/update']);
        }

        $model = new UmkmLegalitas();
        $model->umkm_profile_id = $profile->id;

        if ($model->load(Yii::$app->request->post())) {
            $model->file_upload = UploadedFile::getInstance($model, 'file_upload');
            
            if ($model->validate()) {
                if ($model->file_upload) {
                    $fileName = $profile->id . '_' . time() . '_' . preg_replace('/[^a-zA-Z0-9_-]/', '', $model->file_upload->baseName) . '.' . $model->file_upload->extension;
                    $uploadDir = Yii::getAlias('@frontend/web/uploads/legalitas/');
                    if (!is_dir($uploadDir)) {
                        mkdir($uploadDir, 0777, true);
                    }
                    $model->file_upload->saveAs($uploadDir . $fileName);
                    $model->file_path = 'uploads/legalitas/' . $fileName;
                }
                
                $model->created_at = time();
                $model->updated_at = time();
                $model->status = 0; // 0 = Menunggu Validasi

                if ($model->save(false)) { // Skip attribute validation to save custom fields
                    Yii::$app->session->setFlash('success', 'Dokumen Legalitas berhasil diunggah dan sedang dalam antrean verifikasi DINKOP.');
                    return $this->redirect(['index']);
                }
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionDelete($id)
    {
        $model = UmkmLegalitas::findOne(['id' => $id, 'umkm_profile_id' => $this->getOwnProfile()->id]);
        if ($model) {
            // Hapus file fisik jika ada
            if ($model->file_path && file_exists(Yii::getAlias('@frontend/web/') . $model->file_path)) {
                unlink(Yii::getAlias('@frontend/web/') . $model->file_path);
            }
            $model->delete();
            Yii::$app->session->setFlash('success', 'Dokumen Legalitas berhasil dihapus.');
        }

        return $this->redirect(['index']);
    }

}
