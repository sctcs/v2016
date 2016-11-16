<?php

class HTML {
	var $script;
	var $action;
	var $styleClass = "page";
	var $isDisplayed = FALSE;
	var $isEditable;
	var $isDebug;
	
	var $user;

	function init() {
		$this->isDebug =  FALSE;
		$user = $this->getUser();
		if ( $user && $user->isAdmin() ) {
			$this->isEditable =  TRUE;
			if ( $user->isRoot() ) {
				$this->isDebug =  TRUE;
			}
		} else {
			$this->isEditable = FALSE;
		}
	}
	function updateIsDisplayed() {	
		if ( "true" == parameter("isDisplayed") ) {
			$this->isDisplayed = TRUE;
		} else {
			$this->isDisplayed = FALSE;
		}		
	}

	function formBegin($name=NULL, $isAjax=TRUE) {		
		$att = $this->pair("action", $this->getPageHref($this->action),  FALSE);
		if ( $name ) {
			$att = $att.$this->pair("NAME", $name);
			$att = $att.$this->pair("ID", $name);
		}
		if ( $isAjax ) {
			$att = $att." onsubmit=\"return com.jschart.post(this, 'mainContent');\"";
		}
		$att = $att.$this->pair("METHOD", "POST");
		return $this->begin("FORM", $att)."\n".$this->hidden("isDisplayed", "true");
	}
	function formEnd() {
		return $this->end("FORM")."\n";
	}
	function input($name=NULL, $value=NULL, $size=NULL) {
		return $this->inputTag("text", $name, $value, $size);
	}
	function password($name=NULL, $value=NULL, $size=NULL) {
		return $this->inputTag("password", $name, $value, $size);
	}
	function hidden($name=NULL, $value=NULL) {
		return $this->inputTag("hidden", $name, $value);
	}		
	function inputTag($type, $name=NULL, $value=NULL, $size=20) {
		$att = $this->pair("CLASS", $this->styleClass, FALSE);
		$att = $att.$this->pair("TYPE", $type);	
		if ( $name ) {	
			$att = $att.$this->pair("NAME", $name);
		}
		if ( $value ) {
			$att = $att.$this->pair("VALUE", $value);
		}
		if ( $size ) {
			$att = $att.$this->pair("SIZE", $size);
		}		
		return $this->tag("INPUT", NULL, $att, TRUE);	
	}
	function textarea($name=NULL, $rows=NULL, $cols=NULL, $value=NULL) {
		$att = $this->pair("CLASS", $this->styleClass, FALSE);
		if ( $name ) {
			$att = $att.$this->pair("NAME", $name);
		}		
		if ( $rows ) {
			$att = $att.$this->pair("ROWS", $rows);
		}
		if ( $cols ) {
			$att = $att.$this->pair("COLS", $cols);
		}		
		return $this->begin("TEXTAREA", $att)."\n" . $value . $this->end("TEXTAREA")."\n";	
	}	
	function button($value=NULL, $name=NULL) {
		return $this->buttonTag("button", $value, $name);
	}
	function submit($value=NULL, $name=NULL) {
		return $this->buttonTag("submit", $value, $name);
	}	
	function buttonTag($type, $value=NULL, $name=NULL) {
		$att = $this->pair("CLASS", $this->styleClass, FALSE);
		$att = $att.$this->pair("TYPE", $type);
		if ( $value ) {
			$att = $att.$this->pair("VALUE", $value);
		}
		if ( $name ) {
			$att = $att.$this->pair("NAME", $name);
		}		
		return $this->tag("INPUT", NULL, $att, TRUE)."\n";
	}	
	
	function a($href, $label, $attIn=NULL, $isAjax=TRUE) {
		$att = $this->pair("CLASS", $this->styleClass, FALSE);
		$att = $att . $this->pair("HREF", $href);
		if ( $attIn ) {
			$att = $att ." ". $attIn;
		}
		if ( $isAjax ) {
			$att = $att ." onclick=\"return com.jschart.get(this, 'mainContent');\"";
		}
		return $this->tag("A", $label, $att)."\n";
	}

	function tableBegin($border=NULL, $width=NULL, $cellPadding=4) {
		$att = $this->pair("CLASS", $this->styleClass, FALSE);
		$att = $att.$this->pair("CELLSPACING", "0");
		if ( $cellPadding ) {
			$att = $att.$this->pair("CELLPADDING", $cellPadding);
		}
		if ( $border ) {
			$att = $att.$this->pair("BORDER", $border);
		}
		if ( $width ) {
			$att = $att.$this->pair("WIDTH", $width);
		}
		return "\n".$this->begin("TABLE", $att)."\n";		
	}
	function tableEnd() {
		return $this->end("TABLE")."\n";
	}
	function trBegin($vAlign=NULL, $att=NULL) {
		$t;
		if ( $vAlign ) {
			$t = $this->pair("VALIGN", $vAlign)." ";
		}
		return $this->begin("TR", $t.$att)."\n";
	}
	function trEnd() {
		return $this->end("TR")."\n";
	}

	function tr($val, $vAlign=NULL, $att=NULL) {
		return $this->trBegin($vAlign, $att) . $val . $this->trEnd();
	}
	function td($val, $align=NULL, $width=NULL, $noWrap=NULL, $colSpan=NULL, $rowSpan=NULL, $attIn=NULL) {
		return $this->cell("TD", $val, $align, $width, $noWrap, $colSpan, $rowSpan, $attIn);
	}	
	function th($val, $align=NULL, $width=NULL, $noWrap=NULL, $colSpan=NULL, $rowSpan=NULL, $attIn=NULL) {
		return $this->cell("TH", $val, $align, $width, $noWrap, $colSpan, $rowSpan, $attIn);
	}
	function cell($tag, $val=NULL, $align=NULL, $width=NULL, $noWrap=FALSE, $colSpan=NULL, $rowSpan=NULL, $attIn=NULL) {
		$att = $this->pair("CLASS", $this->styleClass, FALSE);
		if ( $align ) {
			$att = $att. $this->pair("ALIGN", $align);
		} 		
		if ( $width ) {
			$att = $att. $this->pair("WIDTH", $width);
		}
		if ( $noWrap ) {
			$att = $att. $this->pair("NOWRAP", "nowrap");
		}				
		if ( $colSpan ) {
			$att = $att. $this->pair("COLSPAN", $colSpan);
		}
		if ( $rowSpan ) {
			$att = $att. $this->pair("ROWSPAN", $rowSpan);
		}		
		if ( $attIn ) {
			$att = $att." ".attIn;
		}
				
		$v;
		if ( $val ) {
			$v = $val;
		} else {
			$v = "<br/>";
		}
		return $this->tag($tag, $v, $att)."\n";
	}
	
	function begin($name, $att=NULL) {
		$t = "<" . $name;
		if ( $att ) {
			$t = $t." ".$att;
		}
		$t = $t.">";
		return $t;		
	}
	function end($name) {
		return "</".$name.">";
	}		
	function tag($name, $val=NULL, $att=NULL, $isNoCloseTag=FALSE, $isLineBreak=FALSE) {
		$t = "<" . $name;
		if ( $att ) {
			$t = $t." ".$att;
		}
		if ( $isNoCloseTag ) {
			$t = $t."/>";
			return $t;
		}

		$t = $t.">";
		if ( $isLineBreak ) {
			$t = $t."\n";
		}
		if ( $val ) {
			$t = $t.$val;
		}
	
		$t = $t. $this->end($name);
		return $t;
	}
	function br() {
		return $this->tag("BR", NULL, NULL, TRUE);
	}	
	
	function select($pairs, $emptyLabel=NULL, $selectedValue=NULL, $name=NULL, $size=NULL, $attIn=NULL){
		$t = "";
		if ( $emptyLabel ) {
			$t = $t.$this->tag("OPTION", $emptyLabel, "VALUE=\"\"");
		}
		$len = count($pairs);
		for ($i=0; $i<$len; $i++) {
			$p = $pairs[$i];
	
			$att = "VALUE=\"".$p->key."\"";
			if ( $selectedValue == $p->key ) {
				$att = $att." selected";
			}
			$t = $t. $this->tag("OPTION", $p->getValue(), $att);
		}
		$selectAtt = "CLASS=\"page\"";
		if ( $name ) {
			$selectAtt = $selectAtt ." NAME=\"".$name."\"";
		}
		if ( $size ) {
			$selectAtt = $selectAtt ." SIZE=\"".$size."\"";
		}
		if ( !$attIn ) {
			$selectAtt = $selectAtt .$attIn;
		}
		return $this->tag("SELECT", $t, $selectAtt, NULL, TRUE);
	}
	
	function pair($name, $value, $leadingSpace=TRUE) {
		$t;
		if ( $leadingSpace ) {
			$t = " ";
		} else {
			$t = "";
		}
		return $t.$name."=\"".$value."\"";
	}	
	function getAllParameter() {
		$t = "";
		foreach ($_REQUEST as $k => $v) {
			$t = $t."\n<br/>$k = $v";
		}
		return $t;		
	}
	function requiredSign() {
	   return " <sup style=\"color:red\">*</sup>";
	}
	function requiredErrorMessage() {
	   return "<font color=\"red\">Please enter all required fields.</font>";
	}	
	function error($str) {
	   return "<font color=\"red\">$str</font><br/>";
	}	
	function registerLink($action, $label) {
		$href = $this->getPageHref( $action );
		return $this->a($href, $label, "CLASS=\"page\"");
	}
	function getPageHref($action=NULL) {
		$t = $this->script;
		if ( $action ) {
			$t = $t . $action;	
		} else {
			$t = $t . $this->action;
		}
		return $t;
	}
	function redirect($action=NULL, $parameterStr=NULL) {
	   header("Location: " . $this->getPageHref($action) . $parameterStr ) ;
	}
	
	function htmlBegin($title) {
		p("<HTML xmlns=\"http://www.w3.org/1999/xhtml\">");
		p("<HEAD>");		
		p("<TITLE>".$title."</TITLE>\n");
		p("</HEAD>");
		p("<BODY onload=\"load();\">");
	}
	
	function htmlEnd() {
		p("</BODY>");
		p("</HTML>");
	}
	
	function title($title) {
	p("<html>");
	p("<head>");
	p("<meta name=\"keywords\" content=\"New Haven Chinese School, Yale New Haven Chinese School , Connecticut Chinese School, Chinese School\">");
	p("<meta http-equiv=\"Content-type\" content=\"text/html; charset=gb2312\" />");
	p("</head>");
	p("<body>");
	
	
		p("<center><br/><h2 class=\"title\">".$title."</h2></center>\n");
	}			
	function isLogin() {
		if ( $_SESSION["loginUser"] != NULL ) {
			return TRUE;
		} else {
			return FALSE;
		}	
	}
	
	
	function & getUser() {
		if ( $this->user ) {
			return $this->user;
		}
		if ( $_SESSION["loginUser"] ) {
			$this->user =& unserialize($_SESSION["loginUser"]);
		}
		return $this->user;
	}
}


class CSchoolHTML extends HTML {
	function CSchoolHTML() {
		$this->script = "register.php?action=";
		$this->script = "/db/register.php?action=";
		$this->updateIsDisplayed();
	}
	

}

function parameter($name) {
   if ( isset($_REQUEST[$name] ) ) {
      return $_REQUEST[$name];
   } else {
      return "";
   }
}
function p($str) {
	echo $str;
}
function pn($str) {
	p($str."\n");
}

?>
