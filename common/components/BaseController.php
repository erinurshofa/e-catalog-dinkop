<?php

namespace common\components;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;

/**
 * BaseController for applying strict RBAC filters to modules.
 */
class BaseController extends Controller
{
    /**
     * Determines which role is required to access this controller's actions.
     * Override this in child classes.
     */
    protected $requiredRole = '@'; 

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => [$this->requiredRole],
                    ],
                ],
            ],
        ];
    }
}
