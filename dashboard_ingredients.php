<?php
session_start();
if (!isset($_SESSION["user"])) {
    header("Location: Login.php");
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "carabao_center";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch ingredients
$ingredients_sql = "SELECT * FROM ingredients";
$ingredients_result = $conn->query($ingredients_sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Caraboa Center Ingredients</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <style>
        /* Menu bar styles */
        .menu-bar {
            background-color: #88cef0;
            overflow: hidden;
            width: screen;
        }

        .menu-bar a {
            float: left;
            display: block;
            color: #f8f8f8;
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
            border-radius: 18px;
        }

        .menu-bar a:hover {
            background-color: #f8f8f8;
            color: #002b40;
            border-radius: 18px;
        }
    </style>
</head>

<body>
    <div class="menu-bar">
        <a href="landingPage.php">Dashboard</a>
        <a href="dashboard.php">Products</a>
        <a href="dashboard_ingredients.php">Ingredients</a>
        <a href="logout.php" style="float: right;">Logout</a>

    </div>
    <br />
    <div>
        <h1>INGREDIENTS</h1>
        <button onclick="location.href='add_ingredient.php'">Add Ingredient</button>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Ingredient Name</th>
                    <th>Amount</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $ingredients_result->fetch_assoc()) : ?>
                    <tr>
                        <td><?php echo $row['ingredientName']; ?></td>
                        <td><?php echo $row['amount']; ?></td>
                        <td> <button class="btn btn-warning" onclick="location.href='edit_ingredient.php?id=<?php echo $row['ingredientID']; ?>'">Edit</button></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>

</html>