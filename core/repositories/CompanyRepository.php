<?php

namespace core\repositories;

use core\entities\Company;

class CompanyRepository
{
    public function get($id): Company
    {
        if (!$company = Company::findOne($id)) {
            throw new NotFoundException('Company is not found.');
        }
        return $company;
    }

    public function save(Company $company): void
    {
        if (!$company->save()) {
            throw new RuntimeException('Saving error.');
        }
    }

    public function remove(Company $company): void
    {
        if (!$company->delete()) {
            throw new RuntimeException('Removing error.');
        }
    }
}