<?php

session_start();
include('../config/db.php');

// Global remove
if(isset($_GET['remove'])){
  $id = base64_decode($_GET['code']);
  $table = base64_decode($_GET['wr']);
  $conn->query("DELETE FROM `$table` WHERE `id` = '$id'");
  echo "<script>window.history.back();</script>";
  exit();
}

// From `sales` list page
if(isset($_GET['sales'])){
  $invoice = base64_decode($_GET['code']);
  $conn->query("DELETE FROM `p_invoice` WHERE `invoice` = '$invoice'");
  $conn->query("DELETE FROM `p_invoice_summary` WHERE `invoice` = '$invoice'");
  echo "<script>window.history.back();</script>";
  exit();
}

// From `return` list page
if(isset($_GET['return'])){
  $invoice = base64_decode($_GET['code']);
  $conn->query("DELETE FROM `p_return_product` WHERE `invoice` = '$invoice'");
  $conn->query("DELETE FROM `p_return_summary` WHERE `invoice` = '$invoice'");
  echo "<script>window.history.back();</script>";
  exit();
}

// For `pos` session cart
if(isset($_POST["action_pos2"])){
    if(!empty($_SESSION["cart_pos_item"])) {
        foreach($_SESSION["cart_pos_item"] as $k => $v) {
            if($_POST["code"] == $k)
              unset($_SESSION["cart_pos_item"][$k]);				
            if(empty($_SESSION["cart_pos_item"]))
              unset($_SESSION["cart_pos_item"]);
        }
    }
    echo "<script>window.history.back();</script>";
}

// For `purchase` session cart
if(isset($_POST["action2"])){
    if(!empty($_SESSION["cart_item"])) {
        foreach($_SESSION["cart_item"] as $k => $v) {
            if($_POST["code"] == $k)
              unset($_SESSION["cart_item"][$k]);				
            if(empty($_SESSION["cart_item"]))
              unset($_SESSION["cart_item"]);
        }
    }
    echo "<script>window.history.back();</script>";
}

// From `category` list page
if(isset($_GET['removeCategory'])){
  $conn->query("DELETE FROM `p_medicine_category` WHERE `store`='$_SESSION[store_id]' AND `id`='$_GET[removeCategory]'");
  echo "<script>window.history.back();</script>";
}

// From `brand/manufacture` list page
if(isset($_GET['removeBrand'])){
  $conn->query("DELETE FROM `p_brand` WHERE `store`='$_SESSION[store_id]' AND `id`='$_GET[removeBrand]'");
  echo "<script>window.history.back();</script>";
}

// Default page exit
echo "<script>window.history.back();</script>";