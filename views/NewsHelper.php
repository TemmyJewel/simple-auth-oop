<?php
namespace App\views;

class NewsHelper {
    public function newsCard($newsData) {
        if (empty($newsData)) {
            echo '<p>No news available at the moment </p>';
            return;
        }

        if (isset($newsData) && is_array($newsData)) {  
            foreach ($newsData as $news_item) {
                echo '<div>';
                echo '<h3>' . htmlspecialchars($news_item['title']) . '</h3>';
                echo '<p>' . htmlspecialchars($news_item['snippet']) . '</p>';
                echo '<a href="' . htmlspecialchars($news_item['link']) . '" target="_blank">Read more</a>';
                echo '<p>Authors: ' . (!empty($news_item['authors']) ? implode(', ', $news_item['authors']) : 'Unknown') . '</p>';
                echo '<hr>';
                echo '</div>';
            }
        } else {
            echo '<p>No news data available.</p>';
        }
    }

}

