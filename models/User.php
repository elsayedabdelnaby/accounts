<?php

class User {

    var $conn;

    function __construct($conn) {
        $this->conn = $conn;
    }

    public function fetch_all() {
        $query = 'SELECT meds_users.id, meds_users.name, meds_users.password, meds_users.branch_id, meds_branches.name AS branch '
                . 'FROM meds_users INNER JOIN meds_branches ON meds_users.branch_id = meds_branches.id';
        $stmt = $this->conn->prepare($query);
        if ($stmt->execute()) {
            $users = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $users[] = $row;
            }
            return $users;
        } else {
            return false;
        }
    }

    public function add($user) { // take user(associative array) array hold all data you will insert it
        // prepare sql and bind parameters
        $stmt = $this->conn->prepare('INSERT INTO meds_users (name, branch_id, password) VALUES (:name, :branch_id, :password)');
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':branch_id', $branch_id);
        $stmt->bindParam(':password', $password);
        // insert a row
        $name = $user['name'];
        $branch_id = $user['branch_id'];
        $password = $user['password'];
        if ($stmt->execute()) {
            return $this->conn->lastInsertId();
        } else {
            return false;
        }
    }

    public function get($conditions) {
        $query = 'SELECT meds_users.id, meds_users.name, meds_users.password, meds_users.branch_id, meds_branches.name AS branch '
                . 'FROM meds_users INNER JOIN meds_branches ON meds_users.branch_id = meds_branches.id WHERE ';
        if (!empty($conditions)) {
            $count = 0;
            foreach ($conditions as $key => $value) {
                if ($count == 0) {
                    $query .= $key . $value;
                } else {
                    $query .= ' AND ' . $key . $value;
                }
                $count++;
            }
        }
        $stmt = $this->conn->prepare($query);
        $count = 1;
        if ($stmt->execute()) {
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } else {
            return false;
        }
    }

    public function update($user) {
        $query = 'UPDATE meds_users SET name = ?, branch_id = ?, password = ? WHERE id = ?';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $user['name'], PDO::PARAM_STR);
        $stmt->bindParam(2, $user['branch_id'], PDO::PARAM_INT);
        $stmt->bindParam(3, $user['password'], PDO::PARAM_STR);
        $stmt->bindParam(4, $user['id'], PDO::PARAM_INT);
        if ($stmt->execute()) {
            return $stmt->rowCount();
        } else {
            return false;
        }
    }

}
