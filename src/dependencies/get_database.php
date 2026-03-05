<?php
require_once __DIR__ . '/MySqlDatabase.php';

function get_database(): MySqlDatabase
{
    static $instance = null;

    if ($instance === null) {
        $instance = MySqlDatabase::getInstance();
    }

    return $instance;
}
