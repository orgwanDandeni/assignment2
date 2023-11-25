<?php
  
    require_once 'Login.php';
	
	try
	{
		$pdo = new PDO($attr, $user, $pass, $opts);
	}
	catch(PDOException $e)
	{
		throw new PDOException($e->getMessage(), (int)$e->getCode());
	}
	
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>FORM</title>
</head>
<body style="background-image: url('cloud.jpg'); background-repeat: no-repeat; background-size: cover;">


<?php

$css = file_get_contents("style.css");
  
  <!-- اكتبي كودك تحت ذا الكومنت -->
  
  
?>

</body> </html>