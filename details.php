<?php
session_start();
require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'config/init.php');

$checksum = $_SESSION['checksum'];
$user_access_token = $_SESSION['user_access_token'];


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
?>
<!DOCTYPE html>
<html>
<?php include('templates/header.php') ?>
<section class="container grey-text <?php echo $hidemydiv ?>">
  <h4 class="center ">User Logged in!</h4>
  <table>
    <tbody>
      <tr>
        <td>Name</td>
        <td><?php
            echo Globals::$userObj->user_name
            ?>
        </td>
      </tr>
      <tr>
        <td>Firstname</td>
        <td><?php echo Globals::$userObj->user_firstname ?></td>
      </tr>
      <tr>
        <td>Email</td>
        <td><?php echo Globals::$userObj->user_email ?></td>
      </tr>
      <td>Signed agreement</td>
      <td><?php echo Globals::$userObj->signed_agreement ?></td>
      </tr>
      <td>Force password</td>
      <td><?php echo Globals::$userObj->user_force_password ?></td>
      </tr>
      <tr>
        <td>Language</td>
        <td><?php echo Globals::$userObj->user_language ?></td>
      </tr>
      <tr>
        <td>Level</td>
        <td><?php echo Globals::$userObj->user_level ?></td>
      </tr>
      <tr>
        <td>Mobile</td>
        <td><?php echo Globals::$userObj->user_mobile ?></td>
      </tr>
      <tr>
        <td>Tel</td>
        <td><?php echo Globals::$userObj->user_tel ?></td>
      </tr>
    </tbody>
  </table>
</section>
<?php include('templates/footer.php') ?>

</html>