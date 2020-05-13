<?php

use core\database\Column;
use core\database\MigrationHelper;
use core\database\Table;
use yii\db\Migration;

/**
 * Handles the creation of table `{{%comments}}`.
 */
class m200513_201526_create_comments_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(Table::COMPANIES, Column::DESCRIPTION, $this->text()->null());
        $this->addColumn(Table::COMPANIES, Column::PHONE, $this->string()->null());

        $this->createTable(Table::COMMENTS, [
            Column::ID => $this->primaryKey(),
            Column::COMPANY_ID => $this->integer()->notNull(),
            Column::USER_ID => $this->integer()->notNull(),
            Column::ROLE => $this->integer()->notNull(),
            Column::COMMENTS_JSON => $this->text(),
        ]);

        $this->createIndex(MigrationHelper::indexName(Table::COMMENTS, Column::COMPANY_ID), Table::COMMENTS, Column::COMPANY_ID);
        $this->createIndex(MigrationHelper::indexName(Table::COMMENTS, Column::USER_ID), Table::COMMENTS, Column::USER_ID);

        $this->addForeignKey(MigrationHelper::foreignKeyName(Table::COMMENTS, Column::COMPANY_ID), Table::COMMENTS, Column::COMPANY_ID, Table::COMPANIES, Column::ID, Table::CASCADE);
        $this->addForeignKey(MigrationHelper::foreignKeyName(Table::COMMENTS, Column::USER_ID), Table::COMMENTS, Column::USER_ID, Table::USERS, Column::ID, Table::CASCADE);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn(Table::COMPANIES, Column::DESCRIPTION);
        $this->dropColumn(Table::COMPANIES, Column::PHONE);
        $this->dropTable(Table::COMMENTS);
    }
}
