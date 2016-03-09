<?php

require_once('DB.class.php');

class student {

	public $id, $firstname, $lastname, $course, $grade; 


	public function __construct($id = null) {
		if ($id) {
			$this->id = $id; 

			$db = DB::getDBinstance(); 

			$id = $db->real_escape_string($id);
			$query = "SELECT * FROM students WHERE id=$id"; 
			$result = $db->query($query); 
			$student = $result->fetch_assoc(); 

			$this->firstname = $student['firstname'];
			$this->lastname = $student['lastname'];
			$this->course = $student['course'];
			$this->grade = $student['grade'];

		}
	}
	public function get($data) {
		echo json_encode($this);
	}

	public function post($data) {
		$db = DB::getDBinstance(); 

		//ev lägga till ID - Persnumr??
		$firstname = $db->real_escape_string($data['firstname']);		
		$lastname = $db->real_escape_string($data['lastname']);
		$course = $db->real_escape_string($data['course']);
		$grade = $db->real_escape_string($data['grade']);


		$query =" INSERT INTO students 
				(firstname, lastname, course, grade) 
				VALUES ('$firstname', '$lastname', '$course', '$grade') ";


		$db->query($query);

		$user = new user($db->insert_id);
		$user->get();

	}

	public function getGrades(){
		echo "yay!";
	}


	

}