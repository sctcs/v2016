<?php

class Data {
	var $tableName;
	var $fields = array();
	var $error;
	
	var $page;
	var $h;
	var $db;
	var $language;
	
 	function &addField($dbName, $enName, $dataType = "s", $value=NULL) {
		$f =& new Field($dbName, $value);
   		$f->dataType = $dataType;
  		$f->enName = $enName;   
  		$this->fields[ count($this->fields) ] =& $f;
  		return $f;
  	}
  	function & findField($dbName) { 
  		$len = count($this->fields);
		for ($i=0; $i<$len; $i++) {
			$f = $this->fields[$i];
			if ( $f->dbName == $dbName ) {
				return $f;
			}
		}
  	}
  	
	function & refresh($field) {
		return $this->db->refresh($this, $field);
	}

	function & findTeacher($teacherId, &$page, &$h, &$db, &$language) {
		$teacher =& new Teacher(&$page, &$h, &$db, &$language);
		$teacher->teacherId->value = $teacherId;
		return $db->find($teacher, $teacher->teacherId);
	}
	function & findTeacherByEmail($email, &$page, &$h, &$db, &$language) {
		$teacher =& new Teacher(&$page, &$h, &$db, &$language);
		$teacher->email->value = $email;
		return $db->find($teacher, $teacher->email);
	}
	function & findFamily($familyId, &$page, &$h, &$db, &$language) {
		$family =& new Family(&$page, &$h, &$db, &$language);
		$family->familyId->value = $familyId;
		return $db->find($family, $family->familyId);
	}	
	function & findFamilyByPhone($homePhone, &$page, &$h, &$db, &$language) {
		$family =& new Family(&$page, &$h, &$db, &$language);
		$family->homePhone->value = $homePhone;
		return $db->find($family, $family->homePhone);
	}	
	function & findClassroom($classId, &$page, &$h, &$db, &$language) {
		$classroom =& new Classroom(&$page, &$h, &$db, &$language);
		$classroom->classId->value = $classId;
		return $db->find($classroom, $classroom->classId);
	}
	function & findFirstClassroom($gradeId, &$page, &$h, &$db, &$language) {
		$classroom =& new Classroom(&$page, &$h, &$db, &$language);
		$classroom->grade->value = $gradeId;
		return $db->find($classroom, $classroom->grade);
	}	
	function & findStudent($studentId, &$page, &$h, &$db, &$language) {
		$student =& new Student(&$page, &$h, &$db, &$language);
		$student->studentId->value = $studentId;
		return $db->find($student, $student->studentId);
	}

	function & findByFields($metadata, $whereFields=NULL, $whereJoins=NULL) {
		return $this->db->findByFields($metadata, $whereFields, $whereJoins);
	}
}

?>
