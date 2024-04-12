<?php

session_start();
try {

    if (!file_exists('../connection-pdo.php'))
        throw new Exception();
    else
        require_once('../connection-pdo.php');

} catch (Exception $e) {

    $_SESSION['msg'] = 'There were some problems on the server! Please try again later!';

    header('location: ../../admin/category-list.php');

    exit();
    
}

if (!isset($_POST['name']) || !isset($_POST['short_desc']) || !isset($_POST['long_desc']) || !isset($_POST['image'])) {

    $_SESSION['msg'] = 'Invalid POST variable keys! Please refresh the page!';

    header('location: ../../admin/category-list.php');

    exit();
}

$regex = '/^[(A-Z)?(a-z)?(0-9)?\-?\_?\.?\,?\s*]+$/';

if (!preg_match($regex, $_POST['name']) || !preg_match($regex, $_POST['short_desc']) || !preg_match($regex, $_POST['long_desc'])  || !preg_match($regex, $_POST['image'])) {

    $_SESSION['msg'] = 'Invalid Inputs!';

    header('location: ../../admin/category-list.php');

    exit();

} else {

    $name = $_POST['name'];
    $short_desc = $_POST['short_desc'];
    $long_desc = $_POST['long_desc'];
    $image = $_POST['image'];

    $sql = "INSERT INTO categories(name,short_desc,long_desc,image) VALUES(?,?,?,?)";
    $query  = $pdoconn->prepare($sql);
    if ($query->execute([$name, $short_desc, $long_desc,$image])) {

        $_SESSION['msg'] = 'Category Added!';

        header('location: ../../admin/category-list.php');
        
    } else {

        $_SESSION['msg'] = 'There were some problems on the server! Please try again later!';

        header('location: ../../admin/category-list.php');

    }

}
