<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$database = "justine";

// Connect to DB
$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = trim($_POST['username']);
    $email = trim($_POST['email']);
    $old = $_POST['OLD_PASSWORD'];
    $new = $_POST['NEW_PASSWORD'];
    $confirm = $_POST['CONFIRM_NEW_PASSWORD'];

    if (empty($user) || empty($email) || empty($old) || empty($new) || empty($confirm)) {
        $message = "❌ Please fill in all fields.";
    } elseif ($new !== $confirm) {
        $message = "❌ New passwords do not match!";
    } else {
        // Check if user exists
        $stmt = $conn->prepare("SELECT password FROM users WHERE username = ? AND email = ?");
        $stmt->bind_param("ss", $user, $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows === 1) {
            $row = $result->fetch_assoc();
            if ($row['password'] !== $old) {
                $message = "❌ Old password is incorrect.";
            } else {
                // Update password
                $update = $conn->prepare("UPDATE users SET password = ? WHERE username = ? AND email = ?");
                $update->bind_param("sss", $new, $user, $email);
                if ($update->execute()) {
                    $message = "✅ Password changed successfully.";
                } else {
                    $message = "❌ Failed to update password.";
                }
                $update->close();
            }
        } else {
            $message = "❌ Username or email is incorrect.";
        }

        $stmt->close();
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <img src="beter.png" class="namecomp">
    <div class="form-box">
        <form method="POST">
            <h2><b>Change Password</b></h2>

            <?php if (!empty($message)): ?>
                <div style="color:red; margin-bottom:10px;">
                    <?= htmlspecialchars($message) ?>
                </div>
            <?php endif; ?>

            <input type="text" name="username" placeholder="Username" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="OLD_PASSWORD" placeholder="Old Password" required>
            <input type="password" name="NEW_PASSWORD" placeholder="New Password" required>
            <input type="password" name="CONFIRM_NEW_PASSWORD" placeholder="Confirm New Password" required>
            <button type="submit">CHANGE PASSWORD</button>
            <p><a href="login.php">Back to Login</a></p>
        </form>
    </div>
</body>
</html>


