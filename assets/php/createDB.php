<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
        include "Account.php";
        include "Item.php";
        $acct = new Account();
        //$username = $_POST['username'];
        //$password = $_POST['password'];
        //$firstname = $_POST['firstname'];
        //$lastname = $_POST['lastname'];
        //$email = $_POST['email'];
        //$tel = $_POST['telephone'];
        $username = "test1234";
        $password = "123456";
        $firstname = "asdasd";
        $lastname = "aksdjaskd";
        $email = "askdjakl@hotmail.com";
        $tel = "0123456789";
        if (!$acct->checkIfAccountExist($username)){
            if ($acct->createAccount($username, $password, $firstname, $lastname, $email, $tel)){
                echo "<h1>Registered Successful !</h1>";
            }
            else{
                echo "<h1>Registered Failed !</h1>";
            }
        }
        else{
            $acct->getAccount("kuygame", "123456");
            //$item = new Item("Apple_Test", "fruit2", 123.22, 22.222, 55, $acct->id);
            //$acct->addItem($item);
            echo "<h1>Account Exist !</h1>";
        }
    ?>
</body>
</html>
