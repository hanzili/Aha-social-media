<?php
require 'config/config.php';

if (isset($_SESSION['username'])) {
    // if userLoggedIn has value, then the user is logged in
    $userLoggedIn = $_SESSION['username'];
    //get user information
    $user_details_query = mysqli_query($con, "SELECT * FROM users WHERE username='$userLoggedIn'");
    $user = mysqli_fetch_array($user_details_query);


} else {
    // send the user to the register page if not logged in
    // so new user will be redirected to register page directly
    header("Location: register.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!--javascript-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.js"></script>
    <script src="assets/js/demo.js"></script>
    <script src="assets/js/bootbox.js"></script>
    <script src="https://kit.fontawesome.com/89dfc376ef.js" crossorigin="anonymous"></script>

    <!--css-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    
    <title>Welcome to Aha!</title>
</head>
<body>
    <nav class="navbar navbar-expand-lg top_bar_background">
    <div class="container-fluid top_bar">
        <a class="navbar-brand logo" href="#">Aha!</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
                <a class="nav-link" href="<?php echo $userLoggedIn; ?>">
                    <?php echo $user['first_name'];?>
                </a>
                </li>
                <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="#"><i class="fa-solid fa-house-user"></i></a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="#"><i class="fa-solid fa-comment-lines"></i></a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="#">Notificatoin <i class="fa-solid fa-bell"></i></a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="requests.php">Friends <i class="fa-solid fa-user-group"></i></a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="#">Setting <i class="fa-solid fa-gear"></i></a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="includes/handlers/logout.php">Quit <i class="fa-solid fa-right-from-bracket"></i></a>
                </li>
            </ul>
            <form class="d-flex" role="search">
                <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-warning nav_search_bottom" type="submit">Search</button>
            </form>
        </div>
    </div>
    </nav>

    <div class="wrapper">