<?php
    session_start();
    include "Account.php";
    $acct = new Account();
    $email = $_POST['email'];
    $password = $_POST['password'];
    if ($acct->getAccount($email, $password)){
        $_SESSION['acct'] = serialize($acct);
        $_SESSION['id'] = $acct->id;
        $_SESSION['username'] = $acct->username;
        $_SESSION['password'] = $acct->password;
        $_SESSION['email'] = $acct->email;
        $_SESSION['firstname'] = $acct->firstname;
        $_SESSION['lastname'] = $acct->lastname;
        $_SESSION['telephone'] = $acct->tel;
        echo true;
    }
    else{
        echo false;
    }
?>
