<?php



try {
  // Returns a `Facebook\FacebookResponse` object
  $response_pic = $fb->get('/me?fields=id,name,email,birthday,relationship_status,picture,gender', $_SESSION['facebook_access_token']);
} catch(Facebook\Exceptions\FacebookResponseException $e) {
  echo 'Graph returned an error: ' . $e->getMessage();
  exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
  echo 'Facebook SDK returned an error: ' . $e->getMessage();
  exit;
}

$user = $response_pic->getGraphUser();
$birthday = $user['birthday'];
$gender = $user['gender'];
$ngaysinh = (array)$birthday;
$ngay_sinh_chuan = $ngaysinh['date'];
$time_format = date('d-m-Y',strtotime($ngay_sinh_chuan));
//var_dump($user);
echo '<br>email: ' . $user['email'].'<br>';
echo 'Ngày sinh: '.$time_format;
?>