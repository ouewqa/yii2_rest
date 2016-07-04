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

/**
 * Class AuthActiveController
 * @package api\controllers
 */
class AuthActiveController extends ActiveController
{
    /**
     * 如果不允许用户访问，返回ForbiddenHttpException异常
     * @param string $action
     * @param null $model
     * @param array $params
     */
    public function checkAccess($action, $model = null, $params = [])
    {
        parent::checkAccess($action, $model, $params);
        //throw new ForbiddenHttpException();
    }

    /**
     * @return array
     */
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