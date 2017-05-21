<?php

class CourseBranch {

    var $conn;

    function __construct($conn) {
        $this->conn = $conn;
    }

    public function fetch_all() {
        $query = 'SELECT meds_course_branch.id, meds_course_branch.course_id, meds_course_branch.branch_id, meds_course_branch.start_date, '
                . ' meds_course_branch.end_date,meds_course_branch.lectures_number, meds_course_branch.price, creators.name as created_by, updators.name as updated_by, '
                . ' meds_courses.name as course, meds_branches.name as branch, '
                . ' meds_course_branch.instructor_id, meds_instructors.name as instructor'
                . ' FROM meds_course_branch LEFT JOIN meds_users AS creators ON meds_course_branch.created_by = creators.id'
                . ' LEFT JOIN meds_users AS updators ON meds_course_branch.updated_by = updators.id'
                . ' INNER JOIN meds_branches ON meds_course_branch.branch_id = meds_branches.id'
                . ' INNER JOIN meds_courses ON meds_course_branch.course_id = meds_courses.id'
                . ' INNER JOIN meds_instructors ON meds_course_branch.instructor_id = meds_instructors.id';
        $stmt = $this->conn->prepare($query);
        if ($stmt->execute()) {
            $coursesbranches = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $coursesbranches[] = $row;
            }
            return $coursesbranches;
        } else {
            return false;
        }
    }

    public function add($course_branch) { // take student(associative array) array hold all data you will insert it
        // prepare sql and bind parameters
        $stmt = $this->conn->prepare('INSERT INTO meds_course_branch (course_id, branch_id, start_date, end_date, lectures_number, price, currency_id, created_by, instructor_id) 
        VALUES (:course_id, :branch_id, :start_date, :end_date, :lectures_number, :price, :currency_id, :created_by, :instructor_id)');
        $stmt->bindParam(':course_id', $course_id);
        $stmt->bindParam(':branch_id', $branch_id);
        $stmt->bindParam(':start_date', $start_date);
        $stmt->bindParam(':end_date', $end_date);
        $stmt->bindParam(':lectures_number', $lectures_number);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':currency_id', $currency_id);
        $stmt->bindParam(':created_by', $created_by);
        $stmt->bindParam(':instructor_id', $instructor_id);
        // insert a row
        $course_id = $course_branch['course_id'];
        $branch_id = $course_branch['branch_id'];
        $start_date = $course_branch['start_date'];
        $end_date = $course_branch['end_date'];
        $lectures_number = $course_branch['lectures_number'];
        $price = $course_branch['price'];
        $currency_id = $course_branch['currency_id'];
        $created_by = $course_branch['created_by'];
        $instructor_id = $course_branch['instructor_id'];
        if ($stmt->execute()) {
            return $this->conn->lastInsertId();
        } else {
            return false;
        }
    }

    public function get($conditions) {
        $query = 'SELECT meds_course_branch.id, meds_course_branch.course_id, meds_course_branch.branch_id, meds_course_branch.start_date, '
                . ' meds_course_branch.end_date,meds_course_branch.lectures_number, meds_course_branch.price, creators.name as created_by, updators.name as updated_by, '
                . ' meds_courses.name as course, meds_branches.name as branch, '
                . ' meds_course_branch.instructor_id, meds_instructors.name as instructor'
                . ' FROM meds_course_branch LEFT JOIN meds_users AS creators ON meds_course_branch.created_by = creators.id'
                . ' LEFT JOIN meds_users AS updators ON meds_course_branch.updated_by = updators.id'
                . ' INNER JOIN meds_branches ON meds_course_branch.branch_id = meds_branches.id'
                . ' INNER JOIN meds_courses ON meds_course_branch.course_id = meds_courses.id'
                . ' INNER JOIN meds_instructors ON meds_course_branch.instructor_id = meds_instructors.id WHERE ';
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

    public function update($course_branch) {
        $query = 'UPDATE meds_course_branch SET course_id = ?, branch_id = ?, start_date = ?, end_date = ?, lectures_number = ?, price = ?, updated_by = ?, instructor_id = ? WHERE id = ?';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $course_branch['course_id'], PDO::PARAM_INT);
        $stmt->bindParam(2, $course_branch['branch_id'], PDO::PARAM_INT);
        $stmt->bindParam(3, $course_branch['start_date'], PDO::PARAM_STR);
        $stmt->bindParam(4, $course_branch['end_date'], PDO::PARAM_STR);
        $stmt->bindParam(5, $course_branch['lectures_number'], PDO::PARAM_INT);
        $stmt->bindParam(6, $course_branch['price']);
        $stmt->bindParam(7, $course_branch['updated_by'], PDO::PARAM_INT);
        $stmt->bindParam(8, $course_branch['instructor_id'], PDO::PARAM_INT);
        $stmt->bindParam(9, $course_branch['id'], PDO::PARAM_INT);
        if ($stmt->execute()) {
            return $stmt->rowCount();
        } else {
            return false;
        }
    }

}
