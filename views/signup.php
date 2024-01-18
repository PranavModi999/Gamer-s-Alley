<?php
// Define API endpoint file path
$api_file_path = __DIR__ . '/user-api.php';

// Define variables and initialize with empty values
$first_name = $last_name = $email = $password = $confirm_password = "";
$first_name_err = $last_name_err = $email_err = $password_err = $confirm_password_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate first name
    if (empty(trim($_POST["first_name"]))) {
        $first_name_err = "Please enter your first name.";
    } else {
        $first_name = trim($_POST["first_name"]);
    }

    // Validate last name
    if (empty(trim($_POST["last_name"]))) {
        $last_name_err = "Please enter your last name.";
    } else {
        $last_name = trim($_POST["last_name"]);
    }

    // Validate email
    if (empty(trim($_POST["email"]))) {
        $email_err = "Please enter your email.";
    } else {
        $email = trim($_POST["email"]);
    }

    // Validate password
    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter a password.";
    } elseif (strlen(trim($_POST["password"])) < 6) {
        $password_err = "Password must have at least 6 characters.";
    } else {
        $password = trim($_POST["password"]);
    }

    // Validate confirm password
    if (empty(trim($_POST["confirm_password"]))) {
        $confirm_password_err = "Please confirm password.";
    } else {
        $confirm_password = trim($_POST["confirm_password"]);
        if (empty($password_err) && ($password != $confirm_password)) {
            $confirm_password_err = "Password did not match.";
        }
    }

    // Check input errors before inserting in the database
    if (empty($first_name_err) && empty($last_name_err) && empty($email_err) && empty($password_err) && empty($confirm_password_err)) {
        // Prepare data for API request
        $data = [
            'first_name' => $first_name,
            'last_name' => $last_name,
            'email' => $email,
            'password' => $password,
            'user_type' => 'User', // Set your default user type
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
        $api_data = json_decode($api_response, true);

        if (isset($api_data['success']) && $api_data['success']) {
            // Registration successful, redirect to login page
            header("location: signin.php");
        } else {
            // Registration failed, display error message
            echo "Something went wrong. Please try again later.";
        }
    }
}
?>

<!DOCTYPE html>
<html>


<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sign Up</title>
    <style>
        main {
            background-color: #1a1d1a;
            color: white;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            font-family: 'Arial', sans-serif;
            font-size: 18px;
            line-height: 1.6;
        }

        .card-container {
            width: 100;
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
        }

        input,
        select {
            display: block;
            width: calc(100% - 24px);
            padding: 6px;
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
        }

        @media screen and (max-width: 768px) {
            .card-container {
                max-width: 90%;
            }
        }
    </style>

</head>

<body>
    <?php include "custom_nav.php"; ?>
    <main>
        <div class="card-container justify-content-center">
            <div>
                <h2>Sign Up</h2>

                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <label for="first_name">First Name:</label><br>
                    <input type="text" id="first_name" name="first_name"><br>

                    <label for="last_name">Last Name:</label><br>
                    <input type="text" id="last_name" name="last_name"><br>

                    <label for="email">Email:</label><br>
                    <input type="email" id="email" name="email"><br>

                    <label for="password">Password:</label><br>
                    <input type="password" id="password" name="password"><br>

                    <label for="confirm_password">Confirm Password:</label><br>
                    <input type="password" id="confirm_password" name="confirm_password"><br>

                    <label for="user_type">User Type:</label><br>
                    <select id="user_type" name="user_type">
                        <option value="User">User</option>
                        <option value="Admin">Admin</option>

                    </select><br>

                    <span>
                        <?php echo $first_name_err; ?>
                    </span><br>
                    <span>
                        <?php echo $last_name_err; ?>
                    </span><br>
                    <span>
                        <?php echo $email_err; ?>
                    </span><br>
                    <span>
                        <?php echo $password_err; ?>
                    </span><br>
                    <span>
                        <?php echo $confirm_password_err; ?>
                    </span><br>
                    <input type="submit" value="Submit">
                </form>
                <p>Already have an account? <a href="signin.php">Sign in here</a>.</p>

            </div>
        </div>

    </main>
</body>

</html>