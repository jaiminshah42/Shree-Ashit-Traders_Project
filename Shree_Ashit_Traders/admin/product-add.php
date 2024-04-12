<?php require('layout/header.php'); ?>
<?php require('layout/left-sidebar-long.php'); ?>
<?php require('layout/topnav.php'); ?>
<?php require('layout/left-sidebar-short.php'); ?>


<?php

require('../backends/connection-pdo.php');

$sql = 'SELECT id, name FROM categories'; // Changed "fname" to "name"

$query  = $pdoconn->prepare($sql);
$query->execute();
$arr_all = $query->fetchAll(PDO::FETCH_ASSOC);
?>

<head>
<link rel="stylesheet" href="../css/admin.css">

</head>
<div class="section5 white-text">

	<div class="section">
		<h3 class="heading">Add Products</h3>
	</div>


    <div class="section center">
    <form action="../backends/admin/product-add.php" method="post" enctype="multipart/form-data">
            <?php

            if (isset($_SESSION['msg'])) {
                echo '<div class="row" style="background: red; color: black;">
                <div class="col s12">
                    <h6>'.$_SESSION['msg'].'</h6>
                    </div>
                </div>';
                unset($_SESSION['msg']);
            }

            ?>

            <div class="row two">
                <div class="col s6">
                            <div class="input-field">
                            <input id="name" name="name" type="text" class="validate">
                            <label for="name" style="color: black;"><b>Product Name :</b></label>
                            </div>
                </div>
                <div class="col s6">
                            <div class="input-field" style="color: black !important; width: 90%">
						    <select name='category' class="black-text"> <!-- Added class "black-text" -->
						      <?php 

						      		foreach ($arr_all as $key) {
						      			echo '<option value="'.$key['id'].'">'.$key['name'].'</option>';
						      		}
						      ?>
						    </select>
						    <label style="color: black;">Categories</label>
						  </div>
                </div>
            </div>
            <div class="input-field">
            <label style="color: black;"><b>Choose Image :</b></label><br><br>
                <input id="image" name="image" type="file" style="color: black; width: 100%">
                </div>
            <div class="row">
                <div class="col s12">

                <div class="input-field">
                <input id="desc" name="desc" type="text" class="validate" style="color: black; width: 70%">
                <label for="desc" style="color: black;"><b>Description :</b></label>
                </div>
                
                </div>
            
            </div>

            <div class="row">
                <div class="col s12">
                    <div class="section right" >
                        <a href="product-list.php" class="waves-effect waves-light btn" style=" background-color:black">Dismiss</a>
                    </div>
                    <div class="section right" >
                        <button type="submit" class="waves-effect waves-light btn"style=" background-color:black">Add New</button>
                    </div>
                </div>
            </div>

        </form>


    </div>

</div>

<?php require('layout/about-modal.php'); ?>
<?php require('layout/footer.php'); ?>
