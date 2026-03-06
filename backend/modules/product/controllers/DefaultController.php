<?php

namespace backend\modules\product\controllers;

use yii\web\Controller;

/**
 * Default controller for the `product` module
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
                        'roles' => ['@'], // Admin Dinkop
                    ],
                ],
            ],
            'verbs' => [
                'class' => \yii\filters\VerbFilter::class,
                'actions' => [
                    'set-status' => ['POST'],
                    'toggle-featured' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Renders the review view for the module
     * @return string
     */
    public function actionReview()
    {
        $searchModel = new \common\models\ProductsSearch();
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);
        
        // Ensure eager loading to prevent N+1 queries
        $dataProvider->query->with(['category', 'umkmProfile']);
        
        // If not searching, default to sort by pending first, then newest
        if (empty(\Yii::$app->request->queryParams['ProductsSearch'])) {
            $dataProvider->query->orderBy([
                'status' => SORT_ASC, // 0 = pending, 1 = active, 2 = rejected
                'created_at' => SORT_DESC
            ]);
        }

        return $this->render('review', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Approves or rejects a product
     */
    public function actionSetStatus($id, $status)
    {
        $model = $this->findModel($id);
        
        // Validate status: 1 = Approve, 2 = Reject
        if (in_array($status, [1, 2])) {
            $model->status = $status;
            if ($model->save(false)) {
                $msg = $status == 1 ? 'disetujui' : 'ditolak';
                \Yii::$app->session->setFlash('success', "Produk berhasil $msg.");
            } else {
                \Yii::$app->session->setFlash('error', 'Gagal memperbarui status produk.');
            }
        }
        
        return $this->redirect(\Yii::$app->request->referrer ?: ['review']);
    }

    /**
     * Toggles the featured status of a product
     */
    public function actionToggleFeatured($id)
    {
        $model = $this->findModel($id);
        
        if ($model->status != 1) {
            \Yii::$app->session->setFlash('warning', 'Hanya produk aktif yang dapat dijadikan Unggulan.');
            return $this->redirect(\Yii::$app->request->referrer ?: ['review']);
        }

        $model->is_featured = $model->is_featured ? 0 : 1;
        
        if ($model->save(false)) {
            $msg = $model->is_featured ? 'ditambahkan ke' : 'dihapus dari';
            \Yii::$app->session->setFlash('success', "Produk berhasil $msg daftar Unggulan.");
        } else {
            \Yii::$app->session->setFlash('error', 'Gagal mengubah status unggulan produk.');
        }
        
        return $this->redirect(\Yii::$app->request->referrer ?: ['review']);
    }

    protected function findModel($id)
    {
        if (($model = \common\models\Products::findOne($id)) !== null) {
            return $model;
        }

        throw new \yii\web\NotFoundHttpException('The requested page does not exist.');
    }
}
