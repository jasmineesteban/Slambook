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

    <link rel="stylesheet" type="text/css" href="css/style.css">
    <title>My Slambook</title>

</head>    
<nav class="navbar navbar-expand-sm">
        <div class="container">
            <span>
                <a class="navbar-brand" href="home.php">My Slambook</a>
            </span>
                            
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
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


    <!-- Modal -->
    <style>
    .modal-profile-image {
        width: 300px; /* Adjust as needed */
        height: 300px; /* Adjust as needed */
        border-radius: 50%;
        overflow: hidden;
        margin: 0 auto;
    }

    .modal-profile-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
</style>


<a class="nav-link" data-bs-toggle="modal" data-bs-target="#profileModal">My PRofile</a>

<div class="modal fade" id="profileModal" tabindex="-1" aria-labelledby="profileModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="profileModalLabel">Your Profile</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <?php
                    $select = mysqli_query($conn, "SELECT * FROM `user_form` WHERE id = '$user_id'") or die('Query failed');
                    if(mysqli_num_rows($select) > 0){
                        $fetch = mysqli_fetch_assoc($select);
                        if($fetch['image'] == ''){
                            echo '<div class="modal-profile-image"><img src="default-avatar.png" alt="Profile Image"></div>';
                        }else{
                            echo '<div class="modal-profile-image"><img src="uploaded_img/'.$fetch['image'].'" alt="Profile Image"></div>';
                        }
                        echo '<h3>'.$fetch['name'].'</h3>';
                    }
                ?>
                <a href="update.php" class="btn btn-primary">Update Profile</a>
                <a href="home.php?logout" class="btn btn-danger">Logout</a>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


</body>
</html>
