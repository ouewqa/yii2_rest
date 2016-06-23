<?php
namespace api\models;

use yii;
use common\models\User as BaseUser;

class User extends BaseUser
{

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
}
