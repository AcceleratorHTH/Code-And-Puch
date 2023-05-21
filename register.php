<?php
session_start();
header('Content_Type:text/html;charset=UTF-8');
$error_message = '';
if (isset($_POST["register"])) {
    include 'connect.php';

// Get the user input
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

// Check if the passwords match
    if ($password != $confirm_password) {
        $error_message = "Passwords do not match. Please try again.";
    }

// Hash the password
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

// Prepare the statement
    $stmt = mysqli_prepare($connect, "INSERT INTO users (username, password) VALUES (?, ?)");

// Bind the variables to the statement
    mysqli_stmt_bind_param($stmt, "ss", $username, $hashed_password);

// Execute the statement
    if (mysqli_stmt_execute($stmt)) {
        // Redirect to login page
        $_SESSION['flash_message'] = "Registration successful! Please login.";
        header("Location: login.php");
        exit();
    } else {
        echo "<script>alert('Something went wrong. Please try again later');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Register</title>
        <link rel="stylesheet" href="stylesheet.css"/>
    </head>

    <body>
        <div id="wrapper">
            <div class="form">
                <form action="" method="POST" id="form-register">
                    <h1 class="form-heading">
                        <font size="9" style="background: url(&quot;images/chopnhay.gif&quot;)
                              repeat scroll 0% 0% transparent; color:white;text-shadow: 0 0 0.2em #241D1B,0 0 0.2em #241D1B">REGISTER</font>
                    </h1>
                    <div class="form-group">
                        <label for="username">Username:</label>
                        <input type="text" id="username" name="username" class="form-input"/>
                    </div>
                    <div class="form-group">
                        <label for="password">Password:</label>
                        <input type="password" id="password" name="password" class="form-input"/>
                    </div>
                    <div class="form-group">
                        <label for="confirm_password">Confirm Password:</label>
                        <input type="password" id="confirm_password" name="confirm_password" class="form-input"/>
                    </div>
                    <input type="submit" class="form-submit" name="register" value="Register"/>
                    <?php if ($error_message != ''): ?>
                        <p class="error-message"><?php echo $error_message; ?></p>
                    <?php endif; ?>
                </form>
            </div>
        </div>

    </body>

</html>
