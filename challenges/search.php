<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reflected XSS Challenge</title>
    <meta http-equiv="Content-Security-Policy" content="default-src 'self';">
    <link rel="icon" type="image/x-icon" href="../images/favicon.ico">
</head>
<body>
<a href="./index-challenges.php">Go back</a>
<h1>Anonymity</h1>
<p>Anonimize yourself today with our anonimizer 3000, enter your username below to get started.</p>
<form action="" method="get">
    <label id="query">Username: </label>
    <input type="text" name="query">
    <br>
    <br>
    <input type="submit" value="Anonimize">
</form>

<?php
if (isset($_GET['query'])) {
    $query = $_GET['query'];

    $query = checkUserAnswer($query);

    echo "<p>User: $query has been anonimized!</p>";
} else {
    echo "<p>Click the button</p>";
}


function checkUserAnswer($input) {
	$answer = "<img src='' onerror='alert(1)'>";
	if ($input == $answer) {
		echo "<br><b>Challenge completed!</b>";
		return "";
	}
	#htmlspecialchars for not allowing xss
	return htmlspecialchars($input);
}
?>
</body>
</html>
