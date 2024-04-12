<?php require('layout/header.php'); ?>
<?php require('layout/left-sidebar-long.php'); ?>
<?php require('layout/topnav.php'); ?>
<?php require('layout/left-sidebar-short.php'); ?>


<?php

require('../backends/connection-pdo.php');

$sql = 'SELECT orders.order_id, orders.user_name, orders.timestamp, products.fname FROM orders LEFT JOIN products ON orders.food_id = products.id';

$query  = $pdoconn->prepare($sql);
$query->execute();
$arr_all = $query->fetchAll(PDO::FETCH_ASSOC);



?>
						<head>
<link rel="stylesheet" href="../css/admin.css">

            </head>

<div class="section9 white-text" style="">

	<div class="section">
		<h3 class="heading">Orders</h3>
	</div>

  <?php

    if (isset($_SESSION['msg'])) {
        echo '<div class="section center" style="margin: 5px 35px;"><div class="row" style="background: red; color: white;">
        <div class="col s12">
            <h6>'.$_SESSION['msg'].'</h6>
            </div>
        </div></div>';
        unset($_SESSION['msg']);
    }

    ?>
	
	<div class="section10 center">
		<table class="centered responsive-table">
        <thead>
          <tr>
              <th>Order ID</th>
              <th>Customer Name</th>
              <th>Product Name</th>
              <th>Timestamp</th>
          </tr>
        </thead>

        <tbody>
          <?php

            foreach ($arr_all as $key) {

          ?>
          <tr>
            <td><?php echo $key['order_id']; ?></td>
            <td><?php echo $key['user_name']; ?></td>
            <td><?php echo $key['fname']; ?></td>
            <td><?php echo $key['timestamp']; ?></td>
          </tr>

          <?php } ?>
         
        </tbody>
      </table>
	</div>
</div>

<?php require('layout/about-modal.php'); ?>
<?php require('layout/footer.php'); ?>