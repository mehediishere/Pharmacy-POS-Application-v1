<?php 
if(!isset($_POST['return_to_customer'])){
    echo "<script>window.history.back();</script>";
	exit();
}else{
    session_start();
    include('../config/db.php');

    $store = $_SESSION['store_id'];
    $re_invoice = $conn->real_escape_string($_POST['re_invoice']);
    $re_customer = $conn->real_escape_string($_POST['re_customer']);
    $re_customer_code = $conn->real_escape_string($_POST['re_customer_code']);
    $re_total = $conn->real_escape_string($_POST['re_total']); // total without discount & before return
    $re_discount = $conn->real_escape_string($_POST['re_discount']);
    $re_paid = $conn->real_escape_string($_POST['re_paid']); //customer paid
    $after_return_total_price = $conn->real_escape_string($_POST['return_total_price']); // without discount
    $after_return_grand_total = $conn->real_escape_string($_POST['return_product_value']); // with discount
    $payable = $conn->real_escape_string($_POST['cus_should_payable']); // payable to customer
    $payable_to_customer = $conn->real_escape_string($_POST['payable_to_customer']); //pay amount to customer

    $conn->query("INSERT INTO `p_return_summary`(`store`, `invoice`, `customer`, `customer_id`, `grand_price`, `customer_paid`, `returnable`, `returned`, `discount`, `date`) 
                VALUES ('$store', '$re_invoice', '$re_customer', '$re_customer_code', '$re_total', '$re_paid', '$payable', '$payable_to_customer', '$re_discount', '$date')");

    foreach($_SESSION["return_item"] as $row){
        $conn->query("INSERT INTO `p_return_product`(`store`, `invoice`, `product`, `unit_price`, `order_qty`, `return_qty`, `date`) VALUES ('$store', '$re_invoice', '$row[name]', '$row[price]', '$row[orderQty]', '$row[returnQty]', '$date')");
        $returnQty = $row['returnQty'];
        $product = $row['name'];
        $conn->query("UPDATE `p_medicine` SET `qty` = `qty`+'$returnQty' WHERE `store` = '$store' AND `name` = '$product'");
    }

    unset($_SESSION["return_item"]);

    $_SESSION['msg'] ="Information submit successfully";
    header("location:../return.php");
    exit();
}

// Default location
echo "<script>window.history.back();</script>";
exit();