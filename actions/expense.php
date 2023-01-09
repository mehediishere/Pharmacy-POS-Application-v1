<?php

session_start();
include_once("../config/db.php");

// ------- Add Expense category 
if(isset($_POST['submitEC'])){
    $expense = $conn->real_escape_string($_POST['expenseC']);
    if(!ctype_space($expense)){
        $conn->query("INSERT INTO `p_expense_category`(`store`, `category`, `date`) VALUES ('$_SESSION[store_id]','$expense','$date')");
        header("location:../expense-category.php");
        exit();
    }
}

// -------- Add Expense
if(isset($_POST['submitEX'])){
    $chk = 0;
    $expense_name = $conn->real_escape_string($_POST['expense_name']);
    $expense_amount = $conn->real_escape_string($_POST['expense_amount']);
    $edate = $conn->real_escape_string($_POST['edate']);
    $expense_category = $conn->real_escape_string($_POST['expense_category']);
    $details = $conn->real_escape_string($_POST['details']);
    $paymentM = $conn->real_escape_string($_POST['paymentM']);

    $edate = date("Y-m-d", strtotime($edate));

    // Empty input field check 
    if(empty($expense_name) || ctype_space($expense_name)){
        $chk=1;
        $_SESSION['e-msg']="Enter expense title/name";
        echo "<script>window.history.back();</script>";
        exit();
    }
    if(empty($expense_amount) || ctype_space($expense_amount)){
        $chk=1;
        $_SESSION['e-msg']="Enter expense amount";
        echo "<script>window.history.back();</script>";
        exit();
    }

    if($chk == 0){
        $conn->query("INSERT INTO `p_expense`(`store`, `name`, `payment_method`, `amount`, `expense_date`, `category`, `details`, `date`)
         VALUES ('$_SESSION[store_id]','$expense_name', '$paymentM', '$expense_amount', '$edate', '$expense_category', '$details', '$date')");

         $_SESSION['msg']="Information submitted successfully";

         echo "<script>window.history.back();</script>";
        exit();
    }
}


// -------- Update Expense
if(isset($_POST['submitUP'])){
    $chk = 0;
    $id = $conn->real_escape_string(base64_decode($_POST['code']));
    $expense_name = $conn->real_escape_string($_POST['expense_name']);
    $expense_amount = $conn->real_escape_string($_POST['expense_amount']);
    $edate = $conn->real_escape_string($_POST['edate']);
    $expense_category = $conn->real_escape_string($_POST['expense_category']);
    $details = $conn->real_escape_string($_POST['details']);
    $paymentM = $conn->real_escape_string($_POST['paymentM']);

    $edate = date("Y-m-d", strtotime($edate));

    if($chk == 0){
        $conn->query("UPDATE `p_expense` SET `name`='$expense_name',`payment_method`='$paymentM',`amount`='$expense_amount',`expense_date`='$edate',`category`='$expense_category',`details`='$details',`date`='[value-9]' WHERE `store` = '$_SESSION[store_id]' AND `id` = '$id'");
        $_SESSION['msg']="Information submitted successfully";
        echo "<script>window.history.back();</script>";
        exit();
    }
}