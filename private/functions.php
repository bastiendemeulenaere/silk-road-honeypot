<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

function emptyInput($email, $pwd, $pwdrepeat)
{
    return empty($email) || empty($pwd) || empty($pwdrepeat);
}

function invalidEmail($email)
{
    return !filter_var($email, FILTER_VALIDATE_EMAIL);
}

function passwdMatch($pwd, $pwdrepeat)
{
    return $pwd !== $pwdrepeat;
}

function userExists($conn, $email)
{
    $sql = "SELECT * FROM accounts WHERE Email = ?;";
    $stmt = mysqli_stmt_init($conn);
    
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../signup.php?error=stmtfailed1");
        exit();
    }
    
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $resultdata = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($resultdata);
    mysqli_stmt_close($stmt);

    return $row ? $row : false;
}

function handleSignup($conn, $email, $pwd, $pwdrepeat)
{
    if (emptyInput($email, $pwd, $pwdrepeat) || invalidEmail($email) || passwdMatch($pwd, $pwdrepeat)) {
        header("location: ../signup.php?error=invalidinput");
        exit();
    }

    $existingUser = userExists($conn, $email);
    if ($existingUser) {
        header("location: ../signup.php?error=userexists");
        exit();
    }

    $hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);
    $sql = "INSERT INTO accounts (Email, Password) VALUES (?, ?);";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../signup.php?error=stmtfailed2");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ss", $email, $hashedPwd);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    header("location: ../login.php");
    exit();
}

function handleLogin($conn, $email, $pwd)
{
    if (emptyInput($email, $pwd, $pwd)) {
        header("location: ../login.php?error=invalidinput");
        exit();
    }

    $user = userExists($conn, $email);
    if (!$user || !password_verify($pwd, $user["Password"])) {
        header("location: ../login.php?error=wronglogin");
        exit();
    }

    setLoggedIn($conn, $user["AccountsID"]);
    $_SESSION["loggedin"] = true;
    $_SESSION["AccountsID"] = $user["AccountsID"];
    $_SESSION["email"] = $user["Email"];

    if (isAdmin($conn, $email)) {
        header("location: admin/admin_index.php");
    } else {
        header("location: ../index.php?table=created");
    }
    
    exit();
}


function isAdmin($conn, $email)
{
    $sql = "SELECT * FROM accounts WHERE Email = ? AND AccountsID = 1;"; 

    $stmt = mysqli_stmt_init($conn);
    
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        return false;
    }
    
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $resultdata = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($resultdata);
    mysqli_stmt_close($stmt);

    return $row ? true : false;
}

function setLoggedIn($conn, $user_id) {
    $stmt = mysqli_prepare($conn, "UPDATE accounts SET logged_in = 1 WHERE AccountsID = ?");
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);
}

function setLoggedOut($conn, $user_id) {
    $stmt = mysqli_prepare($conn, "UPDATE accounts SET logged_in = 0 WHERE AccountsID = ?");
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);
}

function isUserEnabledByEmail($conn, $email) {
    $stmt = $conn->prepare("SELECT enabled FROM accounts WHERE Email = ?");
    if ($stmt === false) {
        die("Error in preparing the statement: " . $conn->error);
    }

    $stmt->bind_param("s", $email);
    if ($stmt === false) {
        die("Error in binding parameters: " . $conn->error);
    }

    $stmt->execute();
    $stmt->bind_result($enabled);
    $stmt->fetch();

    $stmt->close();

    return (bool) $enabled;
}