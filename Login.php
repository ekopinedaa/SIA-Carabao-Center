<?php
session_start();
if (isset($_SESSION["user"])) {
    header("Location: dashboard.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>

<body class="bg-container">
    <div class="container" style="height: 22rem;">
        <div>
            <h2>Login</h2>
        </div>
        <?php
        if (isset($_POST["login"])) {
            $username = $_POST["username"];
            $password = $_POST["password"];
            require_once "database.php";
            $sql = "SELECT * FROM users WHERE username = '$username'";
            $result = mysqli_query($conn, $sql);
            $user = mysqli_fetch_array($result, MYSQLI_ASSOC);
            if (!empty($user)) {
                session_start();
                $_SESSION["user"] = "yes";
                header("Location: LandingPage.php");
                exit;
            } else {
                echo "<div class='alert alert-danger'>Email does not match</div>";
            }
        }

        ?>
        <form action="login.php" method="post">
            <div class="form-group">
                <input type="username" placeholder="Enter username:" name="username" class="form-control">
            </div>
            <div class="form-group">
                <input type="password" placeholder="Enter password:" name="password" class="form-control">
            </div>
            <div class="form-btn">
                <input type="submit" value="login" name="login" class="btn btn-primary">
            </div>
        </form>
        <div>
            <p>Not Registered yet? <a href="Register.php">register here</a></p>
        </div>
    </div>
</body>

</html>