<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create an Account Form</title>
    <link rel="stylesheet" href="style.css">
</head>
       
<body>
    <img src="beter.png" class="namecomp">

    <div class="form-box" id="Create-an-Account-form">
        <form action="" method="POST">
            <h2><b>Create an Account</b></h2>
            <input type="text" name="username" placeholder="Username" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="password" name="confirm_password" placeholder="Confirm Password" required>
            <button type="submit" name="submit">Done</button>
            <p><a href="login.php">Back to Login</a></p>

        </form> 
    </div>

    <?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "justine";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection Failed: " . $conn->connect_error);
}

if (isset($_POST['submit'])) {
    $user = trim($_POST['username']);
    $email = trim($_POST['email']);
    $pass = trim($_POST['password']);
    $conf = trim($_POST['confirm_password']);

    if ($pass !== $conf) {
        echo "Passwords do not match!";
    } else {
        $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $user, $email, $pass);

        if ($stmt->execute()) {
            echo "New account created successfully!";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    }
}

$conn->close();
?>

</body>
</html>