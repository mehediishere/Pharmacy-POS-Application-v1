<?php

if(!isset($_POST['submit'])){
    echo "<script>window.history.back();</script>";
	exit();
}else{
    session_start();
    include('../config/db.php');

    $chk = 0;
    
    $title = $conn->real_escape_string($_POST['title']);
    $supplier = $conn->real_escape_string($_POST['supplier']);
    $total = $conn->real_escape_string($_POST['total']);
    $payable = $conn->real_escape_string($_POST['payable']);
    $paid = $conn->real_escape_string($_POST['paid']);
    $due = $conn->real_escape_string($_POST['due']);
    $details = $conn->real_escape_string($_POST['details']);
    $supplydate = $conn->real_escape_string($_POST['supplydate']);

    // -------------- Empty input field check 
    if(empty($title)){
        $chk=1;
        $_SESSION['e-msg']="Enter a title / supplier name / other details";
        echo "<script>window.history.back();</script>";
        exit();
    }
    // -------------- Empty input field check end

    if($chk == 0){
        $conn->query("INSERT INTO `p_supply`(`store`, `title`, `supplier`, `total`, `payable`, `paid`, `due`, `details`, `supplydate`, `date`) 
        VALUES ('$_SESSION[store_id]','$title','$supplier','$total','$payable','$paid','$due','$details','$supplydate', '$date')");

        $_SESSION['msg']="Information submit successfully";

        echo "<script>window.history.back();</script>";
        exit();
    }
}