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

    <h1>Welcome to the Admin Dashboard</h1>

    <section>
        <h2 class="table-heading">Currently logged in users</h2>
        <table class="users-table">
            <thead>
                <tr>
                    <th class="text-center">Email</th>
                    <th class="text-center">ID</th>
                </tr>
            </thead>
            <tbody>
                <?php
                require_once 'getusers.php';
                foreach ($logged_in_users as $user) {
                    echo "<tr><td>" . htmlspecialchars($user['Email']) . "</td><td>" . htmlspecialchars($user['AccountsID']) . "</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </section>

    <section>
        <h2 class="table-heading">Total registered users</h2>
        <table class="users-table">
            <thead>
                <tr>
                    <th class="text-center">Email</th>
                    <th class="text-center">ID</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($allUsers as $user) {
                    echo "<tr><td>" . htmlspecialchars($user['Email']) . "</td><td>" . htmlspecialchars($user['AccountsID']) . "</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </section>

    <a href="users.php" class="manage-users">Manage Users</a>
</body>

</html>
