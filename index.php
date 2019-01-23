<?php
session_start();
require_once 'Db.php';
require_once 'Generic.php';
require_once 'User.php';


$user = new User();
var_dump($user->login());
?>