<?php
session_start();
require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'config/init.php');

if (isset($_GET['submit_login'])) {
  $emailaddr =  urlencode($_GET['email']);
  $passwrd =  urlencode($_GET['password']);

  $checksum = calculateChecksum();


  $userToken = getUserToken($checksum, $emailaddr, $passwrd);

  if (array_key_exists("access_token", json_decode($userToken, TRUE))) {
    $user_access_token = json_decode($userToken, TRUE)['access_token'];

    Globals::$clientHeader = array(
      'client-id: ' . client_key,
      'client-secret: ' . $checksum,
      'scope: ' . scope,
      'Authorization: Bearer ' . $user_access_token,
    );

    Globals::$userObj = new User();
    $user = getUser($checksum, $user_access_token);

    foreach ((json_decode($user, TRUE)["result"]) as $key => $value) {
      Globals::$userObj->{$key} = $value;
    }
    $_SESSION['checksum'] = $checksum;
    $_SESSION['user_access_token'] = $user_access_token;

    if (Globals::$userObj->isAgreementSigned() && !Globals::$userObj->isPasswordChangeNeeded()) {
      header("Location: details.php");
    } else {
      header("Location: modify.php");
    }
  } else {
    die(header("Location:index.php?loginFailed=true&reason=password"));
  }
}


function calculateChecksum()
{
  $date = date("Ymd");
  $checksum = sha1(sha1(client_key . "_" . client_secret) . "_" . $date);
  return $checksum;
}
