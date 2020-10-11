<?php
    function MySQLConnector($host, $username, $password, $dbname){
        $hostname = $host;
        $user = $username;
        $pass = $password;
        $db = $dbname;

        $conn = new mysqli($hostname, $user, $pass, $db) or die("Connect failed %s\n.". $conn->error);
        return $conn;
    }
?>
