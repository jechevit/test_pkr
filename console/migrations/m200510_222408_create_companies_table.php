<?php

use core\database\Column;
use core\database\Table;
use yii\db\Migration;

/**
 * Handles the creation of table `{{%companies}}`.
 */
class m200510_222408_create_companies_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(Table::COMPANIES, [
            Column::ID => $this->primaryKey(),
            Column::NAME => $this->string()->notNull(),
            Column::INN => $this->string()->notNull(),
            Column::DIRECTOR_JSON => $this->text(),
            Column::ADDRESS_JSON => $this->text(),
            Column::CREATED_AT => $this->integer()->unsigned()->notNull(),
            Column::UPDATED_AT => $this->integer()->unsigned()
        ], Table::OPTIONS);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable(Table::COMPANIES);
    }
}
