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

if (
    isset($_POST['username']) &&
    isset($_POST['password']) &&
    isset($_POST['firstname']) &&
    isset($_POST['lastname']) &&
    isset($_POST['email'])
) {
    $username = get_post($pdo, 'username');
    $password = get_post($pdo, 'password');
    $firstname = get_post($pdo, 'firstname');
    $lastname = get_post($pdo, 'lastname');
    $email = get_post($pdo, 'email');

    // Hash the password before storing it
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Use prepared statements to prevent SQL injection
    $stmt = $pdo->prepare("INSERT INTO users (username, password, firstname, lastname, email) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$username, $hashedPassword, $firstname, $lastname, $email]);
}

echo <<<_END
<form action="registration.php" method="post"><pre>
Username:
<input type="text" name="username">
Password:
<input type="text" name="password">
First Name:
<input type="text" name="firstname">
Last Name:
<input type="text" name="lastname">
E-mail:
<input type="text" name="email">
<input type="submit" value="Register">
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
