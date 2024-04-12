<head>
<style>

	.cat{
		border: 2px solid black; 
		border-radius: 40px;
		box-shadow: 5px 3px 10px rgba(5, 2, 4, 0.5);
		height:325px;
		width:325px;
	}
	.cat:hover{
	color: black;
	box-shadow: 0px 0px 5px rgba(1, 1, 1, 5); /* Change box shadow on click */
	border: solid 2px black;
	border-radius: 40px;
	}

	.activator{
		height: 150px;
		width: 150px;
	}
	.b1{
		
		background-color:black;
		border-radius: 40px;
		 border: 2px solid black; 


	}
</style>
</head>
<?php

require('backends/connection-pdo.php');


if (isset($_REQUEST['id'])) {

	$sql = 'SELECT * FROM products WHERE cat_id = "'.$_REQUEST['id'].'"';
	
} else {

	$sql = 'SELECT * FROM products';

}

$query  = $pdoconn->prepare($sql);
$query->execute();
$arr_all = $query->fetchAll(PDO::FETCH_ASSOC);



?>


<section class="fcategories">

	<div class="container">

		<?php

			if (isset($_SESSION['msg'])) {
				echo '<div class="section black center" style="margin: 10px; padding: 3px 10px; margin-top: 35px; border: 2px solid black; border-radius: 5px; color: white;">
						<p><b>'.$_SESSION['msg'].'</b></p>
					</div>';

				unset($_SESSION['msg']);
			}
		?>

		<div class="section white center">
			<h3 class="header">Products</h3>
		</div>

		<?php if (count($arr_all) == 0) {
	echo '<div class="section gray center" style="border: 1px solid black; border-radius: 5px;">
			<p class="header">Sorry No Categories to Display!</p>
		</div>';
} else {  ?>

<?php for ($i=1; $i <= count($arr_all); ) { ?>
		
		<div class="row">
			
			<?php for ($j=1; $j <= 3; $j++) { ?>


				<?php if ($i+$j-2 == count($arr_all)) {
					break;
				}  ?>

			<div class="col s12 m4">
				<div class="card cat">
				   
				    <div class="card-content">
						 <div class="card-image waves-effect waves-block waves-light">
				      <img class="activator" src="images/img3.jpg">
				    </div>
				      <h4><a class="black-text" href=""><?php echo $arr_all[$i+$j-2]['fname']; ?></h4></a><i class="material-icons right">read_more</i>
			          <p style="text-align:center;">Click on Order Now to order</p>
			        <div class="card-content center">
					<button class="b1"><a href="backends/order-product.php?id=<?php echo $arr_all[$i+$j-2]['id']; ?>">Order Now!</a></button>
			        </div>
				    </div>
				    <div class="card-reveal">
				      <span class="card-title grey-text text-darken-4"><?php echo $arr_all[$i+$j-2]['fname']; ?><i class="material-icons right">close</i></span>
				      <p><?php echo $arr_all[$i+$j-2]['description']; ?></p>
				    </div>
				  </div>
			</div>

			<?php } ?>

			<?php $i = $i + 3; ?>


		</div>

		<?php
				}
			} 
		?>




	</div>
	
</section>