<?php
class Database {
	var $conn;

	var $h;
	function open() {
		$dbUser = "ynhchine_db";
		$dbPass = "Yctnh";
		$dbName = "ynhchine_development";

		$this->conn = mysql_connect("localhost", $dbUser, $dbPass);
		if (!$this->conn) {
			die("Could not connect: " . mysql_error());
		}
		mysql_select_db($dbName, $this->conn);
	}
	function close() {
		mysql_close($this->conn);
	}

	function & doQuery($sql) {
      if ( $this->h->isDebug == TRUE ) {
			p("<br/>" . $sql);
      }
      $ret =& mysql_query($sql, $this->conn);

		return $ret;
	}


	// i for integer - you can also use s for
	// string, d for double, and b for blob.
	// $stmt->bind_param('sssd', $code, $language, $official, $percent);
	function updateKeep($sql, $fields) {
        $statement = $this->conn->prepare("SELECT thing FROM stuff WHERE id = ?");
        $statement->bind_param("i", $id);

        $statement->execute();
		$statement->close();
	}

 	function toDbValue($dataType, $value) {
		if ( $dataType == 'i' || $dataType == 'd' ) {
			if ( $value ) {
				return $value;
			} else {
				return 0;
			}
		} else {
			return "'".$value."'";
		}
	}
	function toFieldValue($field) {
		return $this->toDbValue($field->dataType, $field->value);
	}
	function toFieldPair($field) {
		$sign;
		if ( $field->dbCompareSign ) {
			$sign = " " . $field->dbCompareSign . " ";
		} else {
			$sign = " = ";
		}
		return $field->dbName . $sign . $this->toFieldValue($field);
	}
	function toWhere($fields, $joins=NULL) {
		$len = count($fields);
		if ( !$fields || $len < 1 ) {
			return "";
		}
		$w = " WHERE ";
		for ($i=0; $i<$len; $i++) {
			$field = $fields[$i];
			if ( $i > 0 ) {
				$w = $w . " ";
				$index = $i-1;
				if ( $joins && $index < count($joins) ) {
					$w = $w . $joins[$index];
				} else {
					$w = $w . "AND";
				}
				$w = $w . " ";
			}
			$w = $w . $this->toFieldPair($field);
		}
		return $w;
	}

	function update($tableName, $updateFields, $whereFields=NULL, $whereJoins=NULL) {
		$t = "";
		$len = count($updateFields);
		for ($i=0; $i<$len; $i++) {
			$field = $updateFields[$i];
			if ( $i > 0 ) {
				$t = $t.", ";
			}
			$t = $t . $this->toFieldPair($field);
		}

		$sql = "UPDATE ".$tableName." SET ".$t . $this->toWhere($whereFields, $whereJoins);
		$this->doQuery($sql);
	}

	function insert($tableName, $fields) {
		$cols = "";
		$vals = "";
		$len = count($fields);
		for ($i=0; $i<$len; $i++) {
			$field = $fields[$i];
			if ( $i > 0 ) {
				$cols = $cols.", ";
				$vals = $vals.", ";
			}
			$cols = $cols . $field->dbName;
			$vals = $vals . $this->toFieldValue($field);
		}
		$sql = "INSERT INTO ". $tableName ."(".$cols.") VALUES (".$vals.")";
		$this->doQuery($sql);
	}

	function & select($metaData, $whereFields=NULL, $whereJoins=NULL, $orderBy=NULL) {
		$sql = "SELECT * from ".$metaData->tableName . $this->toWhere($whereFields, $whereJoins);
		if ( $orderBy ) {
			$sql = $sql." order by ".$orderBy;
		}
		$cnt = 0;
		$list = array();
		$result = $this->doQuery($sql);
		if ( !$result ) {
			return;
		}
		while($row = mysql_fetch_array($result)) {
			$data =& $metaData->newInstance();
			$len = count($data->fields);
			for ($i=0; $i<$len; $i++) {
				$field =& $data->fields[$i];
				$field->value = $row[$field->dbName];
//				p(  $field->value ."=".  $field->dbName ."<br/> ");
			}
			$list[$cnt] =& $data;

//			p(	$data->room->dbName ."==".$data->room->value ."<br/>");
//			$data->room->value = 'ccavaaa';
//			p(	$data->room->dbName ."==".$data->room->value ."<br/>");
			$cnt++;
	  	}
	  	return $list;
	}

	function & selectOne(&$metaData, $whereFields=NULL, $whereJoins=NULL, $dataIn=NULL) {
		$sql = "SELECT * FROM " . $metaData->tableName . $this->toWhere($whereFields, $whereJoins);
		$result =& $this->doQuery($sql);
		if ( !$result ) {
			return;
		}
		while($row = mysql_fetch_array($result)) {
			$data;
			if ( $dataIn ) {
				$data =& $dataIn;
			} else {
				$data =& $metaData->newInstance();
			}
			$len = count($data->fields);
			for ($i=0; $i<$len; $i++) {
				$field =& $data->fields[$i];
				$field->value = $row[$field->dbName];
     //          p(  $field->value .":".  $field->dbName);
			}
			return $data;
	  	}
	}

	function & refreshByFields(&$data, $whereFields=NULL, $whereJoins=NULL) {
		return $this->selectOne($data, $whereFields, $whereJoins, $data);
	}
	function & findByFields(&$data, $whereFields=NULL, $whereJoins=NULL) {
		return $this->selectOne($data, $whereFields, $whereJoins);
	}

	function & refresh($metadata, $field) {
		return $this->refreshByFields($metadata, array($field));
	}
	function & find(&$metadata, $field) {
		return $this->findByFields($metadata, array($field));
	}


	function createTables() {
return;
		$sql = "drop TABLE class_room";
		$this->doQuery($sql);
		$sql = "CREATE TABLE class_room (
			class_id int NOT NULL AUTO_INCREMENT,
			grade int,
			class_number int,
			room varchar(30),
			teacher_id int,
			comments varchar(100),

			PRIMARY KEY(class_id)
					)";
		$this->doQuery($sql);

		$sql = "drop TABLE teacher";
		$this->doQuery($sql);
		$sql = "CREATE TABLE teacher (
			teacher_id int NOT NULL AUTO_INCREMENT,
			english_name varchar(100),
			chinese_name varchar(100),
			email varchar(50),
			phone varchar(30),
			cell varchar(30),
			last_year varchar(30),
			info varchar(200),
			comments varchar(100),
			access int,
			class_id int,
			PRIMARY KEY(teacher_id)
		)";
		$this->doQuery($sql);
	}
}

class Util {
	function isNull($str) {
		if ( strlen($str) < 1 ) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

	function nullToNone($str) {
		if ( $str ) {
			return $str;
		} else {
			return "";
		}
	}
}

?>
