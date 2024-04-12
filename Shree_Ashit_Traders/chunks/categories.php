<head>
<style>

	.cat{
		border: 2px solid black; 
		border-radius: 40px;
		box-shadow: 5px 3px 10px rgba(5, 2, 4, 0.5);

	}
	.cat:hover{
		color: black;
  box-shadow: 0px 0px 5px rgba(1, 1, 1, 5); /* Change box shadow on click */
  border: solid 2px black;
  border-radius: 40px;
	}

	.activator{
		height: 200px;
		width: 200px;
	}
	
</style>
</head>
<?php

require('backends/connection-pdo.php');

$sql = 'SELECT * FROM categories';

$query  = $pdoconn->prepare($sql);
$query->execute();
$arr_all = $query->fetchAll(PDO::FETCH_ASSOC);
?>

<section class="fcategories">

	<div class="container">

		<div class="section white center">
			<h3 class="header">Categories</h3>
		</div>

<?php if (count($arr_all) == 0) {
	echo '<div class="section gray center" style="border: 1px solid black; border-radius: 5px; textalign:"center">
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
				    <div class="card-image waves-effect waves-block waves-light">
				      <img class="activator" src="images/img3.jpg">
				    </div>

				    <div class="card-content" style="text-align:center;">
				      <span class="card-title activator grey-text text-darken-4"><a class="black-text" href="products.php?id=<?php echo $arr_all[$i+$j-2]['id']; ?>"><?php echo $arr_all[$i+$j-2]['name']; ?></a><i class="material-icons right">more_vert</i></span>
				      <div class="card-content">
			          </div>
					  
				    </div>
				    <div class="card-reveal">
				      <span class="card-title grey-text text-darken-4"><?php echo $arr_all[$i+$j-2]['name']; ?><i class="material-icons right">close</i></span>
				      <p><?php echo $arr_all[$i+$j-2]['long_desc']; ?></p>
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