<?php


class Classroom extends Data {
	var $classId;
	var $grade;
	var $classNumber;
	var $room;
	var $teacherId;
	var $comments;

	var $teacher;

	function Classroom(&$page, &$h, &$db, &$language) {
		$this->page =& $page;
		$this->h =& $h;
		$this->db =& $db;
		$this->language =& $language;

		$this->tableName = "class_room";
		$this->classId =& $this->addField("class_id", "ClassId", "i");
		$this->grade =& $this->addField("grade", "Grade", "i");
		$this->classNumber =& $this->addField("class_number", "Class", "i");
		$this->room =& $this->addField("room", "Room");
		$this->teacherId =& $this->addField("teacher_id", "teacherId", "i");
     	$this->comments =& $this->addField("comments", "Other Class Name");
	}

	function isError() {
		if ( ($this->grade->isNull() && $this->classNumber->isNull()) ||
            $this->room->isNull() ) {
			return FALSE;
		}
		return FALSE;
	}

	function doNew() {
		$h = $this->h;
		if ( $h->isDisplayed ) {
			$this->addClassroom();
			if ( $this->error ) {
				$h->title("New Class");
				$this->showForm();
			} else {
				$student = new Student($this->page, $this->h, $this->db, $this->language);
			//	$student->updateDefaultClass();
				$this->page->initPage();
			}
		} else {
			$h->title("New Class");
			$this->showForm();
		}
	}
	function addClassroom() {
		$h = $this->h;
		$this->updateValue();

		$isNewTeacher = FALSE;
		$email = parameter("email");
		$teacher = NULL; //Data::findTeacherByEmail($email, $this->page, $this->h, $this->db, $this->language);
		if ( !$teacher ) {
			$teacher =& new Teacher($this->page, $this->h, $this->db, $this->language);
			$isNewTeacher = TRUE;
		}
		$teacher->updateValue();
		$this->teacher = $teacher;

		if (  $this->isError() ) {
			$this->error = $h->requiredErrorMessage();
			return;
		}

 		if ( $isNewTeacher ) {
			if ( $teacher->isError() ) {
            	$this->error = $h->requiredErrorMessage();
            	return;
         	}
			$teacher->insert();
        	$teacher->refresh($teacher->email);
		} else {
        	$teacher->update();
		}

		$this->teacherId->value = $teacher->teacherId->value;
		if ( $this->room->value ) {
			$this->insert();
			$this->refresh($this->room);

			$teacher->classId->value = $this->classId->value;
			$teacher->update();
		}
	}

	function updateValue() {
		$this->grade->updateValue();
		$this->classNumber->updateValue();
		$this->room->updateValue();
		$this->comments->updateValue();
	}

	function showForm() {
		$h = $this->h;
		if ( $this->error ) {
			p($h->error($this->error));
		}

		p( $h->formBegin() );
		if ( $this->classId->value ) {
			p( $h->hidden("class_id", $this->classId->value) );
		}
		p( $h->tableBegin(1) );

		p( $h->trBegin() );
		p( $h->td("Class Information", "center", NULL, NULL, 2) );
		p( $h->trEnd() );


		$pairs = array();
		for ($i=0; $i<10; $i++) {
			$pairs[$i] = new Pair($i+1, $i+1);
		}
		p( $h->trBegin() );
		p( $h->td($this->grade->getName(), "right") );
		p( $h->td($h->select($pairs, " - ", $this->grade->value, $this->grade->dbName)
			.$h->requiredSign()) );
		p( $h->trEnd() );

		$pairs = array();
		for ($i=0; $i<5; $i++) {
			$pairs[$i] = new Pair($i+1, $i+1);
		}
		p( $h->trBegin() );
		p( $h->td($this->classNumber->getName(), "right") );
		p( $h->td($h->select($pairs, " - ", $this->classNumber->value, $this->classNumber->dbName)
			.$h->requiredSign()) );
		p( $h->trEnd() );


		p( $this->comments->toRowInput($h, 20, "text", FALSE) );
		p( $this->room->toRowInput($h, 5, "text", TRUE) );

		p( $h->trBegin() );
		p( $h->td("Teacher Information", "center", NULL, NULL, 2) );
		p( $h->trEnd() );

		$teacher =& $this->getTeacher();
		if ( !$teacher ) {
			$teacher =& new teacher($this->page, $this->h, $this->db, $this->language);
		}
		p( $teacher->englishName->toRowInput($h) );
		p( $teacher->chineseName->toRowInput($h) );
		p( $teacher->email->toRowInput($h) );
		p( $teacher->phone->toRowInput($h) );
		p( $teacher->cell->toRowInput($h) );
		p( $teacher->info->toRowInput($h) );

		p( $h->trBegin() );
		p( $h->td( $h->submit("Submit"), "center", NULL, NULL, 2) );
		p( $h->trEnd() );

		p( $h->tableEnd() );
		p( $h->formEnd() );
	}

	function doUpdate() {
		$h = $this->h;
		if ( $h->isDisplayed ) {
			$this->update();
			if ( $this->error ) {
				$h->title("Update Class");
				$this->showForm();
			} else {
				$student =& new Student($this->page, $this->h, $this->db, $this->language);
				$student->updateDefaultClass();
				$this->showForm();
			}
		} else {
			$h->title("Update Class");
			$this->showForm();
		}
	}

	function update() {
		$this->updateValue();
		$updateFields = array($this->grade, $this->classNumber, $this->room, $this->comments);
		$whereFields = array($this->classId);
		$this->db->update($this->tableName, $updateFields, $whereFields);

 		$teacher = $this->getTeacher();
		$teacher->updateValue();
		$teacher->update();
	}


	function insert() {
		$insertFields = array($this->teacherId, $this->grade, $this->classNumber, $this->comments,
            $this->room);
		$this->db->insert($this->tableName, $insertFields);
	}

	function getClassName() {
	//	if ( isChinese() ) {
	//		return "Grade ".$this->grade->value." Class ".$this->classNumber->value;
	//	} else {
		if ( $this->grade->value > 0 ) {
			return m($this->grade->value)." &#24180;&#32423; ".m($this->classNumber->value).
				" &#29677;";
		} else {
			return $this->comments->value;
		}
	//	}
	}
	function showAll() {
p("<link href=\"../../common/ynhc.css\" rel=\"stylesheet\" type=\"text/css\">");
		$h = $this->h;
		$classrooms = $this->db->select($this, NULL, NULL, "grade, class_number");
		$len = count($classrooms);

		$h->title("&#29677;&#32423; Classes");
		p( $h->tableBegin(1) );

		p( $h->trBegin() );
		p( $h->th("<br/") );
		p( $h->th(m("Class")) );
		p( $h->th(m("Room")) );
		p( $h->th(m("Grade")) );
		p( $h->th(m("Teacher<br/>English Name")) );
		p( $h->th(m("Teacher<br/>Chinese Name")) );
		if(  isset($_SESSION['logon'])) {
		  p( $h->th(m("Email")) );
		  p( $h->th(m("Phone")) );
        }
		p( $h->th(m("Students")) );
		p( $h->trEnd() );

		for ($i=0; $i<$len; $i++) {
			$c = $classrooms[$i];

			p( $h->trBegin() );

			$val;
			if ( $h->isEditable ) {
				$val = $h->a( $h->getPageHref($this->page->CLASSROOM_UPDATE) .
					"&class_id=".$c->classId->value, $i+1);
			} else {
				$val = $i+1;
			}

			$user =& $h->getUser();
			if ( $user && $user->isRoot() ) {
				$link = $h->a( $h->getPageHref($this->page->DELETE).
					"&tableName=".$c->tableName.
					"&fieldName=".$c->classId->dbName.
					"&id=".$c->classId->value, "Delete");
				$val = $val ."<br/><br/>". $link;
			}

			p( $h->td($val, "center", NULL, "nowrap") );
			p( $h->td($c->getClassName(), "center", NULL, "nowrap") );
			p( $h->td($c->room->value, "center", NULL, "nowrap") );
			p( $h->td($c->grade->value, "center", NULL, "nowrap") );

			$parent =& $c->getTeacher();
			p( $h->td($parent->englishName->value, NULL, NULL, "nowrap") );
			p( $h->td($parent->chineseName->value, NULL, NULL, "nowrap") );
			if(  isset($_SESSION['logon'])) {
         	  p( $h->td($parent->email->value, NULL, NULL, "nowrap") );
			  p( $h->td($parent->phone->value, NULL, NULL, "nowrap") );
            }
			$whereStr = "";
			if ( $c->grade->value < 1 ) {
				$whereStr = "&Art_Class=".$c->comments->value;
			}

			$link = $h->a( $h->getPageHref($this->page->STUDENT_VIEW_ALL) .
					"&class_id=".$c->classId->value.$whereStr, "students");
			p( $h->td($link, "center", NULL, "nowrap") );

			p( $h->trEnd() );
		}
		p( $h->tableEnd() );
	}

	function & getTeacher() {
		if ( !$this->teacher && $this->teacherId->value > 0) {
			$this->teacher =& Data::findTeacher($this->teacherId->value, $this->page, $this->h, $this->db, $this->language);
		}
		return $this->teacher;
	}

	function &newInstance() {
		return new Classroom($this->page, $this->h, $this->db, $this->language);
	}
}

?>
