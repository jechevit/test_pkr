<?php

namespace console\controllers;

use core\repositories\UserRepository;
use Exception;
use Yii;
use yii\console\Controller;
use yii\rbac\ManagerInterface;

class RoleController extends Controller
{
    const ACCESS_PANEL = 'accessPanel';
    const ADMIN = 'admin';
    const USER = 'user';

    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @var ManagerInterface
     */
    private $auth;

    public function __construct($id, $module, UserRepository $userRepository, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->userRepository = $userRepository;
        $this->auth = Yii::$app->authManager;
    }

    /**
     * @throws Exception
     */
    public function actionRole()
    {
        $user = $this->auth->createRole(self::USER);
        $user->description = 'user';
        $this->auth->add($user);
        $admin = $this->auth->createRole(self::ADMIN);
        $admin->description = 'admin';
        $this->auth->add($admin);

        $this->auth->addChild($admin, $user);
    }

    /**
     * @param int $id
     * @param string|null $role
     * @throws Exception
     */
    public function actionAdd(int $id, string $role = null)
    {
        $user = $this->userRepository->get($id);

        if (isset($role)){
            $role = $this->auth->getRole($role);
        } else {
            $role = $this->auth->getRole(self::ADMIN);
        }

        $this->auth->assign($role, $user->id);
    }

    /**
     * @param int $id
     * @param string|null $role
     */
    public function actionDelete(int $id, string $role = null)
    {
        $user = $this->userRepository->get($id);

        if (isset($role)){
            $role = $this->auth->getRole($role);
        } else {
            $role = $this->auth->getRole(self::ADMIN);
        }

        $this->auth->revoke($role, $user->id);
    }
}