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
    <title>Register</title>
</head>

<body style="padding: 20px;">
    <h1 style="font-size: 36px">REGISTER</h1>

    <?php if (!empty($message)): ?>
        <p><?php echo htmlspecialchars($message); ?></p>
    <?php endif; ?>

    <form action="register-handler.php" method="POST" style="font-size: 20px; line-height: 1.5">

        <label for="username">Username:</label><br />
        <input type="text" name="username" required style="font-size: 18px; padding: 5px" /><br /><br />

        <label for="email">Email:</label><br />
        <input type="email" name="email" required style="font-size: 18px; padding: 5px" /><br /><br />

        <label for="password">Password:</label><br />
        <input type="password" name="password" required style="font-size: 18px; padding: 5px" /><br /><br />

        <input type="submit" value="Register" style="font-size: 20px; padding: 10px 15px" />

        <p>Already have an account? <a href="login.php">Login here</a></p>
    </form>
</body>

</html>