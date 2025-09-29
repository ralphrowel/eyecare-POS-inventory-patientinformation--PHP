<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$database = "justine";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$error = "";

// Handle login only after form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['login'])) {
    $user = trim($_POST['username']);
    $pass = trim($_POST['password']);

    if (!empty($user) && !empty($pass)) {
        $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? AND password = ?");
        $stmt->bind_param("ss", $user, $pass);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows === 1) {
            $_SESSION['username'] = $user;
            header("Location: dashboard.php");
            exit();
        } else {
            $error = "Incorrect username or password!";
        }

        $stmt->close();
    } else {
        $error = "Please fill in both fields.";
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login Form</title>
    <link rel="stylesheet" href="style.css" />
</head>
<body>
    <img src="beter.png" class="namecomp" />

    <div class="form-box">
        <form action="" method="POST">
            <h2><b>Login</b></h2>

            

            <input type="text" name="username" placeholder="USERNAME" required />
            <input type="password" name="password" placeholder="PASSWORD" required />

            <button type="submit" name="login">Log In</button>
            <button type="button" onclick="window.location.href='createaccount.php'">Create Account</button>
            <p><a href="forgetpassword.php">Forgot Password?</a></p>
        </form>

        
    </div>
</body>
</html>
