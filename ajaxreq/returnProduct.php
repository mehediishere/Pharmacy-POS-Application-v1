<?php
    session_start();
    include("../config/db.php");

if(isset($_GET['applyReturn'])){
    $invoice = $_GET['invoice'];
    $product_name = $_GET['product_name'];
    $product_id = $_GET['product_id'];
    $orderQty = $_GET['orderQty'];
    $returnQty = $_GET['returnQty'];
    $price = $_GET['price'];

    $itemArray = array(
        $product_id=>array(
            'invoice' => $invoice,
            'name'=>$product_name, 
            'code'=>$product_id, 
            'orderQty'=>$orderQty,
            'returnQty'=>$returnQty,
            'price'=>$price
        ));

    if(!empty($_SESSION["return_item"])) {
        if(in_array($product_id,array_keys($_SESSION["return_item"]))) {
        foreach($_SESSION["return_item"] as $k => $v) {
            if($product_id == $k) {
            if(empty($_SESSION["return_item"][$k]["returnQty"])) {
                $_SESSION["return_item"][$k]["returnQty"] = 0;
            }
            $_SESSION["return_item"][$k]["returnQty"] = $returnQty;
            }
        }
        }else {
            function merge($arr1, $arr2){
                $out = array();
                foreach($arr1 as $key => $val1){
                    if(isset($arr2[$key])){
                        if(is_array($arr1[$key]) && is_array($arr2[$key])){
                            $out[$key]=  merge($arr1[$key], $arr2[$key]);
                        }else{
                            $out[$key]= array($arr1[$key], $arr2[$key]);
                        }
                        unset($arr2[$key]);
                    }else{
                        $out[$key] = $arr1[$key];
                    }
                }
                return $out + $arr2;
            }
            $_SESSION["return_item"] = merge($_SESSION["return_item"],$itemArray);
        }
    } else {
        $_SESSION["return_item"] = $itemArray;
    }
      
}

if(isset($_GET['removeFromReturn'])){
    $invoice = $_GET['invoice'];
    $product_name = $_GET['product_name'];
    $conn->query("DELETE FROM `return_cart` WHERE `invoice` = '$invoice' AND `product` = '$product_name' AND `store` = '$_SESSION[store_id]'");
}