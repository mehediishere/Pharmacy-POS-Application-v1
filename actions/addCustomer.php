<?php 

session_start();
include('../config/db.php');

if(isset($_POST['submit'])){
    $chk = 0;
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $phone = $conn->real_escape_string($_POST['phone']);
    $points = $conn->real_escape_string($_POST['points']);
    $addr1 = $conn->real_escape_string($_POST['addr1']);
    $customerType = $conn->real_escape_string($_POST['customerType']);
    $customerStatus = $conn->real_escape_string($_POST['customerStatus']);


    // -------------- Empty input field check 
    if(empty($name)){
        $chk=1;
        $_SESSION['msg']="Enter customer name";
        echo "<script>window.history.back();</script>";
        exit();
    }
    
    if(empty($phone)){
        $chk=1;
        $_SESSION['msg']="Enter customer phone";
        echo "<script>window.history.back();</script>";
        exit();
    }
    // -------------- Empty input field check end

    $check = mysqli_num_rows($conn->query("SELECT * FROM `p_customer` where `name`='$name' AND `phone`='$phone'"));
    if($check > 0){
        $chk=1;
        $_SESSION['msg']="This user already exist";
        echo "<script>window.history.back();</script>";
        exit();
    }

    if($chk==0){
        $insertCustomerInfo=$conn->query("INSERT INTO `p_customer`(`store`, `name`, `email`, `phone`, `address`, `customertype`, `customerstatus`, `points`, `date`) 
                                                                VALUES ('$_SESSION[store_id]', '$name', '$email', '$phone', '$addr1', '$customerType', '$customerStatus', '$points', '$date')");          
        $_SESSION['msg'] ="Information submit successfully";
        echo "<script>window.history.back();</script>";
        exit();
        
    }else{
        $_SESSION['msg'] ="Something went wrong. Try later !!!";
        echo "<script>window.history.back();</script>";
        exit();
    }

}

if(isset($_POST['submitUP'])){
    $chk = 0;
    $id = $conn->real_escape_string($_POST['code']);
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $phone = $conn->real_escape_string($_POST['phone']);
    $points = $conn->real_escape_string($_POST['points']);
    $addr = $conn->real_escape_string($_POST['addr']);
    $due = $conn->real_escape_string($_POST['due']);
    $wallet = $conn->real_escape_string($_POST['wallet']);
    $customerType = $conn->real_escape_string($_POST['customerType']);
    $customerStatus = $conn->real_escape_string($_POST['customerStatus']);

    $conn->query("UPDATE `p_customer` SET `name`='$name',`email`='$email',`phone`='$phone',`points`='$points',`due`='$due',`wallet`='$wallet',`address`='$addr',`customertype`='$customerType',`customerstatus`='$customerStatus' WHERE `id`='$id' AND `store`='$_SESSION[store_id]'");

    $_SESSION['msg'] =" Update";
    echo "<script>window.history.back();</script>";
    exit();
}


echo "<script>window.history.back();</script>";
exit();