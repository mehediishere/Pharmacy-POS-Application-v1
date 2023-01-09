<?php
session_start();
include('../config/db.php');

if(!empty($_GET["action_pos"])) {
    switch($_GET["action_pos"]) {
      case "add":
        if(!empty($_GET["quantity"])) {
          $productByCode = runQuery("SELECT * FROM `p_medicine` WHERE id='" . $_GET["code"] . "'");
          $itemArray = array(
            $productByCode[0]["id"]=>array(
              'name'=>$productByCode[0]["name"], 
              'code'=>$productByCode[0]["id"], 
              'quantity'=>$_GET["quantity"], 
              'cost'=>$productByCode[0]["cost"],
              'price'=>$productByCode[0]["price"],
              'image'=>$productByCode[0]["img"]
          ));
    
          // echo '<script type="text/javascript">alert("'.print_r($productByCode).'");</script>';
    
          // echo '<script type="text/javascript">alert("'.print_r($itemArray).'");</script>';
          
          // print_r(array_keys($itemArray));
          // print_r($productByCode[0]['id']);

          if(!empty($_SESSION["cart_pos_item"])) {
            if(in_array($productByCode[0]["id"],array_keys($_SESSION["cart_pos_item"]))) {
              foreach($_SESSION["cart_pos_item"] as $k => $v) {
                if($productByCode[0]["id"] == $k) {
                  if(empty($_SESSION["cart_pos_item"][$k]["quantity"])) {
                    $_SESSION["cart_pos_item"][$k]["quantity"] = 0;
                  }
                  $_SESSION["cart_pos_item"][$k]["quantity"] += $_GET["quantity"];
                }
              }
            } else {
              // $_SESSION["cart_pos_item"] = array_merge($_SESSION["cart_pos_item"],$itemArray);
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
              $_SESSION["cart_pos_item"] = merge($_SESSION["cart_pos_item"],$itemArray);
            }
          } else {
            $_SESSION["cart_pos_item"] = $itemArray;
          }
        }
        break;
      case "remove":
        if(!empty($_SESSION["cart_pos_item"])) {
          foreach($_SESSION["cart_pos_item"] as $k => $v) {
              if($_GET["code"] == $k)
                unset($_SESSION["cart_pos_item"][$k]);				
              if(empty($_SESSION["cart_pos_item"]))
                unset($_SESSION["cart_pos_item"]);
          }
        }
      break;
      case "empty":
        unset($_SESSION["cart_pos_item"]);
      break;	
    }
}

// Quantity update
if(isset($_GET['incQty'])){
  // echo "$_GET[code]";
  foreach($_SESSION["cart_pos_item"] as $k => $value){
    if($k == $_GET['code']){
      $_SESSION["cart_pos_item"][$k]['quantity'] = $_GET['qty'];
    }
  }
}


