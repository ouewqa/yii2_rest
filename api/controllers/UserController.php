<?php
/**
 * Created by PhpStorm.
 * User: yuyj
 * Date: 16-6-21
 * Time: 下午7:39
 */

namespace api\controllers;

class UserController extends AuthActiveController
{
    public $modelClass = 'api\models\User';    
}