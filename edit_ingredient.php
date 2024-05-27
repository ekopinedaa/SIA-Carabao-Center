<?php

session_start();
if(!isset($_SESSION["user"])){
    header("Location: Login.php");
    exit();
}

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "carabao_center";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $ingredientID = $_GET['id'];
    $ingredient_sql = "SELECT * FROM ingredients WHERE ingredientID = $ingredientID";
    $ingredient_result = $conn->query($ingredient_sql);
    $ingredient = $ingredient_result->fetch_assoc();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ingredientID = $_POST['ingredientID'];
    $ingredientName = $_POST['ingredientName'];
    $amount = $_POST['amount'];

    $update_sql = "UPDATE ingredients SET ingredientName='$ingredientName', amount=$amount WHERE ingredientID=$ingredientID";
    if ($conn->query($update_sql) === TRUE) {
        header("Location: dashboard_ingredients.php");
        exit();
    } else {
        echo "Error: " . $update_sql . "<br>" . $conn->error;
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Ingredient</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Edit Ingredient</h2>
        <form action="edit_ingredient.php" method="post">
            <input type="hidden" name="ingredientID" value="<?php echo $ingredient['ingredientID']; ?>">
            <div class="mb-3">
                <label for="ingredientName" class="form-label">Ingredient Name</label>
                <input type="text" class="form-control" id="ingredientName" name="ingredientName" value="<?php echo $ingredient['ingredientName']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="amount" class="form-label">Amount</label>
                <input type="number" class="form-control" id="amount" name="amount" value="<?php echo $ingredient['amount']; ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Update Ingredient</button>
            <a href="dashboard_ingredients.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</body>
</html>
