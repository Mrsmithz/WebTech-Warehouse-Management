<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
        include("SQLQuery.php");
        $username = $_POST['username'];
        $password = $_POST['password'];
        $name = $_POST['name'];
        $lastname = $_POST['lastname'];
        $age = $_POST['age'];
        $email = $_POST['email'];
        $address = $_POST['address'];
        $tel = $_POST['telephone'];
        if (!checkIfAccountExist($username)){
            if (createAccount($username, $password, $name, $lastname, $age, $email, $address, $tel)){
                echo "<h1>Registered Successful !</h1>";
            }
            else{
                echo "<h1>Registered Failed !</h1>";
            }
        }
        else{
            echo "<h1>Account Exist !</h1>";
        }
    ?>
</body>
</html>
