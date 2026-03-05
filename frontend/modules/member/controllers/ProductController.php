<?php

namespace frontend\modules\member\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use common\models\Products;
use common\models\UmkmProfile;

class ProductController extends Controller
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
            Yii::$app->session->setFlash('error', 'Silakan lengkapi profil toko Anda terlebih dahulu.');
            return $this->redirect(['/member/profile/update']);
        }

        $dataProvider = new ActiveDataProvider([
            'query' => Products::find()->where(['umkm_profile_id' => $profile->id]),
            'sort' => ['defaultOrder' => ['created_at' => SORT_DESC]],
            'pagination' => ['pageSize' => 10],
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'profile' => $profile
        ]);
    }

    public function actionCreate()
    {
        $profile = $this->getOwnProfile();
        
        $model = new Products();
        $model->umkm_profile_id = $profile->id;

        if ($model->load(Yii::$app->request->post())) {
            
            // Cek jika UMKM belum diverifikasi oleh admin
            if ($profile->status_verifikasi != 1) { // 1 = Disetujui
                Yii::$app->session->setFlash('warning', 'Toko Anda belum diverifikasi oleh Admin DINKOP. Produk Anda akan otomatis berstatus Draf.');
                $model->status = 0; // 0 = Draft
            } else {
                $model->status = 1; // 1 = Terbit/Aktif
            }

            // Generate Slug & Timestamp
            $model->slug = \yii\helpers\Inflector::slug($model->name) . '-' . time();
            $model->created_at = time();
            $model->updated_at = time();

            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Produk berhasil ditambahkan ke Etalase!');
                return $this->redirect(['index']);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = Products::findOne(['id' => $id, 'umkm_profile_id' => $this->getOwnProfile()->id]);

        if ($model->load(Yii::$app->request->post())) {
            $model->slug = \yii\helpers\Inflector::slug($model->name) . '-' . $model->id;
            $model->updated_at = time();

            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Perubahan produk berhasil disimpan.');
                return $this->redirect(['index']);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionDelete($id)
    {
        $model = Products::findOne(['id' => $id, 'umkm_profile_id' => $this->getOwnProfile()->id]);
        if($model){
            $model->delete();
            Yii::$app->session->setFlash('success', 'Produk berhasil dihapus dari Etalase.');
        }

        return $this->redirect(['index']);
    }

}
