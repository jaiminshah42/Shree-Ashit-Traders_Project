<?php
session_start();

try {
    if (!file_exists('../connection-pdo.php')) {
        throw new Exception();
    } else {
        require_once('../connection-pdo.php');
    }
} catch (Exception $e) {
    $_SESSION['msg'] = 'There were some problem in the Server! Try after some time!';
    header('location: ../../admin/product-list.php');
    exit();
}

if (!isset($_POST['name']) || !isset($_POST['desc']) || !isset($_FILES['image']) || !isset($_POST['category'])) {
    $_SESSION['msg'] = 'Invalid POST variable keys! Refresh the page!';
    header('location: ../../admin/product-list.php');
    exit();
}

$regex = '/^[(A-Z)?(a-z)?(0-9)?\-?\_?\.?\s*]+$/';

if (!preg_match($regex, $_POST['name']) || !preg_match($regex, $_POST['desc'])) {
    $_SESSION['msg'] = 'Whoa! Invalid Inputs!';
    header('location: ../../admin/product-list.php');
    exit();
}

$name = $_POST['name'];
$desc = $_POST['desc'];
$category = $_POST['category'];

// Handle image upload
if(isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
    $upload_dir = '../../admin/product_upload/';
    $tmp_file = $_FILES['image']['tmp_name'];
    $image_name = uniqid() . '_' . basename($_FILES['image']['name']);
    $target_file = $upload_dir . $image_name;
    if(move_uploaded_file($tmp_file, $target_file)) {
        // File uploaded successfully, continue with database insertion
        $image = $image_name; // Store only the image name in the database
    } else {
        // Handle file upload error
        $_SESSION['msg'] = 'Failed to upload image.';
        header('location: ../../admin/product-list.php');
        exit();
    }
} else {
    // Handle file upload error
    $_SESSION['msg'] = 'Error uploading image.';
    header('location: ../../admin/product-list.php');
    exit();
}

$sql = "INSERT INTO products(cat_id, fname, description, image) VALUES(?, ?, ?, ?)";
$query  = $pdoconn->prepare($sql);
if ($query->execute([$category, $name, $desc, $image])) {
    $_SESSION['msg'] = 'Product Added!';
    header('location: ../../admin/product-list.php');
} else {
    $_SESSION['msg'] = 'There were some problem in the server! Please try again after some time!';
    header('location: ../../admin/product-list.php');
}
?>
