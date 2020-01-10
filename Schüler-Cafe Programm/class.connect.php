<?php
class Connect {

var $success; //array with status messages
var $db; // mysqli class

/**
* establish connection
*/
public function __construct(){

	$this->db = mysqli_connect("localhost", "susocafe_mysql", "DiuSCDB%2019!", "susocafe");
	$success = array();
	if(!$this->db)
		{
  		$this->success = array("message" => "Connection failed!","error" => mysqli_connect_errno() . PHP_EOL);
		}
	else {
		$this->success = array("message" => "Connection established!","host" => mysqli_get_host_info($this->db) . PHP_EOL );

		}

}

/**
* perform a query
* @param string
* @return array
*/
public function basicQuery($query) {

	$result = $this->db->query($query);
    if (!empty($result) ){
		$value = array();
		$anz = $result->field_count; //number of data fields
		$valCount = 0;
		//the while loop goes through each row in the result array, returning the field values with an numeric index
		while ($row = $result->fetch_array(MYSQLI_NUM)) {
			//the for loop iterates through the fields of one dataset
			for ($x = 0; $x < $anz; $x++) {
				$value[$valCount][$x] = $row[$x];
			}
			$valCount++;
		}
		$result->free();//the result is emptied
		return $value; // an array with numeric indices for the row and fields
	} else {
		//if the query produces an empty array return null to the Model
		return null;
	}



	}

	/**
	* perform a query that deletes sth
	* @param string the query
	* @return array
	*/
	public function deleteQuery($query) {
		// echo "<br><br><br><br><br><br><br><br>asdfghdhkjbn4jkw<br><br>trh<br><br>drth";
		var_dump($query);
		$this->db->query($query);
	}

	/**
	* perform a query that adds sth
	* @param string the query
	* @return array
	*/
	public function addQuery($query) {
		// echo "<br><br><br><br><br><br><br><br>asdfghdhkjbn4jkw<br><br>trh<br><br>drth";
		var_dump($query);
		$this->db->query($query);
	}


}
?>
