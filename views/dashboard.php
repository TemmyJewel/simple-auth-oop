<?php

require_once __DIR__ . '/../bootstrap.php';


session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

    $data = $newsController->index();
    $newsData = $data['newsData'];
    $category = $data['category'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
</head>
<body>
    <form action="logout-handler.php" method="POST" style="display:inline;">
        <button type="submit" class="btn-logout">Logout</button>
    </form>
    <h1>Welcome to your dashboard, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>

    <h2>News Categories</h2>
    <ul>
        <li><a href="dashboard.php?cat=Technology">Technology</a></li>
        <li><a href="dashboard.php?cat=Sports">Sports</a></li>
        <li><a href="dashboard.php?cat=Business">Business</a></li>
        <li><a href="dashboard.php?cat=Entertainment">Entertainment</a></li>
        <li><a href="dashboard.php?cat=Health">Health</a></li>
        <li><a href="dashboard.php?cat=General">General</a></li>
    </ul>

    <h2><?php echo htmlspecialchars($category->value); ?> News</h2>
    <div>
            <?php $newsHelper->newsCard($newsData); ?>
    </div>
    
    
</body>
</html>

