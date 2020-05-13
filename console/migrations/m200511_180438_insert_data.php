<?php

use core\database\Column;
use core\database\Table;
use core\entities\User;
use yii\db\Migration;

/**
 * Class m200511_180438_insert_data
 */
class m200511_180438_insert_data extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->truncateTable(Table::USERS);
        $this->alterColumn(Table::USERS, Column::UPDATED_AT, $this->integer()->unsigned()->null());
        $this->batchInsert(
            Table::USERS,
            [Column::ID, Column::USERNAME, Column::AUTH_KEY, Column::PASSWORD_HASH, Column::PASSWORD_RESET_TOKEN, Column::EMAIL, Column::STATUS, Column::CREATED_AT, Column::UPDATED_AT],
            [
                [1, 'admin', 'lfSzjdUh-d7tw8tkPOJREGNcq92JgTtk', '$2y$13$qOqvKXOktnDJ4nD4NcltEuB/rvylKmhTAT.5ZOT1tpzir95N/z.JG', null, 'admin@gmail.com', User::STATUS_ACTIVE, time(), null],
                [2, 'user', 'sBrmRuSnBfE0ivQab0uhNTQPEtRSRJPD', '$2y$13$PqeDvDJWqdDaNqjR4fEYtOtKC9tUYhVzS5oYSsYSq4oVcPEYsYMMW', null, 'user@gmail.com', User::STATUS_ACTIVE, time(), null],
            ]
        );

        $this->batchInsert(
            Table::AUTH_ASSIGNMENTS,
            [ Column::ITEM_NAME, Column::USER_ID, Column::CREATED_AT],
            [
                ['admin', 1, time()],
                ['user', 2, time()],
            ]
        );

        $this->truncateTable(Table::COMPANIES);
        $this->batchInsert(
            Table::COMPANIES,
            [
                Column::ID, Column::NAME, Column::INN, Column::DIRECTOR_JSON, Column::ADDRESS_JSON, Column::CREATED_AT, Column::UPDATED_AT
            ],
            [
                [1, 'Tesla', '123456789', '{"firstName":"Илон","secondName":"Маск","patronymic":""}', '{"country":"USA","city":"Palo Alto","street":"Deer Creek Road","house":"3500"}', time(), null],
                [2, 'Google LLC', '98565412548', '{"firstName":"Сундар","secondName":"Пичаи","patronymic":""}', '{"country":"USA","city":"Mountain View","street":"Amphitheatre Parkway","house":"1600"}', time(), null],
                [3, 'Яндекс', '7736207543', '{"firstName":"Аркадий","secondName":"Волож","patronymic":"Юррьевич"}', '{"country":"Россия","city":"Санкт-Петербург,","street":"Пискарёвский проспект","house":"2"}', time(), null],
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->truncateTable(Table::USERS);
        $this->truncateTable(Table::AUTH_ASSIGNMENTS);
        $this->truncateTable(Table::COMPANIES);
    }
}
