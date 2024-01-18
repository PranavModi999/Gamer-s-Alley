<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            background-color: #333;
            color: #fff;
        }

        .confirmation-container {
            width: 90%;
            max-width: 600px;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
        }

        .confirmation-message,
        .order-details,
        .back-to-home {
            border: 1px solid #ddd;
            margin-bottom: 20px;
            background-color: #555;
            color: #fff;
            border-radius: 10px;
        }

        .confirmation-message h2,
        .order-details h3 {
            margin-top: 0;
            color: #fff;
        }

        .confirmation-message,
        .order-details {
            padding: 20px;
        }

        .order-details p {
            margin: 10px 0;
        }

        .back-to-home {
            margin-top: 20px;
            text-align: center;
        }

        .back-to-home a {
            text-decoration: none;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            display: inline-block;
        }

        .back-to-home a:hover {
            background-color: #45a049;
        }

        @media (max-width: 768px) {
            .confirmation-container {
                width: 95%;
            }
        }
    </style>
</head>
<body>

    <div class="confirmation-container">

        <div class="confirmation-message">
            <h2>Order Confirmation</h2>
            <p>Thank you for your order! Your purchase is confirmed.</p>
        </div>

       
        <div class="back-to-home">
            <a href="index.html">Continue Shopping</a>
        </div>

    </div>

</body>
</html>