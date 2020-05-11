<?php

namespace core\services;

use core\entities\User;
use core\forms\user\UserCreateForm;
use core\forms\user\UserEditForm;
use core\repositories\UserRepository;
use Throwable;
use Yii;
use yii\base\Exception;
use yii\db\StaleObjectException;
use yii\rbac\ManagerInterface;

class UserService
{
    /**
     * @var UserRepository
     */
    private $repository;

    /**
     * @var RoleManager
     */
    private $roleManager;

    /**
     * UserService constructor.
     * @param UserRepository $repository
     * @param RoleManager $roleManager
     */
    public function __construct(
        UserRepository $repository,
        RoleManager $roleManager
    )
    {
        $this->repository = $repository;
        $this->roleManager = $roleManager;
    }

    /**
     * @param UserCreateForm $form
     * @return User
     * @throws Exception
     * @throws \Exception
     */
    public function create(UserCreateForm $form): User
    {
        $user = User::create(
            $form->username,
            $form->email,
            $form->password
        );

        $this->repository->save($user);
        $this->roleManager->assign($user->id, $form->role);
        return $user;
    }

    /**
     * @param int $id
     * @param UserEditForm $form
     * @throws \Exception
     */
    public function edit(int $id, UserEditForm $form): void
    {
        $user = $this->repository->get($id);
        $user->edit(
            $form->username,
            $form->email
        );

        $this->repository->save($user);
        $this->roleManager->assign($user->id, $form->role);
    }

    /**
     * @param int $id
     * @throws Throwable
     * @throws StaleObjectException
     */
    public function remove(int $id): void
    {
        $user = $this->repository->get($id);
        $this->repository->remove($user);
    }
}