<!DOCTYPE html>
<html>

<head>
    <?php include "header.php"; ?>
</head>

<body class="container-fluid">
    <?php
    include "custom_nav.php";
    require_once('../api/config/Database.php');
    require_once('../api/Product.php');

    $dbConn = new Database();
    $productInstance = new Product($dbConn->getConnection());
    $productList = $productInstance->getAllProducts("all");

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Sanitize inputs
        $name = htmlspecialchars($_POST['name'], ENT_QUOTES, 'UTF-8');
        $detail = htmlspecialchars($_POST['detail'], ENT_QUOTES, 'UTF-8');
        $price = filter_var($_POST['price'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $ratings = filter_var($_POST['ratings'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $rating_count = filter_var($_POST['rating_count'], FILTER_SANITIZE_NUMBER_INT);
        $category = filter_var($_POST['category'], FILTER_SANITIZE_NUMBER_INT);

        // validating user input
        if (empty($name) || empty($price) || empty($ratings) || empty($rating_count) || empty($category)) {
            ?>
            <div class="col-12 text-center">
                <span class="text-danger text-center">All fields are required!</span>
            </div>
            <?php
        } else {
            // Add data securely to the database
            $result = $productInstance->addProduct($name, $detail, $price, $ratings, $rating_count, $category);
            $decoded = json_decode($result, true);
            if ($decoded['success']) {

                $last_id = $dbConn->getConnection()->insert_id;
                echo "insert id" . $last_id;

                //handle image upload
                $target_dir = "../imgs/products/";
                $targetFile = $target_dir . basename($_FILES["productImage"]["name"]);
                $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

                $uploadOk = 1;
                $check = getimagesize($_FILES["productImage"]["tmp_name"]);
                if ($check !== false) {
                    $uploadOk = 1;
                } else {
                    echo "File is not an image.";
                    $uploadOk = 0;
                }
                if (file_exists($targetFile)) {
                    echo "Sorry, file already exists.";
                    $uploadOk = 0;
                }
                if ($_FILES["productImage"]["size"] > 500000) {
                    echo "Sorry, your file is too large.";
                    $uploadOk = 0;
                }
                if ($imageFileType != "jpg") {
                    echo "Sorry, only JPG files are allowed.";
                    $uploadOk = 0;
                }
                if ($uploadOk == 0) {
                    echo "Sorry, your file was not uploaded.";
                } else {
                    $newFileName = $last_id . ".jpg";
                    $newTargetFile = $target_dir . $newFileName;
                    if (move_uploaded_file($_FILES["productImage"]["tmp_name"], $newTargetFile)) {
                        echo "The file " . htmlspecialchars(basename($_FILES["productImage"]["name"])) . " has been uploaded.";
                    } else {
                        echo "Sorry, there was an error uploading your file.";
                    }
                }
                ?>
                <div class="col-12 text-center">
                    <span class="text-success text-center">Product added successfully!</span>
                </div>
                <?php
            }


        }
    }

    if (isset($_GET['deleteItem'])) {
        // Sanitize input for deleteItem
        $deleteItem = filter_var($_GET['deleteItem'], FILTER_SANITIZE_NUMBER_INT);
        $result = $productInstance->deleteProduct($deleteItem);
        $decoded = json_decode($result, true);
        if ($decoded['success']) {
            header("Location: " . $_SERVER['PHP_SELF']);
        }
    }
    ?>
    <main class="row">
        <section class="delete-list col-lg-12 col-md-12">
            <p class="delete-title-text m-0">Update or Delete <span> Products</span>!</p>
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Detail</th>
                        <th>Rating</th>
                        <th>Rating Count</th>
                        <th>Category ID</th>
                        <th>Update</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody id="list-view">
                    <?php
                    foreach ($productList as $item) {
                        ?>
                        <tr>
                            <td>
                                <?php echo $item['product_id'] ?>
                            </td>
                            <td>
                                <?php echo $item['product_name'] ?>
                            </td>
                            <td>
                                <?php echo $item['product_price'] ?>
                            </td>
                            <td>
                                <?php echo $item['product_detail'] ?>
                            </td>
                            <td>
                                <?php echo $item['product_ratings'] ?>
                            </td>
                            <td>
                                <?php echo $item['product_rating_count'] ?>
                            </td>
                            <td>
                                <?php echo $item['product_category'] ?>
                            </td>
                            <td>
                                <a href="./admin_update.php?updateItem=<?php echo urlencode($item['product_id']) ?>">
                                    <img src="../imgs/edit.png" class="edit-icon invert" alt="">
                                </a>
                            </td>
                            <td>
                                <a
                                    href="<?php echo $_SERVER['PHP_SELF'] ?>?deleteItem=<?php echo urlencode($item['product_id']) ?>">
                                    <img src="../imgs/delete.png" class="edit-icon" alt="">
                                </a>
                            </td>

                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </section>
        <section class="add-form col-lg-6 col-md-12 p-0">
            <form class="add-form" method="POST" enctype="multipart/form-data"
                action="<?php echo $_SERVER["PHP_SELF"]; ?>">
                <p class="add-title-text">Create A New <span>Product!</span></p>

                <div class="row justify-content-center">
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <label id="title-text" for="name">Name:</label>
                        <input type="text" id="title" name="name" placeholder="Enter product name" /><br /><br />
                    </div>

                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <label id="title-text" for="Price">Price:</label>
                        <input type="number" id="title" name="price" placeholder="Enter product Price" /><br /><br />
                    </div>
                </div>

                <div class="row justify-content-center">
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <label id="title-text" for="Rating">Rating:</label>
                        <input type="number" id="title" name="ratings" placeholder="Enter product Rating" /><br /><br />
                    </div>

                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <label id="title-text" for="Ratings count">Ratings count:</label>
                        <input type="number" id="title" name="rating_count"
                            placeholder="Enter product Ratings count" /><br /><br />
                    </div>
                </div>

                <div class="row justify-content-center">
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <label id="title-text" for="Category ID">Category ID:</label>
                        <input type="number" id="title" name="category"
                            placeholder="Enter product Category ID" /><br /><br />
                    </div>

                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <input type="file" id="productImage" class="start-button" name="productImage" accept="image/*">
                    </div>
                </div>

                <label id="title-text" for="Details">Details:</label><br />
                <textarea id="title" class="col-8" name="detail"
                    placeholder="Enter product details"></textarea><br /><br />

                <input type="submit" class="submit-button mb-5" value="ADD Product" />
            </form>
        </section>
    </main>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>