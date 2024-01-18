<?php
// Assuming you have a database connection, replace the following with your actual database connection code
$api_file_path = __DIR__ . '/user-api.php';

$email = $password = "";
$email_err = $password_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate email
    if (empty(trim($_POST["email"]))) {
        $email_err = "Please enter your email.";
    } else {
        $email = trim($_POST["email"]);
    }

    // Validate password
    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter your password.";
    } else {
        $password = trim($_POST["password"]);
    }

    // Check input errors before processing the login
    if (empty($email_err) && empty($password_err)) {
        // Prepare data for API request
        $data = [
            'action' => 'login',
            'email' => $email,
            'password' => $password,
        ];

        // Make API request
        $ch = curl_init('file://' . $api_file_path);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        $api_response = curl_exec($ch);
        curl_close($ch);

        // Process API response
        echo $api_response; // You may need to handle the API response accordingly


        $api_data = json_decode($api_response, true);

        if (isset($api_data['success']) && $api_data['success']) {
            session_start();
            $_SESSION["loggedin"] = true;
            // ... (store other user data in the session if needed)
            header("location: welcome.php");
            exit;
        } else {
            // Display an error message
            echo "Login failed. Please check your credentials.";
        }
    }
}
?>


<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sign In</title>
    <style>
        main {
            background-color: #1a1d1a;
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            font-family: 'Arial', sans-serif;
            font-size: 18px;
            line-height: 1.6;
        }

        .card-container {
            background-color: #2c2f2c;
            border-radius: 10px;
            box-shadow: 0 0 20px #1a1d1a;
            padding: 20px;
            width: 90%;
            /* Adjust the width as needed */
            max-width: 600px;
            /* Set a maximum width if needed */

            margin: auto;
        }



        h2 {
            color: #fc6d6d;
            font-size: 2em;
            margin-bottom: 15px;
            text-align: left;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: white;
            text-align: left;
            /* Label text color */
        }

        input,
        select {
            display: block;
            width: calc(100% - 24px);
            padding: 8px;
            margin-bottom: 15px;
            font-size: 1em;
            border: 1px solid #fc6d6d;
            border-radius: 8px;
            background-color: #2c2f2c;
            color: white;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
        }

        input[type="submit"] {
            background: linear-gradient(to right, #fc6d6d, #fc4d4d);
            color: white;
            border: none;
            padding: 14px 20px;
            cursor: pointer;
            font-size: 1em;
            border-radius: 8px;
            transition: background 0.3s ease;
        }

        input[type="submit"]:hover {
            background: linear-gradient(to right, #fc4d4d, #fc6d6d);
        }

        span {
            color: #fc6d6d;
            font-size: 0.9em;
            display: block;
            margin-top: 5px;
        }

        p {
            color: #888;
            margin-top: 10px;
        }

        a {
            color: #fc6d6d;
            text-decoration: none;
            /* Remove underline */
        }

        a:hover {
            text-decoration: underline;
            /* Add underline on hover */
        }
    </style>
</head>

<body>
    <?php include "custom_nav.php"; ?>
    <main>
        <div class="card-container justify-content-center">
            <div>
                <h2>Sign In</h2>

                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <label for="email">Email:</label><br>
                    <input type="email" id="email" name="email">
                    <span>
                        <?php echo $email_err; ?>
                    </span><br>

                    <label for="password">Password:</label><br>
                    <input type="password" id="password" name="password">
                    <span>
                        <?php echo $password_err; ?>
                    </span><br>

                    <input type="submit" value="Login">
                </form>
                <p>Don't have an account? <a href="signup.php">Sign up here</a>.</p>
            </div>
        </div>

    </main>
</body>

</html>