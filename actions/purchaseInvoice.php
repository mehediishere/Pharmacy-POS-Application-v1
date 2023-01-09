<?php
session_start();
require_once("../config/db.php");

if(isset($_POST['orderSubmit'])){
    $chk = 0;
    // $totalQtyf = $conn->real_escape_string($_POST['totalQtyf']);
    // $totalAmountf = $conn->real_escape_string($_POST['totalAmountf']);

    $couponcodef = $conn->real_escape_string($_POST['couponcodef']);
    $paymentmethodf = $conn->real_escape_string($_POST['paymentmethodf']);

    $discounted_tkf = $conn->real_escape_string($_POST['discounted_tkf']);
    $grandtotalf = $conn->real_escape_string($_POST['grandtotalf']);
    // $notef = $conn->real_escape_string($_POST['notef']);
    $transId = $conn->real_escape_string($_POST['transId']);

    if(!empty($transId) && !ctype_space($transId)){
        $paymentStatus = "on review";
        $transectionDate = $date;
    }else{
        $paymentStatus = "unpaid";
        $transectionDate = "";
    }

    if(isset($_SESSION['coupon'])){
        if(($_SESSION['coupon']['coupon'] != $couponcodef) || ($_SESSION['coupon']['discount'] != $discounted_tkf)){
            $_SESSION['e-msg'] ="Order failed! Try again...";
            echo "<script>window.history.back();</script>";
            exit();
        }
    }

    if((!empty($discounted_tkf) && $discounted_tkf > 0) && (empty($couponcodef) || ctype_space($couponcodef))){
        unset($_SESSION['coupon']);
        $_SESSION['e-msg'] ="Order failed! Try again...";
        echo "<script>window.history.back();</script>";
        exit();
    }

    if($discounted_tkf <= 0){
        $couponcodef = "";
    }

    $orderId = rand(1, 9999);

    $totalPrice =0; $totalCost = 0; $sumQty = 0;
    foreach($_SESSION["cart_item"] as $value){
        $totalPrice += $value['price']*$value['quantity'];
        $totalCost += $value['cost']*$value['quantity'];
        $sumQty += $value['quantity'];
    }

    $payable = $totalPrice-$discounted_tkf;
    if($payable <= 0){
        $_SESSION['e-msg'] ="Order failed! Try again...";
        echo "<script>window.history.back();</script>";
        exit();
    }
    
    // insert into "purchase_summery" table
    $conn->query("INSERT INTO `p_purchase_summary`(`invoice`, `store`, `total_qty`, `total_price`, `total_cost`, `payment_method`, `coupon`, `discounted`, `payable`, `paid_status`,`transection_id`, `transection_submit_date`, `date`) 
    VALUES ('$orderId', '$_SESSION[store_id]', '$sumQty', '$totalPrice', '$totalCost', '$paymentmethodf', '$couponcodef', '$discounted_tkf', '$payable', '$paymentStatus', '$transId', '$transectionDate', '$date')");

    // insert into "purchase" table
    $sumPrice =0; $sumCost = 0;
    foreach($_SESSION["cart_item"] as $value){
        $sumPrice += $value['price']*$value['quantity'];
        $sumCost += $value['cost']*$value['quantity'];
        
        // decrease qty
        $getQty = mysqli_fetch_assoc($conn->query("SELECT `qty` FROM `medicine` WHERE `id` = '$value[code]'"));
        $qty = $getQty['qty']-$value['quantity'];
        if($qty < 0){
            $qty = 0;
        }
        $conn->query("UPDATE `medicine` SET `qty` = '$qty' WHERE `id` = '$value[code]'");

        // insert into "coupon_history" table if `coupon` applied
        if(!empty($couponcodef) || ctype_space($couponcodef)){
            $getCouponDetails = mysqli_fetch_assoc($conn->query("SELECT * FROM `coupon` WHERE `code` = '$couponcodef'"));
            
            $conn->query("INSERT INTO `coupon_history`(`code`, `discount`, `type`, `store`, `redeem_date`, `coupon_created`, `coupon_expired`, `purchased`) 
            VALUES ('$couponcodef', '$getCouponDetails[discount]', '$getCouponDetails[type]', '$_SESSION[store_id]','$date', '$getCouponDetails[created]', '$getCouponDetails[expire]', '$totalPrice')");
            
            // update max-redeem of coupon
            $couponQty = $getCouponDetails['max_redeem'] - 1;
            if($couponQty < 0){
                $couponQty = 0;
            }
            $conn->query("UPDATE `coupon` SET `max_redeem` = '$couponQty' WHERE `code` = '$couponcodef'");
        }
        
        // now inserting into `invoice`
        $conn->query("INSERT INTO `p_purchase` (`invoice`, `store`, `product`, `qty`, `cost`, `totalcost`, `price`, `totalprice`, `date`) 
        VALUES ('$orderId', '$_SESSION[store_id]', '$value[name]', '$value[quantity]', '$value[cost]', '$sumCost', '$value[price]', '$sumPrice', '$date')");

        // reset sum value for next product 
        $sumPrice =0; $sumCost = 0;
    }

    // emptying cart 
    unset($_SESSION['coupon']);
    unset($_SESSION["cart_item"]);
        
    $_SESSION['msg'] ="Order placed successfully";
    echo "<script>window.history.back();</script>";
    exit();
}

if(isset($_POST['update'])){
    $chk = 0;
    // $transectionDate = date("Y-m-d", strtotime($conn->real_escape_string($_POST['date'])));
    $paymentWith = $conn->real_escape_string($_POST['trandectionWith']);
    $transectionInfo = $conn->real_escape_string($_POST['transectionInfo']);
    $transectionDetails = $conn->real_escape_string($_POST['transectionDetails']);
    $amount = $conn->real_escape_string($_POST['amount']);
    $invoice = $conn->real_escape_string($_POST['invoice']);

    $checkPayment = mysqli_fetch_assoc($conn->query("SELECT `paid_status` FROM `p_purchase_summary` WHERE `store` = '$_SESSION[store_id]' AND `invoice` = '$invoice'"));
    if($checkPayment['paid_status'] = "unpaid"){
        
        $conn->query("UPDATE `p_purchase_summary` SET `payment_method`='$paymentWith', `transection_id`='$transectionInfo', `on_transection_paid`='$amount', `transection_details`='$transectionDetails', `transection_submit_date`='$date', `paid_status`='on review' WHERE `invoice` = '$invoice'");

        $_SESSION['msg'] = "Submitted successfully";
        echo "<script>window.history.back();</script>";
        exit();
    }elseif($checkPayment['paid_status'] = "paid"){
        $chk = 1;
        $_SESSION['i-msg'] = "Your order payment already paid";
        echo "<script>window.history.back();</script>";
        exit();
    }elseif($checkPayment['paid_status'] != "paid" || $checkPayment['paid_status'] != "unpaid"){
        $chk = 1;
        $_SESSION['i-msg'] = "Your order payment on review. Contact with us for more details. $checkPayment[paid_status]";
        echo "<script>window.history.back();</script>";
        exit();
    }
}

if(isset($_GET['cancel'])){
    $invoice = $_GET['invoice'];
    
    $conn->query("UPDATE `p_purchase_summary` SET `status` = 'cancel' WHERE `invoice` = '$invoice'");
    echo "<script>window.history.back();</script>";
    exit();
}