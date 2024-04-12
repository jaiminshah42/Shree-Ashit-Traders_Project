<?php require('layout/header.php'); ?>
<?php require('layout/left-sidebar-long.php'); ?>
<?php require('layout/topnav.php'); ?>
<?php require('layout/left-sidebar-short.php'); ?>

<head>

<link rel="stylesheet" href="../css/admin.css">

</head>
<div class="section7 white-text">

	<div class="section">
    <h3 class="heading">Add Categories</h3>
	</div>


    <div class="section center" style="padding: 40px;">

        <form action="../backends/admin/cat-add.php" method="post">

            <?php

            if (isset($_SESSION['msg'])) {
                echo '<div class="row" style="color: white;">
                <div class="col s12">
                    <h6>'.$_SESSION['msg'].'</h6>
                    </div>
                </div>';
                unset($_SESSION['msg']);
            }

            ?>

<?php
// Include database connection file
require('../backends/connection-pdo.php');

// Retrieve all banner images from the database
$sql = 'SELECT image FROM categories';

$query  = $pdoconn->prepare($sql);
$query->execute();
$arr_all = $query->fetchAll(PDO::FETCH_ASSOC);

// Initialize variables
$image = ""; 
$error_message = "";

// Check if form is submitted
if (isset($_POST["submit"]) && $_FILES["image"]["name"]) { 

    // Insert data into the database if there is no error
    if (empty($error_message)) {
        // Process image upload
        $targetDir = "../images/upload/";
        $targetFile = $targetDir . basename($_FILES["image"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        // Check if the image file is an actual image or a fake image
        if (isset($_POST["submit"])) {
            $check = getimagesize($_FILES["image"]["tmp_name"]);
            if ($check !== false) {
                $uploadOk = 1;
            } else {
                $error_message .= "File is not an image. ";
                $uploadOk = 0;
            }
        }
        // Check if the file already exists
        if (file_exists($targetFile)) {
            $error_message .= "Sorry, file already exists. ";
            $uploadOk = 0;
        }

        // Check the file size
        if ($_FILES["image"]["size"] > 5000000) {
            $error_message .= "Sorry, your file is too large. ";
            $uploadOk = 0;
        }

        // Allow only certain file formats
        if ($imageFileType != "jpg" && $imageFileType != "jpeg" && $imageFileType != "png" && $imageFileType != "gif") {
            $error_message .= "Sorry, only JPG, JPEG, PNG, and GIF files are allowed. ";
            $uploadOk = 0;
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            $error_message .= "Sorry, your file was not uploaded. ";
        } else {
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
                $image = $targetFile; // Should be $image = $targetFile;
            } else {
                $error_message .= "Sorry, there was an error uploading your file. ";
            }
            
        }

       // Insert data into the database
        if (empty($error_message)) {
            $stmt = $pdoconn->prepare("INSERT INTO categories (image) VALUES (?)");
            $stmt->bindValue(1, $image, PDO::PARAM_STR);

            if ($stmt->execute()) {
                $_SESSION['success'] = "Your Data is Inserted";
                header("location: category-add.php");
                exit();
            } else {
                echo "Error: " . $stmt->error;
            }
        }
    }
}

// Check if delete button is clicked
if (isset($_POST['delete'])) {
    $delete_id = $_POST['delete'];

    // Prepare and execute the delete query
    $stmt = $pdoconn->prepare("DELETE FROM categories WHERE image = ?");
    $stmt->bindValue(1, $delete_id, PDO::PARAM_STR);
    if ($stmt->execute()) {
        // Delete image file from folder
        if (file_exists($delete_id)) {
            if (unlink($delete_id)) {
                $_SESSION['success'] = "Image deleted successfully";
                header("Location: category-add.php.php");
                exit();
            } else {
                echo "Error deleting image file from folder";
            }
        } else {
            echo "Image file not found";
        }
    } else {
        echo "Error deleting image from database";
    }
}
?>

            <div class="row">
                <div class="col s6" style="">
                            <div class="input-field">
                            <input id="name" name="name" type="text" class="validate" style="color: black; width: 70%">
                            <label for="name" style="color: black;"><b>Category Name :</b></label>
                            </div>
                </div>
                <div class="col s6" style="">
                            <div class="input-field">
                            <input id="short_desc" name="short_desc" type="text" class="validate" style="color: black; width: 70%">
                            <label for="short_desc" style="color: black;"><b>Short Description :</b></label>
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
                <input id="long_desc" name="long_desc" type="text" class="validate">
                <label for="long_desc" style="color:black;"><b>Long Description :</b></label>
                </div>
                
                
            </div>
                
            </div>

            <div class="row">
                <div class="col s12">
                    <div class="section right">
                        <a href="category-list.php" class="waves-effect waves-light btn"style=" background-color:black">Dismiss</a>
                    </div>
                    <div class="section right">
                        <button type="submit" class="waves-effect waves-light btn"style=" background-color:black">Add New</button>
                    </div>
                </div>
            </div>

        </form>


    </div>

</div>

<?php require('layout/about-modal.php'); ?>
<?php require('layout/footer.php'); ?>