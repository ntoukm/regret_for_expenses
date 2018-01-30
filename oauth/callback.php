<?php

session_start();

require_once 'common.php';
require_once 'twitteroauth/autoload.php';

use Abraham\TwitterOAuth\TwitterOAuth;

$request_token = [];
$request_token['oauth_token'] = $_SESSION['oauth_token'];
$request_token['oauth_token_secret'] = $_SESSION['oauth_token_secret'];

// Twitterから返されたOAuthトークンが、login.phpでセットしたトークンと一致するか
if (isset($_REQUEST['oauth_token']) && $request_token['oauth_token'] !== $_REQUEST['oauth_token']) {
  die('error. $_REQUEST[oauth_token] and $request_token[oauth_token] are not equal.');
}
// OAuthトークンも利用してTwitterOAuthをインスタンス化
$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $request_token['oauth_token'], $request_token['oauth_token_secret']);

// アプリではaccess_tokenを利用してTwitter上のアカウント情報を取得する
// この変数にOAuthトークンとシークレットトークンが配列で入っている
$_SESSION['access_token'] = $connection->oauth('oauth/access_token', ['oauth_verifier' => $_REQUEST['oauth_verifier']]);

session_regenerate_id();
header('location: /regret_for_expenses/oauth/mypage.php');
