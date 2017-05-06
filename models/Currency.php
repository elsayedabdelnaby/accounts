<?php

class Currency {

    var $conn;

    function __construct($conn) {
        $this->conn = $conn;
    }

    public function fetch_all() {
        $query = 'SELECT * FROM meds_currencies';
        $stmt = $this->conn->prepare($query);
        if ($stmt->execute()) {
            $currencies = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $currencies[] = $row;
            }
            return $currencies;
        } else {
            return false;
        }
    }

    public function add($currency) { // take student(associative array) array hold all data you will insert it
        // prepare sql and bind parameters
        $stmt = $this->conn->prepare('INSERT INTO meds_currencies (name) 
        VALUES (:name)');
        $stmt->bindParam(':name', $name);
        // insert a row
        $name = $currency['name'];
        if ($stmt->execute()) {
            return $this->conn->lastInsertId();
        } else {
            return false;
        }
    }

    public function get($key, $value) {
        $query = 'SELECT * FROM meds_currencies WHERE ' . $key . ' = ?';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $value, PDO::PARAM_INT);
        if ($stmt->execute()) {
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } else {
            return false;
        }
    }

    public function update($branch) {
        $query = 'UPDATE meds_currencies SET name = ? WHERE id = ?';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $branch['name'], PDO::PARAM_STR);
        $stmt->bindParam(2, $branch['id'], PDO::PARAM_INT);
        if ($stmt->execute()) {
            return $stmt->rowCount();
        } else {
            return false;
        }
    }

}
