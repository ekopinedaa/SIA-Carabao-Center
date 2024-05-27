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
    <title>Registration Form</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>

<body class="bg-container">
    <div class="container" style="height: 26rem">
        <div>
            <h2>Register</h2>
        </div>
        <form action="Register.php" method="post">

            <!--This is where the interaction and logic of the front end is placed-->
            <?php
            if (isset($_POST["submit"])) {
                $username = $_POST["username"];
                $password = $_POST["password"];
                $passwordRepeat = $_POST["repeat_password"];
                $errors = array();
                if (empty($username) or empty($password) or empty($passwordRepeat)) {
                    array_push($errors, "All fields are required");
                }
                if (!filter_var($username, FILTER_VALIDATE_EMAIL)) {
                    array_push($errors, "Email is not valid");
                }
                if (strlen($password) < 8) {
                    array_push($errors, "Password must be 8 characters long");
                }
                if ($password !== $passwordRepeat) {
                    array_push($errors, "Password does not match");
                }

                if (count($errors) > 0) {

                    foreach ($errors as $error) {
                        echo "<div class='alert alert-danger'>$error</div>";
                    }
                } else {
                    require_once "database.php";
                    $sql = "INSERT INTO users(username,`password`) VALUES( ?, ? )";
                    $stmt = mysqli_stmt_init($conn);
                    $prepareStmt = mysqli_stmt_prepare($stmt, $sql);
                    if ($prepareStmt) {
                        mysqli_stmt_bind_param($stmt, "ss", $username, $password);
                        mysqli_stmt_execute($stmt);
                        echo "<div class='alert alert-success'> You registered successfully. </div>";
                    } else {
                        die("Something went wrong");
                    }
                }
            }

            ?>
            <!--This is where the interaction and logic of the front end is placed-->

            <div class="form-group">
                <input type="text" class="form-control" name="username" placeholder="Username:">
            </div>
            <div class="form-group">
                <input type="password" class="form-control" name="password" placeholder="Password:">
            </div>
            <div class="form-group">
                <input type="password" class="form-control" name="repeat_password" placeholder="Repeat Password:">
            </div>
            <div class="form-btn">
                <input type="submit" class="btn btn-primary" name="submit" value="Register">
            </div>
        </form>
        <div>
            <p>Already Registered? <a href="Login.php">Login here</a></p>
        </div>
    </div>
</body>

</html>