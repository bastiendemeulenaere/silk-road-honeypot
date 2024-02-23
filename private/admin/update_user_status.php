<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once '../connection.php';

    $userId = filter_input(INPUT_POST, 'user_id', FILTER_VALIDATE_INT);
    $action = filter_input(INPUT_POST, 'action', FILTER_SANITIZE_STRING);

    $activeStatus = ($action === 'enable') ? 1 : 0;

    if ($userId !== false && in_array($action, ['enable', 'disable'])) {
        $stmt = $conn->prepare("UPDATE accounts SET enabled = ? WHERE AccountsID = ?");
        if ($stmt === false) {
            die("Error in preparing the statement: " . $conn->error);
        }

        $stmt->bind_param("ii", $activeStatus, $userId);
        if ($stmt === false) {
            die("Error in binding parameters: " . $conn->error);
        }

        $success = $stmt->execute();
        if ($success === false) {
            die("Error in executing the statement: " . $stmt->error);
        }

        $stmt->close();
        $conn->close();
        
        //exit();
        echo "<script>alert('Update successful: {$activeStatus}');</script>";
    }
    
    header("location: users.php");
    exit();
 
} else {
    header("location: users.php");
    exit();
}
