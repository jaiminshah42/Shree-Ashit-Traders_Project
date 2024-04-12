<?php require('layout/header.php'); ?>
<?php require('layout/left-sidebar-long.php'); ?>
<?php require('layout/topnav.php'); ?>
<?php require('layout/left-sidebar-short.php'); ?>


<?php

require('../backends/connection-pdo.php');

$sql = 'SELECT products.id, products.fname, products.description, categories.name,products.image
        FROM products
        LEFT JOIN categories
        ON products.cat_id = categories.id';

$query  = $pdoconn->prepare($sql);
$query->execute();
$arr_all = $query->fetchAll(PDO::FETCH_ASSOC);



?>
						

<div class="section2 white-text">

	<div class="section">
		<h3 class="heading">Products</h3>
	</div>

  <?php

    if (isset($_SESSION['msg'])) {
        echo '<div class="section center" style="margin: 5px 35px;"><div class="row" style="background: red; color: black;">
        <div class="col s12">
            <h6>'.$_SESSION['msg'].'</h6>
            </div>
        </div></div>';
        unset($_SESSION['msg']);
    }

    ?>
    <head>
<link rel="stylesheet" href="../css/admin.css">
</head>

	<div class="section3 right">
		<a href="product-add.php" class="waves-effect waves-light btn" style="background-color:black">Add New</a>
	</div>
	
	<div class="section4 center">
		<table class="centered responsive-table">
        <thead>
          <tr>
              <th>Name</th>
              <th>Description</th>
              <th>Category</th>
              <th>Product_Image</th>
              <th>Action</th>
          </tr>
        </thead>

        <tbody>
          <?php

            foreach ($arr_all as $key) {

          ?>
          <tr>
            <td><?php echo $key['fname']; ?></td>
            <td><?php echo $key['description']; ?></td>
            <td><?php echo $key['name']; ?></td>
            <td><img class="i" src="product_upload/<?php echo $key['image']; ?>" alt="Uploaded Image" style="width: 50px; height: 50px;"></td>
            <td><a href="../backends/admin/product-delete.php?id=<?php echo $key['id']; ?>"><span class="newbadge" data-badge-caption="">Delete</span></a></td>
          </tr>
              
          <?php } ?>
         
        </tbody>
      </table>
	</div>
</div>

<?php require('layout/about-modal.php'); ?>
<?php require('layout/footer.php'); ?>