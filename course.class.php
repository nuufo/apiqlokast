<?php

class course {
  public $course_id, $student_id, $grade, $data = array();

  public function __construct($course_id = NULL) {
    $db = DB::getDBinstance(); 

    if ($course_id) {
      $this->course_id = $db->real_escape_string($course_id);
      
      $query = "SELECT * FROM Grades WHERE courseid = $this->course_id"; 

      if($result = $db->query($query)) {
        while ($row = $result->fetch_assoc()) {
          $this->data[] = [ 
            'studentid' => $row['studentid'],
            'courseid'  => $row['courseid'],
            'grade'     => $row['grade']
          ];
        }
      }
    }
  }

  public function get($data) {
    echo json_encode([$this->data]);
  } 

  public function putgrades($data) {
    $db = DB::getDBinstance();

    $studentid = $data['studentid'];
    $grade     = $data['grade'];

    $query = 'UPDATE Grades SET grade = "'.$grade.'" WHERE studentid = "'.$studentid.'" AND courseid =  "'.$this->courseid.'"';

    if ($db->query($query)) {
      $respone = ['status' => 'ok'];
    }else {
      $respone = ['status' => 'fail'];
    }

    echo json_encode($respone);
  } 
}
