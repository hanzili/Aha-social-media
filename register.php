<?php
require 'config/config.php';
require 'includes/form_handlers/register_handler.php';
require 'includes/form_handlers/login_handler.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Aha!</title>
    <link rel="stylesheet" type="text/css" href="assets/css/b.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="assets\js\register.js"></script>
</head>
<body>
    <?php
    if (isset($_POST['register_button'])) {
        echo '
        <script>
        $(document).ready(function() {
            $("$first").hide();
            $("$second").show();
        })
        </script>';
    }
    ?>
    <div class='wrapper'>
        <div id="first">
            <div class='login_box'>
                <div class='header'>Login</div>
                    <form action="register.php" method="POST">
                        <input type="email" name="log_email" placeholder="Email Address" value = "<?php checkSession('reg_fname')?>">
                        <br>
                        <input type="password" name="log_password" placeholder="Password">
                        <br>
                        <input class="button" type="submit" name="login_button" value="Login">
                        <br>
                        <a href="#" id="signup" class="signup">Need an account? Click here to register</a>
                        <br>
                        <?php
                        if (in_array("Email or password was incorrect<br>", $error_array)) echo "Email or password was incorrect<br>";
                        ?>
                    </form>
            </div>
        </div>
    

        <div id="second">
            <div class='register_box'>
                <div class='header'>Register</div>
                <!--send the content in the form to the php page-->                
                    <form action="register.php" method="POST">
                        <input type="text" name="reg_fname" placeholder="First Name" value = "<?php checkSession('reg_fname')?>" required>
                        <br>
                        <?php if(in_array("Your first name must be between 2 and 25 characters<br>", $error_array)) echo "Your first name must be between 2 and 25 characters<br>"?>
                        <input type="text" name="reg_lname" placeholder="Last Name" value = "<?php checkSession('reg_lname')?>" required>
                        <br>
                        <?php if(in_array("Your last name must be between 2 and 25 characters<br>", $error_array)) echo "Your last name must be between 2 and 25 characters<br>"?>
                        <input type="text" name="reg_email" placeholder="Email" value = "<?php checkSession('reg_email')?>" required>
                        <br>
                        <input type="text" name="reg_email2" placeholder="Confirm Email" value = "<?php checkSession('reg_email2')?>" required>
                        <br>
                        <?php
                        if (in_array("Email already in use<br>", $error_array)) echo "Email already in use<br>";
                        else if (in_array("Invalid email format<br>", $error_array)) echo "Invalid email format<br>";
                        else if (in_array("Email not match<br>", $error_array)) echo "Email not match<br>";
                        ?>
                        <input type="password" name="reg_password" placeholder="Password" value = "<?php checkSession('reg_password')?>" required>
                        <br>
                        <input type="text" name="reg_password2" placeholder="Confirm Password" value = "<?php checkSession('reg_password2')?>" required>
                        <br>
                        <?php
                        if (in_array("Your passwords do not match<br>", $error_array)) echo "Your passwords do not match<br>";
                        else if (in_array("Your password can only contain english characters or numbers<br>", $error_array)) echo "Your password can only contain english characters or numbers<br>";
                        else if (in_array("Your password must be between 5 and 30 characters<br>", $error_array)) echo "Your password must be between 5 and 30 characters<br>";
                        ?>
                        <input class="button "type="submit" name="register_button" value="Register">
                        <br>
                        <a href="#" id="signin" class="signin">Already have an account? Sign in here!</a>
                        <br>
                        <!--show the prompt of succesfully registered-->
                        <?php if (in_array("<span>You are all set! Goahead and login!</span><br>", $error_array)) echo "<span style='color:#14C800;'>You are all set! Goahead and login!</span><br>"; ?>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>