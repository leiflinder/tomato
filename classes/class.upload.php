<?php
class upload extends conn{

	public $lastid;

	function adjust_week_number_to_tomato_date($tom_id){
		$stmt = $this->conn->prepare("SELECT * FROM `tomato220`.`tomato` WHERE `tomato`.`id` = :tom_id");
		$stmt->bindParam(':tom_id', $tom_id, PDO::PARAM_INT);
		$stmt->execute();
		$row = $stmt->fetch();
		// adjust week number to the tomato_date
		// that way can create tomato from yesterday and have 
		// it be the correct week date
		$tom_date = $row['tomdate'];
		// make new week number
		$week_number = date("W", strtotime($tom_date));
		// build up week number in format "2018-W21" with substring of tom date and week number
		$year = substr( $tom_date, 0, -6 );
		$weeknumber = $year."-W".$week_number;
		$stmt = $this->conn->prepare("UPDATE `tomato220`.`tomato` SET `tomato`.`tomweek` = :week_number WHERE `tomato`.`id` = :tom_id");
		$stmt->bindParam(':tom_id', $tom_id, PDO::PARAM_INT);
		$stmt->bindParam(':week_number', $weeknumber, PDO::PARAM_STR);
		$stmt->execute();
	}

	function upload_tomato($tomdate_param, $tomweek_param, $count_param, $cat_param, $description_param,$url_param){
		$stmt = $this->conn->prepare("INSERT INTO `tomato220`.`tomato` (
			`tomato`.`id`, 
			`tomato`.`tomdate`,
			`tomato`.`tomweek`,
			`tomato`.`count`, 
			`tomato`.`category`, 
			`tomato`.`notes`, 
			`tomato`.`URL`, 
			`tomato`.`timestamp`) 
			VALUES (
				NULL, 
				:tomdate, 
				:week,
				:count, 
				:category, 
				:notes, 
				:URL, 
				CURRENT_TIMESTAMP)");
		// bind parameters
		$stmt->bindParam(':tomdate', $tomdate_param, PDO::PARAM_STR);
		$stmt->bindParam(':week', $tomweek_param, PDO::PARAM_STR);
		$stmt->bindParam(':count', $count_param, PDO::PARAM_INT);
		$stmt->bindParam(':category', $cat_param, PDO::PARAM_INT);
		$stmt->bindParam(':notes', $description_param, PDO::PARAM_STR);
		$stmt->bindParam(':URL', $url_param, PDO::PARAM_STR);

		$stmt->execute();
		$last_id = $this->conn->lastInsertId();
		$pdo = null;
		return $last_id;
	}

	function insertkeywords($tomid, $keyid){
		$stmt = $this->conn->prepare("INSERT INTO `tomato220`.`link_tom_to_keywords` (
			`link_tom_to_keywords`.`id`, 
			`link_tom_to_keywords`.`tom_id`, 
			`link_tom_to_keywords`.`keyword_id`, 
			`link_tom_to_keywords`.`timestamp`) 
			VALUES (
				NULL, 
				:TOMID, 
				:KEYID, 
				CURRENT_TIMESTAMP)");
		// bind parameters
		$stmt->bindParam(':TOMID', $tomid, PDO::PARAM_INT);
		$stmt->bindParam(':KEYID', $keyid, PDO::PARAM_INT);

		$stmt->execute();
		$last_id = $this->conn->lastInsertId();
		$pdo = null;
		$this->lastid = $last_id;
		// update the week number with the tomato date
		// $this->adjust_week_number_to_tomato_date($this->lastid);
		return $last_id;
	}
}
?>
