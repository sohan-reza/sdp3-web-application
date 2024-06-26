<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_login.php');
}

if(isset($_POST['submit'])){

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);

   $update_profile_name = $conn->prepare("UPDATE `admin` SET name = ? WHERE id = ?");
   $update_profile_name->execute([$name, $admin_id]);

   $empty_pass = 'da39a3ee5e6b4b0d3255bfef95601890afd80709';
   $prev_pass = $_POST['prev_pass'];
   $old_pass = sha1($_POST['old_pass']);
   $old_pass = filter_var($old_pass, FILTER_SANITIZE_STRING);
   $new_pass = sha1($_POST['new_pass']);
   $new_pass = filter_var($new_pass, FILTER_SANITIZE_STRING);
   $confirm_pass = sha1($_POST['c_pass']);
   $confirm_pass = filter_var($confirm_pass, FILTER_SANITIZE_STRING);

   if($old_pass == $empty_pass){
      $message[] = 'please enter old password!';
      $message_status[]='error';
   }elseif($old_pass != $prev_pass){
      $message[] = 'old password not matched!';
      $message_status[]='error';
   }elseif($new_pass != $confirm_pass){
      $message[] = 'confirm password not matched!';
      $message_status[]='error';
   }else{
      if($new_pass != $empty_pass){
         $update_admin_pass = $conn->prepare("UPDATE `admin` SET password = ? WHERE id = ?");
         $update_admin_pass->execute([$confirm_pass, $admin_id]);
         $message[] = 'password updated successfully!';
         $message_status[]='success';
      }else{
         $message[] = 'please enter a new password!';
         $message_status[]='error';
      }
   }
   
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>update profile</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>

<?php include '../components/admin_header.php'; ?>

<section class="form-container">

   <form action="" method="post">
      <h3>update profile</h3>
      <input type="hidden" name="prev_pass" value="<?= $fetch_profile['password']; ?>">
      <div class="input_container">
      <label for="password_field" class="input_label">Username</label>
      <input type="text" value="<?= $fetch_profile["name"]; ?>" name="name" class="input_field" required maxlength="50" placeholder="Enter your Username"  oninput="this.value = this.value.replace(/\s/g, '')">
      </div>
      <div class="input_container">
      <label for="password_field" class="input_label">Old Password</label>
      <input type="password" name="old_pass" class="input_field" required maxlength="20" placeholder="Enter your Password"  oninput="this.value = this.value.replace(/\s/g, '')">
      </div>
      <div class="input_container">
      <label for="password_field" class="input_label">New Password</label>
      <input type="password" name="new_pass" class="input_field" required maxlength="20" placeholder="Enter your Password"  oninput="this.value = this.value.replace(/\s/g, '')">
      </div>
      <div class="input_container">
      <label for="password_field" class="input_label">Confirm Password</label>
      <input type="password" name="c_pass" class="input_field" required maxlength="20" placeholder="Enter Confirm your Password"  oninput="this.value = this.value.replace(/\s/g, '')">
      </div>
      <input type="submit" value="update now" class="btn" name="submit">
   </form>

</section>












<script src="../js/admin_script.js"></script>
   
</body>
</html>