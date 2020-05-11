<?php


namespace frontend\forms;


use core\entities\Company;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class CompanySearch extends Model
{
    public $name;
    public $inn;

    public function rules(): array
    {
        return [
            [['inn',], 'integer'],
            [['name'], 'string'],
        ];
    }

    /**
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search(array $params): ActiveDataProvider
    {
        $query = Company::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['id' => SORT_DESC]
            ],
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'inn' => $this->inn,
        ]);

        $query
            ->andFilterWhere(['like', 'name', $this->name]);
        return $dataProvider;
    }
}