<?php
session_start();
include('config/db.php');
echo "<pre>";
print_r($_SESSION['cart_pos_item']);
echo "</pre>";
// unset($_SESSION["return_item"]);

// $sumPrice =0; $sumCost = 0;
// foreach($_SESSION["cart_pos_item"] as $value){
//     $sumPrice += $value['price']*$value['quantity'];
//     $sumCost += $value['cost']*$value['quantity'];
//     echo "$value[name]"." "."$value[quantity]"." "."$value[quantity]"."<br>";
// }
// echo "$sumPrice"."<br>";
// echo "$sumCost"."<br>";

