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

    exit();

    if($customertypef == "Walk-in-Customer"){
        if($currentduef > 0){
            $chk = 1;        
            $_SESSION['e-msg'] ="Walk in customer can't have due.";
            header("location:../pos.php");
            exit();
        }
        if($currentduef < 0){
            $chk = 1;        
            $_SESSION['e-msg'] ="Over paid not allowed for walk in customer.";
            header("location:../pos.php");
            exit();
        }
    }

    if($totalAmountf < 0 || empty($totalAmountf)){
        $chk = 1;        
        $_SESSION['e-msg'] ="Cart is empty";
        header("location:../pos.php");
        exit();
    }

    $invoiceId = rand(1, 9999); // generate invoice

    $totalC = mysqli_fetch_assoc($conn->query("SELECT sum(totalcost) as tc FROM `cart` WHERE `user` = '$_SESSION[store_id]' AND `type` = 'Sales'"));
    
    // Insert in `invoice_summary`
    $invoice_summery = $conn->query("INSERT INTO `invoice_summary` (`invoice`, `invoice_type`, `store`, `client`, `total_qty`, `total_price`, `total_cost`, `payment_method`, `paid`, `due`, `discount_type`, `discount`, `order_date`, `date`) 
    VALUES ('$invoiceId', 'Sales', '$_SESSION[store_id]', '$customertypef', '$totalQtyf', '$totalAmountf', '$totalC[tc]', '$paymentmethodf', '$paidf', '$currentduef', '$discounttypef', '$discountf', '$invoiceDatef', '$date')");

    // insert in `invoice`
    $sql = $conn->query("SELECT a.p_id, a.qty, a.price, a.totalcost, a.type, a.totalprice, b.manufacturerprice, b.name, b.qty AS instock FROM cart AS a LEFT JOIN medicine AS b ON a.p_id = b.id;");
    while($invoice = mysqli_fetch_assoc($sql)){
        if($invoice['type'] == "Sales"){
            $qty = $invoice['instock']-$invoice['qty'];
            $conn->query("UPDATE `medicine` SET `qty` = '$qty' WHERE `medicine`.`id` = '$invoice[p_id]';");
            $insert = $conn->query("INSERT INTO `invoice` (`invoice`, `invoice_type`, `store`, `product`, `qty`, `cost`, `totalcost`, `price`, `total`, `date`) VALUES ('$invoiceId', 'Sales', '$_SESSION[store_id]', '$invoice[name]', '$invoice[qty]', '$invoice[manufacturerprice]', '$invoice[totalcost]', '$invoice[price]', '$invoice[totalprice]', '$date')");
        }
    }
    
    // insert into `customer`
    if($customertypef != "Walk-in-Customer"){
        $customerPaid = mysqli_fetch_assoc($conn->query("SELECT * FROM `customer` WHERE `store` = '$_SESSION[store_id]' AND `id` = '$customertypef'"));

        $paid_history = $paidf+$customerPaid['paid'];
        $due = $currentduef;
        $newWallet = $walletf + $customerPaid['wallet'];
        $conn->query("UPDATE `customer` SET `paid`='$paid_history', `due`='$due', `wallet`='$newWallet' WHERE `store` = '$_SESSION[store_id]' AND `id` = '$customertypef'");
    }

    // emptying cart 
    $conn->query("DELETE FROM `cart` WHERE `type` = 'Sales'");

    // if($insert){            
        $_SESSION['msg'] ="Information submit successfully";
        header("location:../pos.php");
        exit();
    // }
}

if(isset($_GET['remove'])){
    $id = $_GET['remove'];
    $conn->query("DELETE FROM `cart` WHERE `serial`='$id'");
    header("location:../pos.php");
    exit();
}