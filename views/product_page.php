<!DOCTYPE html>
<html>

<head>
    <?php include "header.php" ?>
</head>

<body class="container-fluid">
    <?php
    include("custom_nav.php");
    require_once('../api/config/Database.php');
    require_once('../api/Product.php');
    require_once('../api/Category.php');

    $dbConn = new Database();
    $activeCategory = "";

    $productInstance = new Product($dbConn->getConnection());
    if (isset($_GET['filter'])) {
        $safe_filter = htmlspecialchars($_GET['filter'], ENT_QUOTES, "UTF-8");
        $productList = $productInstance->getAllProducts($safe_filter);
    } else {
        $productList = $productInstance->getAllProducts("all");
    }

    $categoryInstance = new Category($dbConn->getConnection());
    $categoryList = $categoryInstance->getAllCategories();

    ?>

    <main class="row m-2 m-md-5">

        <div class="col-md-3 col-lg-2 d-flex flex-column flex-shrink-0 p-3 text-white">
            <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
                <img src="../imgs/category_icon.png" class="img-fluid menu-icon">
                <span class="fs-4">Filter categories</span>
            </a>
            <hr>
            <ul class="nav nav-pills flex-column mb-auto">
                <?php
                foreach ($categoryList as $item) { ?>
                    <li class="category-item">
                        <a href="<?php echo $_SERVER['PHP_SELF'] ?>?filter=<?php echo urlencode($item['category_name']) ?>"
                            class="nav-link text-white ">
                            <?php echo $item['category_name'] ?>
                        </a>
                    </li>
                <?php } ?>
            </ul>
            <hr>
        </div>

        <div class="col-md-9 col-lg-10 d-flex flex-column flex-shrink-0 p-3 text-white">
            <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
                <span class="fs-4 mx-3">
                    <?php echo $_GET['filter'] ?>
                </span>
            </a>
            <hr>
            <div class="row row-cols-1 row-cols-md-3 row-cols-lg-5 g-4">
                <?php foreach ($productList as $item) { ?>
                    <div class="col bg-danger rounded mx-3 p-0">
                        <a href="./details_page.php?id=<?php echo urlencode($item['product_id']) ?>"
                            class="text-decoration-none text-reset">
                            <img src="../imgs/products/<?php echo $item['product_id'] ?>.jpg" class="img-fluid rounded ">
                            <div class="d-flex justify-content-between text-decoration-none list-style-none">
                                <h5 class="mx-2 my-1 p-0 text-wrap">
                                    <?php echo $item['product_name'] ?>
                                </h5>
                                <h5 class="mx-2 my-1 p-0">
                                    <?php echo $item['product_price'] ?>
                                </h5>
                            </div>
                        </a>
                    </div>
                <?php } ?>
            </div>
            <hr>
        </div>
    </main>
</body>

</html>