<?php

include 'config.php';
session_start();
$user_id = $_SESSION['user_id'];

if(isset($_POST['update_profile'])){

   $update_name = mysqli_real_escape_string($conn, $_POST['update_name']);
   $update_email = mysqli_real_escape_string($conn, $_POST['update_email']);

   mysqli_query($conn, "UPDATE `user_form` SET name = '$update_name', email = '$update_email' WHERE id = '$user_id'") or die('query failed');

   // Check if password fields are not empty
   if(!empty($_POST['update_pass']) && !empty($_POST['new_pass']) && !empty($_POST['confirm_pass'])){
      $old_pass = $_POST['old_pass'];
      $update_pass = mysqli_real_escape_string($conn, md5($_POST['update_pass']));
      $new_pass = mysqli_real_escape_string($conn, md5($_POST['new_pass']));
      $confirm_pass = mysqli_real_escape_string($conn, md5($_POST['confirm_pass']));

      // Verify old password
      if($update_pass != $old_pass){
         $message[] = 'Old password not matched!';
      }elseif($new_pass != $confirm_pass){
         $message[] = 'Confirm password not matched!';
      }else{
         // Update password if old password matches and new password fields are matched
         mysqli_query($conn, "UPDATE `user_form` SET password = '$confirm_pass' WHERE id = '$user_id'") or die('query failed');
         $message[] = 'Password updated successfully!';
      }
   }

   // Update profile picture
   $update_image = $_FILES['update_image']['name'];
   $update_image_size = $_FILES['update_image']['size'];
   $update_image_tmp_name = $_FILES['update_image']['tmp_name'];
   $update_image_folder = 'uploaded_img/'.$update_image;

   if(!empty($update_image)){
      if($update_image_size > 2000000){
         $message[] = 'Image is too large';
      }else{
         $image_update_query = mysqli_query($conn, "UPDATE `user_form` SET image = '$update_image' WHERE id = '$user_id'") or die('query failed');
         if($image_update_query){
            move_uploaded_file($update_image_tmp_name, $update_image_folder);
         }
         $message[] = 'Image updated successfully!';
      }
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

</head>
<body>
   
<div class="update-profile">

   <?php
      $select = mysqli_query($conn, "SELECT * FROM `user_form` WHERE id = '$user_id'") or die('query failed');
      if(mysqli_num_rows($select) > 0){
         $fetch = mysqli_fetch_assoc($select);
      }
   ?>

   <form action="" method="post" enctype="multipart/form-data">
      <?php
         if($fetch['image'] == ''){
            echo '<img src="images/default-avatar.png">';
         }else{
            echo '<img src="uploaded_img/'.$fetch['image'].'">';
         }
         if(isset($message)){
            foreach($message as $message){
               echo '<div class="message">'.$message.'</div>';
            }
         }
      ?>

<!-- Button to trigger modal -->
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#updateProfileModal">
  Update Profile
</button>

<!-- Update Profile Modal -->
<div class="modal fade" id="updateProfileModal" tabindex="-1" aria-labelledby="updateProfileModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateProfileModalLabel">Update Profile</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="update-profile">
                    <form action="" method="post" enctype="multipart/form-data">
                        <div class="flex">
                            <div class="inputBox">
                                <span>Username:</span>
                                <input type="text" name="update_name" value="<?php echo $fetch['name']; ?>" class="box">
                                <span>Your Email:</span>
                                <input type="email" name="update_email" value="<?php echo $fetch['email']; ?>" class="box">
                                <span>Update Your Profile:</span>
                                <input type="file" name="update_image" accept="image/jpg, image/jpeg, image/png" class="box">
                            </div>
                            <div class="inputBox">
                                <input type="hidden" name="old_pass" value="<?php echo $fetch['password']; ?>">
                                <span>Old Password:</span>
                                <input type="password" name="update_pass" placeholder="Enter old password" class="box">
                                <span>New Password:</span>
                                <input type="password" name="new_pass" placeholder="New password" class="box">
                                <i class="fas fa-eye-slash show-password-icon" onclick="togglePassword('new_pass')"></i>
                                <span>Confirm New Password:</span>
                                <input type="password" name="confirm_pass" placeholder="Confirm new password" class="box">
                                <i class="fas fa-eye-slash show-password-icon" onclick="togglePassword('confirm_pass')"></i>
                            </div>
                        </div>
                        <input type="submit" value="Update Profile" name="update_profile" class="btn">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
