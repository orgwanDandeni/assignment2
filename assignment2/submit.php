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
    <title>Login</title>
</head>

<body style="background-image: url('cloud.jpg'); background-repeat: no-repeat; background-size: cover;">

<?php

$css = file_get_contents("style.css");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $enteredUsername = validateField($_POST['username'], 'Username');
    $enteredPassword = validateField($_POST['password'], 'Password');
    $enteredUsername = trim($_POST['username']);
    $enteredPassword = trim($_POST['password']);

    if ($enteredUsername !== false && $enteredPassword !== false) {
        try {
            $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
            $stmt->execute([$enteredUsername]);
            $user = $stmt->fetch();

            if ($user && password_verify($enteredPassword, $user['password'])) {
                echo <<<_END
<pre class="output">
<h2 style="color:#A8A8A8">Welcome!</h2>

<p>Username: {$user['username']}</p>
<p>Password: {$user['password']}</p>
</pre>
_END;
            } else {
                echo "<p>Incorrect username or password. Please try again.</p>";
            }
        } catch (PDOException $e) {
            error_log("Error: " . $e->getMessage());
            echo "<p>An error occurred. Please try again.</p>";
        }
    } else {
        // Validation failed, do not proceed with database interaction
        echo "<p>Incorrect username or password. Please try again.</p>";
    }
}

function validateField($value, $fieldName)
{
    $value = trim($value);
    if (!isset($value) || empty($value)) {
        // Return false to indicate validation failure
        return false;
    }

    return htmlentities($value);
}
?>

<span class="output">Click here to <a href="sign_in.php">Login</a> again</span>

</body>
</html>
