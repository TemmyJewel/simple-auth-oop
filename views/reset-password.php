<?php
session_start();
$message = $_SESSION['message'] ?? '';
unset($_SESSION['message']);

$token = $_GET['token'] ?? null;
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Reset Password</title>
</head>

<body style="padding: 20px;">
    <h1 style="font-size: 36px">RESET PASSWORD</h1>

    <?php if (!empty($message)): ?>
        <p><?= htmlspecialchars($message); ?></p>
    <?php endif; ?>

    <form action="reset-password-handler.php" method="POST" style="font-size: 20px;">

        <input type="hidden" name="token" value="<?= htmlspecialchars($token); ?>">
        <label for="password">Enter New Password:</label><br />
        <input type="password" name="password" required style="font-size: 18px; padding: 5px" /><br /><br />


        <label for="confirm_password">Confirm New Password:</label><br />
        <input type="password" name="confirm_password" required style="font-size: 18px; padding: 5px" /><br /><br />

        <p><a href="recover-password.php">Recover Password</a></p>

        <input type="submit" value="Reset Password" style="font-size: 20px; padding: 10px 15px" />

    </form>
</body>

</html>