<?php
session_start();
include("../config/db.php");

if(isset($_GET['applyCoupon'])){
    $coupon = $_GET['coupon'];
    $amount = $_GET['amount'];
    $store = $_SESSION['store_id'];

    $discountAmount = 0;

    $checkCoupon = mysqli_num_rows($conn->query("SELECT `code` FROM `coupon` WHERE `code` = '$coupon'"));
    $checkHistory = mysqli_num_rows($conn->query("SELECT `code`, `store` FROM `coupon_history` WHERE `code` = '$coupon' AND `store` = '$store'"));

    if($checkCoupon > 0 && $checkHistory <= 0){
        $cp = mysqli_fetch_assoc($conn->query("SELECT * FROM `coupon` WHERE `code` = '$coupon'"));
        if($cp['type'] == "FLAT"){
            $discountAmount = $cp['discount'];
            $amount = $amount - $discountAmount;
        }else{
            $discountAmount = $amount*($cp['discount']/100);
            $amount = $amount - $discountAmount;
        }
        $_SESSION['coupon'] = [ "store"=> $store, "amount" => $amount, "coupon" => $coupon, "discount" => $discountAmount ];
    }else{
        unset($_SESSION['coupon']);
    }
    
    $arr = [ "amount" => $amount, "coupon" => $coupon, "discount" => $discountAmount ];
    echo json_encode($arr);
}

// For  add-purchase-old.php (will remove later) 
if(isset($_POST['couponDiscount'])){
    $amount = $_POST['amount'];
    $coupon = $_POST['coupon'];
    $store = $_SESSION['store_id'];

    $checkCoupon = mysqli_num_rows($conn->query("SELECT `code` FROM `coupon` WHERE `code` = '$coupon'"));
    $checkHistory = mysqli_num_rows($conn->query("SELECT `code`, `store` FROM `coupon_history` WHERE `code` = '$coupon' AND `store` = '$store'"));

    if($checkCoupon > 0 && $checkHistory <= 0){
        $cp = mysqli_fetch_assoc($conn->query("SELECT * FROM `coupon` WHERE `code` = '$coupon'"));
        if($cp['type'] == "FLAT"){
            $discountAmount = $cp['discount'];
            $amount = $amount - $discountAmount;
        }else{
            $discountAmount = $amount*($cp['discount']/100);
            $amount = $amount - $discountAmount;
        }
        $arr = [ "amount" => $amount, "coupon" => $coupon, "discount" => $discountAmount ];
    }else{
        $arr = ["amount" => $amount, "coupon" => $coupon, "discount" => "0"];
    }
    
    echo json_encode($arr);
}