<?php
	require_once("database.php");

    $DB_NAME = 'bookstore';
    $DB_HOST = 'localhost';
    $DB_PORT = '3306';
    $DB_USER = 'root';
    $DB_PASS = 'root';

    $DB = DB::Open($DB_NAME, $DB_HOST, $DB_PORT, $DB_USER, $DB_PASS);
?>