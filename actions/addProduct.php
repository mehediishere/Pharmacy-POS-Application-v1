<?php

session_start();
include('../config/db.php');

if(isset($_POST['submit'])){
    $chk = 0;
    $product_name = $conn->real_escape_string($_POST['product_name']); //required
    $product_code = $conn->real_escape_string($_POST['product_code']);
    $strength = $conn->real_escape_string($_POST['strength']);
    $unit = $conn->real_escape_string($_POST['unit']);
    $shelf = $conn->real_escape_string($_POST['shelf']);
    $category_product = $conn->real_escape_string($_POST['category_product']); //required
    $brand_product = $conn->real_escape_string($_POST['brand_product']); //required
    $abroad = $conn->real_escape_string($_POST['abroad']);
    $new_stock = $conn->real_escape_string($_POST['new_stock']); //required
    $product_price = $conn->real_escape_string($_POST['product_price']); //required
    $cost = $conn->real_escape_string($_POST['cost']); //required
    $details = $conn->real_escape_string($_POST['details']);
    $expiredate = $conn->real_escape_string($_POST['expiredate']);

    // Date formet change
    $expiredate = date("Y-m-d", strtotime($expiredate));

    // image 
    $uploadFileRename = "not-available.png";
    $filename = $_FILES["uploadfile"]["name"]; //file name
    if(!empty($filename)){
        $tempname = $_FILES["uploadfile"]["tmp_name"]; //file
        $uploadFileRename = time().rand(00,999).$_SESSION['store_id'].$filename; //rename file
        $folder = "../dist/img/product/".$uploadFileRename; //root folder destination

        $allowTypes = array('jpg','png','jpeg');
        $fileType = pathinfo($filename, PATHINFO_EXTENSION);

        // checking file type for image
        if(!in_array($fileType, $allowTypes)){
            $chk = 1;
            $_SESSION['e-msg']="Only 'jpg','png','jpeg' support.";
            echo "<script>window.history.back();</script>";
            exit();
        }
    }

    // Empty input field check 
    if(empty($product_name) || ctype_space($product_name)){
        $chk=1;
        $_SESSION['e-msg']="Product name can not be empty";
        echo "<script>window.history.back();</script>";
        exit();
    }

    if(empty($category_product) || ctype_space($category_product)){
        $chk=1;
        $_SESSION['e-msg']="Category field can not be empty";
        echo "<script>window.history.back();</script>";
        exit();
    }

    if(empty($brand_product) || ctype_space($brand_product)){
        $chk=1;
        $_SESSION['e-msg']="Brand field can not be empty";
        echo "<script>window.history.back();</script>";
        exit();
    }

    if(empty($new_stock) || ctype_space($new_stock)){
        $chk=1;
        $_SESSION['e-msg']="Stock can not be empty";
        echo "<script>window.history.back();</script>";
        exit();
    }

    if(empty($product_price) || ctype_space($product_price)){
        $chk=1;
        $_SESSION['e-msg']="Product price can not be empty";
        echo "<script>window.history.back();</script>";
        exit();
    }

    if(empty($cost) || ctype_space($cost)){
        $chk=1;
        $_SESSION['e-msg']="Enter cost";
        echo "<script>window.history.back();</script>";
        exit();
    }

    // Empty input field check end


    // checking product 
    $check = numRows("SELECT * FROM `p_medicine` where `price`='$product_price' AND `category`='$category_product' AND `name`='$product_name' AND `store`='$_SESSION[store_id]'");
    if($check > 0){
        $chk=1;
        $_SESSION['e-msg']="This product already exist";
        echo "<script>window.history.back();</script>";
        exit();
    }

    if($chk==0){
        $insert=$conn->query("INSERT INTO `p_medicine`(`store`, `expiredate`, `abroad`, `name`, `details`, `category`, `brand`, `strength`, `unit`, `code`, `shelf`, `cost`, `price`, `qty`, `img`, `date`) 
            VALUES ('$_SESSION[store_id]', '$expiredate', '$abroad', '$product_name', '$details', '$category_product', '$brand_product', '$strength', '$unit', '$product_code', '$shelf', '$cost', '$product_price', '$new_stock', '$uploadFileRename', '$date')");        
            $_SESSION['msg'] ="Information submit successfully";
            if(!empty($filename)){
                move_uploaded_file($tempname, $folder);
            }
            header("location:../add-product.php");
            exit();
    }else{
        $_SESSION['msg'] ="Something went wrong. Try again !!!";
        header("location:../add-product.php");
        exit();
    }
}

// Default return
echo "<script>window.history.back();</script>";
exit();