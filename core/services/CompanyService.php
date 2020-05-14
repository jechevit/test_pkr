<?php

namespace core\services;

use core\entities\Address;
use core\entities\Comment;
use core\entities\Company;
use core\entities\Director;
use core\forms\CompanyForm;
use core\repositories\CompanyRepository;
use core\repositories\UserRepository;

class CompanyService
{
    /**
     * @var CompanyRepository
     */
    private $repository;
    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * CompanyService constructor.
     * @param CompanyRepository $repository
     * @param UserRepository $userRepository
     */
    public function __construct(
        CompanyRepository $repository,
        UserRepository $userRepository
    )
    {
        $this->repository = $repository;
        $this->userRepository = $userRepository;
    }

    /**
     * @param CompanyForm $form
     * @return Company
     */
    public function create(CompanyForm $form): Company
    {
        $company = Company::create(
            $form->name,
            $form->inn,
            $form->description,
            $form->phone,
            new Director(
                $form->director->firstName,
                $form->director->secondName,
                $form->director->patronymic
            ),
            new Address(
                $form->address->country,
                $form->address->city,
                $form->address->street,
                $form->address->house
            )
        );
        $this->repository->save($company);
        return $company;
    }

    /**
     * @param int $id
     * @param CompanyForm $form
     */
    public function edit(int $id, CompanyForm $form): void
    {
        $company = $this->repository->get($id);

        $company->edit(
            $form->name,
            $form->inn,
            $form->description,
            $form->phone,
            new Director(
                $form->director->firstName,
                $form->director->secondName,
                $form->director->patronymic
            ),
            new Address(
                $form->address->country,
                $form->address->city,
                $form->address->street,
                $form->address->house
            )
        );

        $this->repository->save($company);
    }

    /**
     * @param int $id
     */
    public function remove(int $id)
    {
        $company = $this->repository->get($id);
        $this->repository->remove($company);
    }

    /**
     * @param int $companyId
     * @param int $userId
     * @param string $property
     * @param string $text
     * @return Comment
     */
    public function addComment(
        int $companyId,
        int $userId,
        string $property,
        string $text
    ): Comment
    {
        $company = $this->repository->get($companyId);
        $user = $this->userRepository->get($userId);

        $comment = $company->addComment(
            $user->id,
            $property,
            $text
        );
        $this->repository->save($company);

        return $comment;
    }
}