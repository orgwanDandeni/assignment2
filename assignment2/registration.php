<?php
require_once 'Login.php';

// Define variables to avoid undefined variable errors
$username = $password = $firstname = $lastname = $email = "";

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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate all fields
    $username = validateField($_POST['username'], 'Username');
    $password = validateField($_POST['password'], 'Password');
    $firstname = validateField($_POST['firstname'], 'First Name');
    $lastname = validateField($_POST['lastname'], 'Last Name');
    $email = validateField($_POST['email'], 'Email');

    // If all fields are valid, proceed with database interaction
    if ($username && $password && $firstname && $lastname && $email) {
        try {
            $pdo = new PDO($attr, $user, $pass, $opts);

            // Use prepared statements to prevent SQL injection
            $stmt = $pdo->prepare("INSERT INTO users (username, password, firstname, lastname, email) VALUES (?, ?, ?, ?, ?)");
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $stmt->execute([$username, $hashedPassword, $firstname, $lastname, $email]);

            echo "Registration successful!";
        } catch (PDOException $e) {
            // Handle database connection or query error
            echo "Error: " . $e->getMessage();
        }
    }
}

function validateField($value, $fieldName)
{
    $value = trim($value);
    if (!isset($value) || empty($value)) {
        return "$fieldName is required.";
    }

    switch ($fieldName) {
        case 'Username':
        case 'First Name':
        case 'Last Name':
            if (!ctype_alpha($value)) {
                return "$fieldName should contain only letters.";
            }
            break;
        case 'Email':
            if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
                return "Invalid email format.";
            }
            break;
        case 'Password':
            if (strlen($value) < 8) {
                return "Password should be at least 8 characters.";
            }
            break;
    }

    return ""; // No error, return an empty string
}

// ...

// In your HTML, display validation errors
if ($username && $password && $firstname && $lastname && $email) {
    // Your database interaction code here
} else {
    // Display validation errors
    echo "<div class='validation-errors'>";

    // Check if the keys are set before accessing them
    echo isset($_POST['username']) ? validateField($_POST['username'], 'Username') . "<br>" : '';
    echo isset($_POST['password']) ? validateField($_POST['password'], 'Password') . "<br>" : '';
    // Repeat for other fields

    echo "</div>";
}


echo <<<_END
<form action="" method="post"><pre>
Username:
<input type="text" name="username" value="$username">
Password:
<input type="password" name="password" value="$password">
First Name:
<input type="text" name="firstname" value="$firstname">
Last Name:
<input type="text" name="lastname" value="$lastname">
E-mail:
<input type="text" name="email" value="$email">
<input type="submit" value="SUBMIT">
</pre></form>
_END;

$query = "SELECT * FROM users";
$result = $pdo->query($query);

while ($row = $result->fetch()) {
    $r0 = htmlspecialchars($row['username']);
    $r1 = htmlspecialchars($row['password']);
    $r2 = htmlspecialchars($row['firstname']);
    $r3 = htmlspecialchars($row['lastname']);
    $r4 = htmlspecialchars($row['email']);

    echo <<<_END
    <pre>
    <h2 style="color:#A8A8A8"><b>Your Input:</b></h2>
    $r0
    $r1
    $r2
    $r3
    $r4
    </pre>
_END;
}

function get_post($pdo, $var)
{
    return htmlentities($_POST[$var]);
}
?>
</body>
</html>
