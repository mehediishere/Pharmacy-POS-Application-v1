<?php
session_start();
include('../config/db.php');

if(isset($_GET['updateExpenseCategory'])){
    $id = $_GET['code'];
    $value = $_GET['value'];
    $conn->query("UPDATE `p_expense_category` SET `category`='$value' WHERE `id` = '$id' AND `store` = '$_SESSION[store_id]'");
    echo "<script>window.history.back();</script>";
    exit();
}