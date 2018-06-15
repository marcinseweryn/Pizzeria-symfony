<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pizzeria";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM `orders` WHERE state = 'waiting'";
if($result = $conn->query($sql)){


echo '<h6 class="dropdown-header">New Orders: </h6>
            <div class="dropdown-divider"></div>';

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo '<a class="dropdown-item" href="/admin/orders/waiting-orders">
              <strong>Order '.$row["order_id"].'</strong>
              <span class="small float-right text-muted">'.$row["date"].'</span>
              <div class="dropdown-message small">New order</div>
            </a>';
    }
    echo "<script>
               $('#order-icon').css({
                  color: 'white',
                });
                $('#exclamation-icon').css({
                  color: 'red', 
                  display:'block',
                });
                $('#new-orders-info').css({
                  display:'inline-block',
                });
                
                var audio = new Audio('/bell.mp3');
                audio.play();
          </script>";
} else {
    
    echo '<a class="dropdown-item" href="#">
              <strong>None</strong>
            </a>';
          "<script>
              $('#order-icon').css({
                 color: 'gray',
               });
               $('#exclamation-icon').css({
                 display:'none',
               });
               $('#new-orders-info').css({
                  display:'none',
               });
         </script>";
}
$conn->close();
}else {
    printf("Error: %s\n", $conn->error);
}

