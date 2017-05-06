<?php

class Course {

    var $conn;

    function __construct($conn) {
        $this->conn = $conn;
    }

    public function fetch_all() {
        $query = 'SELECT meds_courses.id, meds_courses.name, meds_courses.start_date, meds_courses.end_date, meds_courses.total_hours, meds_courses.price, meds_courses.notes,'
                . ' meds_branches.name as branch, meds_branches.id as branch_id,'
                . ' meds_currencies.name AS currency, meds_currencies.id AS currency_id FROM meds_courses'
                . ' INNER JOIN meds_branches ON meds_courses.branch_id = meds_branches.id'
                . ' INNER JOIN meds_currencies ON meds_courses.currency_id = meds_currencies.id';
        $stmt = $this->conn->prepare($query);
        if ($stmt->execute()) {
            $courses = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $courses[] = $row;
            }
            return $courses;
        } else {
            return false;
        }
    }

    public function add($course) { // take student(associative array) array hold all data you will insert it
        // prepare sql and bind parameters
        print_r($course);
        $stmt = $this->conn->prepare('INSERT INTO meds_courses (name, start_date, end_date, total_hours, price, notes, branch_id, currency_id) 
        VALUES (:name, :start_date, :end_date, :total_hours, :price, :notes, :branch_id, :currency_id)');
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':start_date', $start_date);
        $stmt->bindParam(':end_date', $end_date);
        $stmt->bindParam(':total_hours', $total_hours);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':notes', $notes);
        $stmt->bindParam(':branch_id', $branch_id);
        $stmt->bindParam(':currency_id', $currency_id);
        // insert a row
        $name = $course['name'];
        $start_date = $course['start_date'];
        $end_date = $course['end_date'];
        $total_hours = $course['total_hours'];
        $price = $course['price'];
        $notes = $course['notes'];
        $branch_id = $course['branch_id'];
        $currency_id = $course['currency_id'];
        if ($stmt->execute()) {
            return $this->conn->lastInsertId();
        } else {
            return false;
        }
    }

    public function get($conditions) {
        $query = 'SELECT meds_courses.id, meds_courses.name, meds_courses.start_date, meds_courses.end_date, meds_courses.total_hours, meds_courses.price, meds_courses.notes,'
                . ' meds_branches.name as branch, meds_branches.id as branch_id,'
                . ' meds_currencies.name AS currency, meds_currencies.id AS currency_id FROM meds_courses'
                . ' INNER JOIN meds_branches ON meds_courses.branch_id = meds_branches.id'
                . ' INNER JOIN meds_currencies ON meds_courses.currency_id = meds_currencies.id WHERE ';
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

    public function update($course) {
        print_r($course);
        $query = 'UPDATE meds_courses SET name = ?, start_date = ?, end_date = ?, total_hours = ?, price = ?, notes = ?, branch_id = ?, currency_id = ? WHERE id = ?';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $course['name'], PDO::PARAM_STR);
        $stmt->bindParam(2, $course['start_date'], PDO::PARAM_STR);
        $stmt->bindParam(3, $course['end_date'], PDO::PARAM_STR);
        $stmt->bindParam(4, $course['total_hours'], PDO::PARAM_STR);
        $stmt->bindParam(5, $course['price'], PDO::PARAM_INT);
        $stmt->bindParam(6, $course['notes'], PDO::PARAM_INT);
        $stmt->bindParam(7, $course['branch_id'], PDO::PARAM_INT);
        $stmt->bindParam(8, $course['currency_id'], PDO::PARAM_INT);
        $stmt->bindParam(9, $course['id'], PDO::PARAM_INT);
        if ($stmt->execute()) {
            return $stmt->rowCount();
        } else {
            return false;
        }
    }

}
