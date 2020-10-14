<?php
    include("MySQLConnector.php");
    $myDatabase = MySQLConnector("34.87.91.113", "root", "031961698", "MyDatabase");
    function checkIfAccountExist($username){
        $accountDB = $GLOBALS['myDatabase'];
;       $stmt = "select username from account";
        $result = $accountDB->query($stmt);
        while ($row = $result->fetch_assoc()){
            if (!strcmp(strtolower($row['username']), strtolower($username))){
                $result->close();
                return true;
            }
        }
        $result->close();
        return false;
    }
    function createAccount($username, $password, $firstname, $lastname, $email, $tel){
        $accountDB = $GLOBALS['myDatabase'];
        $sql = "insert into account(username, password, firstname, lastname, email, telephone) values(?,?,?,?,?,?)";
        $stmt = $accountDB->prepare($sql);
        $stmt->bind_param("ssssss", $username, $password, $firstname, $lastname, $email, $tel);
        if ($stmt->execute()){
            $stmt->close();
            return true;
        }
        else{
            $stmt->close();
            return false;
        }
    }
    function AddItems($user_id, $item_name, $item_type, $item_price, $item_weight, $quantity){
        $itemsDB = $GLOBALS['myDatabase'];
        $sql = "insert into items(user_id, item_name, item_type, item_price, item_weight, quantity) values(?,?,?,?,?,?,?)";
        $stmt = $itemsDB->prepare($sql)
        $stmt->bind_param("issddi", $user_id, $item_name, $item_type, $item_price, $item_weight, $quantity);
        if ($stmt->excute()){
            $stmt->close();
            return true;
        }
        else{
            $stmt->close();
            return false;
        }
    }
?>
