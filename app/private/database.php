<?php

require_once 'db_credentials.php';

function db_connect()
{
    $connection = new mysqli(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
    confirm_db_connect($connection);
    return $connection;
}

function db_disconnect($connection)
{
    if (isset($connection)) {
        $connection->close();
    }
}

function confirm_db_connect($connection)
{
    if ($connection->connect_error) {
        $msg = "Database connection failed: ";
        $msg .= $connection->connect_error;
        exit($msg);
    }
}

function confirm_result($result_set)
{
    if (!$result_set) {
        exit("Database query failed.");
    }
}