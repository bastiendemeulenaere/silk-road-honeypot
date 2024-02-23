<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Labs Web Pentesting</title>
    <link rel="icon" type="image/x-icon" href="../images/favicon.ico">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f5f5f5;
            padding-top: 50px;
        }

        .site-wrapper {
            position: relative;
            width: 100%;
            height: 100%;
            min-height: 100%;
            background-color: #fff;
        }

        .site-wrapper-inner {
            display: table;
            width: 100%;
            min-height: 100%;
        }

        .cover-container {
            margin-right: auto;
            margin-left: auto;
        }

        .masthead {
            padding: 10px 0;
            background-color: #333;
            color: #fff;
        }

        .inner {
            padding: 30px;
        }

        .cover-heading {
            margin-top: 0;
            font-size: 50px;
            font-weight: bold;
            color: #333;
        }

        form {
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #333;
            color: #fff;
        }
    </style>
</head>
<body id="top">
<div class="site-wrapper">
    <div class="site-wrapper-inner">
        <div class="cover-container">
            <div class="masthead clearfix">
                <div class="inner">
                </div>
            </div>
            <br>
        </div>
        <div class="inner cover">
            <p class="mb-5"><a href="./index-challenges.php">Go back</a></p>
            <h1 class="cover-heading">View our items</h1>
            <form method="GET">
                <label for="search">Search:</label>
                <input type="text" id="search" name="search"/>
                <input type="submit" value="Search">
            </form>
            <?php
            $search = $_GET['search'];

            $search = validateAndSanitize($search);

            function validateAndSanitize($input) {
                return strip_tags(trim($input));
            }


            $itemsQuery = !isset($search) ? "SELECT *
                                     FROM items" :
                "SELECT *
                                     FROM items
                                     WHERE name LIKE '%" . $search . "%'";

            $db = new SQLite3('Items-User-Info.db');
            $items = $db->query($itemsQuery);
            echo 'You searched for: ' . $search;

            ?>
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Quantity</th>
                    <th>Price</th>
                </tr>
                </thead>
                <tbody>
                <?php
                while ($row = $items->fetchArray(SQLITE3_ASSOC)) {

                    $rows[] = $row;


                    $adminFound = false;
                    foreach ($rows as $row) {
                        foreach ($row as $field) {
                            if (stripos($field, 'admin') !== false) {
                                echo "<br><br><br><b>Challenge Solved</b><br>";
                                $adminFound = true;
                                break 2;
                            }
                        }
                    }





                    echo '<tr>';
                    echo '<td>' . $row['name'] . '</td>';
                    echo '<td>' . $row['quantity'] . '</td>';
                    echo '<td>$' . number_format($row['price'], 2) . '</td>';
                    echo '</tr>';
                }
                ?>
                </tbody>
            </table>
            <?php
            $db->close();
            ?>
        </div>
</body>
</html>