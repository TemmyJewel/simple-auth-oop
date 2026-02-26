<?php 
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
</head>
<body>
    <h1>Welcome to your dashboard, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>

    <h2>News Categories</h2>
    <ul>
        <li><a href="#">Technology</a></li>
        <li><a href="#">Sports</a></li>
        <li><a href="#">Business</a></li>
        <li><a href="#">Entertainment</a></li>
        <li><a href="#">Health</a></li>
    </ul>
    
    <form action="logout-handler.php" method="POST" style="display:inline;">
        <button type="submit" class="btn-logout">Logout</button>
    </form>
</body>
</html>