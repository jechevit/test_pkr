<?php

namespace core\forms;

use core\entities\Company;

/**
 * Class CompanyForm
 * @package core\forms
 *
 * @property $address AddressForm
 * @property $director DirectorForm
 */
class CompanyForm extends CompositeForm
{
    public $name;
    public $inn;

    public function __construct(Company $company = null, $config = [])
    {
        if ($company) {
            $this->name = $company->name;
            $this->inn = $company->inn;
            $this->address = new AddressForm($company);
            $this->director = new DirectorForm($company);
        }
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['name', 'inn'], 'required'],
            ['name', 'string'],
            ['inn', 'integer', 'max' => 12, 'min' => 12]
        ];
    }

    protected function internalForms(): array
    {
        return ['director', 'address'];
    }
}