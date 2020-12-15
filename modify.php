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
$hidePasswordError = 'hide';
Globals::$userObj = new User();
$user = getUser($checksum, $user_access_token);
foreach ((json_decode($user, TRUE)["result"]) as $key => $value) {
    Globals::$userObj->{$key} = $value;
}

if (!Globals::$userObj->user_force_password) {
    $hidemodify = "hide";
}

if (Globals::$userObj->signed_agreement > 0) {
    $hideeul = "hide";
}


if (isset($_GET['submit_eul'])) {
    if (!Globals::$userObj->user_force_password) {
        header("Location: details.php");
    } else {
        $hideeul = "hide";
    }
    modifyEUL($user_access_token, $checksum, client_key);
}

if (isset($_GET['submit_password'])) {
    $newPassword =  urlencode($_GET['new_password']);
    if (validatePassword($newPassword)) {
        if (Globals::$userObj->signed_agreement > 0) {
            header("Location: details.php");
        } else {
            $hidemodify = "hide";
        }
        modifyPassword($newPassword, $user_access_token, $checksum, client_key);
    } else {
        $hidePasswordError = 'unhide';
    }
}

function validatePassword($passwrd)
{
    if (strlen($passwrd) >= 7 && containsNumbers($passwrd) >= 1 && containsSpecChars($passwrd)) {
        return true;
    }
    return false;
}


function containsNumbers($string)
{
    return preg_match('/\\d/', $string) > 0;
}

function containsSpecChars($string)
{
    return preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $string) > 0;
}
?>

<!DOCTYPE html>
<html>
<?php include('templates/header.php') ?>
<section class="container grey-text <?php echo $hideeul ?>">
    <h4 class="center">End user license</h4>
    <form action="" method="GET" class="white">
        <p><?php if (Globals::$userObj->signed_agreement == 0) {
                echo Globals::$userObj->getEUL($checksum, $user_access_token);
            } ?>
        </p>
        <div class="center">
            <label><input type="checkbox" /><span>I AGREE</span></label>
            </br>
            </br>
            <input type="submit" name="submit_eul" value="submit" class="btn brand z-depth-0">
        </div>
    </form>
</section>
<section class="container grey-text <?php echo $hidemodify ?>">
    <h4 class="center">Change Password</h4>
    <form action="" method="GET" class="white">
        <label for="old_password">Old password</label>
        <input type="password" name="old_password" required>
        <label for="new_password">New password</label>
        <input type="password" name="new_password" minlength="7" required>
        <p class="<?php echo $hidePasswordError ?>">
            <br>Your new password should be: <br>* at least 7 characters long <br>* at least 1 numeric character<br>* at least 1 special character<br>
        </p>
        <div class="center">
            <input type="submit" name="submit_password" value="submit" class="btn brand z-depth-0">
        </div>
    </form>
</section>
<?php include('templates/footer.php') ?>

</html>