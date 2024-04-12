<?php require('layout/header.php'); ?>
<?php require('layout/left-sidebar-long.php'); ?>
<?php require('layout/topnav.php'); ?>
<?php require('layout/left-sidebar-short.php'); ?>
<?php require('layout/about-modal.php'); ?>
<?php require('layout/footer.php'); ?>

<?php
// Include database connection file
require('../backends/connection-pdo.php');

// Retrieve all banner images from the database
$sql = 'SELECT image FROM banner_info';

$query  = $pdoconn->prepare($sql);
$query->execute();
$arr_all = $query->fetchAll(PDO::FETCH_ASSOC);

// Initialize variables
$image = ""; 
$error_message = "";

// Check if form is submitted
if (isset($_POST["submit"]) && $_FILES["lis_img"]["name"]) { 
    // Insert data into the database if there is no error
    if (empty($error_message)) {
        // Process image upload
        $targetDir = "upload/";
        $targetFile = $targetDir . basename($_FILES["lis_img"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        // Check if the image file is an actual image or a fake image
        if (isset($_POST["submit"])) {
            $check = getimagesize($_FILES["lis_img"]["tmp_name"]);
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
        if ($_FILES["lis_img"]["size"] > 5000000) {
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
            if (move_uploaded_file($_FILES["lis_img"]["tmp_name"], $targetFile)) {
                $image = $targetFile; // Should be $image = $targetFile;
            } else {
                $error_message .= "Sorry, there was an error uploading your file. ";
            }
            
        }

       // Insert data into the database
       if (empty($error_message)) {
        $stmt = $pdoconn->prepare("INSERT INTO banner_info (image) VALUES (?)");
        $stmt->bindValue(1, $image, PDO::PARAM_STR);

        if ($stmt->execute()) {
            $_SESSION['success'] = "Your Data is Inserted";
            header("location: add_banner.php");
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
    $stmt = $pdoconn->prepare("DELETE FROM banner_info WHERE image = ?");
    $stmt->bindValue(1, $delete_id, PDO::PARAM_STR);
    if ($stmt->execute()) {
        // Delete image file from folder
        if (file_exists($delete_id)) {
            if (unlink($delete_id)) {
                $_SESSION['success'] = "Image deleted successfully";
                header("Location: add_banner.php");
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
<head>
<link rel="stylesheet" href="../css/admin.css">

</head>
<div class="section9 center">
<table class="centered responsive-table">
    <thead>
        <tr>
            <th>Image</th>
            <th>Action</th>
        </tr>
    </thead>

    <tbody>
    <?php
    foreach ($arr_all as $key) {
        if (file_exists($key['image'])) {
    ?>
            <tr>
                <td><img class="i" src="<?php echo $key['image']; ?>" alt="Uploaded Image" style="width: 50px; height: 50px;"></td>
                <td>
                    <form method="post">
                        <input type="hidden" name="delete" value="<?php echo $key['image']; ?>"> <!-- Use image path as the value -->
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this image?')">Delete</button>
                    </form>
                </td>
            </tr>
    <?php
        }
    }
    ?>
</tbody>

</table>

<form action="" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="lis_img">Choose Image</label>
        <input type="file" name="lis_img" id="lis_img" required>
        <button type="submit" class="btn btn-primary mt-3" name="submit">Upload</button>
        <?php
        // Display error message if any
        if (!empty($error_message)) {
            echo "<p class='error'>$error_message</p>";
        }
        ?>
    </div>
</form>
