<?php require('layout/header.php'); ?>
<?php require('layout/left-sidebar-long.php'); ?>
<?php require('layout/topnav.php'); ?>
<?php require('layout/left-sidebar-short.php'); ?>
						
<?php
if (isset($_SESSION['msg'])) {
    echo '<div id="msg" class="section white-text" style="background-color:black">'.$_SESSION['msg'].'</div>';
    echo '<script type="text/javascript">
        setTimeout(function() {
            document.getElementById("msg").style.display = "none";
        }, 2000);
    </script>';
    unset($_SESSION['msg']);
}
?>
<head>
<link rel="stylesheet" href="../css/admin.css">

</head>
<body>
<div class="section1">

<div class="row one">
	<div class="col s12">
<!-- 
	<a class="dash-btn" href="product-list.php"><div class="sec white">Products</div></a>
	<a class="dash-btn" href="category-list.php"><div class="sec white">Categories</div></a>
	<a class="dash-btn" href="order-list.php"><div class="sec white">Orders</div></a>
 -->

 <h1> <b>SHREE ASHIT TRADERS</b></h1>

	</div>

</div>

</div>

</body>


<?php require('layout/about-modal.php'); ?>
<?php require('layout/footer.php'); ?>