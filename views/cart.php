<!DOCTYPE html>
<html lang="en">

<head>
    <?php include "header.php" ?>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: #555;
            color: #fff;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
            color: #fff;
        }

        th {
            background-color: #DF826C;
        }

        .total {
            margin-top: 10px;
            font-weight: bold;
            color: #fff;
        }

        .quantity-input {
            width: 40px;
            margin: auto;
            border-radius: 4px;
            border: 1px solid grey;
            text-align: center;
        }

        .checkout-button,
        .delete-button,
        .quantity-button {
            margin-top: 20px;
            padding: 10px;
            cursor: pointer;
            border: 2px solid transparent;
            /* Transparent border */
            border-radius: 20px;
            /* Rounded corners */
            transition: border-color 0.3s, background-color 0.3s;
            /* Smooth color transition on hover */
        }

        .checkout-button {
            background-color: #4CAF50;
            color: white;
            border-color: #4CAF50;
            /* Green border */
        }

        .delete-button {
            background-color: #FF0000;
            color: white;
            border-color: #FF0000;
            /* Red border */
        }



        .quantity-button.increase {
            background-color: #4CAF50;
            color: white;
            border-color: #4CAF50;
            /* Green border */
        }

        .quantity-button.decrease {
            background-color: #FF0000;
            color: white;
            border-color: #FF0000;
            /* Red border */
        }

        .quantity-button:hover,
        .checkout-button:hover,
        .delete-button:hover {
            background-color: #555;
            /* Darker color on hover */
        }
    </style>
</head>

<body>
    <?php include "custom_nav.php";
    require_once('../api/config/Database.php');
    require_once('../api/Product.php');
    require_once('../api/Cart.php');

    $dbConn = new Database();

    $cartInstance = new Cart($dbConn->getConnection());
    $cartList = $cartInstance->getAllCarts();

    $productInstance = new Product($dbConn->getConnection());

    if (isset($_GET['deleteItem'])) {
        $cartInstance->deleteCart((int) $_GET['deleteItem']);
        header('location:cart.php');
    }
    ?>
    <div class="col-8 m-auto text-center">
        <h2>Your Shopping Cart</h2>
        <hr />
    </div>
    <div class="col-8 m-auto">

        <table class="table">
            <thead>
                <tr>
                    <th>name</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="list-view">
                <?php
                foreach ($cartList as $item) {
                    $currentProduct = $productInstance->getProductById($item['product_id']);
                    ?>
                    <tr>
                        <td>
                            <?php echo $currentProduct['product_name'] ?>
                        </td>
                        <td>
                            <?php echo $currentProduct['product_price'] ?>
                        </td>
                        <td class="">
                            <input type="text" class="quantity-input" value="<?php echo $item['qty'] ?>"
                                onchange="updateTotal(this)" disabled>
                        </td>
                        <td id="totalB">
                            <?php echo $currentProduct['product_price'] * $item['qty'] ?>
                        </td>
                        <td>
                            <a href="<?php echo $_SERVER['PHP_SELF'] ?>?deleteItem=<?php echo urlencode($item['id']) ?>">
                                <img src="../imgs/delete.png" class="edit-icon" alt="">
                            </a>
                        </td>
                    </tr>
                    <?php
                }
                ?>
            </tbody>
        </table>

        <a href="./checkout.php">
            <button class="submit-button">Checkout</button>
        </a>

    </div>
</body>

</html>