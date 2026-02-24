<?php
session_start();
$message = $_SESSION['message'] ?? '';
unset($_SESSION['message']);
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login</title>
</head>

<body style="padding: 20px;">
    <h1 style="font-size: 36px">LOGIN</h1>

    <?php if (!empty($message)): ?>
        <p><?php echo htmlspecialchars($message); ?></p>
    <?php endif; ?>

    <form action="login-handler.php" method="POST" style="font-size: 20px;">
        <label for="email">Username:</label><br />
        <input type="text" name="username" required style="font-size: 18px; padding: 5px" /><br /><br />

        <label for="password">Password:</label><br />
        <input type="password" name="password" required style="font-size: 18px; padding: 5px" /><br /><br />

        <p><a href="recover-password.php">Recover Password</a></p>

        <input type="submit" value="Login" style="font-size: 20px; padding: 10px 15px" />

        <p>Don't have an account? <a href="register.php">Register here</a></p>
    </form>
</body>

</html>