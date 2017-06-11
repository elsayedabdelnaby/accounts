<?php

class Instructor {

    var $conn;

    function __construct($conn) {
        $this->conn = $conn;
    }

    public function fetch_all() {
        $query = 'SELECT meds_instructors.id, meds_instructors.name, meds_instructors.phone FROM meds_instructors';
        $stmt = $this->conn->prepare($query);
        if ($stmt->execute()) {
            $instructors = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $instructors[] = $row;
            }
            return $instructors;
        } else {
            return false;
        }
    }

    public function add($instructor) { // take instructor(associative array) array hold all data you will insert it
        // prepare sql and bind parameters
        $stmt = $this->conn->prepare('INSERT INTO meds_instructors (name, phone) VALUES (:name, :phone)');
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':phone', $phone);
        // insert a row
        $name = $instructor['name'];
        $phone = $instructor['phone'];
        if ($stmt->execute()) {
            return $this->conn->lastInsertId();
        } else {
            return false;
        }
    }

    public function get($conditions) {
        $query = 'SELECT meds_instructors.id, meds_instructors.name, meds_instructors.phone FROM meds_instructors WHERE ';
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
        $query = 'SELECT meds_instructors.id, meds_instructors.name, meds_instructors.phone FROM meds_instructors WHERE ';
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
            $instructors = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $instructors[] = $row;
            }
            return $instructors;
        } else {
            return false;
        }
    }

    public function update($instructor) {
        $query = 'UPDATE meds_instructors SET name = ?, phone = ? WHERE id = ?';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $instructor['name'], PDO::PARAM_STR);
        $stmt->bindParam(2, $instructor['phone'], PDO::PARAM_STR);
        $stmt->bindParam(3, $instructor['id'], PDO::PARAM_INT);
        if ($stmt->execute()) {
            return $stmt->rowCount();
        } else {
            return false;
        }
    }

    public function getAllPayments($id) {
        $query = 'SELECT *, meds_instructors.name AS instructor, meds_employes.name AS employe, meds_vendors.name AS vendor, meds_branches.name AS branch, meds_payment_methods.name as paymentmethod, meds_users.name as creator FROM meds_payments'
                . ' LEFT JOIN meds_instructors ON meds_payments.instructor_id  = meds_instructors.id '
                . ' LEFT JOIN meds_vendors ON meds_payments.vendor_id  = meds_vendors.id'
                . ' LEFT JOIN meds_employes ON meds_payments.employe_id  = meds_employes.id '
                . ' INNER JOIN meds_branches ON meds_payments.branch_id = meds_branches.id'
                . ' INNER JOIN meds_payment_methods ON meds_payments.payment_method_id = meds_payment_methods.id'
                . ' INNER JOIN meds_users ON meds_payments.created_by  = meds_users.id WHERE meds_payments.instructor_id = ?';
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
        $sum = 'SELECT sum(value) AS total FROM meds_payments WHERE meds_payments.instructor_id = ?';
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
