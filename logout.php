<?php
session_start();  
require_once 'private/functions.php';
require_once 'private/connection.php';
setLoggedOut($conn, $_SESSION["AccountsID"]);
session_unset();
session_destroy();

header("location: index.php");

exit();
