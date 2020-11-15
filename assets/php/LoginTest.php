<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
    session_start();
    include "Account.php";
    $acct = new Account();
    $email = $_POST['login_email'];
    $password = $_POST['login_pass'];
    if ($acct->getAccount($email, $password)){
        $_SESSION['id'] = $acct->id;
        $_SESSION['username'] = $acct->username;
        $_SESSION['password'] = $acct->password;
        $_SESSION['firstname'] = $acct->firstname;
        $_SESSION['lastname'] = $acct->lastname;
        $_SESSION['email'] = $acct->email;
        $_SESSION['tel'] = $acct->tel;
        echo "<h1>".$acct->id."</h1><br>";
        echo "<h1>".$acct->username."</h1><br>";
        echo "<h1>".$acct->password."</h1><br>";
        echo "<h1>".$acct->firstname."</h1><br>";
        echo "<h1>".$acct->lastname."</h1><br>";
        echo "<h1>".$acct->email."</h1><br>";
        echo "<h1>".$acct->tel."</h1><br>";
        echo "<a href=\"/index.php\"><h1>CLICK</h1></a>";
    }
    else{
        echo "<h1>Login Failed!</h1><br>";
    }
    ?>
</body>
</html>
