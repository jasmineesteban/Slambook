<?php
include 'config.php';
session_start();

$message = []; // Initialize $message array

if(isset($_POST['submit'])){

   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $pass = mysqli_real_escape_string($conn, md5($_POST['password']));

   $select = mysqli_query($conn, "SELECT * FROM `user_form` WHERE email = '$email' AND password = '$pass'") or die('query failed');

   if(mysqli_num_rows($select) > 0){
      $row = mysqli_fetch_assoc($select);
      $_SESSION['user_id'] = $row['id'];
      header('location:home.php');
      exit();
   }else{
      $message[] = 'Incorrect email or password!';
   }

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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">


    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/99c24c4877.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="css/style.css">

    <title>Welcome to My Slambook</title>

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
            <p class="heading">Log In</p>
                <?php
                if(isset($message)){
                    foreach($message as $message){
                        echo '<div class="message">'.$message.'</div>';
                    }
                }
                ?>
                <div class="inputContainer">
                    <input type="email" name="email" placeholder="Email" class="inputField" required>
                </div>
    
                <div class="inputContainer position-relative">
                    <input type="password" name="password" id="password" placeholder="Password" class="inputField" required>
                    <i class="fas fa-eye-slash show-password-icon" id="showPassword"></i>
                </div>

              
                <div class="inputContainer">
                    <input type="submit" name="submit" value="Submit" class="btn">
                </div>

           <!-- Forgot Password Link -->
            <div class="inputContainer">
                <a href="#" data-bs-toggle="modal" data-bs-target="#forgotPasswordModal" class="forgot-password">Forgot Password?</a>
            </div>

            <div class="signupContainer">
                  <p>Don't have an account yet?</p>
                  <a href="create.php">Create your account</a>
            </div>

            <!-- Forgot Password Modal -->
            <div class="modal fade" id="forgotPasswordModal" tabindex="-1" aria-labelledby="forgotPasswordModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="forgotPasswordModalLabel">Forgot Password</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="forgot_password.php" method="post">
                                <div class="mb-3">
                                    <label for="email" class="form-label">Enter your email address:</label>
                                    <input type="email" class="form-control" id="email" name="email" required>
                                </div>
                                <button type="submit" class="btn btn-primary" name="submit">Reset Password</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <script src="script/login.js"></script>
</body>
</html>
