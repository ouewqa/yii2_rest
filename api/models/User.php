<?php
namespace api\models;

use yii;
use common\models\User as BaseUser;

/**
 * @property mixed allowance
 * @property mixed allowance_updated_at
 */
class User extends BaseUser implements yii\filters\RateLimitInterface, \OAuth2\Storage\UserCredentialsInterface
{
    /**
     * @var int
     */
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
     * rest oauth授权验证接口，如果使用　Filsh/yii2-oauth2-server　需要读取 oauth_users 表
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['auth_key' => $token]);
    }

    /**
     * @param yii\web\Request $request
     * @param yii\base\Action $action
     * @return array
     */
    public function getRateLimit($request, $action)
    {
        return [$this->rateLimit, 60]; // 限制在1秒内可以请求 $this->rateLimit 次
    }

    /**
     * @param yii\web\Request $request
     * @param yii\base\Action $action
     * @return array
     */
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

    /**
     * @param $username
     * @param $password
     * @return bool
     */
    public function checkUserCredentials($username, $password)
    {
        $user = static::findByUsername($username);
        if (empty($user)) {
            return false;
        }
        return $user->validatePassword($password);
    }

    /**
     * @param $username
     * @return array
     */
    public function getUserDetails($username)
    {
        $user = static::findByUsername($username);
        return ['user_id' => $user->getId()];
    }

    /**
     * @param $username
     * @return null|static
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username]);
    }
}
