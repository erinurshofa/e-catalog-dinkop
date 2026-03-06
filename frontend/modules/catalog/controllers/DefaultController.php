<?php

namespace frontend\modules\catalog\controllers;

use yii\web\Controller;

/**
 * Default controller for the `catalog` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $request = \Yii::$app->request;
        $searchQuery = $request->get('q');
        $categoryId = $request->get('category_id');

        $query = \common\models\Products::find()
            ->with(['productImages', 'category', 'umkmProfile'])
            ->where(['products.status' => 1]);

        if (!empty($searchQuery)) {
            $query->andFilterWhere(['like', 'products.name', $searchQuery]);
        }
        if (!empty($categoryId)) {
            $query->andFilterWhere(['products.category_id' => $categoryId]);
        }

        $dataProvider = new \yii\data\ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 12,
                'defaultPageSize' => 12,
                'route' => 'catalog/default/index',
                'params' => array_merge($_GET, ['q' => $searchQuery, 'category_id' => $categoryId]),
            ],
            'sort' => [
                'defaultOrder' => [
                    'created_at' => SORT_DESC,
                ]
            ],
        ]);

        $categories = \common\models\Categories::find()
            ->orderBy(['name' => SORT_ASC])
            ->all();

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchQuery' => $searchQuery,
            'categoryId' => $categoryId,
            'categories' => $categories,
        ]);
    }

    /**
     * Renders the product detail view
     * @param string $slug
     * @return string
     * @throws \yii\web\NotFoundHttpException if the product cannot be found
     */
    public function actionDetail($slug)
    {
        $product = \common\models\Products::find()
            ->with(['productImages', 'category', 'umkmProfile'])
            ->where(['slug' => $slug, 'status' => 1])
            ->one();

        if (!$product) {
            throw new \yii\web\NotFoundHttpException('Produk tidak ditemukan atau tidak aktif.');
        }

        // Increment view count
        $product->updateCounters(['view_count' => 1]);

        // Get related products from the same category
        $relatedProducts = \common\models\Products::find()
            ->with(['productImages', 'umkmProfile', 'category'])
            ->where(['category_id' => $product->category_id, 'status' => 1])
            ->andWhere(['!=', 'id', $product->id])
            ->limit(4)
            ->orderBy(['created_at' => SORT_DESC])
            ->all();

        return $this->render('detail', [
            'product' => $product,
            'relatedProducts' => $relatedProducts,
        ]);
    }
}
