<?php
/**
 * Created by PhpStorm.
 * User: yuyj
 * Date: 16-6-21
 * Time: 下午7:39
 */

namespace api\controllers;

/**
 * Class UserController
 * @package api\controllers
 */
class UserController extends AuthActiveController
{
    /**
     * required
     * 
     * @var $modelClass string the model class name. This property must be set.
     */
    public $modelClass = 'api\models\User';
}