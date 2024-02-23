<?php
session_start();

require_once '../connection.php';

$logged_in_users = array();
$stmt = mysqli_prepare($conn, "SELECT Email, AccountsID FROM accounts WHERE logged_in = 1");
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

while ($user = mysqli_fetch_assoc($result)) {
    $logged_in_users[] = $user;
}

$stmt_all_users = mysqli_prepare($conn, "SELECT Email, AccountsID FROM accounts");
mysqli_stmt_execute($stmt_all_users);
$result_all_users = mysqli_stmt_get_result($stmt_all_users);

$allUsers = array();
while ($user = mysqli_fetch_assoc($result_all_users)) {
    $allUsers[] = $user;
}

?>