<?php
    include "MySQLConnector.php";
    class Account{
        public $myDatabase;
        public $conn;
        public $id, $username, $password, $email, $firstname, $lastname, $tel;
        function __construct(){
            $this->myDatabase = new MySQLConnector();
            $this->conn = $this->myDatabase->getConn();
        }
        function createAccount($username, $password, $firstname, $lastname, $email, $tel){
            $sql = "insert into account(username, password, firstname, lastname, email, telephone) values(?,?,?,?,?,?)";
            $stmt = $this->conn->prepare($sql);
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
        function getAccount($username, $password){
            $sql = "select id, username, password, firstname, lastname, email, telephone from account where username=(?) and password=(?)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("ss", $username, $password);
            if ($stmt->execute()){
                $result = $stmt->get_result();
                $row = $result->fetch_assoc();
                $this->id = $row['id'];
                $this->username = $row['username'];
                $this->password = $row['password'];
                $this->firstname = $row['firstname'];
                $this->lastname = $row['lastname'];
                $this->email = $row['email'];
                $this->tel = $row['telephone'];
                $result->close();
                $stmt->close();
                return true;
            }
            else{
                $stmt->close();
                return false;
            }
        }
        function changePassword($new_password){
            $sql = "update account set password=(?) where username=(?) and email=(?)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("sss", $new_password, $this->username, $this->email);
            if ($stmt->execute()){
                $stmt->close();
                return true;
            }
            else{
                $stmt->close();
                return false;
            }
        }
        function getUser_id(){
            $sql = "select id from account where username=(?) and email=(?)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("ss", $this->username, $this->email);
            if ($stmt->execute()){
                $stmt->close();
                return true;
            }
            else {
                $stmt->close();
                return false;
            }
        }
        function deleteAccount(){
            $sql = "delete from account where username=(?)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("s", $this->username);
            if ($stmt->execute()){
                $stmt->close();
                return true;
            }
            else{
                $stmt->close();
                return false;
            }
        }
        function checkIfAccountExist($username){
            $sql = "select username from account";
            $result = $this->conn->query($sql);
            while ($row = $result->fetch_assoc()){
                if (!strcmp(strtolower($row['username']), strtolower($username))){
                    $result->close();
                    return true;
                }
            }
            $result->close();
            return false;
        }
        function checkIfEmailExist($email){
            $sql = "select email from account";
            $result = $this->conn-query($sql);
            while ($row = $result->fetch_assoc()){
                if (!stcmp(strtolower($row['email']), strtolower($email))){
                    $result->close();
                    return true;
                }
            }
            $result->close();
            return false;
        }
        function checkIfItemExist($item){
            $sql = "select item_name, item_type from items where user_id=(?)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("i", $item->getUser_id());
            if ($stmt->execute()){
                $result = $stmt->get_result();
                while ($row = $result->fetch_assoc()){
                    $name_comp = strcmp(strtolower($item->item_name), strtolower($row['item_name']));
                    $type_comp = strcmp(strtolower($item->item_type), strtolower($row['item_type']));
                    if (!$name_comp && !$type_comp){
                        $result->close();
                        $stmt->close();
                        return true;
                    }
                }
                $result->close();
                $stmt->close();
                return false;
            }
            else{
                $stmt->close();
                return false;
            }
        }
        function addItem($item){
            $sql = "insert into items(user_id, item_name, item_type, item_price, item_weight, quantity) values(?,?,?,?,?,?)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("issddi", $item->user_id, $item->item_name, $item->item_type, $item->item_price, $item->item_weight, $item->quantity);
            if ($stmt->execute()){
                $stmt->close();
                return true;
            }
            else{
                $stmt->close();
                return false;
            }
        }
        function deleteItem($item){
            $sql = "delete from items where item_name=(?) and user_id=(?) and item_type=(?)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("sis", $item->item_name, $item->user_id, $item->item_type);
            if ($stmt->execute()){
                $stmt->close();
                return true;
            }
            else{
                $stmt-close();
                return false;
            }
        }
    }
?>
