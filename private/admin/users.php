<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../../assets/css/style.css">
</head>

<body>
    <header>
        <?php include_once '../../nav.php'; ?>
    </header>

    <h2 class="table-heading">Enable/Disable Users:</h2>
    <table class="users-table">
        <thead>
            <tr>
                <th class="text-center">Email</th>
                <th class="text-center">ID</th>
                <th class="text-center">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            require_once 'getusers.php';

            foreach ($allUsers as $user) {
                $userId = htmlspecialchars($user['AccountsID']);
                $email = htmlspecialchars($user['Email']);
            ?>
                <tr>
                    <td><?= $email ?></td>
                    <td><?= $userId ?></td>
                    <td>
                        <form action='update_user_status.php' method='post'>
                            <input type='hidden' name='user_id' value='<?= $userId ?>'>
                            <input type='hidden' name='action' value='enable'>
                            <button type='submit'>Enable</button>
                        </form>
                        <form action='update_user_status.php' method='post'>
                            <input type='hidden' name='user_id' value='<?= $userId ?>'>
                            <input type='hidden' name='action' value='disable'>
                            <button type='submit'>Disable</button>
                        </form>
                    </td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
</body>

</html>
