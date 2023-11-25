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

            // Hash the password before storing it
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Use prepared statements to prevent SQL injection
            $stmt = $pdo->prepare("INSERT INTO users (username, password, firstname, lastname, email) VALUES (?, ?, ?, ?, ?)");
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
    // Check if the field is set and not empty
    if (!isset($value) || empty($value)) {
        echo "Error: $fieldName is required.<br>";
        return false;
    }

    // Additional validation for specific fields
    switch ($fieldName) {
        case 'Username':
        case 'First Name':
        case 'Last Name':
            // Only allow letters
            if (!ctype_alpha($value)) {
                echo "Error: $fieldName should contain only letters.<br>";
                return false;
            }
            break;
        case 'Email':
            // Check for a valid email format
            if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
                echo "Error: Invalid email format.<br>";
                return false;
            }
            break;
        case 'Password':
            // Check for a valid password (at least 8 characters)
            if (strlen($value) < 8) {
                echo "Error: Password should be at least 8 characters.<br>";
                return false;
            }
            break;
    }

    return htmlentities($value); // Return the sanitized value
}

echo <<<_END
<form action="" method="post"><pre>
Username:
<input type="text" name="username">
Password:
<input type="password" name="password">
First Name:
<input type="text" name="firstname">
Last Name:
<input type="text" name="lastname">
E-mail:
<input type="text" name="email">
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
    <h2><b>Your Input:</b></h2>
    $r0
    $r1
    $r2
    $r3
    $r4
    </pre>
_END;
}

function get_post($pdo, $var) {
    return htmlentities($_POST[$var]);
}
?>

</body> </html>
