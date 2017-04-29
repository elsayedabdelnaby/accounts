<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "test";

// try {
//     $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
//     // set the PDO error mode to exception
//     $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
//     echo "Connected successfully"; 
// }catch(PDOException $e){
//     echo "Connection failed: " . $e->getMessage();
// }

class Database{
    var $servername, $username, $password, $dbname;
    function  __construct($servername, $username, $password, $dbname){
        $this->servername = $servername;
        $this->username = $username;
        $this->password = $password;
        $this->dbname = $dbname;
    }

    public function get_connection(){
        $conn = new PDO("mysql:host=".$this->servername.";dbname=".$this->dbname."", $this->username, $this->password);
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
    }
}