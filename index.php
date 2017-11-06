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
$loginUrl = $helper->getLoginUrl('https://test-do-bong-cua-ban.herokuapp.com/callback.php', $permissions);//Change YOUR_URL to your URL CALLBACK FILE

//echo '<a href="' . $loginUrl . '">Log in with Facebook!</a>';

?>


<!DOCTYPE HTML>  
<html>
<head>
<style>
.error {color: #FF0000;}
</style>
</head>
<body>  

<?php
// define variables and set to empty values
$nameErr = $emailErr = $genderErr = $websiteErr = "";
$name = $email = $gender = $comment = $website = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (empty($_POST["name"])) {
    $nameErr = "Name is required";
  } else {
    $name = test_input($_POST["name"]);
    // check if name only contains letters and whitespace
    if (!preg_match("/^[a-zA-Z ]*$/",$name)) {
      $nameErr = "Only letters and white space allowed";
    }
  }
  
  if (empty($_POST["email"])) {
    $emailErr = "Email is required";
  } else {
    $email = test_input($_POST["email"]);
    // check if e-mail address is well-formed
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $emailErr = "Invalid email format";
    }
  }
    
  if (empty($_POST["website"])) {
    $website = "";
  } else {
    $website = test_input($_POST["website"]);
    // check if URL address syntax is valid (this regular expression also allows dashes in the URL)
    if (!preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i",$website)) {
      $websiteErr = "Invalid URL";
    }
  }

  if (empty($_POST["comment"])) {
    $comment = "";
  } else {
    $comment = test_input($_POST["comment"]);
  }

  if (empty($_POST["gender"])) {
    $genderErr = "Gender is required";
  } else {
    $gender = test_input($_POST["gender"]);
  }
}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>

<h2>Kiểm tra giới tính của bạn.</h2>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">  
  Tên: <input type="text" name="name" value="<?php echo $name;?>">
  <span class="error">* <?php echo $nameErr;?></span>
  <br>
  E-mail: <input type="text" name="email" value="<?php echo $email;?>">
  <span class="error">* <?php echo $emailErr;?></span>
  <br>  
  Giới tính:
  <input type="radio" name="gender" <?php if (isset($gender) && $gender=="female") echo "checked";?> value="female">Nữ
  <input type="radio" name="gender" <?php if (isset($gender) && $gender=="male") echo "checked";?> value="male">Nam
  <input type="radio" name="gender" <?php if (isset($gender) && $gender=="bede") echo "checked";?> value="bede">Bê đê
  <span class="error">* <?php echo $genderErr;?></span>
  <br><br>
  <input type="submit" name="submit" value="Kiểm tra">  
</form>


<?php
echo "<h2>Kết quả:</h2>";
echo $name;
echo "<br>";
echo $email;
echo "<br>";

echo "<br>";

$text = '';
if( $gender == 'female' ) 
	$text = 'Bạn có 50% bê đê'.
else if ( $gender == 'male' )
	$text = 'Trai thẳng 100%'.
else 
	$text = 'Chào mừng bạn đến với thế giới thứ 3.'
echo $text;
?>

</body>
</html>
