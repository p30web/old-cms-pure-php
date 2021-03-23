<?php 
error_reporting(1);
$db = new MysqliDb (Array (
    'host' => 'localhost',
    'username' => 'root',
    'password' => '',
    'db'=> 'betting_casino',
    'charset' => 'utf8'));
//date_default_timezone_set('Asia/Tehran');