<?php
//////////////////////////////////////////////
//DUC LINH - haanhduclinh.com
//BASIC FACEBOOK
//////////////////////////////////////////////
session_start();
use Facebook\Facebook;
// require Facebook PHP SDK
// see: https://developers.facebook.com/docs/php/gettingstarted/
require_once("Facebook/Facebook.php");
require_once 'Facebook/autoload.php';
// initialize Facebook class using your own Facebook App credentials
// see: https://developers.facebook.com/docs/php/gettingstarted/#install
 
$fb = new Facebook([
    'app_id' => '547715898894425', // APP ID
    'app_secret' => '26a2811412323bc50fef767000d24ea3',//SECRET
    'default_graph_version' => 'v2.5',
]);
//$appsecret_proof= hash_hmac('sha256', $access_token, $app_secret);
$helper = $fb->getRedirectLoginHelper();
$permissions = ['email', 'user_likes','publish_actions','user_photos','user_relationships','user_birthday']; // optional
//$loginUrl = $helper->getLoginUrl('https://test-do-bong-cua-ban.herokuapp.com/callback.php', $permissions);//Change YOUR_URL to your URL CALLBACK FILE

$accessToken = $helper->getAccessToken();

echo 'session la: ' . $accessToken;
?>