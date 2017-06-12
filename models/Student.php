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

    public function getOr($conditions) {
        $query = 'SELECT meds_students.id, meds_students.name, meds_students.phone FROM meds_students WHERE ';
        if (!empty($conditions)) {
            $count = 0;
            foreach ($conditions as $key => $value) {
                if ($count == 0) {
                    $query .= $key . $value;
                } else {
                    $query .= ' OR ' . $key . $value;
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

    public function getAllPayments($id) {
        $query = 'SELECT *, meds_courses.name AS course, meds_students.name AS student, meds_payment_methods.name as paymentmethod, meds_users.name as creator, meds_branches.name AS branch FROM meds_entrances'
                . ' LEFT JOIN meds_courses ON meds_entrances.course_id  = meds_courses.id '
                . ' LEFT JOIN meds_students ON meds_entrances.student_id  = meds_students.id'
                . ' LEFT JOIN meds_payment_methods ON meds_entrances.payment_method_id = meds_payment_methods.id'
                . ' INNER JOIN meds_users ON meds_entrances.created_by  = meds_users.id'
                . ' INNER JOIN meds_branches ON meds_entrances.branch_id  = meds_branches.id WHERE meds_entrances.student_id = ? ORDER BY created_at DESC';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id, PDO::PARAM_INT);
        if ($stmt->execute()) {
            $payments = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $payments[] = $row;
            }
            return $payments;
        } else {
            return FALSE;
        }
    }

    public function getTotalPayments($id) {
        $sum = 'SELECT sum(value) AS total FROM meds_entrances WHERE meds_entrances.student_id = ?';
        $stmt = $this->conn->prepare($sum);
        $stmt->bindParam(1, $id, PDO::PARAM_INT);
        if ($stmt->execute()) {
            $sum = $stmt->fetch(PDO::FETCH_ASSOC);
            return $sum = $sum['total'];
        } else {
            return FALSE;
        }
    }

}
