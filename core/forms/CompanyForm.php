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
    public $description;
    public $phone;

    public function __construct(Company $company = null, $config = [])
    {
        if ($company) {
            $this->name = $company->name;
            $this->inn = $company->inn;
            $this->description = $company->description;
            $this->phone = $company->phone;
            $this->address = new AddressForm($company->address);
            $this->director = new DirectorForm($company->director);
        } else {
            $this->address = new AddressForm();
            $this->director = new DirectorForm();
        }

        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['name', 'inn'], 'required'],
            [['name', 'description', 'phone'], 'string'],
            ['inn', 'integer']// 'min' => 11, 'max' => 12]
        ];
    }

    protected function internalForms(): array
    {
        return ['director', 'address'];
    }
}