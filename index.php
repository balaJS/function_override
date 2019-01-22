<?php
require_once 'Db.php';
require_once 'User.php';


$user = new User();
var_dump($user->get_data());
?>