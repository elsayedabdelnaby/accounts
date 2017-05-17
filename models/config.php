<?php

define('URL', 'http://localhost/accounts/');
date_default_timezone_set('Africa/Cairo');
set_time_limit(0);

class Database {

    var $servername, $username, $password, $dbname;

    function __construct($servername, $username, $password, $dbname) {
        $this->servername = $servername;
        $this->username = $username;
        $this->password = $password;
        $this->dbname = $dbname;
//         $this->servername = 'localhost';
//         $this->username = 'mostiger_account';
//         $this->password = 'U)3OCmX%R0Jc';
//         $this->dbname = 'mostiger_accounts';
    }

    public function get_connection() {
        $conn = new PDO("mysql:host=" . $this->servername . ";dbname=" . $this->dbname . "", $this->username, $this->password);
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
    }

}

$database = new Database('localhost', 'root', '', 'accounts');
$conn = $database->get_connection();
