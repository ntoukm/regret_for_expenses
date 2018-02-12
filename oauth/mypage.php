<?php

session_start();

require_once 'common.php';
require_once 'twitteroauth/autoload.php';

use Abraham\TwitterOAuth\TwitterOAuth;

$access_token = $_SESSION['access_token'];

// OAuthトークンも利用してTwitterOAuthをインスタンス化
$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $access_token['oauth_token'], $access_token['oauth_token_secret']);
$twitteroauth_user = $connection->get('account/verify_credentials'); // ユーザー情報を取得

try {
    $dbh = new PDO(
        'mysql:host=localhost;dbname=dev_no_kakin;charset=utf8',
        'root',
        'root',
        array(
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_EMULATE_PREPARES => false,
        )
    );

    $checkUserExistence = $dbh->prepare(
        'SELECT `id` FROM `users` WHERE `twitter_id` = :twitter_id;'
    );
    $checkUserExistence->execute([':twitter_id' => $twitteroauth_user->id]);

    $user_id = $checkUserExistence->fetch(PDO::FETCH_COLUMN);

    // 初回ログインかどうか
    if ($user_id) {
        $_SESSION['user_id'] = $user_id;
    } else {
        $insertUser = $dbh->prepare(
            'INSERT INTO `users` (`name`, `twitter_id`) VALUES (:name, :twitter_id);'
        );
        $insertUser->execute([':name' => $twitteroauth_user->name, ':twitter_id' => $twitteroauth_user->id]);

        $_SESSION['user_id'] = $dbh->lastInsertId('id');
    }
    $_SESSION['is_signined'] = true;
    header('location: /regret_for_expenses/top.php');

} catch(PDOException $e) {
    $error = $e->getMessage();
}
