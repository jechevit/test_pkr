<?php

namespace core\services;

use core\entities\Address;
use core\entities\Company;
use core\entities\Director;
use core\forms\CompanyForm;
use core\repositories\CompanyRepository;

class CompanyService
{
    /**
     * @var CompanyRepository
     */
    private $repository;

    /**
     * CompanyService constructor.
     * @param CompanyRepository $repository
     */
    public function __construct(CompanyRepository $repository)
    {
        $this->repository = $repository;
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
}