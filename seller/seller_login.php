<?php

include '../components/connect.php';

session_start();
function Is_email($user)
{
if(filter_var($user, FILTER_VALIDATE_EMAIL)) {
return true;
} else {
return false;
}
}
if(isset($_POST['submit'])){

   $username = $_POST['username'];
   $username = filter_var($username, FILTER_SANITIZE_STRING);
   $pass = sha1($_POST['pass']);
   $pass = filter_var($pass, FILTER_SANITIZE_STRING);
   $check_email = Is_email($username);
   
   if($check_email)
   {
      $select_seller = $conn->prepare("SELECT * FROM `seller` WHERE email= ? AND password = ?");
      $select_seller->execute([$username,$pass]);
      $row = $select_seller->fetch(PDO::FETCH_ASSOC);
   }
   else{
      $select_seller = $conn->prepare("SELECT * FROM `seller` WHERE name= ? AND password = ?");
      $select_seller->execute([$username,$pass]);
      $row = $select_seller->fetch(PDO::FETCH_ASSOC);
   }

   if($select_seller->rowCount() > 0){
      $_SESSION['seller_id'] = $row['id'];
      
      header('location:dashboard.php');
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

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- <link rel="stylesheet" href="../css/seller_style.css"> -->

</head>
<body class='reg'>

<script src="sweetalert2.min.js"></script>
<script src="sweetalert2/dist/sweetalert2.min.js"></script>
<link rel="stylesheet" href="@sweetalert2/themes/dark/dark.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<?php
  if(isset($message) && $message!='' && isset($message_status) && $message_status!=''){
   foreach(array_combine($message, $message_status) as $code => $name){
      ?>
      <script>
            
                        Swal.fire({
icon: "<?php echo $name;?>", 
html: "<?php echo $code ;?>",  
showCloseButton: true,
background: 'white'
} );
      </script>
 <?php  }
   }
   ?>

<section class="form-container">

   <form action="" method="post">
      
      <h3>Branch Login</h3>
      <div class="input_container">
      <label for="password_field" class="input_label">Username</label>
      <input type="text" name="username" class="input_field" required maxlength="50" placeholder="Enter your Username Or Email"  oninput="this.value = this.value.replace(/\s/g, '')">
      </div>
      <div class="input_container">
      <label for="password_field" class="input_label">Password</label>
      <input type="password" name="pass" class="input_field" required maxlength="20" placeholder="Enter your Password"  oninput="this.value = this.value.replace(/\s/g, '')">
      </div>
      <input type="submit" value="login now" class="btn" name="submit">
      <p>don't have an account? <a href="seller_register.php">register now</a></p>

      <span><a href="../index.php">Get Back To Home</a></span>
      
   </form>

</section>
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
  background-image: url('https://images.pexels.com/photos/956981/milky-way-starry-sky-night-sky-star-956981.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1'); /* Replace 'your_background_image_url.jpg' with your actual background image URL */
  background-size: cover;
  background-position: center;
}

.form-container {
  width: 300px;
  margin: 100px auto;
  background-color: #fff;
  padding: 20px;
  border-radius: 10px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
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