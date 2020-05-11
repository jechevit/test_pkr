<?php

namespace core\services;

use DomainException;
use Exception;
use Yii;
use yii\rbac\ManagerInterface;

class RoleManager
{
    /**
     * @var ManagerInterface
     */
    private $manager;

    /**
     * RoleManager constructor.
     * @param ManagerInterface $manager
     */
    public function __construct(ManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    /**
     * @param int $userId
     * @param string $name
     * @throws Exception
     */
    public function assign(int $userId, string $name): void
    {
        if (!$role = $this->manager->getRole($name)) {
            throw new DomainException(Yii::t('CoreErrors', 'Role "' . $name . '" does not exist.'));
        }
        $this->manager->revokeAll($userId);
        $this->manager->assign($role, $userId);
    }
}