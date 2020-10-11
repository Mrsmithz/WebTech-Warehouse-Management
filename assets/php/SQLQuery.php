<?php
    include("MySQLConnector.php");
    function checkIfAccountExist($username){
        $AccountDB = MySQLConnector("localhost", "root", "031961698", "mydatabase");
        $stmt = "select username from account";
        $result = $AccountDB->query($stmt);
        while ($row = $result->fetch_assoc()){
            if (!strcmp(strtolower($row['username']), strtolower($username))){
                $AccountDB->close();
                return true;
            }
        }
        $AccountDB->close();
        return false;
    }
    function createAccount($username, $password, $name, $lastname, $age, $email, $address, $tel){
        $AccountDB = MySQLConnector("localhost", "root", "031961698", "mydatabase");
        $stmt = $AccountDB->prepare("insert into account(username, password, name, lastname, age, email,
        address, telephone, type) values(?,?,?,?,?,?,?,?,?)");
        $type = "user";
        $stmt->bind_param("ssssdssss", $username, $password, $name, $lastname, $age, $email, $address, $tel, $type);
        if ($stmt->execute()){
            $stmt->close();
            $AccountDB->close();
            return true;
        }
        else{
            $stmt->close();
            $AccountDB->close();
            return false;
        }
    }
    function AddItems($username, $email, $item_name, $type, $price, $weight, $quantity){
        $InventoryDB = MySQLConnector("inventory");
        $stmt = $InventoryDB->prepare("insert into items(username, email, item_name, type, price, weight, quantity) values(?,?,?,?,?,?,?)");
        $stmt->bind_param("ssssddi", $username, $email, $item_name, $type, $price, $weight, $quantity);
        if ($stmt->execute()){
            $stmt->close();
            $InventoryDB->close();
            return true;
        }
        else{
            $stmt->close();
            $InventoryDB->close();
            return false;
        }
    }
?>
