<?php
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    echo "<p class='content'>Welcome, " . htmlspecialchars($_SESSION["email"]) . "!</p>";
}
?>
