<?php
// variables for storing user information
$fname = "";
$lname = "";
$em = "";
$em2 = "";
$password = "";
$password2 = "";
$date = "";
$error_array = array();

function processInput($formname) {
    // move any html tags and space for security
    $varname = strip_tags($_POST[$formname]);
    $varname = str_replace(' ','',$varname);
    // turn everything to lower letter and the first letter to capital
    $varname = ucfirst(strtolower($varname));
    $_SESSION[$formname] = $varname;
    return $varname;
}

function checkSession($varname) {
    if (isset($_SESSION[$varname])) {
        echo $_SESSION[$varname];
    }
}

// if the buttom the pressed
if(isset($_POST['register_button'])) {
    // check if the input is valid and store them into global arary
    $fname = processInput("reg_fname");
    $lname = processInput("reg_lname");
    $em = processInput("reg_email");
    $em2 = processInput("reg_email2");
    $password = strip_tags($_POST['reg_password']);
    $_SESSION['reg_password'] = $password;
    $password2 = strip_tags($_POST['reg_password2']);
    $_SESSION['reg_password2'] = $password2;
    $date = date("Y-m-d");
    
    // check if email are valid
    if ($em == $em2) { // check if two inputs are the same
        if (filter_var($em, FILTER_VALIDATE_EMAIL)) {
            $em = filter_var($em, FILTER_VALIDATE_EMAIL);
            // check if email already exists
            $e_check = mysqli_query($con, "SELECT email FROM users WHERE email='$em'");
            //count number of rows returned
            $num_rows = mysqli_num_rows($e_check);
            if ($num_rows > 0) {
                array_push($error_array, "Email already in use<br>");
            }
        } else {
            array_push($error_array, "Invalid email format<br>");
        }
    } else {
        array_push($error_array, "Email not match<br>");
    }
    // check the length of first name and last name
    if (strlen($fname) > 25 || strlen($fname) < 2) {
        array_push($error_array, "Your first name must be between 2 and 25 characters<br>");
    }
    if (strlen($lname) > 25 || strlen($lname) < 2) {
        array_push($error_array, "Your last name must be between 2 and 25 characters<br>");
    }
    // check if the password is valid
    if ($password != $password2) {
        array_push($error_array, "Your passwords do not match<br>");
    } else {
        // check if the password match with the regex
        if (preg_match('/[^A-Za-z0-9]/', $password)) {
            array_push($error_array, "Your password can only contain english characters or numbers<br>");
        }
    }
    // check the length of password
    if((strlen($password) > 30 )|| (strlen($password) < 5)) {
        $a = strlen($password);
        echo "the length is $a";
        array_push($error_array, "Your password must be between 5 and 30 characters<br>");
    }


    // create user profile
    if (empty($error_array)) {
        $password = md5($password); //encrypte the password

        // generate username
        $username = strtolower($fname . "_" . $lname);
        $check_username_query = mysqli_query($con, "SELECT username FROM users WHERE username='$username'");

        $i = 0;

        // if username exists add a number after it
        while (mysqli_num_rows($check_username_query) != 0 ){
            $i++; //Add 1 to i
            $username = $username . "_" . $i;
            $check_username_query = mysqli_query($con, "SELECT username FROM users WHERE username='$username'");
        }

        // assign profile picture
        $rand = rand(1,2);
        if ($rand == 1) $profile_pic = "assets/images/profile_pics/defaults/head_belize_hole.png";
        else $profile_pic = "assets/images/profile_pics/defaults/head_pomegranate.png";

        // default user information
    $query = mysqli_query($con, "INSERT INTO users VALUES ('', '$fname', '$lname', '$username', '$em', '$password', '$date', '$profile_pic', '0', '0', 'no', ',')");

    // prompt the user after user creation
    array_push($error_array, "<span>You are all set! Goahead and login!</span><br>");
    } 
    // clear session variable
    $_SESSION['reg_fname'] = "";
    $_SESSION['reg_lname'] = "";
    $_SESSION['reg_email'] = "";
    $_SESSION['reg_email2'] = "";
}
?>
