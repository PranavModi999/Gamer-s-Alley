<!DOCTYPE html>
<html>

<head>
    <?php include "header.php" ?>
    
</head>

<body class="container-fluid">
    <?php include "custom_nav.php" ?>
    <main class="row">
        <div class="col-md-7 p-5">
            <p class="intro-text">
                Immerse yourself in gaming with our <br />ultimate gaming
                platform.<br />Use our app to
                <span id="">
                    Discover, Explore.
                </span>
            </p>
            <div class="card-container flex-wrap">
                <div id="card-1">
                    <img class="card-image" src="../imgs/simple.png" />
                    <p></p>
                </div>
                <div id="card-2">
                    <img class="card-image" src="../imgs/budget.png" />
                    <p></p>
                </div>
                <div id="card-3">
                    <img class="card-image" src="../imgs/bar-chart.png" />
                    <p></p>
                </div>
            </div>

            <a href="./product_page.php">
                <button class="start-button">
                    Shop Now
                </button>
            </a>
        </div>
        <div class="col-md-5">
            <div class="m-5 d-flex align-items-center justify-content-center">
                <div class="illustration">
                    <img class="illustration-image image-fluid" src="../imgs/products/4.jpg" alt="illustrate-image" />
                </div>
            </div>
            <div class="banner-text my-2 display-6 text-center">
                <p>Limited time Offer: Get up to <span class="text-danger">50% off</span> on selected items!</p>
            </div>
        </div>
    </main>
</body>

</html>