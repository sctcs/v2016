<?php

class Student extends Data {
	var $studentId;
	var $familyId;
	var $cnName;
	var $enName;
	var $grade;
	var $classId;
	var $age;
	var $gender;
	var $isOldStudent;
	var $comments;	

	var $family;
	var $classRoom;
	
	var $lastYearClasses;
	var $volunteerOptions;
	var $lastYearGrade;
	var $lastYearClassNum;	
	
	var $firstName;
	var $lastName;
	var $startingLevel;
	var $artClass;	
	var $studentStatus;
	function Student(&$page, &$h, &$db, &$language) {
		$this->page =& $page;
		$this->h =& $h;
		$this->db =& $db;
		$this->language =& $language;
	
		$this->tableName = "student";
		$this->studentId =& $this->addField("student_id", "Student Id", "i");
		$this->familyId =& $this->addField("family_id", "Family Id", "i");
    	$this->cnName =& $this->addField("cn_name", "Chinese Name");
    	$this->enName =& $this->addField("en_name", "English Name");
    	$this->grade =& $this->addField("grade", "Grade", "i");
		$this->classId =& $this->addField("class_id", "Class Id");
		$this->age =& $this->addField("age", "Age", "i");
		$this->gender =& $this->addField("gender", "Gender");
   		$this->isOldStudent =& $this->addField("ClassLastYear", "Return Student");
    	$this->comments =& $this->addField("comments", "Comments");
    	
		$this->firstName =& $this->addField("FirstName", "First Name");    	
		$this->lastName =& $this->addField("LastName", "lastName");    	
		$this->startingLevel =& $this->addField("StartingLevel", "Starting Level"); 
		$this->artClass =& $this->addField("Art_Class", "Art Class");	
		$this->studentStatus =& $this->addField("StudentStatus", "Student Status", "i");  	
    }
    
	function doNew() {
		$h =& $this->h;		

		if ( "true" == parameter("prefill") ) {
			$this->updateValue();
			$phone = parameter("home_phone");

			if ( $phone ) {
				$this->family =& Data::findFamilyByPhone($phone, $this->page, $this->h, $this->db, $this->language);				
			}
			$h->title("Student Registration");	
			$this->showForm();							
			return;
		}		

		if ( $h->isDisplayed ) {			
			$this->addStudent();
			if ( $this->error ) {
				$h->title("Student Registration");	
				$this->showForm();
			} else {
				$this->addSucess();
			}
		} else {
			$h->title("Student Registration");	
			$familyId = parameter("family_id");
			if ( $familyId > 0 ) {			
				$this->familyId->value = $familyId;
			}	
			
			$this->showForm();
		}	
	}
	function doUpdate() {
		$h =& $this->h;	
		if ( $h->isDisplayed ) {
			$this->update();
			if ( $this->error ) {
				$h->title("Update Student Registration");	
				$this->showForm();
			} else {
				$this->showForm();
			}			
		} else {
			$h->title("Update Student Registration");
			$this->showForm();
		}	
	}
 
	function addSucess() {
		$h =& $this->h;
		p( $h->title("Thank you for your Registration") );	
		p("<br/><br/>If you want to add another student, please click ");
		
		$href = $h->getPageHref($this->page->STUDENT_NEW);	
		$href = $href."&family_id=".$this->familyId->value;
		p( $h->a($href, "<b>here</b>") );
		
	} 
	function showForm() {
		$h =& $this->h;
		if ( $this->error ) {
			p($h->error($this->error));
		}
/*
		if ( $h->action == $this->page->STUDENT_NEW ) {
			p("<br/>If you used the system this year, you can just type<br/>");
			p("your phone number (without area code, no space or dash, just number)<br/>");
			p("and click on \"Prefill\" button to prefill your family information " );
			
			p("<br/> &nbsp; &nbsp; ");
			p( $h->formBegin() );
			p( $h->hidden("prefill", "true") );
			p( $h->input("home_phone", parameter("home_phone"), 7) );
			p(" ");
			p( $h->submit("Prefill") );
			p( $h->formEnd() ); 
			p("<br/>"); 
		} 		
*/
		$family =& $this->getFamily();		
		p( $h->formBegin() );		
		if ( $this->studentId->value ) {
			p( $h->hidden("student_id", $this->studentId->value) );			
		}
		if ( $family ) {
			p( $h->hidden("family_id", $family ->familyId->value) );
		}
		p( $h->tableBegin(1) );
		
		p( $h->trBegin() );
		p( $h->th("Student Information", "center", NULL, NULL, 2) );
		p( $h->trEnd() );
	
		p( $h->trBegin() );
		p( $h->td($this->cnName->getName(), "right") );
		p( $h->td( $h->input($this->cnName->dbName, $this->cnName->value, 25) .	
				$h->requiredSign() . "<br/>(Use pinyin if you cannot use characters)"));
		p( $h->trEnd() );
	
		//p( $this->cnName->toRowInput($h, NULL, NULL, TRUE) );
		p( $this->enName->toRowInput($h, NULL, NULL, TRUE) );
      
		$pairs = $this->getGradeList();
		p( $h->trBegin() );
		p( $h->td($this->grade->getName(), "right") );
		p( $h->td($h->select($pairs, " - ", $this->grade->value, $this->grade->dbName) 
			.$h->requiredSign()) );
		p( $h->trEnd() );

		p( $this->age->toRowInput($h, 2, "text", FALSE) );
		
		$pairs = array();
		$pairs[0] = new Pair("m", "boy");
		$pairs[1] = new Pair("f", "girl");
		p( $h->trBegin() );
		p( $h->td($this->gender->getName(), "right") );
		p( $h->td($h->select($pairs, " - ", $this->gender->value, $this->gender->dbName)) );
		p( $h->trEnd() );
		
		p("<tr>");
		p("<td align=\"right\" class=\"page\">");
		p( "&nbsp;" );
		p("</td>");
		p("<td class=\"page\">");
		$pairs =& $this->getLastYearClasses();
		
		p( "Last semester your child was in (Please select)<br/>" );
		p( $h->select($pairs, NULL, $this->isOldStudent->value, $this->isOldStudent->dbName) );	
		p("</td>");
		p("</tr>");							

		p( $h->trBegin() );
		p( $h->th("Parent Information", "center", NULL, NULL, 2) );
		p( $h->trEnd() );
		
		if ( !$family ) {
			$family =& new Family($this->page, $this->h, $this->db, $this->language);
		}

		p("<tr>");
		p("<td align=\"right\" class=\"page\">");
		p( $family->homePhone->getName());
		p("</td>");
		p("<td class=\"page\">");
		p("Area Code: ");
		p( $h->input($family->homePhoneArea->dbName, $family->homePhoneArea->value, 3) );
		p("&nbsp; &nbsp; ");
		p( $h->input($family->homePhone->dbName, $family->homePhone->value, 7) );
		p( $h->requiredSign() );		
		p( "<br/>(format: 3897733 no space, no dash, just number please)");
		//p("<br/><br/>If you are adding second student for your family, you can ");
		//p("just type<br/>your phone number and click ");
		//p(" \"Prefill\" button to prefill the following<br/>information " );
		//p( $h->submit("Prefill", "prefill") );
		p("</td>");
		p("</tr>");
		
		p( $h->trBegin() );
		p( $h->td($family->cellPhone->getName(), "right") );
		p( $h->td( $h->input($family->cellPhone->dbName, $family->cellPhone->value, 25) .	
				$h->requiredSign() . "<br/>(For emergency contact)"));
		p( $h->trEnd() );			
			
		p( $family->fatherName->toRowInput($h, 30) );
		p( $family->fatherEmail->toRowInput($h, 30) );
		p( $family->fatherWork->toRowInput($h, 30, NULL, FALSE) );
		p( $family->motherName->toRowInput($h, 30, NULL, FALSE) );
		p( $family->motherEmail->toRowInput($h, 30, NULL, FALSE) );
		p( $family->motherWork->toRowInput($h, 30, NULL, FALSE) );
		p( $family->address->toRowInput($h) );	
		p( $family->city->toRowInput($h) );	
		p( $family->zip->toRowInput($h, 10) );			

		$pairs = array();
		$pairs[0] = new Pair("1", "yes");
		$pairs[1] = new Pair("2", "no");
		p( $h->trBegin() );
		p( $h->td($h->select($pairs, NULL, $family->isImageOk->value, $family->isImageOk->dbName), "right") );
		$t = "I agree, by selecting \"yes\", that the school might take photos of student activities, ".
			" which might has my son/daughter's image,  and ".
			"use them on its website and publications.";
		p( $h->td($t) );
		p( $h->trEnd() );		

		p("<tr>");
		p("<td align=\"right\" class=\"page\">");
		$pairs = array();
		$pairs[0] = new Pair("1", "yes");
		$pairs[1] = new Pair("2", "no");	
		p( $h->select($pairs, NULL, $family->isDirOk->value, $family->isDirOk->dbName) );	
		p("</td>");
		p("<td class=\"page\">");				
		p("I agree to put my information in the Yale-New-Haven Community ");
		p("Chinese School directory. I understand if I select No,  ");
		p("I cannot access the directory too. ");
		p("</td>");
		p("</tr>");
		
		p("<tr>");
		p("<td align=\"right\" class=\"page\">");
		p( $family->volunteer->getName() );
		p("</td>");
		p("<td class=\"page\">");
		$pairs =& $this->getVolunteerOptions();
		 		
		p( $h->select($pairs, "Please Select", $family->volunteer->value, $family->volunteer->dbName) );	
		p("<br/>Please specify if selecting other: " 
			.$h->input($family->volunteerOther->dbName, $family->volunteerOther->value, 10));
		p("</td>");
		p("</tr>");
		
				
		p("<tr>");
		p("<td align=\"right\" class=\"page\">");
		$pairs = array();
		$pairs[0] = new Pair("1", "yes");	
		p( $h->select($pairs, NULL, $family->disclaimer->value, $family->disclaimer->dbName) );	
		p("</td>");
		p("<td class=\"page\">");				
		p("In consideration of the activities at the Southern Connecticut ");
		p("State University Sponsored by Yale-New-Haven Community Chinese School,  ");
		p("a non-profit organization, it is understood and agreed ");
		p("that said Yale-New-Haven Community Chinese School or its officials, teachers, or ");
		p("volunteers will not be held responsible for missing of child, any ");
		p("injury, accident, sustained by the member of our party, or for the loss ");
		p("of or damage to any property belonging to a member of our party or ");
		p("anyone else. ");
		p("<br/>");
		p("I have read and accepted the above release of liability statement  ");
		p("and all policies and regulations of Yale-New-Haven Community Chinese School. ");

		p("</td>");
		p("</tr>");
		
		
		p( $h->trBegin() );
		p( $h->td( $h->submit("Submit"), "center", NULL, NULL, 2) );
		p( $h->trEnd() );
                  
		if ( $h->isEditable && $this->studentId->value ) {	
			$link = $h->a( $h->getPageHref($this->page->DELETE).
						"&tableName=".$this->tableName.
						"&fieldName=".$this->studentId->dbName.
						"&id=".$this->studentId->value, "Delete IT!"); 
			p( $h->trBegin() );
			p( $h->td( $link." (careful, gone forever)", "center", NULL, NULL, 2) );
			p( $h->trEnd() );
		}      
         
		p( $h->tableEnd() );		
		p( $h->formEnd() );         
	}
	function getGradeList() {
		$pairs = array();
		for ($i=0; $i<10; $i++) {
			$pairs[$i] = new Pair($i+1, $i+1);
		}
		return $pairs;	
	}

	function updateValue() {
		$this->cnName->updateValue();
		$this->enName->updateValue();
		$this->grade->updateValue();
		$this->age->updateValue();
		$this->gender->updateValue();
		$this->isOldStudent->updateValue();
		$this->comments->updateValue();		
	}
	function addStudent() {
		$h =& $this->h;
		$this->updateValue();

		$isNewFamily = FALSE;

		$family = NULL;		
		$familyId = parameter("family_id");
		if ( $familyId ) {
			$family =& Data::findFamily($familyId, $this->page, $this->h, $this->db, $this->language);		
		}
		
		if ( !$family ) {
			$phone = parameter("home_hone");
			if ( $phone ) {
//				$family =& Data::findFamilyByPhone($phone, $this->page, $this->h, $this->db, $this->language);				
			}
		}
		if ( !$family ) {
			$family = new Family($this->page, $this->h, $this->db, $this->language);
			$isNewFamily = TRUE;
		}
		$family->updateValue();
		$this->family = $family;
		
		if (  $this->isError() ) {						
			return;
		}
 		if ( $isNewFamily ) {
			if ( $family->isError() ) {
				$this->error = $family->error;             	           	
            	return;
         	}
			$family->insert();	
        	$family->refresh($family->homePhone);
		} else {
        	$family->update();
		}
      
		$this->familyId->value = $family->familyId->value;
		
		$this->insert();
		
//		$this->updateDefaultClass();
	}
 
	function isError() {
		$h =& $this->h;
		if ( ($this->cnName->isNull() && $this->enName->isNull()) ||
            $this->grade->isNull() ) {
            $this->error = $h->requiredErrorMessage();
			return TRUE;
		}
		return FALSE;
	}

	function insert() {
		$insertFields = array($this->familyId, $this->cnName, $this->enName, $this->grade,
            $this->age, $this->gender,  
			$this->isOldStudent,         
            $this->comments);
		$this->db->insert($this->tableName, $insertFields);
	}

	function update() {
		$this->updateValue();	
		$updateFields = array($this->cnName, $this->enName, $this->grade,
            $this->age, $this->gender,   
			$this->isOldStudent,
            $this->comments);
		$whereFields = array($this->studentId);
		$this->db->update($this->tableName, $updateFields, $whereFields);
		
		$this->updateDefaultClass();
		
  		$family = $this->getFamily();
		$family->updateValue();
		$family->update();		
	}

	function updateDefaultClass() {
return;	
		$student = new Student($this->page, $this->h, $this->db, $this->language);
		$student->classId->value = 0;
		$whereFields = array();
		$whereFields[0] = $student->classId;
		
		$students = $this->db->select($this, $whereFields);
		$len = count($students);

		for ($i=0; $i<$len; $i++) {
			$c = $students[$i];			
			
			$classroom = Data::findFirstClassroom($c->grade->value, $this->page, $this->h, $this->db, $this->language);
			if ( $classroom ) {				
				$sql = "update ".$this->tableName." set class_id = ". $classroom->classId->value . 
						" where student_id = ".$c->studentId->value;
				$this->db->doQuery($sql);				
			}
		}
	}


	function showAll() {		
		$h =& $this->h;
	
				
		$classIdIn = parameter("class_id");			
		
		$gradeList = array();
		$classRoom;
		$title;
		
		if ( $classIdIn > 0 ) {			
			$classRoom = Data::findClassroom($classIdIn, $this->page, $this->h, $this->db, $this->language);
			$grade = $classRoom->grade->value;
			$gradeList[0] = new Pair($grade, $grade);
			$title = $classRoom->getClassName(). " Students";
			$title = $title ." (Room ".$classRoom->room->value.")";
		} else {	
			$gradeList = $this->getGradeList();
			$title = "All Students";
		}
		p("<link href=\"../../common/ynhc.css\" rel=\"stylesheet\" type=\"text/css\">");
		
		$orderBy;
		$parameterOrderBy = parameter("orderBy");
		if ( $parameterOrderBy ) {
			$orderBy = $parameterOrderBy;
		} else {
			$orderBy = "ClassLastYear, StartingLevel, LastName, FirstName";
		}
		$gradeClass = array();
		$len = count($gradeList);
		for ($i=0; $i<$len; $i++) {
			$g = $gradeList[$i];
			
			$c = new Classroom($this->page, $this->h, $this->db, $this->language);
			$c->grade->value = $g->key;
			$whereFields = array($c->grade);
			$dbClasses = $this->db->select($c, $whereFields, NULL, "class_number");
			
			$classes = array();
			$numOfClass = count($dbClasses);						
			for ($j=0; $j<$numOfClass; $j++) {
				$cr = $dbClasses[$j];
				$pair =& new Pair($cr->classId->value, $cr->getClassName());
				$pair->valueOther = $cr->classNumber->value;
				$classes[$j] =& $pair; 
			}
			$gradeClass[$g->key] = $classes;			
		}

		$artClass = parameter("Art_Class");
		$whereFields = array();
		$this->studentStatus->value = 0;
		$this->studentStatus->dbCompareSign = ">";
		$whereFields[0] = $this->studentStatus;	
		if ( $classRoom ) {			
			if ( $artClass ) {
				$this->artClass->value = $artClass;
			//	$whereFields = array();
				$whereFields[1] = $this->artClass;	
			} else {
			//	$whereFields = array();
				$whereFields[1] = $classRoom->classId;			
			}	
		}		

		$students = $this->db->select($this, $whereFields, NULL, $orderBy);
		$len = count($students);

		$h->title($title);			
		p( $h->formBegin() );		
		p( $h->tableBegin(1) );
		
		p( $h->trBegin() );
		p( $h->th("<br/") );
		p( $h->th($this->toOrderByLabel("English Name", "LastName, FirstName")) );
		p( $h->th($this->toOrderByLabel("Chinese Name", "cn_name")) );
		p( $h->th("Parent Name") );
		p( $h->th($this->toOrderByLabel("Class", "class_id")) );
		
		if ( $h->isEditable ) {
			p( $h->th($this->toOrderByLabel("Last Year Class", "ClassLastYear")) );		
			p( $h->th($this->toOrderByLabel("New Student<br/>Starting Level", "StartingLevel")) );
			p( $h->th("Gender") );
			p( $h->th("Assign") );
			if ( $artClass ) {			
				p( $h->th("Art Class") );	
			}	
//			p( $h->th(m("Parent Email")) );
//			p( $h->th(m("Home Phone")) );
		}
		
		p( $h->trEnd() );

		for ($i=0; $i<$len; $i++) {
			$c = $students[$i];
			if ( $h->isDisplayed ) {
				$assignClass = parameter("assignClass".$c->studentId->value);
				if ( $assignClass > 0 && $assignClass != $c->classId->value ) {
					$sql = "update ".$this->tableName." set class_id = ". $assignClass . 
						" where student_id = ".$c->studentId->value;
					$this->db->doQuery($sql);
					$c->classId->value = $assignClass;
				}
			}
			
			p( $h->trBegin() );
			$link;
			if ( $h->isEditable ) {
				$link = $h->a( $h->getPageHref($this->page->STUDENT_UPDATE) .
						"&student_id=".$c->studentId->value, $i+1); 
				$link = $i+1;
			} else {
				$link = $i+1;
			}
			p("<TD class=\"page\" align=\"center\" nowrap=\"\">");
			p( $link );
			p("</TD>");
			p("<TD class=\"page\" nowrap=\"\">");
			p( $c->firstName->value. " " .$c->lastName->value );
			p("</TD>");
			p("<TD class=\"page\" nowrap=\"\">");
			p( $c->cnName->value."<br/>");		
			p("</TD>");	
			
			$family = $c->getFamily();			
			p("<TD class=\"page\" nowrap=\"\">");
			p( $family->primaryCPFirstName->value. " ". $family->primaryCPLastName->value );
			p("</TD>");
			            			            				
			$classroom = $c->getClassroom();			
			p("<TD class=\"page\" nowrap=\"\">");
			if ( $classroom ) {
				p ( $classroom->getClassName() );
			} else {
				p ("<br/>");
			}
			p("</TD>");				
			
			if ( $h->isEditable ) {
	         	p("<TD class=\"page\" nowrap=\"\">");
	         	p($this->lastYearClassToDisplay($c->isOldStudent->value) );
	         	p("<br/></TD>");
	         	p("<TD class=\"page\" nowrap=\"\">");
				p( $c->startingLevel->value ."<br/>");
				p("</TD>");			

				p("<TD class=\"page\" nowrap=\"\">");
				p( $c->gender->value);
				p("</TD>");				            						
			
				$classLink;						
				if ( $classroom ) {
					$classLink = $h->a( $h->getPageHref($this->page->CLASSROOM_UPDATE) .
						"&class_id=".$c->classId->value, $classroom->getClassName()); 
				}
						
				$val;
				if ( $c->classId->value > 0 ) {
					$val = $classLink;				
				} else {
		         	$classes;
		         	$classId = $c->classId->value;
		         	if ( $c->isOldStudent->value > 0 ) {
		         		$g = $this->toLastYearGrade($c->isOldStudent->value);
		         		$classes =& $gradeClass[$g];
		         		
		         		if ( $classId < 1 ) {	         		
			         		$clsNum = $this->toLastYearClassNum($c->isOldStudent->value);
			         		$lastCnt = count($classes);
			         		for ($k=0; $k<$lastCnt; $k++) {
			         			$lC = $classes[$k];		     
			         			if ( $lC->valueOther == $clsNum ) {
			         				$classId = $lC->key;
			         			}		         			
			         		}		    
		         		}
		         	} else {
		         		$classes =& $gradeClass[$c->startingLevel->value];
		         	}	         		    		              	
					$val = $classLink ." ".
						 $h->select($classes, NULL, $classId, "assignClass".$c->studentId->value);				
				}
				p("<TD class=\"page\" nowrap=\"\">");
				p( $val ); 
				p("</TD>");	
				
				if ( $artClass ) {
					p("<TD class=\"page\" nowrap=\"\">");
					p( $c->artClass->value);
					p("</TD>");	
				}				
				/*				
				p("<TD class=\"page\" nowrap=\"\">");
				p( $family->homePhoneArea->value." ".$family->homePhone->value );
				p("</TD>");
				p("<TD class=\"page\" nowrap=\"\">");
	         	p( $family->primaryCPEmail->value );
	         	p("</TD>");
	         	*/				        	
			}
			
			p( $h->trEnd() );
		}
		
		if ( $h->isEditable ) {
			p( $h->trBegin() );
			p( $h->td( $h->submit("Assign Class"), "center", NULL, NULL, 15) );
			p( $h->trEnd() );
		}
         
		p( $h->tableEnd() );		
		p( $h->formEnd() );   		
	}
	
	function toOrderByLabel($label, $orderField) {
		$h =& $this->h;		
		$classIdIn = parameter("class_id");	
		$link = $h->a( $h->getPageHref($this->page->STUDENT_VIEW_ALL) .
						"&orderBy=".$orderField."&class_id=".$classIdIn, $label); 
		return $link;

	}	
	
	function genderToDisplay($dbValue) {
		if ( "f" == $dbValue ) {
			return "girl";
		} else {
			return "boy";
		}
	}
 
	function & getClassroom() {
		if ( !$this->classRoom && $this->classId->value > 0) {
			$this->classRoom =& Data::findClassroom($this->classId->value, $this->page, $this->h, $this->db, $this->language);
		}
		return $this->classRoom;
	}
	
	function & getFamily() {
		if ( !$this->family && $this->familyId->value > 0) {
			$this->family =& Data::findFamily($this->familyId->value, $this->page, $this->h, $this->db, $this->language);
		}
		return $this->family;
	}	

	function & newInstance() {
		return new Student($this->page, $this->h, $this->db, $this->language);
	}
	
	function getLastYearClasses() {
		if ( $this->lastYearClasses ) {
			return $this->lastYearClasses;
		}
	
		$pairs = array();
		$pairs[0] = new Pair("0", "");	
		$pairs[1] = new Pair("1", "1 &#24180;&#32423; 1 &#29677; (&#26446;&#25102;&#30495;)");
		$pairs[2] = new Pair("2", "1 &#24180;&#32423; 2 &#29677; (&#21016;&#20070;&#31584;)");
		$pairs[3] = new Pair("3", "1 &#24180;&#32423; 3 &#29677; (&#26361;&#34164;)");
		$pairs[4] = new Pair("4", "2 &#24180;&#32423; 1 &#29677; (&#26446;&#29738;)");
		$pairs[5] = new Pair("5", "2 &#24180;&#32423; 2 &#29677; (&#32834;&#22411;&#38081;)");
		$pairs[6] = new Pair("6", "2 &#24180;&#32423; 3 &#29677; (&#26472;&#24314;&#26032;)");
		$pairs[7] = new Pair("7", "3 &#24180;&#32423; 1 &#29677; (&#20613;&#20057;&#20809;)");
		$pairs[8] = new Pair("8", "3 &#24180;&#32423; 2 &#29677; (&#38047;&#26757;)");
		$pairs[9] = new Pair("9", "4 &#24180;&#32423; 1 &#29677; (&#33539;&#26195;&#23425;)");
		$pairs[10] = new Pair("10", "4 &#24180;&#32423; 2 &#29677; (&#38472;&#26391;)");
		$pairs[11] = new Pair("11", "5 &#24180;&#32423; 1 &#29677; (&#29579;&#23447;&#23195;)");
		$pairs[12] = new Pair("12", "5 &#24180;&#32423; 2 &#29677; (&#36911;&#24428;)");
		$pairs[13] = new Pair("13", "6 &#24180;&#32423; 1 &#29677; (&#38472;&#26107;)");
		$pairs[14] = new Pair("14", "6 &#24180;&#32423; 2 &#29677; (&#36793;&#25991;&#24420;)");
		$pairs[15] = new Pair("15", "7 &#24180;&#32423; 1 &#29677; (&#26366;&#24314;&#25935;)");
		$pairs[16] = new Pair("16", "8 &#24180;&#32423; 2 &#29677; (&#26519;&#33459;)");				
		$this->lastYearClasses =& $pairs;	
		
		return $this->lastYearClasses;
	}	
	
	function lastYearClassToDisplay($dbValue) {
		$classes =& $this->getLastYearClasses();
		if ( $dbValue >= 0 && count($classes) ) {
			$p = $classes[$dbValue];
			return $p->value;
		}
		return "<br/>";
	}
	
	function getVolunteerOptions() {
		if ( $this->volunteerOptions ) {
			return $this->volunteerOptions;
		}	
		$pairs = array();
		$pairs[0] = new Pair("1", "Board or PTO");
		$pairs[1] = new Pair("2", "Special events such as Chinese New Year Party or final ceremony");	
		$pairs[2] = new Pair("3", "backup  teacher");
		$pairs[3] = new Pair("4", "Others");
		
		$this->volunteerOptions =& $pairs;
		return $this->volunteerOptions;
	}
		
	function volunteerToDisplay($dbValue) {
		$options =& $this->getVolunteerOptions();
		if ( $dbValue >= 0 && count($options) ) {
			$p = $options[$dbValue];
			return $p->value;
		}
		return "&nbsp;";
	}	
	
 	function toLastYearGrade($lastYearClassId) {
 		if ( !$this->lastYearGrade ) {
 			$this->lastYearGrade = array();
 			$this->lastYearGrade[0] = 0;
 			$this->lastYearGrade[1] = 1;
 			$this->lastYearGrade[2] = 1;
 			$this->lastYearGrade[3] = 1;
 			$this->lastYearGrade[4] = 2;
 			$this->lastYearGrade[5] = 2;
 			$this->lastYearGrade[6] = 2;
 			$this->lastYearGrade[7] = 3;
 			$this->lastYearGrade[8] = 3;
 			$this->lastYearGrade[9] = 4;
 			$this->lastYearGrade[10] = 4;
 			$this->lastYearGrade[11] = 5;
 			$this->lastYearGrade[12] = 5;
 			$this->lastYearGrade[13] = 6;
 			$this->lastYearGrade[14] = 6;
 			$this->lastYearGrade[15] = 7;
 			$this->lastYearGrade[16] = 8; 			
 		}
 		$cnt = count($this->lastYearGrade);
 		if ( $lastYearClassId > 0 && $lastYearClassId < $cnt ) {
 			return $this->lastYearGrade[$lastYearClassId] + 1;
 		}
 		return 0;
  	}
  	
 	function toLastYearClassNum($lastYearClassId) {
 		if ( !$this->lastYearClassNum ) {
 			$this->lastYearClassNum = array();
 			$this->lastYearClassNum[0] = 0;
 			$this->lastYearClassNum[1] = 1;
 			$this->lastYearClassNum[2] = 2;
 			$this->lastYearClassNum[3] = 3;
 			$this->lastYearClassNum[4] = 1;
 			$this->lastYearClassNum[5] = 2;
 			$this->lastYearClassNum[6] = 3;
 			$this->lastYearClassNum[7] = 1;
 			$this->lastYearClassNum[8] = 2;
 			$this->lastYearClassNum[9] = 1;
 			$this->lastYearClassNum[10] = 2;
 			$this->lastYearClassNum[11] = 1;
 			$this->lastYearClassNum[12] = 2;
 			$this->lastYearClassNum[13] = 1;
 			$this->lastYearClassNum[14] = 2;
 			$this->lastYearClassNum[15] = 1;
 			$this->lastYearClassNum[16] = 1; 			
 		}
 		$cnt = count($this->lastYearClassNum);
 		if ( $lastYearClassId > 0 && $lastYearClassId < $cnt ) {
 			return $this->lastYearClassNum[$lastYearClassId];
 		}
 		return 0;
  	}
  	function getName() {
  		return $this->firstName->value. " " .$this->lastName->value;
  	}
	function emailClassInfo() {	
		$h =& $this->h;
		if ( !$h->isEditable ) {
			p( "Access denied" );
			return;
		}
		
		$isSure = parameter("isSure");
		if ( "true" != $isSure ) {
			p("<br/><br/><h2>Are you sure to email all parents? "); 
			$link = $h->a( $h->getPageHref($this->page->EMAIL_CLASS_INFO) .
						"&isSure=true", "YES");
			p($link);
			p("</h2>");
			return; 
		}
				
		$students = $this->db->select($this);
		$len = count($students);
		
		$from = "support@ynhchineseschool.org";
		$headers = "From: $from";
		for ($i=0; $i<$len; $i++) {
			$s =& $students[$i];
			$family =& $s->getFamily();
			$classroom =& $s->getClassroom();
			if ( !$family || !$classroom ) {
				continue;
			}
			
			$to = $family->primaryCPEmail->value;
			$subject = "Correctoin: Chinese School: class info for ".$s->getName();
			$content = "\n";
			$content = $content."The school will start tomorrow, Sep. 9th.  The previous email has an error.\n\n";	
			$content = $content."**********  Please do not reply this email\n\n";			
			$content = $content."Hi ".$family->primaryCPFirstName->value. ":";
			$content = $content."\n";
			$content = $content."\n";
			$content = $content."Here is the class information for ".$s->getName();
			$content = $content."\n";
			$content = $content."\tclass: ".$classroom->getClassName();
//			$content = $content."   (grade ".$classroom->grade-value." class ".$classroom->classNumber->value.")";
			$content = $content."\n";
			$content = $content."\troom: ".$classroom->room->value;
			$content = $content."\n";
			
			$teacher =& $classroom->getTeacher();
			$content = $content."\tteacher: ".$teacher->englishName->value. " ".$teacher->chineseName->value ." ".$teacher->phone->value;
			$content = $content."\n\n";
			$content = $content."For more info, visit http://www.ynhchineseschool.org.";
			$content = $content."\n\n";
			
			$content = $content."Just a remainder, the school will start at 1:00pm, Sunday, Sep. 16th.\n";
			$content = $content."Please drop the student to the classroom and come to";
			$content = $content." cafeteria (located at the middle of B-wing in Engleman Hall)";
			$content = $content." to pay tuition fee. We only accept check or cash. For easy";
			$content = $content." processing, we prefer check. Please make payable";
			$content = $content." to YNH Chinese School.\n\n";
			
			$content = $content."Remember to bring poker, chess, volleyball ...\n\n";

			$content = $content."Hope your kid will have a great Chinese school year!\n\n";

			$content = $content."Best wishes,\n\n";
			$content = $content."Yale-New-Haven Community Chinese School at SCSU\n\n";
			
			if ( $to == "hliang@graphlogic.com" ) {
//				mail($to,$subject,$content,$headers);
			    p($content);
			    p("<br/>");
			} else {
//mail($to,$subject,$content,$headers);
				p($to);
				p("<br/>");
			}
		}
		P("Emails have been sent, please close your browser in case.");
	}  	
}


?>
