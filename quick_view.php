<?php

include 'components/connect.php';
session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

include 'components/wishlist_cart.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>quick view</title>
   
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">
   <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
   <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.15.0/moment.min.js"></script>
   
</head>
<body>
   
<?php include 'components/user_header.php'; ?>

<section class="quick-view">

   <h1  class="heading">quick view</h1>

   <?php
     $pid = $_GET['pid'];
     $select_products = $conn->prepare("SELECT products.id,products.name,products.price,products.image_01,products.image_02,products.image_03,products.category,products.details,products.p_person,products.p_bedroom,products.p_bed,products.p_bath,products.p_checkin,products.p_checkout,products.p_country,products.p_state,products.p_city,products.p_facility,seller.id as seller_id,seller.name as seller_name,seller.email as seller_email,seller.phone as seller_phone,seller.f_language,seller.s_language,seller.description as seller_desc FROM `products`,`seller` WHERE products.seller_id=seller.id and products.id = ?"); 
     $select_products->execute([$pid]);
     if($select_products->rowCount() > 0){
      while($fetch_product = $select_products->fetch(PDO::FETCH_ASSOC)){
   ?>
   <form action="" method="post" class="box">
      <input type="hidden" name="pid" value="<?= $fetch_product['id']; ?>">
      <input type="hidden" name="name" value="<?= $fetch_product['name']; ?>">
      <input type="hidden" name="price" value="<?= $fetch_product['price']; ?>">
      <input type="hidden" name="image" value="<?= $fetch_product['image_01']; ?>">
      <input type="hidden" name="seller_id" value="<?= $fetch_product['seller_id']; ?>">
      
      <div class="row">
         <div class="image-container">
            <div class="main-image">
               <img src="uploaded_img/<?= $fetch_product['image_01']; ?>" alt="">
            </div>
            <div class="sub-image">
               <img src="uploaded_img/<?= $fetch_product['image_01']; ?>" alt="">
               <img src="uploaded_img/<?= $fetch_product['image_02']; ?>" alt="">
               <img src="uploaded_img/<?= $fetch_product['image_03']; ?>" alt="">
            </div>
         </div>

         <?php
            $day_count = '1 Day';

            $category = $fetch_product['category'];
            // Check each option
            if ($category == "beach") {
               $day_count = '1 Day';
            } elseif ($category == "city") {
               $day_count = '3 Day';
            } elseif ($category == "camping") {
               $day_count = '5 Day';
            } elseif ($category == "hill") {
               $day_count = '7 Day';
            } elseif ($category == "forest") {
               $day_count = '15 Day';
            } elseif ($category == "boat") {
               $day_count = '1 Month';
            }
         ?>
         
         <div class="content">
            <div class="flex">
            <div class="name "><?= $fetch_product['name']; ?> </div>
               
               <div class="card">
                  <p class="title"><span>TK: </span><span id='price'><?= $fetch_product['price']; ?></span><br><span> 
                  
                  Per <?=$day_count;?></span></p>
                  </div>
                  


              </div>
              <div class="details"><?= $fetch_product['details']; ?></div>
              <div class="flex-btn room ">
            <div class="span"><i class="fa-solid fa-person"></i><?= $fetch_product['p_person']; ?> Person </div>   
            <div class="span"><i class="fa-solid fa-person-shelter"></i><?= $fetch_product['p_bedroom']; ?> Bedroom </div>
            <div class="span"><i class="fa-solid fa-bed"></i><?= $fetch_product['p_bed']; ?> Bed</div>
            <div class="span"><i class="fa-solid fa-restroom"></i><?= $fetch_product['p_bath']; ?> Restroom </div>
           
         </div>
            <!-- <div class="flex-btn check">
            <div class="span " >Check-in <span class="material-symbols-outlined">login</span><input id="checkin" class="checkin"name="checkin" type="text" autocomplete="off"></input> <p id="clear"><i class="fa-solid fa-xmark fa-xl"></i></p> </div>
            <div class="span " >Check-out<span class="material-symbols-outlined">logout</span><input id="checkout" class="checkout" name="checkout" type="text" autocomplete="off"></input>  </div>   
            <script>$( "#checkin" ).datepicker("setDate", new Date("<?php echo $_POST['checkin'] ?>"));</script>
            <script>$( "#checkout" ).datepicker("setDate", new Date("<?php echo $_POST['checkout'] ?>"));</script>
            </div> -->
            <div id="extra-feature">
               <div class="form-check form-check-inline">
                  <input type="checkbox" id="wifi" name="services[]" value="wifi" checked>
                  <label for="wifi">Wi-Fi</label><br>
               </div>

               <div class="form-check form-check-inline">
                  <input type="checkbox" id="breakfast" name="services[]" value="breakfast">
                  <label for="breakfast">Breakfast</label><br>
               </div>

               <div class="form-check form-check-inline">
                  <input type="checkbox" id="lunch" name="services[]" value="lunch">
                  <label for="lunch">Lunch</label><br>
               </div>
               <div class="form-check form-check-inline">
                  <input type="checkbox" id="dinner" name="services[]" value="dinner">
                  <label for="dinner">Dinner</label><br>
               </div>
                  
               <div class="form-check form-check-inline">
                  <input type="checkbox" id="fitnessCenter" name="services[]" value="fitness_center" checked>
                  <label for="fitnessCenter">Fitness Center</label><br>
               </div>

               <div class="form-check form-check-inline">
                  <input type="checkbox" id="swimmingPool" name="services[]" value="swimming_pool">
                  <label for="swimmingPool">Swimming Pool</label><br>
               </div>

               <div class="form-check form-check-inline">
                  <input type="checkbox" id="roomService" name="services[]" value="room_service" checked>
                  <label for="roomService">Room Service</label><br>
               </div>

               <div class="form-check form-check-inline">
                  <input type="checkbox" id="parking" name="services[]" value="parking" checked>
                  <label for="parking">Parking</label><br>
               </div>

               <div class="form-check form-check-inline">
                  <input type="checkbox" id="laundryService" name="services[]" value="laundry_service">
                  <label for="laundryService">Laundry Service</label><br>
               </div>

               <div class="form-check form-check-inline">
                  <input type="checkbox" id="petFriendly" name="services[]" value="pet_friendly">
                  <label for="petFriendly">Pet-friendly</label><br>
               </div>


            


            </div>

            <!-- <script>
            // Get all checkboxes within the div with id "extra-feature"
            const checkboxes = document.querySelectorAll('#extra-feature input[type="checkbox"]');

            // Add event listener to each checkbox
            checkboxes.forEach(checkbox => {
               checkbox.addEventListener('change', function() {
                     alert(`Checkbox ${this.id} is now ${this.checked ? 'checked' : 'unchecked'}`);
               });
            });
         </script> -->

         <script>
            document.addEventListener('DOMContentLoaded', function() {
               const checkboxes = document.querySelectorAll('#extra-feature input[type="checkbox"]');
               const priceElement = document.getElementById('price');
               let basePrice = parseFloat(priceElement.textContent);

               checkboxes.forEach(checkbox => {
                     checkbox.addEventListener('change', function() {
                        let priceChange = parseFloat(this.dataset.price);
                        
                           switch (this.id) {
                              case 'wifi':
                                    basePrice += this.checked ? 0 : 0;
                                    break;
                              case 'breakfast':
                                    basePrice += this.checked ? 50 : -50;
                                    break;
                              case 'lunch':
                                    basePrice += this.checked ? 80 : -80;
                                    break;
                              case 'dinner':
                                    basePrice += this.checked ? 60 : -60;
                                    break;
                              case 'fitnessCenter':
                                    basePrice += this.checked ? 0 : 0;
                                    break;
                              case 'swimmingPool':
                                    basePrice += this.checked ? 20 : -20;
                                    break;
                              case 'roomService':
                                    basePrice += this.checked ? 0 : -0;
                                    break;
                              case 'parking':
                                    basePrice += this.checked ? 0 : -0;
                                    break;
                              case 'laundryService':
                                    basePrice += this.checked ? 10 : -10;
                                    break;
                              case 'petFriendly':
                                    basePrice += this.checked ? 20 : -20;
                                    break;
                              default:
                                    break;
                           }
                           priceElement.textContent = basePrice.toFixed(2);
                     });
               });
            });
         </script>

            <style>
               #extra-feature {
                  border: 2px solid gray;
                  padding: 15px;
                  border-radius: 9px;
                  padding-bottom: 0;
                  font-weight: bold;
               }
            </style>

            <div class="">
               <div><span id="info" class="info ">Please Select Your Necessary Fascility</span></div>
            </div>
            <style>
               input[type="checkbox"] {
               transform: scale(1.5); /* Increase the size of the checkbox */
               margin-right: 10px; /* Add some spacing between the checkbox and label */
            }
            
            label {
               font-size: 1.2em; /* Increase the font size of the labels */
               display: table-cell; /* Display labels in a row */
               margin-bottom: 10px; /* Add some space between rows */
            }
            </style>
            <div class="flex-btn ">
            <input type="submit" value="reserve" class="btn" name="add_to_cart"></input>
               <input class="option-btn" type="submit" name="add_to_wishlist" value="add to wishlist">
            </div>
          

         </div>
         <div class="content seller">
            <h3>Host</h3>
            <div class="flex">
            <div class="name ">Hi, I Am <span><?= $fetch_product['seller_name']; ?></span></div>


              </div>
              <h2>Description</h2>
              <div class="details"><?= $fetch_product['seller_desc']; ?></div>
              <div class="details facility"><span>Facility</span>  <p><?= $fetch_product['p_facility']; ?></p></div>
              
            
    
         </div>

         
         <div class="wrapper_chat" id='wrapper_chat'>
        <div class="title">Talk to <span><?= $fetch_product['seller_name']; ?></span></div>
        <div class="form_chat">
         <h3 id='login'>Log in to Chat</h3>
            <div class="bot-inbox inbox">
                <div class="msg-header">
                    
                    
                </div>
            </div>
            
        </div>
        <div class="typing-field">
        <span id='reload'><i class="fa-solid fa-rotate"></i></span>
            <div class="input-data">
                <input onkeyup="sendbtn()" id="data" type="text" placeholder="Type something here.." >
                <span id="send-btn" disabled>Send</span>
            </div>
        </div>


        <style>
         .content.seller {
   display: flex;
   flex-direction: column;
}

.content.seller h3,
.content.seller h2,
.content.seller .details,
.content.seller .flex,
.content.seller .wrapper_chat {
   margin-bottom: 20px;
}

.content.seller .name span {
   font-weight: bold;
}

.content.seller .details.facility,
.content.seller .details.language {
   margin-top: 10px;
}

.wrapper_chat .title {
   font-size: 1.2rem;
   font-weight: bold;
   margin-bottom: 10px;
}

.wrapper_chat .form_chat h3 {
   font-size: 1.1rem;
   font-weight: bold;
   margin-bottom: 10px;
}

.wrapper_chat .bot-inbox,
.wrapper_chat .input-data {
   margin-bottom: 10px;
}

.wrapper_chat .input-data input {
   width: calc(100% - 80px);
   padding: 10px;
   border: 1px solid #ccc;
   border-radius: 5px;
}

.wrapper_chat #send-btn {
   display: inline-block;
   padding: 10px;
   border-radius: 5px;
   background-color: #007bff;
   color: #fff;
   cursor: pointer;
}

.wrapper_chat #send-btn:disabled {
   background-color: #ccc;
   cursor: not-allowed;
}
.wrapper_chat {
   border: 1px solid #ccc;
   border-radius: 5px;
   padding: 15px;
   background-color: #f9f9f9;
}

.wrapper_chat .title {
   font-size: 1.5rem;
   font-weight: bold;
   margin-bottom: 10px;
}

.wrapper_chat .chat-box {
   max-height: 200px;
   overflow-y: auto;
   margin-bottom: 10px;
}

.wrapper_chat .chat-message {
   background-color: #e6f2ff;
   border-radius: 10px;
   padding: 10px;
   margin-bottom: 5px;
}

.wrapper_chat .chat-message .message-header {
   font-weight: bold;
   margin-bottom: 5px;
}

.wrapper_chat .input-field {
   display: flex;
   align-items: center;
}

.wrapper_chat .input-field input {
   flex: 1;
   padding: 10px;
   border: 1px solid #ccc;
   border-radius: 5px;
}

.wrapper_chat #send-btn {
   padding: 10px 20px;
   border-radius: 20px;
   background-color: #007bff;
   color: #fff;
   cursor: pointer;
}

.wrapper_chat #send-btn:disabled {
   background-color: #ccc;
   cursor: not-allowed;
}

        </style>
        
    </div>

    <script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-element-bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src="https://code.jquery.com/ui/1.13.1/jquery-ui.min.js" integrity="sha256-eTyxS0rkjpLEo16uXTS0uVCS4815lc40K2iVpWDvdSY=" crossorigin="anonymous"></script>
<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.0/themes/base/jquery-ui.css" rel="stylesheet" type="text/css">

    <script>
    function sendbtn() {
	 if(document.getElementById("data").value==="") { 
      $("#send-btn").css('display','none');
        } else { 
         $("#send-btn").css('display','block');
        }
    }

    
 
    $("#clear").on('click', function() {
     
      $('#clear').attr('class', 'disabled');
       $("#checkout").prop('disabled', true);
       $("#checkout").val('');
       $("#checkin").val('');
       window.location.reload();


  });
   

   
   
   
    <?php 

         $totaldayslist='';

      $select_orders = $conn->prepare("SELECT * FROM `orders` Where pid=? and payment_status <> 'rejected' " );
      $select_orders->execute([$pid]);
      if($select_orders->rowCount() > 0){
         while($row = $select_orders->fetch(PDO::FETCH_ASSOC)){

                   $start = strtotime($row['checkin']);
                  $end = strtotime($row['checkout']);            
                  for ($i=$start; $i<=$end; $i+=86400) { 
                  $dateslistselect[]= '"'.date('d-m-Y',$i).'"';   
                  }          
                  }
                  $dateslistselect=array_filter($dateslistselect);
                  $totaldayslist =implode(", ", $dateslistselect);  

         
      }
      
    ?>
    var unavailableDates = [<?php echo $totaldayslist;?>];
      console.log(<?php echo $totaldayslist;?>);
    var dateToday= new Date();
function unavailable(date) {
  
    dmy =   date.getDate()+ "-" + (date.getMonth() + 1) + "-" +date.getFullYear();
    if ($.inArray(dmy, unavailableDates) == -1) {
        return [true, ""];
    } else {
        return [false, "", "Unavailable"];
    }
}

function parseDate(dateString) {
    var parts = dateString.split("-");
    return new Date("20" + parts[2], parts[1] - 1, parts[0]);
}
function datediff(first, second) {        
    return Math.round((second - first) / (1000 * 60 * 60 * 24));
}


if(unavailableDates!=null)
{
var dates= $("#checkin,#checkout").datepicker({
   dateFormat: 'dd-mm-yy',
   maxDate: "3m+",
   changeMonth:true,
   numberOfMonths:1,
   minDate:dateToday,
   beforeShowDay: function(date){
      var dateString = $.datepicker.formatDate('dd-mm-yy', date);
          return [unavailableDates.indexOf(dateString) === -1];
   },
   onSelect:function(selectedDate){
      var option=this.id=="checkin" ? "minDate" :"maxDate",
      instance= $(this).data("datepicker"),
    date = $.datepicker.parseDate(instance.settings.dateFormat || $.datepicker._defaults.dateFormat, selectedDate, instance.settings);
    date.setDate(date.getDate() + 1);
         dates.not(this).datepicker("option",option,date);
        
         var maxDate='3m+';
         for(let i=0;i<unavailableDates.length;i++)
         {
            var date1 = parseDate(selectedDate);
            var date2 = parseDate(unavailableDates[i]);
         
            var diff = datediff(date1,date2);
            if(diff>-1)
            {
               maxDate=unavailableDates[i];
              console.log(maxDate);
               break;
            }
         }
         
            dates.not(this).datepicker("option", "maxDate",maxDate);
            $("#checkout").prop('disabled', false);
            $('#clear').attr('class', '');
            var inn= $('[id="checkin"]').val();
            var out=$('[id="checkout"]').val();
            if(inn!='' && out!='')
               { 
                  
                  var dayDiff =datediff(parseDate(inn), parseDate(out));
                  var price=document.getElementById("price").innerHTML;
                  var totalprice=dayDiff*price;
                  document.getElementById("info").innerHTML=dayDiff+" Nights x $"+price+"  = $"+totalprice;
               }
   }
   
});
}
else{

var dates= $("#checkin,#checkout").datepicker({
   dateFormat: 'dd-mm-yy',
   gotoCurrent: true,
   defaultDate:"1+w",
   maxDate: "3m+",
   changeMonth:true,
   numberOfMonths:1,
   minDate:dateToday,
   onSelect:function(selectedDate){
      var option=this.id=="checkin" ? "minDate" :"maxDate",
      instance= $(this).data("datepicker"),
    date = $.datepicker.parseDate(instance.settings.dateFormat || $.datepicker._defaults.dateFormat, selectedDate, instance.settings);
    date.setDate(date.getDate() + 1);
         dates.not(this).datepicker("option",option,date);   
         $("#checkout").prop('disabled', false);
         $('#clear').attr('class', '');
         var inn= $('[id="checkin"]').val();
            var out=$('[id="checkout"]').val();
            if(inn!='' && out!='')
               { 
                  
                  var dayDiff =datediff(parseDate(inn), parseDate(out));
                  var price=document.getElementById("price").innerHTML;
                  var totalprice=dayDiff*price;
                  document.getElementById("info").innerHTML=dayDiff+" Nights x $"+price+"  = $"+totalprice;
               }
   }
   
});
}






        $(document).ready(function(){
         
         $('#clear').attr('class', 'disabled');
         $("#checkout").prop('disabled', true);
          var user_id = '<?php echo $user_id; ?>';
          var seller_id='<?php echo  $fetch_product['seller_id']; ?>';
          $(".form_chat").animate({ scrollTop: 20000000 }, "slow");
          if(user_id!='')
          {
            $("#login").css('display','none');
         load_data();
         $("#reload").on("click", function(){
                           $(".form_chat").html('');
                        load_data();   
                     }); 
         function load_data(){
            $.ajax({
               url: 'message.php',
               type:'get',
               data : {
                     user_id:user_id,
                     seller_id:seller_id
               },
               dataType:'json',
               success:function(result){
                  if(result.status==1)
                  {
                    
                     const data=result.data;
                    
                    
                     $.each(data,function(index,text){
                       
                      
                        if(text['seller']!='')
                        {
                           
                           $replay = '<div class="bot-inbox inbox seller"><div class="icon"><i class="fa-solid fa-user-tie"></i></div><div class="msg-header"><p>'+ text['seller'] +'</p></div></div>';
                        $(".form_chat").append($replay);
                  
                        }
                        else{
                           $replay = '<div class="bot-inbox inbox customer"><div class="msg-header"><p>'+ text['customer'] +'</p></div><div class="icon"><i class="fas fa-user"></i></div></div>';
                        $(".form_chat").append($replay);
                        $(".form_chat").animate({ scrollTop: 20000000 }, "slow");
                        }

                        

                     });
                   
                  }
                  else{
                     $("#login").css('display','block');
                     $("#login").text('Say Hello');
                    
                     
                  }
                  
               }
            })
         }
      
            $("#send-btn").on("click", function(){
                $value = $("#data").val();
                $msg = '<div class="user-inbox inbox"><div class="msg-header"><p>'+ $value +'</p></div></div>';
                $(".form").append($msg);
                $("#data").val('');
                
                
                $.ajax({
                    url: 'send_message.php',
                    type: 'get',
                    data : {
                     text:$value,
                     user_id:user_id,
                     seller_id:seller_id
               },
                    success: function(result){
                     $replay = '<div class="bot-inbox inbox customer"><div class="msg-header"><p>'+ $value +'</p></div><div class="icon"><i class="fas fa-user"></i></div></div>';
                        $(".form_chat").append($replay);
                        
                    }
                });
            });
         }
         else{
            $("#login").css('display','block');
            $("#send-btn").css('display','none');
            $("#data").prop('disabled', true);
         }
        });
    </script>
    </div>

      </div>
   </form>
   <script>
 document.getElementById("checkin").innerHTML = moment('<?=$fetch_product['p_checkin']?>', 'DD-MM-YYYY').format('MMM D Y');
 document.getElementById("checkout").innerHTML = moment('<?=$fetch_product['p_checkout']?>', 'DD-MM-YYYY').format('MMM D Y');
</script>

   <?php
      
      }
   }else{
      echo '<p class="empty">no places added yet!</p>';
   }
   ?>

</section>













<?php include 'components/footer.php'; ?>

<script src="js/script.js"></script>



</body>
</html>