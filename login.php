<?php
session_start();
include "db.php";

if(isset($_POST['login'])){
    $username = $_POST['username'];
    $password = $_POST['password'];

    if(empty($username) || empty($password)) {

    $error = "Please enter username and password";
    } else {
        $sql = $conn-> prepare("SELECT * FROM admin WHERE name = '$username'");

        $sql->execute();

        $user = $sql->get_result()->fetch_assoc();

        if($user && password_verify($password, $user['password'])) {
$_SESSION['user_id'] = $user['id'];
$_SESSION['username'] = $user['name'];
header("Location: index.php");

exit;

        } else {
            $error = "Invalid username or password";
        }

    }

}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
</head>

<body>
<?php
if (!empty($error)) {
    echo "<p style='color: red;'>$error</p>";
}
?>

<h1>Student Grading System - Login</h1>

<h2>Login</h2>

<form method="POST">
    <label>Username:</label>
    <input type="text" name="username">
    <br><br>
    <label>Password:</label>
    <input type="password" name="password">
    <br><br>
    <button type="submit" name="login">Login</button>
</form>

</body>
</html>