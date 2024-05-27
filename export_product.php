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

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['products'])) {
    $productAmounts = $_POST['product_amounts']; // Get the amounts of each product
    foreach ($_POST['products'] as $key => $productID) {
        $product_sql = "SELECT productName, price FROM products WHERE productID = $productID";
        $product_result = $conn->query($product_sql);
        if ($product_result->num_rows > 0) {
            $product = $product_result->fetch_assoc();
            $productName = $product['productName'];
            $price = $product['price'];
            $amount = $productAmounts[$key]; // Get the amount of the current product

            // Calculate total price for the amount of product
            $total = $price * $amount;

            $export_sql = "INSERT INTO orders (productOrdered, total) VALUES ('$productName', $total)";
            if ($conn->query($export_sql) !== TRUE) {
                echo "Error: " . $export_sql . "<br>" . $conn->error;
            }
        }
    }
    header("Location: dashboard.php");
    exit();
}

$products_sql = "SELECT * FROM products";
$products_result = $conn->query($products_sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Export Products</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <style>
    input[type="number"] {
        width: 60px; /* Adjust the width as needed */
    }
</style>
</head>
<body>
    <div>
        <h2>Select Products to Export</h2>
        <form action="export_product.php" method="post">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Select</th>
                        <th>Product ID</th>
                        <th>Product Name</th>
                        <th>Price</th>
                        <th>Amount</th> <!-- New column for amount -->
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = $products_result->fetch_assoc()): ?>
                    <tr>
                        <td><input type="checkbox" name="products[]" value="<?php echo $row['productID']; ?>"></td>
                        <td><?php echo $row['productID']; ?></td>
                        <td><?php echo $row['productName']; ?></td>
                        <td><?php echo $row['price']; ?></td>
                        <td><input type="number" name="product_amounts[]" value="1" min="1"></td> <!-- Input field for amount -->
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
            <button type="submit" class="btn btn-primary" onclick="alert('Product exported successfully')">Export Selected Products</button>
            <a href="dashboard.php" class="btn btn-secondary">back</a>
        </form>
    </div>
</body>
</html>
