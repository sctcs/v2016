<?php

class Family extends Data {
	var $familyId;
	var $homePhone;
	var $homePhoneArea;		
	var $fatherName;
	var $fatherEmail;
	var $fatherWork;	
	var $motherEmail;	
	var $motherName;
	var $motherWork;
	var $cellPhone;	
	var $address;
	var $city;
	var $zip;
	var $disclaimer;
	var $isDirOk;
	var $isImageOk;	
	var $volunteer;
	var $volunteerOther;
	var $comments;	
	
	var $primaryCPFirstName;
	var $primaryCPLastName;
	var $primaryCPEmail;
	
	function Family(&$page, &$h, &$db, &$language) {
		$this->page =& $page;
		$this->h =& $h;
		$this->db =& $db;
		$this->language =& $language;
	
		$this->tableName = "family";
		$this->familyId =& $this->addField("family_id", "Family Id", "i");
		$this->homePhone =& $this->addField("home_phone", "Home Phone");
		$this->homePhoneArea =& $this->addField("home_phone_area", "Area Code");
		$this->homePhoneArea->value = 203;
    	
		$this->fatherName =& $this->addField("father_name", "Parent 1 Name");
		$this->fatherEmail =& $this->addField("father_email", "Parent 1 Email");
		$this->fatherWork =& $this->addField("father_work", "Parent 1 Working At");
		$this->motherName =& $this->addField("mother_name", "Parent 2 Name");
		$this->motherEmail =& $this->addField("mother_email", "Parent 2 Email");
		$this->motherWork =& $this->addField("mother_work", "Parent 2 Working At");
		$this->cellPhone =& $this->addField("cell_phone", "Cell Phone");
		$this->address =& $this->addField("address", "Address");		
		$this->city =& $this->addField("city", "City");
		$this->zip =& $this->addField("zip", "Zip Code");				
		$this->disclaimer =& $this->addField("disclaimer", "Disclaimer");
		$this->isDirOk =& $this->addField("is_dir_ok", "Directory List");		
		$this->isImageOk =& $this->addField("is_image_ok", "isImageOk");
		$this->volunteer =& $this->addField("volunteer", "Volunteer Work");
		$this->volunteerOther =& $this->addField("volunteer_other", "Volunteer Work");
    	$this->comments =& $this->addField("comments", "Comments");
    	
    	$this->primaryCPFirstName =& $this->addField("PrimaryCP_FirstName", "PrimaryCP_FirstName");
    	$this->primaryCPLastName =& $this->addField("PrimaryCP_LastName", "PrimaryCP_LastName");
    	$this->primaryCPEmail =& $this->addField("PrimaryCP_email", "PrimaryCP_email");
  
    }
 
	function updateValue() {
		$this->homePhone->updateValue();
		$this->homePhoneArea->updateValue();
		$this->fatherName->updateValue();
		$this->fatherEmail->updateValue();		
		$this->fatherWork->updateValue();
		$this->motherName->updateValue();
		$this->motherEmail->updateValue();
		$this->motherWork->updateValue();
		$this->cellPhone->updateValue();
		$this->address->updateValue();		
		$this->city->updateValue();
		$this->zip->updateValue();
		$this->disclaimer->updateValue();
		$this->isDirOk->updateValue();
		$this->isImageOk->updateValue();
		$this->volunteer->updateValue();
		$this->volunteerOther->updateValue();
		$this->comments->updateValue();		
	}

	function isError() {
		$h =& $this->h;
		if ( $this->homePhone->isNull() ||
			 $this->homePhoneArea->isNull() ||
             $this->fatherName->isNull() ||
             $this->fatherEmail->isNull() ||
             $this->city->isNull() ||
             $this->zip->isNull() ||
             $this->disclaimer->isNull() ||
			 $this->isDirOk->isNull() ||		
			 $this->isImageOk->isNull()
        ) {
        	$this->error = $h->requiredErrorMessage();
			return TRUE;
		}
		
		if ( strlen($this->homePhone->value) != 7 ) {
			$this->error = "<font color=\"red\">Invalid home phone.</font>";
			return TRUE;
		}
		return FALSE;
	}

	function insert() {
		$insertFields = array(
			$this->homePhone,
			$this->homePhoneArea,
			$this->fatherName,
			$this->fatherEmail,
			$this->fatherWork,
			$this->motherName,
			$this->motherEmail,
			$this->motherWork,
			$this->cellPhone,
			$this->address,
			$this->city,
			$this->zip,
			$this->disclaimer,
			$this->isDirOk,			
			$this->isImageOk,
			$this->volunteer,
			$this->volunteerOther,	            
            $this->comments);
		$this->db->insert($this->tableName, $insertFields);
	}

	function update() {
		$this->updateValue();	
		$updateFields = array( 
			$this->homePhone,
			$this->homePhoneArea,
			$this->fatherName,
			$this->fatherEmail,
			$this->fatherWork,
			$this->motherName,
			$this->motherEmail,
			$this->motherWork,
			$this->cellPhone,
			$this->address,
			$this->city,
			$this->zip,
			$this->disclaimer,
			$this->isDirOk,			
			$this->isImageOk,
			$this->volunteer,
			$this->volunteerOther,	            
            $this->comments);
		$whereFields = array($this->familyId);
		$this->db->update($this->tableName, $updateFields, $whereFields);
	}

	function & newInstance() {
		return new Family($this->page, $this->h, $this->db, $this->language);
	}
}


?>
