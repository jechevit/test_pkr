<?php

namespace core\forms\user;

use core\entities\User;
use Yii;
use yii\base\Model;

class UserCreateForm extends Model
{
    public $username;
    public $password;
    public $email;
    public $role;

    public function rules(): array
    {
        return [
            [['username', 'email', 'role'], 'required'],
            ['email', 'email'],
            [['username', 'email'], 'string', 'max' => 255],
            [['username', 'email'], 'unique', 'targetClass' => User::class],
            ['password', 'string', 'min' => 6]
        ];
    }
}