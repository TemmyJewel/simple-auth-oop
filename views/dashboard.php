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
        <?php if (isset($newsData) && is_array($newsData)) : ?>
            <?php foreach ($newsData as $news_item) : ?>
                <div>
                    <h3><?php echo htmlspecialchars($news_item['title']); ?></h3>
                    <p><?php echo htmlspecialchars($news_item['snippet']); ?></p>
                    <a href="<?php echo htmlspecialchars($news_item['link']); ?>" target="_blank">Read more</a>
                        <p>Authors: <?php echo !empty($news_item['authors']) ? implode(', ', $news_item['authors']) : 'Unknown'; ?></p>
                        <hr>
                    </div>
            <?php endforeach; ?>
        <?php else : ?>
            <p>No news data available.</p>
        <?php endif; ?>
    </div>
    
    
</body>
</html>

