<?php
session_start();
if (!isset($_SESSION["user"])) {
    header("Location: Login.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carabao Center - Quality Products</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <style>
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
    <div class="bg-container-lp">
        <h1>Welcome to Carabao Center</h1>
        <p>We are dedicated to providing high-quality products made with the finest ingredients with the freshest ingredients to be found.</p>

        <h1>Our Story</h1>
        <p>Carabao Center was founded in [year] by [founder's name] with the vision of bringing authentic and delicious products to our customers. Our journey began in [location] where we started producing our signature [product name]. Over the years, we have expanded our product line and built a reputation for excellence.</p>

        <h1>Our Products</h1>
        <p>At Carabao Center, we offer a wide range of products to satisfy every palate. From traditional favorites to innovative creations, each product is crafted with care and attention to detail. Some of our popular offerings include:</p>
        <ul>
            <li>Fresh Milk: Fresh Milk that freshly extracted from our well-taken-care-of carabaos.</li>
            <li>Cheese: Delectable cheeses made with love.</li>
            <li>Milk Ice Cream: Cold and fresh Ice Cream.</li>
            <!-- Add more products as needed -->
        </ul>

        <h1>Contact Us</h1>
        <p>If you have any questions or inquiries, please feel free to contact us:</p>
        <p>Email: Inqueries@CarabaoCenter.gov.ph</p>
        <p>Phone: 09758694326</p>
    </div>
</body>

</html>