<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include_once "private/connection.php";
include_once 'private/functions.php';
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true && isAdmin($conn, $_SESSION["email"])) {
    echo '
    <nav class="navbar">
        <div class="camel-container">
            <img src="/images/camel.png" alt="camel" class="camel">
        </div>
       <ul>
                <li><a href="/index.php">Home</a></li>
                <li><a href="/about.php">About</a></li>
                <li><a href="/challenges/index-challenges.php">Challenges</a></li>
                <li><a href="/private/admin/admin_index.php">Admin Panel</a></li>
                <li class="avatar">
                    <img src="/images/avatar.png" alt="user_avatar" class="user-avatar">
                     <ul class="avatar-dropdown">
                        <li><a href="/logout.php">Logout</a></li>
                        <li><a href="/settings.php">Settings</a></li>
                    </ul>
                  </li>
                </ul>
    </nav>
    ';
} else if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    echo '
    <nav class="navbar">
        <div class="camel-container">
            <img src="/images/camel.png" alt="camel" class="camel">
        </div>
       <ul>
                <li><a href="/index.php">Home</a></li>
                <li><a href="/about.php">About</a></li>
                <li><a href="/challenges/index-challenges.php">Challenges</a></li>
                <li class="avatar">
                    <img src="/images/avatar.png" alt="user_avatar" class="user-avatar">
                     <ul class="avatar-dropdown">
                        <li><a href="/logout.php">Logout</a></li>
                        <li><a href="/settings.php">Settings</a></li>
                    </ul>
                  </li>
                </ul>
    </nav>
    ';

} else {
    echo '
    <nav class="navbar">
        <div class="camel-container">
            <img src="/images/camel.png" alt="camel" class="camel">
        </div>
        <ul>
            <li><a href="/index.php">Home</a></li>
            <li><a href="/login.php">Login</a></li>
            <li><a href="/about.php">About</a></li>
        </ul>
    </nav>
    ';
}
?>
