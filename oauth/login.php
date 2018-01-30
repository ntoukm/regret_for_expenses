<?php

session_start();

require_once 'common.php';
require_once 'twitteroauth/autoload.php';

use Abraham\TwitterOAuth\TwitterOAuth;

$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET); // TwitterOAuthのインスタンスを生成

$request_token = $connection->oauth('oauth/request_token', ['oauth_callback' => OAUTH_CALLBACK]); // コールバックURLのセット
// callback.phpで利用
$_SESSION['oauth_token'] = $request_token['oauth_token'];
$_SESSION['oauth_token_secret'] = $request_token['oauth_token_secret'];

$url = $connection->url('oauth/authenticate', ['oauth_token' => $request_token['oauth_token']]); // Twitterの認証画面のURLを取得
header('location:'.$url);
