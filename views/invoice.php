<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Invoice</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat&display=swap">
  <style>
    body {
      padding: 0;
      background-color: #1a1d1a;
      margin: 0;
      font-family: Fira Sans, Arial;
      color: white;
      text-align: center; /* Center align text in the body */
    }

    main {
      width: 90%;
      max-width: 600px;
      margin: auto;
      margin-top: 20px;
    }

    .invoice {
      margin-top: 20px;
      padding: 20px;
      border: 2px solid #ff5a5f;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(255, 90, 95, 0.5);
    }

    h2 {
      margin-bottom: 10px;
      font-family: 'Montserrat', sans-serif;
    }

    p {
      margin: 5px 0;
    }

  </style>
</head>

<body>
  <main class="invoice">
    <div class="order-summary">
      <h2>Invoice</h2>
      <p>Order Number: 123456</p>
      <p>Order Date: December 13, 2023</p>
    </div>

    <div class="customer-info">
      <h2>Customer Information</h2>
      <p>Customer Name: John Doe</p>
      <p>Email: john.doe@example.com</p>
      <p>Phone Number: 123-456-7890</p>
    </div>

    <div class="shipping-info">
      <h2>Shipping Address</h2>
      <p>Address: 123 Main St</p>
      <p>City: Anytown</p>
      <p>Province: State</p>
      <p>ZIP Code: 12345</p>
      <p>Country: United States</p>
    </div>

    <div class="payment-info">
      <h2>Payment Information</h2>
      <p>Payment Method: Pay on Delivery</p>
    </div>

    <div class="order-details">
      <h2>Order Details</h2>
      <p>Items in Cart: 3</p>
      <p>Total Amount: $100.00</p>
    </div>
  </main>
</body>

</html>
