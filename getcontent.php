<?php

$cacheFile = 'cache/filteredPosts.json';

// first, check for a recent local copy
if (file_exists($cacheFile) && (filemtime($cacheFile) < time() - 600)) {

    $filteredPostsJson = file_get_contents($cacheFile);

} else {

    $sources = array(
        'https://www.reddit.com/r/forhire/new.json',
        'https://www.reddit.com/r/hiring/new.json',
    );

    $posts = array();
    $filteredPosts = array();
    $existingTitlesArray = array();

    $keywordsPositive = array('php', 'laravel', 'slim', 'silex', 'aws', 'api', 'data');
    $keywordsNegative = array('seo');
    $keywordsStrip = array('[hiring]');

    foreach ($sources as $source) {
        $contentJson = file_get_contents($source);
        $contentArray = json_decode($contentJson, TRUE);
        $posts = array_merge($posts, $contentArray['data']['children']);
    }

    foreach ($posts as $post) {

        $score = 0;
        $postTitle = $post['data']['title'];
        $postHTMLText = html_entity_decode($post['data']['selftext_html']);
        $postCreated = date("d/m/Y H:ia", $post['data']['created_utc']);

        if (stristr($postTitle, 'Hiring') == TRUE) {

            $postTitle = strtolower($postTitle);
            $postHTMLText = strtolower($postHTMLText);

            foreach ($keywordsPositive as $keyword) {
                if (stristr($postTitle, $keyword) == true) {
                    $score++;
                }
                if (stristr($postHTMLText, $keyword) == true) {
                    $score++;
                }
            }

            foreach ($keywordsNegative as $keyword) {
                if (stristr($postTitle, $keyword) == true) {
                    $score--;
                }
                if (stristr($postHTMLText, $keyword) == true) {
                    $score--;
                }
            }

            $postTitle = str_replace($keywordsStrip, '', $postTitle);

            $post['data']['title'] = $postTitle;
            $post['data']['text'] = strip_tags($postHTMLText);
            $post['data']['created'] = $postCreated;
            $post['data']['score'] = $score;

            $filteredPosts[] = $post['data'];

            $existingTitlesArray[] = $postTitle;
        }
    }

    $filteredPostsJson = json_encode($filteredPosts);

    file_put_contents($cacheFile, $filteredPostsJson);
}

echo $filteredPostsJson;