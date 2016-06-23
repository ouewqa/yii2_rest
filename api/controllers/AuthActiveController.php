<?php
/**
 * Created by PhpStorm.
 * User: yuyj
 * Date: 2016-06-23
 * Time: 14:59
 */

namespace api\controllers;

use yii\rest\ActiveController;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBearerAuth;


class AuthActiveController extends ActiveController
{
    public function checkAccess($action, $model = null, $params = [])
    {
        //throw new ForbiddenHttpException();
    }

    public function behaviors()
    {
        $behaviors = parent::behaviors();

        //开启oauth授权验证
        $behaviors['authenticator'] = [
            'class' => CompositeAuth::className(),
            'authMethods' => [
                //HttpBasicAuth::className(),
                HttpBearerAuth::className(),
                //QueryParamAuth::className(),
            ],
        ];

        //开启请求频率限制
        $behaviors['rateLimiter']['enableRateLimitHeaders'] = true;

        return $behaviors;
    }
}