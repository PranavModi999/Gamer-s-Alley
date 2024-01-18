<!DOCTYPE html>
<html>

<head>
    <?php include "header.php" ?>
</head>

<body class="container-fluid">
    <?php include "custom_nav.php";
    require_once('../api/config/Database.php');
    require_once('../api/Product.php');

    $dbConn = new Database();

    $productInstance = new Product($dbConn->getConnection());
    $productList = $productInstance->getAllProducts("all");

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        extract($_POST);
        $result = $productInstance->updateProduct($productId, $name, $detail, $price, $ratings, $rating_count, $category);
        $decoded = json_decode($result, true);
        if ($decoded['success']) {
            header("location:admin_page.php");
        }
    }
    if (isset($_GET['updateItem'])) {
        $product = $productInstance->getProductById($_GET['updateItem']);
    }

    ?>
    <main class="row">
        <section class="add-form col-lg-6 col-md-12 p-0">
            <form class="add-form" method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
                <p class="add-title-text">Update an existing <span>Product</span></p>
                <input type="number" value="<?php echo $_GET['updateItem'] ?>" name="productId" hidden>
                <div class="row justify-content-center">
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <label id="title-text" for="name">Name:</label>
                        <input type="text" id="title" name="name" value="<?php echo $product['product_name'] ?>"
                            placeholder="Enter product name" /><br /><br />
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <label id="title-text" for="Price">Price:</label>
                        <input type="number" id="title" name="price" value="<?php echo $product['product_price'] ?>"
                            placeholder="Enter product Price" /><br /><br />
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <label id="title-text" for="Rating">Rating:</label>
                        <input type="number" id="title" name="ratings" value="<?php echo $product['product_ratings'] ?>"
                            placeholder="Enter product Rating" /><br /><br />
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <label id="title-text" for="Ratings count">Ratings count:</label>
                        <input type="number" id="title" name="rating_count"
                            value="<?php echo $product['product_rating_count'] ?>"
                            placeholder="Enter product Ratings count" /><br /><br />
                    </div>
                </div>

                <div class="row justify-content-center">
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <label id="title-text" for="Category ID">Category ID:</label>
                        <input type="number" value="<?php echo $product['product_category'] ?>" id="title"
                            name="category" placeholder="Enter product Category ID" /><br /><br />
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12"></div>
                </div>

                <label id="title-text" for="Details">Details:</label><br />
                <textarea id="title" class="col-8" name="detail"
                    placeholder="Enter product details"><?php echo $product['product_detail'] ?></textarea><br /><br />

                <input type="submit" class="submit-button mb-5" value="Update Product" />
            </form>
        </section>

    </main>

    <!-- Bootstrap JS and jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>