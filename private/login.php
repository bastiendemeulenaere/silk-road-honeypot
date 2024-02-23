<?php

session_start();

require_once 'connection.php';
require_once 'functions.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST["uid"];
    $pwd = $_POST["password"];

    if (emptyInput($email, $pwd, $pwd)) {
        header("location: ../login.php?error=emptyinput");
        exit();
    }

    $userIsEnabled = isUserEnabledByEmail($conn, $email);

    if (!$userIsEnabled) {
        header("location: ../login.php?error=disabled");
        exit();
    }

    handleLogin($conn, $email, $pwd);
    $_SESSION['loggedin'] = true;
    $_SESSION['email'] = $email;
} else {
    header("location: ../login.php");
    exit();
}
