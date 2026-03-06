<?php

namespace backend\modules\umkm\controllers;

use yii\web\Controller;

/**
 * Default controller for the `umkm` module
 */
class DefaultController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'], // pastikan admin
                    ],
                ],
            ],
            'verbs' => [
                'class' => \yii\filters\VerbFilter::class,
                'actions' => [
                    'approve' => ['POST'],
                    'reject' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all pending UmkmProfiles.
     */
    public function actionIndex()
    {
        $searchModel = new \common\models\UmkmProfileSearch();
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);
        
        // Force pending only for verification page
        $dataProvider->query->andWhere(['status_verifikasi' => 0]);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single UmkmProfile for review.
     */
    public function actionVerify($id)
    {
        $model = $this->findModel($id);
        
        if ($model->status_verifikasi != 0) {
            \Yii::$app->session->setFlash('warning', 'UMKM ini sudah diverifikasi sebelumnya.');
            return $this->redirect(['index']);
        }

        return $this->render('verify', [
            'model' => $model,
        ]);
    }

    public function actionApprove($id)
    {
        $model = $this->findModel($id);
        $model->status_verifikasi = 1;
        if ($model->save(false)) { // Save without validation if just updating status
            \Yii::$app->session->setFlash('success', 'UMKM berhasil disetujui.');
        } else {
            \Yii::$app->session->setFlash('error', 'Gagal menyetujui UMKM.');
        }
        return $this->redirect(['index']);
    }

    public function actionReject($id)
    {
        $model = $this->findModel($id);
        $model->status_verifikasi = 2; // Asumsi 2 adalah ditolak
        if ($model->save(false)) {
            \Yii::$app->session->setFlash('error', 'UMKM telah ditolak.');
        }
        return $this->redirect(['index']);
    }

    /**
     * Comprehensive Search page
     */
    public function actionData()
    {
        $searchModel = new \common\models\UmkmProfileSearch();
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);

        return $this->render('data', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Full Detail View
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    protected function findModel($id)
    {
        if (($model = \common\models\UmkmProfile::findOne($id)) !== null) {
            return $model;
        }

        throw new \yii\web\NotFoundHttpException('The requested page does not exist.');
    }
}
