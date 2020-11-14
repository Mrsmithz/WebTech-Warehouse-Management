<?php
    class MySQLConnector{
        private $conn;
        function __construct(){
            $this->conn = new mysqli("34.87.91.113", "root", "031961698", "MyDatabase") or die("Connect failed %s\n.". $conn->error);
        }
        function getConn(){
            return $this->conn;
        }
    }
?>
