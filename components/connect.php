<?php

$db_name = 'mysql:host=localhost;dbname=hotel';
$user_name = 'root';
$user_password = 'workhard';

$conn = new PDO($db_name, $user_name, $user_password);
$conn1 = new PDO($db_name, $user_name, $user_password);

?>