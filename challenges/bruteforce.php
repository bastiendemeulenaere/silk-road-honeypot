<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    if ($username === "admin" && $password === "5tr0ngPillz!") {
        header("Location: welcome.php");
        exit();
    } else {
        $error = "Invalid username or password. Please try again.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="icon" type="image/x-icon" href="../images/favicon.ico">
</head>
<body>

<h2>Login Form</h2>

<!-- Note to Ross Ulbricht: If you forgot your username, it is "admin" and the password might be in the /hints directory -->
<form action="" method="post">
    <div>
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>
    </div>
    <div>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
    </div>
    <input type="submit" value="Login">
</form>

<a href="./index-challenges.php">Go back</a>

<?php
if(isset($error)) {
    echo "<p>$error</p>";
}
?>

</body>
</html>
