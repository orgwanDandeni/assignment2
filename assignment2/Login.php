<?php

$host = 'localhost';
$data = 'clients';
$user = 'root';
$pass = '';
$char = 'utf8mb4';
$attr = "mysql:host=$host;dbname=$data;charset=$char";
$opts =
[
   PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
   PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
   PDO::ATTR_EMULATE_PREPARES => false,
   ];

?>
