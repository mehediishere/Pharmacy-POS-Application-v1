<?php
session_start();
require_once("../config/db.php");

if(isset($_POST['orderSubmit'])){
    $chk = 0;
    $totalQtyf = $conn->real_escape_string($_POST['totalQtyf']);
    $totalAmountf = $conn->real_escape_string($_POST['totalAmountf']);

    $title = $conn->real_escape_string($_POST['title']);
    $invoiceDatef = $conn->real_escape_string($_POST['invoiceDatef']); 
    $customertypef = $conn->real_escape_string($_POST['customertypef']); 
    
    $discountf = $conn->real_escape_string($_POST['discountf']);
    $discounttypef = $conn->real_escape_string($_POST['discounttypef']);
    $afterdiscountf = $conn->real_escape_string($_POST['afterdiscountf']);

    $paymentmethodf = $conn->real_escape_string($_POST['paymentmethodf']);
    $paidf = $conn->real_escape_string($_POST['paidf']);

    $previousduef = $conn->real_escape_string($_POST['previousduef']);
    $currentduef = $conn->real_escape_string($_POST['currentduef']);
    $walletf = $conn->real_escape_string($_POST['walletf']);     

    // Date formet change
    $invoiceDatef = date("Y-m-d", strtotime($invoiceDatef));

    if($customertypef == "Walk-in-Customer"){
        if($currentduef > 0){
            $chk = 1;        
            $_SESSION['e-msg'] ="Walk in customer can't have due.";
            echo "<script>window.history.back();</script>";
            exit();
        }
        if($currentduef < 0){
            $chk = 1;        
            $_SESSION['e-msg'] ="Over paid not allowed for walk in customer.";
            echo "<script>window.history.back();</script>";
            exit();
        }
    }

    if(!empty($discountf) && $discountf > 0 && $afterdiscountf <= 0){
        $chk = 1;        
        $_SESSION['e-msg'] ="Something went wrong! Try again";
        echo "<script>window.history.back();</script>";
        exit();
    }

    $sumPrice =0;
    foreach($_SESSION["cart_pos_item"] as $value){
        $sumPrice += $value['price']*$value['quantity'];
    }

    if($paidf > $sumPrice){
        $chk = 1;        
        $_SESSION['e-msg'] ="Over paid not allowed.";
        echo "<script>window.history.back();</script>";
        exit();
    }

    if($totalAmountf < 0 || empty($totalAmountf)){
        $chk = 1;        
        $_SESSION['e-msg'] ="Cart is empty";
        echo "<script>window.history.back();</script>";
        exit();
    }

    $invoiceId = rand(1, 9999); // generate invoice

    $totalPrice =0; $totalCost = 0; $sumQty = 0;
    foreach($_SESSION["cart_pos_item"] as $value){
        $totalPrice += $value['price']*$value['quantity'];
        $totalCost += $value['cost']*$value['quantity'];
        $sumQty += $value['quantity'];
    }    
    
    // Insert in `invoice_summary`
    $conn->query("INSERT INTO `p_invoice_summary` (`invoice`, `store`, `client`, `total_qty`, `total_price`, `total_cost`, `payment_method`, `paid`, `due`, `discount_type`, `discount`, `payable`, `order_date`, `date`) 
    VALUES ('$invoiceId', '$_SESSION[store_id]', '$customertypef', '$sumQty', '$totalPrice', '$totalCost', '$paymentmethodf', '$paidf', '$currentduef', '$discounttypef', '$discountf', '$afterdiscountf', '$invoiceDatef', '$date')");

    // insert in `invoice`
    $sumPrice =0; $sumCost = 0;
    foreach($_SESSION["cart_pos_item"] as $value){
        $sumPrice += $value['price']*$value['quantity'];
        $sumCost += $value['cost']*$value['quantity'];
        
        // decrease qty
        $getQty = mysqli_fetch_assoc($conn->query("SELECT `qty` FROM `p_medicine` WHERE `id` = '$value[code]' AND `store` = '$_SESSION[store_id]'"));
        $qty = $getQty['qty']-$value['quantity'];
        if($qty < 0){
            $qty = 0;
        }
        $conn->query("UPDATE `p_medicine` SET `qty` = '$qty' WHERE `id` = '$value[code]'");
        
        // now inserting into `invoice`
        $conn->query("INSERT INTO `p_invoice` (`invoice`, `store`, `product_id`, `product`, `qty`, `cost`, `totalcost`, `price`, `totalprice`, `date`) 
        VALUES ('$invoiceId', '$_SESSION[store_id]', '$value[code]', '$value[name]', '$value[quantity]', '$value[cost]', '$sumCost', '$value[price]', '$sumPrice', '$date')");

        // reset sum value for next product 
        $sumPrice =0; $sumCost = 0;
    }

    // insert into `customer` for due, wallet, payment history
    if($customertypef != "Walk-in-Customer"){
        $customerPaid = mysqli_fetch_assoc($conn->query("SELECT * FROM `customer` WHERE `store` = '$_SESSION[store_id]' AND `id` = '$customertypef'"));

        $paid_history = $paidf+$customerPaid['paid'];
        $due = $currentduef;
        $newWallet = $walletf + $customerPaid['wallet'];
        $conn->query("UPDATE `customer` SET `paid`='$paid_history', `due`='$due', `wallet`='$newWallet' WHERE `store` = '$_SESSION[store_id]' AND `id` = '$customertypef'");
    }

    if($customertypef != "Walk-in-Customer"){
        $customer = mysqli_fetch_assoc($conn->query("SELECT * FROM `customer` WHERE `store` = '$_SESSION[store_id]' AND `id` = '$customertypef'"));
        $cname = $customer['name'];
        $caddr = $customer['address1'];
    }else{
        $cname = $customertypef;
        $caddr = $title;
    }

    $_SESSION["invoice_user_print"] = array(
        "invoice"=>"$invoiceId",
        "name"=>"$cname", 
        "phone"=>"$customer[phone]", 
        "email"=>"$customer[email]", 
        "address1"=>"$caddr",
        "discount"=>"$discountf",
        "discount_type"=>"$discounttypef",
        "after_discount"=>"$afterdiscountf",
        "total_price"=>"$totalPrice",
        "paid"=>"$paidf",
        "due"=>"$currentduef",
    );
    $_SESSION["invoice_cart_print"] = $_SESSION["cart_pos_item"];

    // emptying cart 
    unset($_SESSION["cart_pos_item"]);
    $_SESSION['msg'] ="Submit successfully";
    // echo "<script>window.history.back();</script>";
    header("location:../invoice.php");
    exit();
}