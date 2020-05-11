<?php

namespace core\forms\user;

use core\entities\User;
use yii\base\Exception;
use yii\base\Model;

class PasswordChangeForm extends Model
{
    public $newPassword;
    public $newPasswordRepeat;
    /**
     * @var User
     */
    private $_user;

    /**
     * PasswordChangeForm constructor.
     * @param User $user
     * @param array $config
     */
    public function __construct(User $user, array $config = [])
    {
        $this->_user = $user;
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['newPassword', 'newPasswordRepeat'], 'required'],
            ['newPassword', 'string', 'min' => 6],
            ['newPasswordRepeat', 'compare', 'compareAttribute' => 'newPassword'],
        ];
    }
}