<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_login.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>dashboard</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <link rel="stylesheet" href="../css/admin_style.css">
   
   <script src="https://cdnjs.cloudflare.com/ajax/libs/apexcharts/3.39.0/apexcharts.min.js"></script>

</head>
<body>

<?php include '../components/admin_header.php'; ?>

<section class="dashboard">

   <h1 class="heading">dashboard</h1>

   <div class="box-container">

      <div class="box">
         <h3>welcome!</h3>
         <p><?= $fetch_profile['name']; ?></p>
        
      </div>

      <div class="box">
         <p>Total Pendings</p>
         <?php
            $total_pendings = 0;
            $select_pendings = $conn->prepare("SELECT * FROM `orders` WHERE payment_status = ?");
            $select_pendings->execute(['pending']);
            if($select_pendings->rowCount() > 0){
               while($fetch_pendings = $select_pendings->fetch(PDO::FETCH_ASSOC)){
                  $total_pendings += $fetch_pendings['total_price'];
               }
            }
         ?>
         <h3><?= $total_pendings; ?><span>৳</span></h3>
         
      </div>

      <div class="box">
         <p>Completed Orders</p>
         <?php
            $total_completes = 0;
            $select_completes = $conn->prepare("SELECT * FROM `orders` WHERE payment_status = ?");
            $select_completes->execute(['completed']);
            if($select_completes->rowCount() > 0){
               while($fetch_completes = $select_completes->fetch(PDO::FETCH_ASSOC)){
                  $total_completes += $fetch_completes['total_price'];
               }
            }
         ?>
         <h3><span>৳</span><?= $total_completes; ?><span>/-</span></h3>
         
       
      </div>

      <div class="box">
         <p>Orders Placed</p>
         <?php
            $select_orders = $conn->prepare("SELECT * FROM `orders`");
            $select_orders->execute();
            $number_of_orders = $select_orders->rowCount()
         ?>
         <h3><?= $number_of_orders; ?></h3>
         
       
      </div>

      <div class="box">         
         <p>Products Added</p>

         <?php
            $select_products = $conn->prepare("SELECT * FROM `products`");
            $select_products->execute();
            $number_of_products = $select_products->rowCount()
         ?>
         <h3><?= $number_of_products; ?></h3>
        
      </div>

      <div class="box"> 
         <p>Normal Users</p>

         <?php
            $select_users = $conn->prepare("SELECT * FROM `users`");
            $select_users->execute();
            $number_of_users = $select_users->rowCount()
         ?>
         <h3><?= $number_of_users; ?></h3>
       
      </div>

      <div class="box">
         <p>Admin Users</p>
         <?php
            $select_admins = $conn->prepare("SELECT * FROM `admin`");
            $select_admins->execute();
            $number_of_admins = $select_admins->rowCount()
         ?>
         <h3><?= $number_of_admins; ?></h3>
         
        
      </div>

      <div class="box">
         <p>New Messages</p>
         <?php
            $select_messages = $conn->prepare("SELECT * FROM `messages`");
            $select_messages->execute();
            $number_of_messages = $select_messages->rowCount()
         ?>
         <h3><?= $number_of_messages; ?></h3>
         
         
      </div>

   </div>

<div class="box">
   <div id="chart"></div>
</div>
<script>
   // JavaScript function to render the chart
   function renderChart(totalPendings, totalCompletes) {
      var options = {
         series: [totalPendings, totalCompletes],
         labels: ['Pending Orders', 'Completed Orders'],
         chart: {
            type: 'donut',
            height: 350
         },
         plotOptions: {
            pie: {
               donut: {
                  labels: {
                     show: true,
                     total: {
                        show: true,
                        showAlways: true,
                        label: 'Total',
                        fontSize: '22px',
                        fontFamily: 'Helvetica, Arial, sans-serif',
                        fontWeight: 600,
                        color: '#373d3f',
                        formatter: function (w) {
                           return w.globals.seriesTotals.reduce((a, b) => {
                              return a + b
                           }, 0)
                        }
                     }
                  }
               }
            }
         },
         legend: {
            position: 'bottom'
         }
      };

      var chart = new ApexCharts(document.querySelector("#chart"), options);
      chart.render();
   }

   // Call the function with data collected from PHP
   renderChart(<?php echo $total_pendings; ?>, <?php echo $total_completes; ?>);
</script>


</section>











<script src="../js/admin_script.js"></script>


</body>
</html>