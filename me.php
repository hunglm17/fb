<?php


$fb->setDefaultAccessToken($_SESSION['facebook_access_token']);

try {
  $response = $fb->get('/me');
  $userNode = $response->getGraphUser();
} catch(Facebook\Exceptions\FacebookResponseException $e) {
  // When Graph returns an error
  echo 'Graph returned an error: ' . $e->getMessage();
  exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
  // When validation fails or other local issues
  echo 'Facebook SDK returned an error: ' . $e->getMessage();
  exit;
}
//var_dump($userNode);
echo 'Logged in as ' . $userNode->getName();
echo '<br>';
$id_user = $userNode->getId();
//echo $id_user;
#POST DATA
// $linkData = [
//   'link' => 'http://haanhduclinh.com',
//   'message' => 'User provided message',
//   'picture' => 'http://haanhduclinh.com/wp-content/uploads/2015/04/ha-anh-duc-linh-404-e1428974578721.png',
//   'description' =>'Thông tin mô tả thử nghiệm'
//   ];
//message must come from userdata. Pre-filled content is forbidden by the flatform policies
// try {
//   $response = $fb->post('/me/feed', $linkData, $_SESSION['facebook_access_token']);
// } catch(Facebook\Exceptions\FacebookResponseException $e) {
//   echo 'Graph returned an error: ' . $e->getMessage();
//   exit;
// } catch(Facebook\Exceptions\FacebookSDKException $e) {
//   echo 'Facebook SDK returned an error: ' . $e->getMessage();
//   exit;
// }
#POST DATA END
$picture_url = 'https://graph.facebook.com/'.$id_user.'/picture?width=250&height=250';
echo "<img src='".$picture_url."''>";
?>