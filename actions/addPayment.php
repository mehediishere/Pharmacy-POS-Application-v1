<?php 

session_start();
include('../config/db.php');

if(isset($_POST['submit'])){
    $chk = 0;
    $transaction = $conn->real_escape_string($_POST['transaction']);
    $payment_date = $conn->real_escape_string($_POST['payment_date']);
    $payment_type = $conn->real_escape_string($_POST['payment_type']);
    $account_type = $conn->real_escape_string($_POST['account_type']);
    $account_id = $conn->real_escape_string($_POST['account_id']);
    $amount = $conn->real_escape_string($_POST['amount']);
    $payment_method = $conn->real_escape_string($_POST['payment_method']);
    $details = $conn->real_escape_string($_POST['details']);

    $user = mysqli_fetch_assoc($conn->query("SELECT * FROM `p_$account_type` WHERE `id` = '$account_id' AND `store` = '$_SESSION[store_id]'"));

    // Date formet change
    $payment_date = date("Y-m-d", strtotime($payment_date));



    // -------------- Empty input field check 
    if(empty($transaction) || ctype_space($transaction)){
        $chk=1;
        $_SESSION['e-msg']="Enter transaction";
        echo "<script>window.history.back();</script>";
        exit();
    }

    if(empty($payment_date) || ctype_space($payment_date)){
        $chk=1;
        $_SESSION['e-msg']="Enter payment date";
        echo "<script>window.history.back();</script>";
        exit();
    }

    if(empty($amount) || ctype_space($amount)){
        $chk=1;
        $_SESSION['e-msg']="Enter amount";
        echo "<script>window.history.back();</script>";
        exit();
    }

    if(empty($payment_method) || ctype_space($payment_method)){
        $chk=1;
        $_SESSION['e-msg']="Enter payment method";
        echo "<script>window.history.back();</script>";
        exit();
    }
    // -------------- Empty input field check end

    if($chk==0){
        $conn->query("INSERT INTO `p_payment`(`store`, `transaction`, `payment_date`, `payment_type`, `account_type`, `name`, `phone`, `amount`, `payment_method`, `details`, `date`) 
        VALUES ('$_SESSION[store_id]','$transaction','$payment_date','$payment_type','$account_type','$user[name]', '$user[phone]', '$amount','$payment_method','$details','$date')");

        $_SESSION['msg'] ="Information submit successfully";
        echo "<script>window.history.back();</script>";
        exit();
        
    }else{
        $_SESSION['e-msg'] ="Something went wrong. Try later !!!";
        echo "<script>window.history.back();</script>";
        exit();
    }

}

if(isset($_POST['submitUP'])){
    $chk = 0;
    $pyid = $conn->real_escape_string($_POST['pyid']);
    $transaction = $conn->real_escape_string($_POST['transaction']);
    $payment_date = $conn->real_escape_string($_POST['payment_date']);
    $payment_type = $conn->real_escape_string($_POST['payment_type']);
    $amount = $conn->real_escape_string($_POST['amount']);
    $payment_method = $conn->real_escape_string($_POST['payment_method']);
    $details = $conn->real_escape_string($_POST['details']);

    $conn->query("UPDATE `p_payment` SET `transaction`='$transaction',`payment_date`='$payment_date',`payment_type`='$payment_type',`amount`='$amount',`payment_method`='$payment_method',`details`='$details' WHERE `store`='$_SESSION[store_id]' AND `id` ='$pyid'");
    
    echo "<script>window.history.back();</script>";
    exit();
}

echo "<script>window.history.back();</script>";
exit();