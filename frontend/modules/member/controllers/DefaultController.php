<?php

namespace frontend\modules\member\controllers;

use yii\web\Controller;
use yii\filters\AccessControl;

/**
 * Default controller for the `member` module
 */
class DefaultController extends Controller
{
    public $layout = 'main';

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

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $profile = \common\models\UmkmProfile::findOne(['user_id' => \Yii::$app->user->id]);
        $totalProducts = 0;
        
        if ($profile) {
            $totalProducts = \common\models\Products::find()->where(['umkm_profile_id' => $profile->id])->count();
        }

        return $this->render('index', [
            'profile' => $profile,
            'totalProducts' => $totalProducts,
        ]);
    }
}
