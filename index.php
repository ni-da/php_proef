<?php?>
<!DOCTYPE html>
<html>
<?php include('templates/header.php') ?>
<section class="container grey-text">
    <h4 class="center">User Login</h4>
    <form action="login.php" method="GET" class="white">
        <label for="">E-mailadres</label>
        <input type="text" name="email" required>

        <label for="">Wachtwoord</label>
        <input type="password" name="password" required>
        <?php $reasons = array("password" => "Wrong Username or Password");
        if (isset($_GET["loginFailed"])) {
            echo $reasons[$_GET["reason"]];
        }
        ?>

        <div class="center">
            <input type="submit" name="submit_login" value="submit" class="btn brand z-depth-0">
        </div>
    </form>
</section>
<?php include('templates/footer.php') ?>

</html>