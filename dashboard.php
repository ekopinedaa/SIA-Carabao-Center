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

// Fetch products
$products_sql = "SELECT * FROM products";
$products_result = $conn->query($products_sql);

// Fetch ingredients
$ingredients_sql = "SELECT ingredientID, ingredientName FROM ingredients";
$ingredients_result = $conn->query($ingredients_sql);
$ingredients = [];
while ($row = $ingredients_result->fetch_assoc()) {
    $ingredients[$row['ingredientID']] = $row['ingredientName'];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Caraboa Center Dashboard</title>
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

<body >
    <div class="menu-bar">
        <a href="landingPage.php">Dashboard</a>
        <a href="dashboard.php">Products</a>
        <a href="dashboard_ingredients.php">Ingredients</a>
        <a href="logout.php" style="float: right;">Logout</a>

    </div>
    <br />
    <div>
        <h1>PRODUCTS</h1>
        <button onclick="location.href='add_product.php'">Add Product</button>
        <button onclick="exportProduct()">Export</button>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Product ID</th>
                    <th>Product Name</th>
                    <th>Ingredient 1</th>
                    <th>Ingredient 2</th>
                    <th>Price</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $products_result->fetch_assoc()) : ?>
                    <tr>
                        <td><?php echo $row['productID']; ?></td>
                        <td><?php echo $row['productName']; ?></td>
                        <td><?php echo $ingredients[$row['ingredient1ID']]; ?></td>
                        <td><?php echo $ingredients[$row['ingredient2ID']]; ?></td>
                        <td><?php echo $row['price']; ?></td>
                        <td>
                            <button class="btn btn-warning" onclick="location.href='edit_product.php?id=<?php echo $row['productID']; ?>'">Edit</button>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <script>
        function exportProduct() {
            // Implement export functionality here
            // Redirect to export.php with necessary parameters
            location.href = 'export_product.php';
        }
    </script>
</body>

</html>