<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link rel="stylesheet" href="assets/css/style.css">
  <link rel="icon" type="image/x-icon" href="images/favicon.ico">
</head>
<body>
        <header>
            <?php include_once 'nav.php';
            include 'private/error.php';?>  
        </header>
        <main>        
        <div class="loginform">
            <form action="private/login.php" method="POST">
            <input type="email" name="uid" id="uid" placeholder="Email" required>
            <input type="password" name="password" id="password" placeholder="Password" required>
            <input type="submit" value="LOG IN" id="submitlogin" name="submit"><br>
            <p class="create-account">Don't have an account? <a href="signup.php">Create one</a></p>
            </form>
        </div>
        </main>
    </body>
</html>