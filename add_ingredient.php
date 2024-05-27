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

// Add ingredient form handling
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ingredientName = $_POST['ingredientName'];
    $amount = $_POST['amount'];

    $sql = "INSERT INTO ingredients (ingredientName, amount) VALUES ('$ingredientName', $amount)";
    if ($conn->query($sql) === TRUE) {
        echo '<script>alert("Ingredient added successfully");</script>';
        header("Location: dashboard_ingredients.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Fetch ingredients for the dropdown
$ingredients_sql = "SELECT ingredientID, ingredientName FROM ingredients";
$ingredients_result = $conn->query($ingredients_sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Ingredient</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Add Ingredient</h2>
        <form action="add_ingredient.php" method="post">
            <div class="mb-3">
                <label for="ingredientName" class="form-label">Ingredient Name</label>
                <input type="text" class="form-control" id="ingredientName" name="ingredientName" required>
            </div>
            <div class="mb-3">
                <label for="amount" class="form-label">Amount</label>
                <input type="number" class="form-control" id="amount" name="amount" required>
            </div>
            <button type="submit" class="btn btn-primary">Add Ingredient</button>
        </form>
    </div>
</body>
</html>
