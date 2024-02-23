<?php
session_start();

include_once "private/connection.php";

function getUserProfilePicture() {
    global $conn;

    if (isset($_SESSION["AccountsID"])) {
        $stmt = $conn->prepare("SELECT profile_picture FROM accounts WHERE AccountsID = ?");
        $stmt->bind_param("i", $_SESSION["AccountsID"]);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result) {
            $row = $result->fetch_assoc();
            return $row["profile_picture"];
        } else {
            return false; // Handle error
        }
        $stmt->close();
    }

    return false; // No user ID in session
}

function displayProfilePicture() {
    $profilePicture = getUserProfilePicture();

    if (empty($profilePicture)) {
        echo "<img src='images/avatar.png' width='200' />";
    } else {
        echo "<img src='images/pfp/" . htmlspecialchars($profilePicture) . "' width='200' />";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="icon" type="image/x-icon" href="images/favicon.ico">
</head>
<body>
    <header>
        <?php include_once 'nav.php';?>
    </header>
    <div class="container">
        <div class="image-container">
            <?php displayProfilePicture(); ?>
        </div>
        <h1>Upload new avatar</h1>
        <form action="private/update-profile.php" method="POST" enctype="multipart/form-data">
            <input type="file" name="uploadfile" id="fileInput" accept="image/*">
            <input type="submit" value="SUBMIT" id="submitAvatar" name="SUBMIT">
        </form>
    </div>
</body>
</html>
