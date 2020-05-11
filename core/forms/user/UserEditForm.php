<?php

namespace core\forms\user;

use core\entities\User;
use Yii;
use yii\base\Model;

class UserEditForm extends Model
{
    public $username;
    public $email;
    public $role;

    /**
     * @var User
     */
    private $_user;

    /**
     * UserCreateForm constructor.
     * @param User|null $user
     * @param array $config
     */
    public function __construct(User $user, $config = [])
    {
        $this->email = $user->email;
        $this->username = $user->username;
        $roles = Yii::$app->authManager->getRolesByUser($user->id);
        $this->role = $roles ? reset($roles)->name : null;
        $this->_user = $user;
        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            [['username', 'email', 'role'], 'required'],
            ['email', 'email'],
            [['username', 'email'], 'string', 'max' => 255],
            [['username', 'email'], 'unique', 'targetClass' => User::class, 'filter' => ['<>', 'id', $this->_user->id]],
        ];
    }
}