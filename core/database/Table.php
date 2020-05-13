<?php

namespace core\database;

class Table
{
    const OPTIONS = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
    const CASCADE = 'CASCADE';
    const RESTRICT = 'RESTRICT';

    const USERS = '{{%users}}';
    const USER = '{{%user}}';
    const COMPANIES = '{{%companies}}';
    const AUTH_ASSIGNMENTS = '{{%auth_assignments}}';
    const COMMENTS = '{{%comments}}';
}