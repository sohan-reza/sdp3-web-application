<?php

include 'components/connect.php';

session_start();
function Is_email($user)
{
if(filter_var($user, FILTER_VALIDATE_EMAIL)) {
return true;
} else {
return false;
}
}
if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

if(isset($_POST['submit'])){

   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $pass = sha1($_POST['pass']);
   $pass = filter_var($pass, FILTER_SANITIZE_STRING);
   $check_email = Is_email($email);
   
   if($check_email)
   {
   $select_user = $conn->prepare("SELECT * FROM `users` WHERE email = ?  AND password = ?");
   $select_user->execute([$email, $pass]);
   $row = $select_user->fetch(PDO::FETCH_ASSOC);
   }
   else{
      $select_user = $conn->prepare("SELECT * FROM `users` WHERE name = ?  AND password = ?");
   $select_user->execute([$email, $pass]);
   $row = $select_user->fetch(PDO::FETCH_ASSOC);
   }

   if($select_user->rowCount() > 0){
      $_SESSION['user_id'] = $row['id'];
      header('location:index.php');
   }else{
      $message[] = 'incorrect username or password!';
      $message_status[]='error';
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>login</title>
   
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
    <link rel="stylesheet" href="css/style.css"> 

</head>
<body>
   
<?php include 'components/user_header.php'; ?>

<section class="form-container">

   <form action="" method="post">
      
      <h3>login now</h3>
      <div class="input_container">
      <label for="password_field" class="input_label">Username Or Email</label>
      <input type="text" name="email" class="input_field" required maxlength="50" placeholder="Enter your Username Or Email"  oninput="this.value = this.value.replace(/\s/g, '')">
      </div>
      <div class="input_container">
      <label for="password_field" class="input_label">Password</label>
      <input type="password" name="pass" class="input_field" required maxlength="20" placeholder="Enter your Password"  oninput="this.value = this.value.replace(/\s/g, '')">
      </div>
      <input type="submit" value="login now" class="btn" name="submit">
      <p>don't have an account? <a href="user_register.php">register now</a></p>
      
   </form>

</section>













<?php include 'components/footer.php'; ?>

<script src="js/script.js"></script>
<style>
   /* Reset styles */
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

body {
  font-family: Arial, sans-serif;
  background-color: #f9f9f9;
  background-image: url('https://images.pexels.com/photos/235985/pexels-photo-235985.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1');
}

.user-header {
  background-color: #007bff;
  color: #fff;
  padding: 10px 20px;
}

.user-header h1 {
  margin: 0;
}

.form-container {
  width: 400px;
  margin: 50px auto;
  
  padding: 20px;
  border-radius: 10px;
 
}

h3 {
  text-align: center;
  margin-bottom: 20px;
  color: #333;
}

.input_container {
  margin-bottom: 15px;
}

.input_label {
  display: block;
  margin-bottom: 5px;
  color: #555;
}

.input_field {
  width: 100%;
  padding: 10px;
  border: 1px solid #ccc;
  border-radius: 5px;
}

.btn {
  width: 100%;
  padding: 10px;
  border: none;
  background-color: #007bff;
  color: #fff;
  border-radius: 5px;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

.btn:hover {
  background-color: #0056b3;
}

.register-link {
  text-align: center;
  margin-top: 15px;
}

.register-link a {
  color: #007bff;
  text-decoration: none;
}

.register-link a:hover {
  text-decoration: underline;
}

/* SweetAlert styling */
.swal2-icon {
  font-size: 2.5em;
}

.swal2-close {
  color: #000;
}

.swal2-content {
  color: #000;
}

</style>
</body>
</html>