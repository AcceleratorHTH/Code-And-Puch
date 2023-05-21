<?php
session_start();
header('Content_Type:text/html;charset=UTF-8');

if (isset($_SESSION['flash_message'])) {
    echo '<script type="text/javascript">';
    echo 'alert("' . $_SESSION['flash_message'] . '");';
    echo '</script>';
    unset($_SESSION['flash_message']);
}

if (isset($_POST["login"])) {
    include 'connect.php';

    $user = $_POST['username'];
    $pass = $_POST['password'];

    $query = "SELECT * FROM users WHERE username = ?";

    // Initialize a statement for the query
    $stmt = mysqli_prepare($connect, $query);

    // Bind the $user variable to the statement
    mysqli_stmt_bind_param($stmt, "s", $user);

    // Execute the statement
    mysqli_stmt_execute($stmt);

    // Get the result of the query
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);

        // Verify the password
        if (password_verify($pass, $user['password'])) {
            echo "<script>alert('Login successful');</script>";
        } else {
            echo "<script>alert('Wrong username or password');</script>";
        }
    } else {
        echo "<script>alert('Wrong username or password');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login</title>
        <link rel="stylesheet" href="stylesheet.css"/>
    </head>

    <body>
        <div id="wrapper">
            <div class="form">
                <form action="" method="POST" id="form-login">
                    <h1 class="form-heading">
                        <font size="9" style="background: url(&quot;images/chopnhay.gif&quot;)
                              repeat scroll 0% 0% transparent; color:white;text-shadow: 0 0 0.2em #241D1B,0 0 0.2em #241D1B">LOGIN</font>
                    </h1>
                    <div class="form-group">
                        <label for="username">Username:</label>
                        <input type="text" id="username" name="username" class="form-input"/>
                    </div>
                    <div class="form-group">
                        <label for="password">Password:</label>
                        <input type="password" id="password" name="password" class="form-input"/>
                    </div>
                    <input type="submit" class="form-submit" name="login" value="Login"/>
                    <a href="register.php"> No account? Register now! </a>
                </form>
            </div>
        </div>

    </body>

</html>

