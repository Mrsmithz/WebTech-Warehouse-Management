<?php
session_start();
include "Account.php";
include "Customer.php";
$acct = new Account();
$acct->id = $_SESSION['id'];
$acct->firstname = $_SESSION['firstname'];
$acct->lastname = $_SESSION['lastname'];
$acct->username = $_SESSION['username'];
$acct->password = $_SESSION['password'];
$acct->email = $_SESSION['email'];
$acct->tel = $_SESSION['telephone'];

$order_number = $_POST['order_number'];
$track_number = $_POST['track_number'];
$contact = $_POST['contact'];
$tel_opt = $_POST['telephone_opt'];
$tel = $_POST['telephone'];
$name = $_POST['name'];
$price = $_POST['price'];
$method = $_POST['method'];
$address = $_POST['address'];
$subdistrict = $_POST['subdistrict'];
$district = $_POST['district'];
$province = $_POST['province'];
$postcode = $_POST['postcode'];

$customer = new Customer($order_number, $track_number, $contact, $tel, $tel_opt, $name, $price, $method, $address, $subdistrict, $district, $province, $postcode);
if ($acct->addCustomer($customer)){
    echo true;
}
else {
    echo false;
}
?>
