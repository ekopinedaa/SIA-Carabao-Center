<?php

session_start();
if(!isset($_SESSION["user"])){
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
// Add product form handling
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $productName = $_POST['productName'];
    $ingredient1ID = $_POST['ingredient1ID'];
    $ingredient2ID = $_POST['ingredient2ID'];
    $price = $_POST['price'];

    $sql = "INSERT INTO products (productName, ingredient1ID, ingredient2ID, price) VALUES ('$productName', $ingredient1ID, $ingredient2ID, $price)";
    if ($conn->query($sql) === TRUE) {
        header("Location: dashboard.php");
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
    <title>Add Product</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Add Product</h2>
        <form action="add_product.php" method="post">
            <div class="mb-3">
                <label for="productName" class="form-label">Product Name</label>
                <input type="text" class="form-control" id="productName" name="productName" required>
            </div>
            <div class="mb-3">
                <label for="ingredient1ID" class="form-label">Ingredient 1</label>
                <select class="form-control" id="ingredient1ID" name="ingredient1ID" required>
                    <?php while ($row = $ingredients_result->fetch_assoc()): ?>
                        <option value="<?php echo $row['ingredientID']; ?>"><?php echo $row['ingredientName']; ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="ingredient2ID" class="form-label">Ingredient 2</label>
                <select class="form-control" id="ingredient2ID" name="ingredient2ID" required>
                    <?php
                    // Reset the result pointer and fetch again for the second dropdown
                    $ingredients_result->data_seek(0);
                    while ($row = $ingredients_result->fetch_assoc()): ?>
                        <option value="<?php echo $row['ingredientID']; ?>"><?php echo $row['ingredientName']; ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">Price</label>
                <input type="number" class="form-control" id="price" name="price" required>
            </div>
            <button type="submit" class="btn btn-primary" onclick="alert('Product added successfully')">Add Product</button>
            <a href="dashboard.php" class="btn btn-secondary">Back</a>
        </form>
    </div>
</body>
</html>
