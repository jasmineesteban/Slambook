<?php

include 'config.php';

$message = []; // Initialize $message array

if(isset($_POST['submit'])){

   $name = mysqli_real_escape_string($conn, $_POST['name']);
   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $pass = mysqli_real_escape_string($conn, md5($_POST['password']));
   $cpass = mysqli_real_escape_string($conn, md5($_POST['cpassword']));
   $image = $_FILES['image']['name'];
   $image_size = $_FILES['image']['size'];
   $image_tmp_name = $_FILES['image']['tmp_name'];
   $image_folder = 'uploaded_img/'.$image;

   $select = mysqli_query($conn, "SELECT * FROM `user_form` WHERE email = '$email' AND password = '$pass'") or die('query failed');

   if(mysqli_num_rows($select) > 0){
      $message[] = 'User already exists'; 
   }else{
      if($pass != $cpass){
         $message[] = 'Passwords do not match!';
      }elseif($image_size > 2000000){
         $message[] = 'Image size is too large!';
      }else{
         $insert = mysqli_query($conn, "INSERT INTO `user_form`(name, email, password, image) VALUES('$name', '$email', '$pass', '$image')") or die('query failed');

         if($insert){
            move_uploaded_file($image_tmp_name, $image_folder);
            $message[] = 'Registered successfully!';
            header('location:home.php');
            exit(); // Terminate script after redirection
         }else{
            $message[] = 'Registration failed!';
         }
      }
   }

} else {
    // Unset message if form is not submitted
    unset($message);
}

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

    <link rel="stylesheet" type="text/css" href="css/style.css">



    <title>Create My Slambook</title>
    <style>
        .show-password-icon {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
        }
    </style>
</head>
<body>
    <!---Left Side--->
    <section class="half-page container-fluid d-flex align-items-center">
    <div class="row col text-center">
        <h1 class="grays">My Slambook</h1>
        <p>Write, Share, Remember</p>
    </div>
    
    <div class="row col text-center image-container">
        <img src="line.png">
    </div>
    </section>

    <!---Right Side--->
    <section class="right-side container-fluid d-flex align-items-center">
        <form class="form_main" action="" method="post" enctype="multipart/form-data">
        <h3>Create an Account</h3>
            <?php
            if(isset($message)){
                foreach($message as $message){
                    echo '<div class="message">'.$message.'</div>';
                }
            }
            ?>
                <div class="inputContainer">
                    <input type="text" name="name" placeholder="Enter Username" class="inputField" required>
                </div>

                <div class="inputContainer">
                    <input type="email" name="email" placeholder="Enter Email" class="inputField" required>
                </div>
                <div class="inputContainer position-relative">
                    <input type="password" name="password" id="password" placeholder="Enter Password" class="inputField" required>
                    <i class="fas fa-eye-slash show-password-icon" onclick="togglePassword('password')"></i>
                </div>

                <div class="inputContainer position-relative">
                    <input type="password" name="cpassword" id="cpassword" placeholder="Confirm Password" class="inputField" required>
                    <i class="fas fa-eye-slash show-password-icon" onclick="togglePassword('cpassword')"></i>
                </div>

                <div class="inputContainer">
                    <input type="submit" name="submit" value="Submit" class="btn">
                </div>

                <div class="signupContainer">
                    <p>Already have an account?</p>
                <a href="login.php">Log in here</a>
                </div>

            </form>
            <script src="script/create.js"></script>
</body>
</html>
