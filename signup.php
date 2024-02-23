<?php
if (isset($_GET['error'])) {
    $error = $_GET['error'];

    if ($error === 'emptyinput') {
        echo "Error: Empty input!";
    } elseif ($error === 'passwordsdontmatch') {
        echo "Error: Passwords don't match!";
    } elseif ($error === 'invalidemail') {
        echo "Error: Invalid email!";
    } elseif ($error === 'usernametaken') {
        echo "Error: Username already taken!";
    }

    unset($_SESSION['error-message']);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup</title>

    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="icon" type="image/x-icon" href="images/favicon.ico">
</head>

    </head>
    <body>
        <header>
            <?php include_once 'nav.php';?>
        </header>
        <main>
            <div class="registerform">
                <form method ="POST" action="private/signup.php">
                    <input type="email" name="email" id="email" placeholder="Email">
                    <input type="password" name="pwd" id="pwd" placeholder="Password">
                    <input type="password" name="pwdrepeat" id="pwdrepeat" placeholder="Repeat Password">
                    <input type="submit" value="Create Account" id="submitacc" name="submit" >
                </form>
            </div>
        </main>
    </body>
</html>