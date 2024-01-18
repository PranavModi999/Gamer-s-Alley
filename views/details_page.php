<!DOCTYPE html>
<html>

<head>
    <?php include "header.php" ?>
</head>

<body class="container-fluid">
    <?php
    include "custom_nav.php";
    require_once('../api/config/Database.php');
    require_once('../api/Product.php');
    require_once('../api/Cart.php');
    require_once('../api/Category.php');

    $dbConn = new Database();

    $productInstance = new Product($dbConn->getConnection());
    $safe_id = htmlspecialchars($_GET['id'], ENT_QUOTES, 'UTF-8');
    $product = $productInstance->getProductById($safe_id);

    $categoryInstance = new Category($dbConn->getConnection());
    $category = $categoryInstance->getCategoryById($product["product_category"]);

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['cart'])) {
        $quantity = htmlspecialchars($_POST['quantity'], ENT_QUOTES, 'UTF-8');
        $cartInstance = new Cart($dbConn->getConnection());
        $cartInstance->addCart(57, (int) $safe_id, (int) $quantity);
        echo "Item added to cart";
    }
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['checkout'])) {
        header('location:checkout.php');
    }
    ?>
    <main class="row">
        <div class="container">
            <div class="row justify-content-center my-5">
                <div class="col-lg-3 col-md-4">
                    <img src="../imgs/products/<?php echo $product['product_id'] ?>.jpg" class="img-fluid rounded ">
                </div>
                <div class="col-lg-5 col-md-8 m-3">
                    <div class="row justify-content-between">
                        <div class="col-md-8">
                            <h3>
                                <?php echo $product['product_name'] ?>
                            </h3>
                            <small class="text-danger">
                                <?php echo $category['category_name'] ?>
                            </small>
                        </div>
                        <div class="col-md-3 mx-3 text-end">
                            <h3>$
                                <?php echo $product['product_price'] ?>
                            </h3>
                        </div>
                    </div>
                    <hr />
                    <div class="col-md-4 m-0 p-0">
                        <h4>rating:
                            <?php echo $product['product_ratings'] ?>/5
                        </h4>
                    </div>
                    <p>
                        <?php echo $product['product_detail'] ?>
                    </p>
                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>?id=<?php echo urlencode($safe_id) ?>"
                        method="POST">
                        <input type="hidden" name="id" name="id" value="<?php echo $product['product_id'] ?>/5">
                        <div class="row">
                            <div class="col">
                                <label for="quantity" class="form-label">Quantity:</label>
                                <input type="number" id="quantity" name="quantity" class="form-control" value="1"
                                    min="1">
                            </div>
                        </div>
                        <input type="submit" id="delete-cancel-button" name="cart" value="Add to cart"
                            class="my-4 mx-2" />
                        <input type="submit" id="delete-cancel-button" name="checkout" value="Checkout"
                            class="my-4 mx-2" />
                    </form>
                </div>
            </div>
        </div>
    </main>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>