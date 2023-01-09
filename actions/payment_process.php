<?php
    session_start();
    require_once("../config/db.php");

    // Calculate discount -------------------------------------
    if (isset($_GET['applyDiscount'])) {
        $discount = $_GET['discount'];
        $type = $_GET['type'];
        // $user = $_GET['user'];
        $amount = $_GET['amount'];

        if(!empty($discount) || $discount >0){
            if($type == "flat"){
                $amount = $amount - $discount;
            }else{
                $amount = $amount - ($amount*($discount/100));
            }
        }
        
        $array = ["amount"=>$amount];
        echo json_encode($array);
    }

    // Check previous customer due ------------------------------
    if (isset($_GET['payBtn'])) {
        $customer = $_GET['customer'];
        if($customer != "Walk-in-Customer"){
            $previousDue = mysqli_fetch_assoc($conn->query("SELECT `due` FROM `customer` WHERE `store` = '$_SESSION[store_id]' AND `id` = '$customer'"));
            echo $previousDue['due'];
        }
    }

    // Check paid status once fill paid input[text] --------------
    if (isset($_GET['paidStatus'])) {
        $customer = $_GET['customer'];
        $payable = (double)$_GET['payable'];
        $due = (double)$_GET['due'];
        $paid = (double)$_GET['paid'];
        $wallet = 0;
        $currentDue=0;

        $pd = $payable+$due;
        
        if(!empty($paid) && $customer != "Walk-in-Customer"){
            if($paid == $pd)
            {
                $currentDue = 0;
            }
            elseif($paid < $pd)
            {
                $dd = $pd - $paid;
                $currentDue = number_format($dd, 2);
            }
            elseif($paid > $pd)
            {
                $currentDue = 0;
                $wallet = $wallet + ($paid - ($payable+$due));
            }
        }
        elseif(!empty($paid) && $customer == "Walk-in-Customer")
        {
            $currentDue = $payable - $paid;
        }

        $arr = ["wallet" => round($wallet,2), "currentDue"=> round($currentDue,2)];
        echo json_encode($arr);
    }