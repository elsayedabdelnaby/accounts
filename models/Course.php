<?php

class Course {

    var $conn;

    function __construct($conn) {
        $this->conn = $conn;
    }

    public function fetch_all() {
        $query = 'SELECT meds_courses.id, meds_courses.name, meds_courses.content, meds_courses.learning_objectives, '
                . ' meds_courses.hours_number,meds_courses.notes, creators.name as created_by, updators.name as updated_by '
                . ' FROM meds_courses LEFT JOIN meds_users AS creators ON meds_courses.created_by = creators.id'
                . ' LEFT JOIN meds_users AS updators ON meds_courses.updated_by = updators.id';
        echo $query;
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
        $stmt = $this->conn->prepare('INSERT INTO meds_courses (name, content, learning_objectives, notes, hours_number, created_by) 
        VALUES (:name, :content, :learning_objectives, :notes, :hours_number, :created_by)');
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':content', $content);
        $stmt->bindParam(':learning_objectives', $learning_objectives);
        $stmt->bindParam(':notes', $notes);
        $stmt->bindParam(':hours_number', $hours_number);
        $stmt->bindParam(':created_by', $created_by);
        // insert a row
        $name = $course['name'];
        $content = $course['content'];
        $learning_objectives = $course['learning_objectives'];
        $notes = $course['notes'];
        $hours_number = $course['hours_number'];
        $created_by = $course['created_by'];
        if ($stmt->execute()) {
            return $this->conn->lastInsertId();
        } else {
            return false;
        }
    }

    public function get($conditions) {
        $query = 'SELECT meds_courses.id, meds_courses.name, meds_courses.content, meds_courses.learning_objectives, '
                . ' meds_courses.hours_number,meds_courses.notes, creators.name as created_by, updators.name as updated_by '
                . ' FROM meds_courses LEFT JOIN meds_users AS creators ON meds_courses.created_by = creators.id'
                . ' LEFT JOIN meds_users AS updators ON meds_courses.updated_by = updators.id WHERE ';
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
        $query = 'UPDATE meds_courses SET name = ?, content = ?, learning_objectives = ?, notes = ?, hours_number = ?, updated_by = ? WHERE id = ?';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $course['name'], PDO::PARAM_STR);
        $stmt->bindParam(2, $course['content'], PDO::PARAM_STR);
        $stmt->bindParam(3, $course['learning_objectives'], PDO::PARAM_STR);
        $stmt->bindParam(4, $course['notes'], PDO::PARAM_STR);
        $stmt->bindParam(5, $course['hours_number'], PDO::PARAM_INT);
        $stmt->bindParam(6, $course['updated_by'], PDO::PARAM_INT);
        $stmt->bindParam(7, $course['id'], PDO::PARAM_INT);
        if ($stmt->execute()) {
            return $stmt->rowCount();
        } else {
            return false;
        }
    }

}
