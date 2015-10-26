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
        $postContent = $post['data']['selftext'];
        $postCreated = date("d/m/Y H:ia", $post['data']['created_utc']);

        if (stristr($postTitle, 'Hiring') == TRUE) {

            $postTitleLower = strtolower($postTitle);
            $postContentLower = strtolower($postContent);

            foreach ($keywordsPositive as $keyword) {
                if (stristr($postTitleLower, $keyword) == true) {
                    $score++;
                }
                if (stristr($postHTMLTextLower, $keyword) == true) {
                    $score++;
                }
            }

            foreach ($keywordsNegative as $keyword) {
                if (stristr($postTitleLower, $keyword) == true) {
                    $score--;
                }
                if (stristr($postHTMLTextLower, $keyword) == true) {
                    $score--;
                }
            }

            $postTitle = str_replace($keywordsStrip, '', $postTitle);

            $post['data']['title'] = $postTitle;
            $post['data']['text'] = $postContent;
            $post['data']['created'] = $postCreated;
            $post['data']['score'] = $score;

            $filteredPosts[] = $post['data'];

            $existingTitlesArray[] = $postTitle;
        }
    }

    $filteredPostsJson = json_encode($filteredPosts);

    file_put_contents($cacheFile, $filteredPostsJson);
}

//print_r(json_decode($filteredPostsJson, TRUE));

echo $filteredPostsJson;