<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Checkout</title>
  <?php include "header.php" ?>
  <style>
    body {
      padding: 0;
      background-color: #1a1d1a;
      margin: 0;
      font-family: Fira Sans, Arial;
      color: white;
      text-align: center;
      /* Center align text in the body */
    }

    main {
      display: grid;
      grid-template-columns: 1fr 1fr;
      padding: 10px;
    }

    form {
      width: 90%;
      max-width: 600px;
      margin: auto;
    }

    label {
      display: block;
      margin-top: 10px;
      color: white;
    }

    input,
    select {
      width: 100%;
      padding: 8px;
      margin-top: 5px;
      background-color: #1a1d1a;
      border: 1px solid #ff5a5f;
      color: white;
      border-radius: 4px;
      /* Added border-radius */
    }

    button {
      padding: 10px;
      background-color: #ff5a5f;
      color: white;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      margin-top: 10px;
      transition: background-color 0.3s ease;
    }

    button.cancel {
      background-color: #1a1d1a;
      border: 2px solid #ff5a5f;
    }

    button:hover {
      background-color: #1a1d1a;
      border: 2px solid #ff5a5f;
      color: #ff5a5f;
    }

    button.cancel:hover {
      background-color: #ff5a5f;
      color: white;
    }

    .payment-method label {
      display: inline-block;
      /* Display label and radio button in the same line */
      margin-bottom: 10px;
      position: relative;
      padding-left: 25px;
      cursor: pointer;
      font-size: 16px;
    }

    .payment-method input {
      position: absolute;
      left: 0;
      top: 50%;
      transform: translateY(-50%);
    }

    .payment-method .radio-custom {
      position: absolute;
      left: 0;
      top: 50%;
      transform: translateY(-50%);
      width: 16px;
      height: 16px;
      background-color: transparent;
      border: 2px solid #ff5a5f;
      border-radius: 50%;
      transition: background-color 0.3s ease;
    }

    .payment-method input:checked+.radio-custom {
      background-color: #ff5a5f;
    }

    .payment-method input:checked+.radio-custom:after {
      content: '';
      position: absolute;
      left: 50%;
      top: 50%;
      transform: translate(-50%, -50%);
      width: 8px;
      height: 8px;
      background-color: white;
      border-radius: 50%;
    }

    .order-summary,
    h1 {
      margin-top: 20px;
      /* Added margin-top for spacing */
    }

    /* Add your remaining styles below */
  </style>
</head>

<body>
  <?php include "custom_nav.php";
  ?>

  <form class="add-form" method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
    <p class="add-title-text"><span>Checkout!</span></p>
    <p class="add-title-text">Personal Information</p>

    <div class="row justify-content-center">
      <div class="col-lg-6 col-md-6 col-sm-12">
        <label id="title-text" for="name">Name:</label>
        <input type="text" id="title" name="name" placeholder="Enter product name" /><br /><br />
      </div>

      <div class="col-lg-6 col-md-6 col-sm-12">
        <label id="title-text" for="Price">email:</label>
        <input type="email" id="title" name="email" placeholder="Enter product email" /><br /><br />
      </div>
    </div>

    <div class="row justify-content-center">
      <div class="col-lg-6 col-md-6 col-sm-12">
        <label id="title-text" for="address">address:</label>
        <input type="number" id="title" name="addresss" placeholder="Enter product address" /><br /><br />
      </div>

      <div class="col-lg-6 col-md-6 col-sm-12">
        <label id="title-text" for="phone">phone:</label>
        <input type="phone" id="title" name="phone" placeholder="Enter product phone" /><br /><br />
      </div>
    </div>
    <p class="add-title-text">Payment Information</p>
    <div class="row justify-content-center">
      <div class="col-lg-6 col-md-6 col-sm-12">
        <label id="title-text" for="name">Name on card:</label>
        <input type="text" id="title" name="name" placeholder="Enter card name" /><br /><br />
      </div>

      <div class="col-lg-6 col-md-6 col-sm-12">
        <label id="title-text" for="Price">Card number:</label>
        <input type="number" id="title" name="email" placeholder="Enter card number" /><br /><br />
      </div>
    </div>

    <div class="row justify-content-center">
      <div class="col-lg-6 col-md-6 col-sm-12">
        <label id="title-text" for="address">card expiry:</label>
        <input type="date" id="title" name="addresss" placeholder="Enter card expiry" /><br /><br />
      </div>

      <div class="col-lg-6 col-md-6 col-sm-12">
        <label id="title-text" for="phone">CVV:</label>
        <input type="number" id="title" name="cvv" placeholder="Enter cvv" /><br /><br />
      </div>
    </div>
    <a href="./confirmation.php">
      <input type="button" class="submit-button mb-5" value="Buy Now" />
    </a>
  </form>

</body>

</html>