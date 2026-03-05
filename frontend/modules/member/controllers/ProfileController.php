<?php

namespace frontend\modules\member\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use common\models\UmkmProfile;

class ProfileController extends Controller
{
    public $layout = 'main'; // Menggunakan layout Dasbor khusus

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
        ];
    }

    public function actionIndex()
    {
        $profile = UmkmProfile::findOne(['user_id' => Yii::$app->user->id]);
        return $this->render('index', [
            'model' => $profile
        ]);
    }

    public function actionUpdate()
    {
        $model = UmkmProfile::findOne(['user_id' => Yii::$app->user->id]);
        
        if (!$model) {
            Yii::$app->session->setFlash('error', 'Profil UMKM belum terbentuk.');
            return $this->redirect(['/member/default/index']);
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Profil Berhasil Diperbarui!');
            return $this->redirect(['index']); // Kembali ke halaman info/view profile
        }

        return $this->render('update', [
            'model' => $model
        ]);
    }
}
