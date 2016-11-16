<?php

class Page {
	var $STUDENT_NEW = 1;
	var $STUDENT_NEW_SUCCESS = 2;
	var $STUDENT_UPDATE = 3;
	var $STUDENT_VIEW_ALL = 4;	
	
	var $CLASSROOM_NEW = 5;
	var $CLASSROOM_SUCCESS = 6;	
	var $CLASSROOM_UPDATE = 7;
	var $CLASSROOM_VIEW_ALL = 8;
	var $TEACHER_VIEW_ALL = 9;
		
	var $CLEAN_DATABASE = 10;
	var $INIT_PAGE = 11;
	
	var $LOGIN = 12;
	var $MAP = 13;	
	var $DELETE = 14;		
	var $EMAIL_CLASS_INFO = 15;		
	
	var $h;
	var $db;
	var $language;
	function Page(&$h, &$db, &$language) {
		$this->h =& $h;
		$this->db =& $db;
		$this->language =& $language;
	}
	function service() {
		$action = parameter("action");
		if ( !$action ) {
			$action = $this->STUDENT_NEW;
		}
		$this->h->action = $action;
		switch ($action) {
			case $this->CLEAN_DATABASE:
				$this->db->createTables();
				$this->initPage();
				return;						
			case $this->INIT_PAGE:
				$this->initPage();
				break;	

			case $this->LOGIN:
				$user =& $this->h->getUser();
				if ( $user && $user->isAdmin() ) {
					$this->initPage();
				} else {
					$this->doLogon();
				}
				break;	
									
			case $this->STUDENT_NEW:
				$student =& new Student($this, $this->h, $this->db, $this->language);
				$student->doNew();
				break;
			case $this->STUDENT_UPDATE:				
				$student =& Data::findStudent(parameter("student_id"), $this, $this->h, $this->db, $this->language);
				$student->doUpdate();
				break;
			case $this->STUDENT_NEW_SUCCESS:
				$student =& new Student($this, $this->h, $this->db, $this->language);
				$student->addSucess();
				break;
			case $this->STUDENT_VIEW_ALL:
				$student =& new Student($this, $this->h, $this->db, $this->language);
				$student->showAll();
				break;	
				
			case $this->CLASSROOM_NEW:
				$classroom =& new Classroom($this, $this->h, $this->db, $this->language);
				$classroom->doNew();
				break;
			case $this->CLASSROOM_UPDATE:				
				$classroom =& Data::findClassroom(parameter("class_id"), $this, $this->h, $this->db, $this->language);
				$classroom->doUpdate();
				break;
			case $this->CLASSROOM_VIEW_ALL:
				$classroom =& new Classroom($this, $this->h, $this->db, $this->language);
				$classroom->showAll();
				break;	
				
			case $this->TEACHER_VIEW_ALL:
				$teacher =& new Teacher($this, $this->h, $this->db, $this->language);
				$teacher->showAll();
				break;
			case $this->MAP:
				$map =& new Map();
//				$this->h->htmlBegin("Test");
				$address = "501 Crescent Street New Haven, CT";
				$map->showMap($map->KEY_CHINESE_SCHOOL, $address, 500, 400);
//				$this->h->htmlEnd();
				break;	
			case $this->DELETE:
				$this->doDelete();
				$this->initPage();
				break;	
			case $this->EMAIL_CLASS_INFO:
				$student =& new Student($this, $this->h, $this->db, $this->language);
				$student->emailClassInfo();
				break;				
																												
		}
	}
	function doDelete() {
		$tableName = parameter("tableName");
		$fieldName = parameter("fieldName");
		$id = parameter("id");
		if ( !$tableName || !$fieldName || !$id ) {
			return;
		}
		$sql = "delete from ".$tableName." where ".$fieldName." = ".$id;
		$this->db->doQuery($sql);			
	}

	function initPage() {
		$h =& $this->h;
		$user =& $h->getUser();
		
		if ( !$user || !$user->isAdmin() ) {
			$this->showLoginForm();
			return;
		}
		
		p( $h->title("Administration Page") );
		
		p("<div class='page'><ul>");	
		
		p("<li>");	
		p( $this->toA($this->STUDENT_VIEW_ALL, "Students") );
		p("</li><br/>");						

		p("<li>");
		p( $this->toA($this->TEACHER_VIEW_ALL, "Teacher List") );
		p("</li><br/>");

		p("<li>");
		p( $this->toA($this->CLASSROOM_VIEW_ALL, "Class List") );
		p("</li><br/>");

		
		p("<li>");
		p( $this->toA($this->CLASSROOM_NEW, "Add a New Class") );
		p("</li><br/>");
		
		p("<li>To update a class and teacher information, click ");
		p( $this->toA($this->CLASSROOM_VIEW_ALL, "Here") );
		p(". You will get list of classes, and then click on a class link to see the update page");		
		p("</li><br/>");
/*			
		p("<li>To update a student information, click ");
		p( $this->toA($this->STUDENT_VIEW_ALL, "Here") );
		p(". You will get list of students, and then click on a student link to see the update page.");		
		p("</li><br/>");
*/		
		p("<li>To assign student into classes, click ");
		p( $this->toA($this->STUDENT_VIEW_ALL, "Here") );
		p(". You will get list of students. Change the dropdown for class and hit 'Assign Class' button.");		
		p("</li><br/>");	

		p("<li>");
		p( $this->toA($this->EMAIL_CLASS_INFO, "Email Parents Class Assignment") );
		p("</li><br/>");

		p("<li>");
		p("<a href=\"https://st74.startlogic.com/phpMyAdmin-2.6.3/index.php\">Database</a>" );		
		p("</li><br/>");	
		
/*		
		p("<li>");	
		p( $this->toA($this->STUDENT_NEW, "Add a New Student") );
		p("</li><br/>");
*/		
		if ( $user->isRoot() ) {
  		
  			p("<li>");
  			p( $this->toA($this->LOGIN, "Login Page") );
  			p("</li>");		

  			p("<li>");
  			p( $this->toA($this->INIT_PAGE, "Administration Page") );
  			p("</li>");
		
			p("<li>");
			p( $this->toA($this->CLEAN_DATABASE, "Clean Database") );
			p("</li>");
			
			p("<li>");
			p( $this->toA($this->MAP, "Map") );
			p("</li>");			
		}
		p("</ul></div>");
	}
	function doLogon() {
		$h =& $this->h;	
		$USERID = 'school';
		$USERID_ADMIN = 'schools';
		$PASS = 'scsu';
		
		$error;
		$userIdIn = parameter("userId");		
		if ( $h->isDisplayed ) {
			if ( ( $USERID == $userIdIn || $USERID_ADMIN == $userIdIn ) &&
				 $PASS == parameter("password") ) {
				 $person =& new Teacher($this, $this->h, $this->db, $this->language);
				 if ( $userIdIn	== $USERID_ADMIN ) {
				 	$person->access->value = 100;
				 } else {
				 	$person->access->value = 90;
				 }
				 $person->chineseName->value = $userIdIn;
				 $_SESSION["loginUser"] =& serialize($person);		 
				 $this->initPage();		
				 $user =& $h->getUser();	 
				 return;		 
			} else {
				$error = "Invalid user id and/or password";
			}
		}
		$this->showLoginForm($error);
	}
	function showLoginForm($error=NULL) {	
		$h = $this->h;
		p( "<br/><ul>");
		p( $h->title("Please Login") );
		
		if ( $error ) {
			p($h->error($error));
		}
		p( $h->formBegin() );		
		p( $h->tableBegin() );
		
		p( $h->trBegin() );
		p( $h->td("User Id", "right") );
		$userId = parameter("userId");
		p( $h->td( $h->input("userId", $userId, 15) ) );		
		p( $h->trEnd() );

		p( $h->trBegin() );
		p( $h->td("Password") );
		$pass = parameter("password");
		p( $h->td( $h->input("password", $pass, 15) ) );		
		p( $h->trEnd() );	

		p( $h->trBegin() );
		p( $h->td( $h->submit("Submit"), "center", NULL, NULL, 2) );
		p( $h->trEnd() );
         
		p( $h->tableEnd() );		
		p( $h->formEnd() );         				
		p( "</ul>");
	}	
   	function toA($action, $label) {
   		$h =& $this->h;
		$href = $h->getPageHref($action);		
		if ( $fileName ) {
			$href = $href."&f=".$fileName;
		}	
		return $h->a($href, $label, $att);
	}
}


class Field {
	var $dbName;
	var $dataType = "s";
	var $enName;
	var $value;
	var $dbCompareSign;

	function Field($dbName, $value=NULL, $dataType=NULL) {
		$this->dbName = $dbName;
		if ( $value ) {
			$this->value = $value;
		}
		if ( $dataType ) {
			$this->dataType = $dataType;
		}
	}

	function getName() {
		if ( $isEnglish ) {
			return $this->enName;
		} else {
			return $this->enName;
		}
	}
	function toRowInput($h, $size=25, $type="text", $isRequired=TRUE) {	
		$t = 	$h->trBegin() .		
				$h->td($this->getName(), "right") .				
				$h->td( $h->inputTag($type, $this->dbName, $this->value, $size) .	
				$this->getRequired($h, $isRequired)) .
				$h->trEnd();
		return $t;
	}
	function getRequired($h, $isRequired) {
		if ( !$isRequired ) {
			return NULL;
		}
		return $h->requiredSign();
	}
	function isNull() {
		if ( $this->value ) {
			return FALSE;
		} else {
			return TRUE;
		}
	}
	function updateValue() {
		return $this->value = parameter($this->dbName);
	}
	function setValue($value) {
		$this->value = $value;
	}
}

class Pair {
	var $key;
	var $value;
	var $valueOther;

	function Pair($key, $value) {
		$this->key = $key;
		$this->value = $value;
	}
	function getValue() {
		return m($this->value);
	}
}

?>
