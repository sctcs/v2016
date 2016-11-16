<?php

class Language {
	var $tables = array();
 	function put($key, $value) {
  		$this->tables[$key] = $value;
  	}
	function get($key) {
  		$val = $this->tables[$key];
  		if ( $val ) {
  			return $val;
  		} else {
  			return $key;
  		}
  	}
}

class English extends Language {
	function English() {
		$this->put("Class", "Class");
		$this->put("Room", "Room");
		$this->put("Teacher", "Teacher");
		$this->put("Grade", "Grade");
		$this->put("Age", "Age");
		$this->put("Gender", "Gender");
		$this->put("Submit", "Submit");
		$this->put("Chinese Name", "Chinese Name");
		$this->put("English Name", "English Name");
		$this->put("Parent Name", "Parent Name");
		$this->put("Phone", "Phone");
		$this->put("Email", "Email");
		$this->put("Boy", "Boy");
		$this->put("Girl", "Girl");
		$this->put("1", "1");
		$this->put("2", "2");
		$this->put("3", "3");
		$this->put("4", "4");
		$this->put("5", "5");
		$this->put("6", "6");
		$this->put("7", "7");
		$this->put("8", "8");
		$this->put("9", "9");
		$this->put("10", "10");
		$this->put("boy", "boy");
		$this->put("girl", "girl");
		$this->put("Parent Information", "Parent Information");
		$this->put("Student Information", "Student Information");
		$this->put("Parent Chinese Name", "Parent Chinese Name");
		$this->put("Parent English Name", "Parent English Name");
		$this->put("All Classes", "All Classes");      
     
	}
}
class Chinese extends Language {
	function Chinese() {
		$this->put("Class", "Class");
		$this->put("Room", "Room");
		$this->put("Teacher", "Teacher");
		$this->put("Grade", "Grade");
		$this->put("Age", "Age");
		$this->put("Gender", "Gender");
		$this->put("Submit", "Submit");
		$this->put("Chinese Name", "Chinese Name");
		$this->put("English Name", "English Name");
		$this->put("Parent Name", "Parent Name");
		$this->put("Phone", "Phone");
		$this->put("Email", "Email");
		$this->put("Boy", "Boy");
		$this->put("Girl", "Girl");
		$this->put("1", "1");
		$this->put("2", "2");
		$this->put("3", "3");
		$this->put("4", "4");
		$this->put("5", "5");
		$this->put("6", "6");
		$this->put("7", "7");
		$this->put("8", "8");
		$this->put("9", "9");
		$this->put("10", "10");
		$this->put("boy", "boy");
		$this->put("girl", "girl");
		$this->put("Parent Information", "Parent Information");
		$this->put("Student Information", "Student Information");
		$this->put("Parent Chinese Name", "Parent Chinese Name");
		$this->put("Parent English Name", "Parent English Name");
		$this->put("All Classes", "All Classes");      
	}
}
function m($key) {
	global $language;
	return $language->get($key);
}
function isChinese() {
	if ( "en" == $_SESSION["language"] ) {
		return FALSE;
	} else {
		return TRUE;
	}
}
?>
