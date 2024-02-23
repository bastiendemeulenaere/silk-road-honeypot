<?php
session_start();

$target_dir = '../images/pfp/';
$htmlfield = 'uploadfile';
$whitelist_extensions = ['jpeg', 'png', 'gif', 'jpg'];
$whitelist_content_types = ['image/jpeg', 'image/png', 'image/gif', 'image/jpg'];
$max_file_size = 500000;
$min_file_size = 50;
$max_filename_length = 63;


if ($_SERVER["REQUEST_METHOD"] === "POST") {

    if (file_exists($target_dir) !== true) {
        die('Sorry, no uploads are allowed today');
    }

    if (!isset($_FILES) || !array_key_exists($htmlfield, $_FILES) || !array_key_exists('name', $_FILES[$htmlfield])) {
        die('Please spefify a file name to upload');
    }
    $uname = $_FILES[$htmlfield]['name'];

    if (strlen($uname) > $max_filename_length) {
        die('Sorry, the file name is too long.');
    }

    $tmpname = $_FILES[$htmlfield]['tmp_name'];
    if (is_uploaded_file($tmpname) !== true) {
      die('Sorry, the file is not the uploaded one!');
    }

    $lc = strtolower($uname);

    // Extension validation via whitelist depending on business-critical requirements.
    $extlc = pathinfo($lc, PATHINFO_EXTENSION);
    if (in_array($extlc, $whitelist_extensions, true) !== true) {
        die("Sorry, the file extension '".htmlspecialchars($extlc)."' is not allowed");
    }

    if ((in_array(mime_content_type($tmpname), $whitelist_content_types, true) !== true) ||
        (in_array($_FILES[$htmlfield]["type"], $whitelist_content_types, true) !== true)) {
        die('Sorry, this content type is not allowed.');
    }

    // basename() may prevent filesystem traversal attacks
    $target_file = $target_dir . $_SESSION["AccountsID"] . '.' . $extlc;

    // further check for directory traversal
    $target_rp = realpath(pathinfo($target_file, PATHINFO_DIRNAME));
    $targetdir_rp = realpath($target_dir);
    if ($target_rp === false || strpos($target_rp, $targetdir_rp) !== 0) {
        die('Sorry, directory traversals are not allowed');
    }

    $filesize = $_FILES[$htmlfield]['size'];

    if ($filesize > $max_file_size) {
        die('Sorry, your file is too large.');
    }

    if ($filesize < $min_file_size) {
        die('Sorry, your file is too small.');
    }

        $imageinfo = getimagesize($tmpname);

        if (!$imageinfo && isset($imageinfo)) {
            die('Sorry, not allowed.');
            exit();
        }

        $newFilename = $_SESSION["AccountsID"] . '.' . $extlc;

        if (move_uploaded_file($tmpname, $target_file)===true) {
            $userId = $_SESSION["AccountsID"];
            require_once "connection.php";

            try {
                $sql = "UPDATE accounts SET profile_picture = ? WHERE AccountsID = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("si", $newFilename, $userId);
                $stmt->execute();
                $stmt->close();

                header("Location: ../settings.php?success=1");
                exit();
            } catch (Exception $e) {
                error_log("Error executing database query: " . $e->getMessage());
                echo "Error updating database.";
                exit();
            }
        } else {
            die('Sorry, there was an error uploading your file.');
        }
    } else {
        die("Error uploading file.");
        exit();
    }


header("Location: ../settings.php?error=1");
exit();
?>
