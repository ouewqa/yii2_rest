<?php
namespace api\models;

use yii;
use common\models\User as BaseUser;

/**
 * @property mixed allowance
 * @property mixed allowance_updated_at
 */
class User extends BaseUser implements yii\filters\RateLimitInterface
{
    public $rateLimit = 100;

    /**
     * 只返回指定字段
     * @inheritdoc
     * @return array
     */
    public function fields()
    {
        return [
            'id', 'username', 'email'
        ];
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['auth_key' => $token]);
    }

    public function getRateLimit($request, $action)
    {
        return [$this->rateLimit, 60]; // 限制在1秒内可以请求 $this->rateLimit 次
    }

    public function loadAllowance($request, $action)
    {
        return [$this->allowance, $this->allowance_updated_at];
    }

    /**
     * 保存到user表
     * @param yii\web\Request $request
     * @param yii\base\Action $action
     * @param int $allowance
     * @param int $timestamp
     */
    public function saveAllowance($request, $action, $allowance, $timestamp)
    {
        $this->allowance = $allowance;
        $this->allowance_updated_at = $timestamp;
        $this->save();
    }
}
