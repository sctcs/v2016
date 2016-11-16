<?php

class Teacher extends Data {
	var $teacherId;
	var $englishName;
	var $chineseName;
	var $email;
	var $phone;
	var $cell;
	var $lastYear;
	var $info;
    var $comments;
    var $access;
    var $classId;

	var $classRoom;
	function Teacher(&$page, &$h, &$db, &$language) {
		$this->page =& $page;
		$this->h =& $h;
		$this->db =& $db;
		$this->language =& $language;

		$this->tableName = "teacher";
		$this->teacherId =& $this->addField("teacher_id", "teacherId", "i");
  		$this->englishName =& $this->addField("english_name", "English Name");
  		$this->chineseName =& $this->addField("chinese_name", "Chinese Name");
		$this->email =& $this->addField("email", "Email");
  		$this->phone =& $this->addField("phone", "Phone");
  		$this->cell =& $this->addField("cell", "Cell Phone");
  		$this->lastYear =& $this->addField("last_year", "Last Year");
  		$this->info =& $this->addField("info", "Teacher Info");
    	$this->comments =& $this->addField("comments", "Comments");
    	$this->access =& $this->addField("access", "Access", "i", 1);
    	$this->classId =& $this->addField("class_id", "Class Id", "i", 1);
	}

	function updateValue() {
		$this->englishName->updateValue();
		$this->chineseName->updateValue();
		$this->email->updateValue();
		$this->phone->updateValue();
		$this->cell->updateValue();
		$this->lastYear->updateValue();
		$this->info->updateValue();
		$this->comments->updateValue();
	}

	function isError() {
		if ( ( $this->chineseName->isNull() && $this->englishName->isNull() ) ||
			 $this->email->isNull() ||
			 $this->phone->isNull() ) {
			return FALSE;
		}
      return FALSE;
	}

   function insert() {
		$insertFields = array(
			$this->englishName,
			$this->chineseName,
			$this->email,
			$this->phone,
			$this->cell,
            $this->lastYear,
            $this->info,
            $this->comments,
            $this->classId);
		$this->db->insert($this->tableName, $insertFields);
	}

	function update() {
		$updateFields = array(
			$this->englishName,
			$this->chineseName,
			$this->email,
			$this->phone,
			$this->cell,
            $this->lastYear,
            $this->info,
            $this->comments,
            $this->classId
		);
		$whereFields = array($this->teacherId);
		$this->db->update($this->tableName, $updateFields, $whereFields);
	}

	function showAll() {

p("<link href=\"../../common/ynhc.css\" rel=\"stylesheet\" type=\"text/css\">");
		$h = $this->h;
		$teachers = $this->db->select($this, NULL, NULL, "english_name");
		$len = count($teachers);

		$h->title("&#32769;&#24072; Teachers");
		p( $h->tableBegin(1) );

		p( $h->trBegin() );
		p( $h->th("<br/") );
		p( $h->th(m("English Name")) );
		p( $h->th(m("Chinese Name")) );
		p( $h->th("2007&#24180;<br/>&#65288;&#31179;&#23395;&#26032;&#23398;&#26399;&#65289;") );
		p( $h->th(m("Room")) );
		p( $h->th(m("Students")) );
        if(  isset($_SESSION['logon'])) {
		   p( $h->th(m("Email")) );
        }
		p( $h->th(m("Home Phone")) );
        if(  isset($_SESSION['logon'])) {
    		p( $h->th(m("Cell Phone")) );
        }
		p( $h->th(m("Teacher Info")) );
		p( $h->trEnd() );

		for ($i=0; $i<$len; $i++) {
			$t = $teachers[$i];
			$c =& $t->getClassroom();

			$className;
			$room;
			$studentsLink;
			if ( $c ) {
				$className = $c->getClassName();
				$room = $c->room->value;


				$whereStr = "";
				if ( $c->grade->value < 1 ) {
					$whereStr = "&Art_Class=".$c->comments->value;
				}
				$studentsLink = $h->a( $h->getPageHref($this->page->STUDENT_VIEW_ALL) .
					"&class_id=".$c->classId->value.$whereStr, "students");
			} else {
				$className = "<br/>";
				$room = "<br/>";
				$studentsLink = "<br/>";
			}

			p( $h->trBegin() );

			$val = $i + 1;

			$user =& $h->getUser();
			if ( $user && $user->isRoot() ) {
				$link = $h->a( $h->getPageHref($this->page->DELETE).
					"&tableName=".$t->tableName.
					"&fieldName=".$t->teacherId->dbName.
					"&id=".$t->teacherId->value, "Delete");
				$val = $val ."<br/>". $link;
			}
			p( $h->td($val, "center", NULL, "nowrap") );

			p( $h->td($t->englishName->value, NULL, NULL, "nowrap") );
			p( $h->td($t->chineseName->value, NULL, NULL, "nowrap") );
			p( $h->td($className, NULL, NULL, "nowrap") );
			p( $h->td($room, "center", NULL, "nowrap") );
			p( $h->td($studentsLink, "center", NULL, "nowrap") );
          if(  isset($_SESSION['logon'])) {
         	p( $h->td($t->email->value, NULL, NULL, "nowrap") );
          }
			p( $h->td($t->phone->value, NULL, NULL, "nowrap") );
          if(  isset($_SESSION['logon'])) {
			p( $h->td($t->cell->value, NULL, NULL, "nowrap") );
          }
			p( $h->td($t->info->value."<br/>", NULL, NULL, "nowrap") );
			p( $h->trEnd() );
		}
		p( $h->tableEnd() );
	}

	function isRoot() {
		return $this->access->value == 100;
	}
	function isAdmin() {
		return $this->access->value >= 90;
	}

	function & newInstance() {
		return new Teacher($this->page, $this->h, $this->db, $this->language);
	}

	function & getClassroom() {
		if ( !$this->classRoom && $this->classId->value > 0) {
			$this->classRoom =& Data::findClassroom($this->classId->value, $this->page, $this->h, $this->db, $this->language);
		}
		return $this->classRoom;
	}

}

?>
