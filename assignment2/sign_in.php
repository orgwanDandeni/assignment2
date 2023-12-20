<?php
require_once 'Login.php';

try {
    $pdo = new PDO($attr, $user, $pass, $opts);
} catch (PDOException $e) {
    throw new PDOException($e->getMessage(), (int) $e->getCode());
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

echo <<<_END
<form action="submit.php" method="post">
    <h2 style="color:#A8A8A8">Login</h2>

    <div class="container">
        <input type="text" name="username" required>
        <input type="password" name="password" required>
        <input type="submit" value="Login">
    </div>

    <div class="container">
        <span class="password">if Not Registered click here to <a href="registration.php">Login</a></span>
    </div>
</form>
_END;
?>
