<?php

class Student {

    var $conn;

    function __construct($conn) {
        $this->conn = $conn;
    }

    public function fetch_all() {
        $query = 'SELECT meds_students.id, meds_students.name, meds_students.phone FROM meds_students';
        $stmt = $this->conn->prepare($query);
        if ($stmt->execute()) {
            $students = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $students[] = $row;
            }
            return $students;
        } else {
            return false;
        }
    }

    public function add($student) { // take student(associative array) array hold all data you will insert it
        // prepare sql and bind parameters
        $stmt = $this->conn->prepare('INSERT INTO meds_students (name, phone) 
        VALUES (:name, :phone)');
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':phone', $phone);
        // insert a row
        $name = $student['name'];
        $phone = $student['phone'];
        if ($stmt->execute()) {
            return $this->conn->lastInsertId();
        } else {
            return false;
        }
    }

    public function get($conditions) {
        $query = 'SELECT meds_students.id, meds_students.name, meds_students.phone FROM meds_students WHERE ';
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

    public function update($student) {
        $query = 'UPDATE meds_students SET name = ?, phone = ? WHERE id = ?';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $student['name'], PDO::PARAM_STR);
        $stmt->bindParam(2, $student['phone'], PDO::PARAM_STR);
        $stmt->bindParam(3, $student['id'], PDO::PARAM_INT);
        if ($stmt->execute()) {
            return $stmt->rowCount();
        } else {
            return false;
        }
    }

}
