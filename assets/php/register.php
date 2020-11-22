<?php
include "Account.php";
$acct = new Account();
$username = $_POST['r_username'];
$password = $_POST['r_password'];
$email = $_POST['r_email'];
$firstname = $_POST['r_firstname'];
$lastname = $_POST['r_lastname'];
$tel = $_POST['r_tel'];
if ($acct->createAccount($username, $password, $firstname, $lastname, $email, $tel)){
    echo true;
}
else{
    echo false;
}
?>
