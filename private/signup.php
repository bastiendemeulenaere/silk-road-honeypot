<?php

if (isset($_POST["submit"])) {

    require_once 'connection.php';
    require_once 'functions.php';
    
$email = $_POST["email"];
$pwd = $_POST["pwd"];
$pwdrepeat = $_POST["pwdrepeat"];

if(emptyInput($email, $pwd, $pwdrepeat)){
    $_SESSION['error-message'] = "emptyinput";
    header("location: ../signup.php?error=emptyinput");
    exit();
}

if(passwdMatch($pwd, $pwdrepeat) !== false){
    $_SESSION['error-message'] = "passwordsdontmatch";
    header("location: ../signup.php?error=passwordsdontmatch");
    exit();
}

if(invalidEmail($email)){
    $_SESSION['error-message'] = "invalidemail";
    header("location: ../signup.php?error=invalidemail");
    exit();
}


if(userExists($conn, $email)){
    $_SESSION['error-message'] = "usernametaken";
    header("location: ../signup.php?error=usernametaken");
    exit();
 }

 handleSignup($conn, $email, $pwd, $pwdrepeat);
 header("location: ../login.php");
}
else{
    header("location: ../login.php");
    exit();
}
