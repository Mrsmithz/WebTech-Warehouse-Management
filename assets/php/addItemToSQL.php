<?php
session_start();
include "Account.php";
include "Item.php";
$acct = new Account();
$acct->id = $_SESSION['id'];
$acct->firstname = $_SESSION['firstname'];
$acct->lastname = $_SESSION['lastname'];
$acct->username = $_SESSION['username'];
$acct->password = $_SESSION['password'];
$acct->email = $_SESSION['email'];
$acct->tel = $_SESSION['telephone'];

$item_name = $_POST['item_name'];
$item_type = $_POST['item_type'];
$item_price = $_POST['item_price'];
$item_weight = $_POST['item_weight'];
$item_quantities = $_POST['item_quantities'];
$item = new Item($item_name, $item_type, $item_price, $item_weight, $item_quantities, $acct->id);
if ($acct->addItem($item)){
    echo true;
}
else{
    echo false;
}
?>
