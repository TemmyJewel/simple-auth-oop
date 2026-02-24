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
    <title>Recover Password</title>
</head>

<body style="padding: 20px;">
    <h1 style="font-size: 36px">RECOVER PASSWORD</h1>

    <?php if (!empty($message)): ?>
        <p><?php echo htmlspecialchars($message); ?></p>
    <?php endif; ?>

    <form action="recover-password-handler.php" method="POST" style="font-size: 20px;">

        <label>Enter Email:</label><br />
        <input type="email" name="email" required style="font-size: 18px; padding: 5px" /><br /><br />

        <input type="submit" value="Recover Password" style="font-size: 20px; padding: 10px 15px" />

    </form>
</body>

</html>