<?php
include 'config.php';
session_start();

// Check if user is not logged in, redirect to login page
if(!isset($_SESSION['user_id'])){
   header('location:login.php');
   exit(); // Terminate script after redirection
}

// Logout functionality
if(isset($_GET['logout'])){
   // Unset session variables and destroy session
   session_unset();
   session_destroy();
   header('location:login.php');
   exit(); // Terminate script after redirection
}

$user_id = $_SESSION['user_id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Mochiy+Pop+One&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/99c24c4877.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="css/home.css">
    <link rel="stylesheet" type="text/css" href="css/card.css">
    <title>My Slambook</title>
</head> 
<body>

<nav class="navbar navbar-expand-sm">
    <div class="container">
        <a class="navbar-brand d-flex" href="home.php">MY SLAMBOOK</a>
                            
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0 d-flex">
                <li class="nav-item mx-2">
                    <a class="nav-link" href="#">Add Friend</a>
                </li>
                <li class="nav-item mx-2">
                    <a class="nav-link" href="#">My Profile</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="inputContainer position-relative">
    <input type="search" name="search" id="search" placeholder="Search" class="inputField">
    <i class="fas fa-search" id="search-icon"></i>
</div>


<div class="card">
  <div class="profile-pic"></div>
  <div class="bottom">
    <div class="content">
      <span class="name">My Name</span>
    </div>
    <div class="bottom-bottom">
      <div class="social-links-container">
        <i class="fa fa-x-twitter mx-2"></i>
         <a href="<?php echo $fetch['tweet']; ?>">
        <i class="fa fa-facebook mx-2"></i>
        <a href="<?php echo $fetch['fb']; ?>">
        <i class="fa fa-envelope mx-2"></i>
        <a href="<?php echo $fetch['email']; ?>">
      </div>
      <button class="button">View More</button>
    </div>
  </div>
</div>

</body>
</html>

