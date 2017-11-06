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
 
$facebook = new Facebook([
    'app_id' => '547715898894425', // APP ID
    'app_secret' => '26a2811412323bc50fef767000d24ea3',//SECRET
    'default_graph_version' => 'v2.5',
]);


$signed_request = $facebook->getSignedRequest();
if($signed_request["page"]["liked"]!=1){
 $is_liked = false; 
}else{
 $is_liked = true;
}
    ?>
    
<!doctype html>
<html xmlns:fb="http://www.facebook.com/2008/fbml">
<meta http-equiv="Content-Type" co
<head>
<title>Tutorial FaceBook App</title>

</head>
<body>
<?php
if($is_liked ){
    $user = $facebook->getUser();
    if ($user) {
      try {
        // Proceed knowing you have a logged in user who's authenticated.
        $user_profile = $facebook->api('/me');
      } catch (FacebookApiException $e) {
        error_log($e);
        $user = null;
      }
        $code = $_REQUEST["code"];
        if(empty($code)) {
            $_SESSION['state'] = md5(uniqid(rand(), TRUE)); //CSRF protection
            $dialog_url = "http://www.facebook.com/dialog/oauth?client_id=" 
            . $config["appId"] . "&redirect_uri=" . urlencode(CANVAS_PAGE) . "&state="
            . $_SESSION['state'];
    
            echo("<script> top.location.href='" . $dialog_url . "'</script>");
        }
        //get user access_token
        $token_url = 'https://graph.facebook.com/oauth/access_token?client_id='
        . $config["appId"] . '&redirect_uri=' . urlencode(CANVAS_PAGE) 
        . '&client_secret=' . $config["secret"] 
        . '&code=' . $code;
        $access_token = file_get_contents($token_url);
        
        // Run fql query
        $fql_query_url = 'https://graph.facebook.com/'
        . '/fql?q=SELECT+birthday+FROM+user+WHERE+uid=me()'
        . '&' . $access_token;
        $fql_query_result = file_get_contents($fql_query_url);
        $fql_query_obj = json_decode($fql_query_result, true);
        $birthday = $fql_query_obj["data"][0]["birthday"];
        ?>
        <img src="https://graph.facebook.com/<?php echo $user; ?>/picture">
        <h3>Chào <strong><?=$outname . " " . $user_profile["name"];?></strong></h3>
        
        <div>
            <p>Ngày sinh của bạn là: <?=$birthday?></p>
            
        </div>
        <?php
    }else{
        echo("<script> top.location.href='" . $facebook->getLoginUrl() . "&scope=user_birthday'</script>");
    }
}else{
    ?>
    <img src="images/like.jpg" border="0" />
    <?php
}

?> 
</body>
</html> 