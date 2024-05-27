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
    $productID = $_GET['id'];
    $product_sql = "SELECT * FROM products WHERE productID = $productID";
    $product_result = $conn->query($product_sql);
    $product = $product_result->fetch_assoc();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $productID = $_POST['productID'];
    $productName = $_POST['productName'];
    $ingredient1ID = $_POST['ingredient1ID'];
    $ingredient2ID = $_POST['ingredient2ID'];
    $price = $_POST['price'];

    $update_sql = "UPDATE products SET productName='$productName', ingredient1ID=$ingredient1ID, ingredient2ID=$ingredient2ID, price=$price WHERE productID=$productID";
    if ($conn->query($update_sql) === TRUE) {
        header("Location: dashboard.php");
        exit();
    } else {
        echo "Error: " . $update_sql . "<br>" . $conn->error;
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
    <title>Edit Product</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Edit Product</h2>
        <form action="edit_product.php" method="post">
            <input type="hidden" name="productID" value="<?php echo $product['productID']; ?>">
            <div class="mb-3">
                <label for="productName" class="form-label">Product Name</label>
                <input type="text" class="form-control" id="productName" name="productName" value="<?php echo $product['productName']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="ingredient1ID" class="form-label">Ingredient 1</label>
                <select class="form-control" id="ingredient1ID" name="ingredient1ID" required>
                    <?php while ($row = $ingredients_result->fetch_assoc()): ?>
                        <option value="<?php echo $row['ingredientID']; ?>" <?php if ($row['ingredientID'] == $product['ingredient1ID']) echo 'selected'; ?>>
                            <?php echo $row['ingredientName']; ?>
                        </option>
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
                        <option value="<?php echo $row['ingredientID']; ?>" <?php if ($row['ingredientID'] == $product['ingredient2ID']) echo 'selected'; ?>>
                            <?php echo $row['ingredientName']; ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">Price</label>
                <input type="number" class="form-control" id="price" name="price" value="<?php echo $product['price']; ?>" required>
            </div>
            <button type="submit" class="btn btn-primary" onclick="alert('Product updated successfully')">Update Product</button>
            <a href="#" onclick="history.back();" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</body>
</html>
