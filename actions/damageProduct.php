<?php 

if(!isset($_POST['submit'])){
    echo "<script>window.history.back();</script>";
	exit();
}else{

    session_start();
    include('../config/db.php');

    
    $chk = 0;
    $product = $_POST['product'];   //required
    $product_explode = explode('|', $product);
    $id = $conn->real_escape_string($product_explode[0]);
    $name = $conn->real_escape_string($product_explode[1]);
    $stock = $conn->real_escape_string($product_explode[2]);
    $price = $conn->real_escape_string($product_explode[3]);
    $cost = $conn->real_escape_string($product_explode[4]);
    $qty = $conn->real_escape_string($_POST['qty']);
    $note = $conn->real_escape_string($_POST['note']);

    // -------------- Empty input field check 

    if(empty($name) || ctype_space($name)){
        $chk=1;
        $_SESSION['e-msg']="Select product";
        echo "<script>window.history.back();</script>";
        exit();
    }

    if(empty($qty) || ctype_space($qty)){
        $chk=1;
        $_SESSION['e-msg']="Enter damaged product quantity";
        echo "<script>window.history.back();</script>";
        exit();
    }

    if($stock <= 0){
        $chk=1;
        $_SESSION['e-msg']="You dont have sufficient stock";
        echo "<script>window.history.back();</script>";
        exit();
    }  
    // -------------- Empty input field check end

    if($chk==0){
        $newStock = $stock - $qty;
        $conn->query("UPDATE `medicine` SET `qty` = '$newStock' WHERE `id` = '$id' AND `store` = '$_SESSION[store_id]'");
        $conn->query("INSERT INTO `p_damage_product`(`store`, `product`, `total_qty`, `damage_qty`, `cost`, `price`, `note`, `date`) VALUES ('$_SESSION[store_id]','$name','$stock','$qty','$cost','$price', '$note', '$date')");

        $_SESSION['msg'] ="Information submit successfully";
        header("location:../add-damage.php");
        exit();
        
    }else{
        $_SESSION['e-msg'] ="Something went wrong. Try later !!!";
        header("location:../add-damage.php");
        exit();
    }

}