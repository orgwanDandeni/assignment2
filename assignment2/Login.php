<?php

   $host = 'localhost';
   $data = 'publications';
   $user = 'root';
   $pass = 'assignment2';
   $chrs = 'utf8mb4';
   $attr = "mysql:host=$host;dbname=$data;charset=$chrs";
   $opts =
   [
   PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
   PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
   PDO::ATTR_EMULATE_PREPARES => PDO::false,

?>