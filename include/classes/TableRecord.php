<?

class TableRecord {
	var $KeyIsAutoIncrement;
	var $HostName;
	var $HostUserName;
	var $HostPwd;
	var $DBName;
	var $Name;
	var $ResouceLink;
	var $KeyField;
	var $Fields;
	var $isDebugging;
	var $Encoding;
	var $Collation;	
	var $StatusField;	

//----------------------------------------------------------------------------------------------------
	function w($label, $val) 
	{
		if ($this->isDebugging) 
		{
		echo '<div style="font-family:arial;font-size:8pt;font-weight:bold;">'.get_class($this).'.<span style="color:red;">'.$label.'</span>:'.$val.'</div>';
		}
	}
//----------------------------------------------------------------------------------------------------
	function InitTable() {

		$this->w("InitTable()", "called");
	
		$sql = "SHOW COLUMNS FROM ".$this->Name;
		$result = mysql_query($sql);
		if (!$result) {
			$tmp = $this->isDebugging;
			$this->isDebugging = true;
			$this->w("Could not run query",  mysql_error());
			$this->w("running", $sql);
			
			$this->isDebugging = $tmp;
			return false;
		}
		
		$this->w("finding", "Key field and auto increment field");
		while ($row = mysql_fetch_assoc($result)) {
			$FieldKey = $row['Key'];
			$FieldExtra = $row['Extra'];
	//*** finding the key field name		
			if ($FieldKey == 'PRI') {
	//*** check if it is 'auto_increment'
				if ($FieldExtra == 'auto_increment') {
					$this->KeyIsAutoIncrement = true;
					break;
				}
			} //($row['Key'] == 'PRI') {
		} // while (
		
		$this->w("initializing", "fields object array");
		//*** initialize the fields array
		$result = mysql_query("select * from ".$this->Name. " where 1 = 2");
		$i = 0;
		while ($i < mysql_num_fields($result)) {
		   $meta = mysql_fetch_field($result, $i);
		   if (!$meta) {
			  // echo "No information available<br />\n";
		   } else {
				$this->Fields[$meta->name] = $meta;
				$this->w("Initializing Field", $meta->name);
				if (($meta->primary_key)) {
					$this->KeyField = $meta->name;
				}
		   }
		   $i++;
		}
		return true;
	}

//----------------------------------------------------------------------------------------------------	
	function TableRecord($Link, $Table, $Encoding = "utf8", $Collation = "utf8_general_ci")
	{
		$this->w("Contructor", "called");
		//initiallize the basic properties for by accessing the table directly
		$this->KeyIsAutoIncrement = false;
		$this->ResouceLink = $Link;
		$this->Name = $Table;
		$this->KeyField = "id";
		$this->isDebugging = false;
		$this->Encoding = $Encoding;
		$this->Collation = $Collation;
		$this->StatusField = $this->Name . "_status";

		return $this->InitTable();
	} // function
//----------------------------------------------------------------------------------------------------
	function InsertRecord($recordArr) {
		$this->w("InsertRecord", "called");
		$counter = 0;
		$sql = "insert into ". $this->Name." (";
		$SqlValue = "values (";
		$retValue = false;

		//if (isset($recordArr) && $this->InitTable()) {
		if (isset($recordArr)) {
			//array_key_exists()
			$this->w("Preparing", "SQL");
			if ($this->KeyIsAutoIncrement) {
				//dont insert the key value 
				$this->w("this->KeyField", $this->KeyField);
				foreach ($this->Fields as $FieldName => $FieldObj) {
					if ($FieldName <> $this->KeyField) {
						if (array_key_exists($FieldName, $recordArr)) {
							// check if numeric field inputting non-numeric data
							if ($FieldObj->numeric) {
								if (is_numeric($recordArr[$FieldName])) {
									$typeMatch = true;
								} else {
									$typeMatch = false;
								}
							} else {
								$typeMatch = true;
							}
							if ($typeMatch) {
								if (!($counter == 0)) {
									$sql .= ", ";
									$SqlValue .= ", ";
								} 
								$sql .= $FieldName;
								if($recordArr[$FieldName] == '' && !$FieldObj->not_null) {
										$SqlValue .= "null";
								} else if ($recordArr[$FieldName] == 'now()') {
									$SqlValue .= $recordArr[$FieldName];
								} else {
									$SqlValue .= "'".$recordArr[$FieldName]."'";
								}
								$counter++;
							}
						} //if (array_key_exists($FieldName, $recordArr)) {
					} // if ($FieldName <> $this->KeyField) {
				}
				$sql .= ") ";
				$SqlValue .= ") ";

				$sql .= $SqlValue;

				$this->w("executing", $sql);
				$result = mysql_query($sql, $this->ResouceLink);
				if (!$result) {
					$retValue = false;
					$tmp = $this->isDebugging;
					$this->isDebugging = true;
					$this->w("Could not run query",  mysql_error());
					$this->w("sql",  $sql);
					$this->isDebugging = $tmp;
				} else {
					$retValue = mysql_insert_id($this->ResouceLink);
				}
			} else { //if ($this->KeyIsAutoIncrement) {
				// insert the key value too
				$this->w("Preparing", "SQL");
				foreach ($this->Fields as $FieldName => $FieldObj) {
					if (array_key_exists($FieldName, $recordArr)) {
						// check if numeric field inputting non-numeric data
						if ($FieldObj->numeric) {
							if (is_numeric($recordArr[$FieldName])) {
								$typeMatch = true;
							} else {
								$typeMatch = false;
							}
						} else {
							$typeMatch = true;
						}
						if ($typeMatch) {
							if (!($counter == 0)) {
								$sql .= ", ";
								$SqlValue .= ", ";
							} 
							$sql .= $FieldName;
							if ($recordArr[$FieldName] == 'now()') {
								$SqlValue .= $recordArr[$FieldName];
							} else {
								$SqlValue .= "'".$recordArr[$FieldName]."'";
							} 
							$counter++;
						}
					}
				}
				$sql .= ") ";
				$SqlValue .= ") ";

				$sql .= $SqlValue;

				$this->w("executing", $sql);
				
				$result = mysql_query($sql, $this->ResouceLink);

				if (!$result) {
					$retValue = false;
					$tmp = $this->isDebugging;
					$this->isDebugging = true;
					$this->w("Could not run query",  mysql_error());
					$this->w("sql",  $sql);
					$this->isDebugging = $tmp;
				} else {
					$retValue = $recordArr[$this->KeyField];
				}
			} //if ($this->KeyIsAutoIncrement) {
		} else {	//if (isset($recordArr) && $this->InitTable()) {
			$retValue = false;
		} //if (isset($recordArr) && $this->InitTable()) {
		return $retValue;
	} //function 

//----------------------------------------------------------------------------------------------------
	function UpdateRecord($recordArr) {
		$this->w("UpdateRecord", "called");
		//if (isset($recordArr) && $this->InitTable()) {
		if (isset($recordArr)) {
			$recordKey = $recordArr[$this->KeyField];
			$sql = "update ". $this->Name." set ";
			$SqlWhere = " where ".$this->KeyField." = ".$recordKey;
			$counter = 0;
			foreach ($this->Fields as $FieldName => $FieldObj) {
				//$this->w("FieldName", $FieldName);
				if (array_key_exists($FieldName, $recordArr)) {
					if (!($counter == 0)) {
						$sql .= ", ";
					} 
					$value = $recordArr[$FieldName];
					if($recordArr[$FieldName] == '' && !$FieldObj->not_null) {
						$sql .= $FieldName." = null ";
					} else {
						if ($value == 'now()') {
//							$SqlValue .= $recordArr[$FieldName];
							$sql .= $FieldName." = ".$value."";
						} else {
							$sql .= $FieldName." = '".$value."' ";
						} 
					}
					$counter++;
				} 
				
			}
			$sql .= $SqlWhere;
			//echo "<div>excuting:".$sql."</div>";
			$this->w("executing", $sql);

			$result = mysql_query($sql, $this->ResouceLink);
			if (!$result) {
				$retValue = false;
				$tmp = $this->isDebugging;
				$this->isDebugging = true;
				$this->w("Could not run query",  mysql_error());
				$this->w("sql",  $sql);
				$this->isDebugging = $tmp;
			} else {
				$retValue = true;
			}
		} else { //if (isset($recordArr) && $this->InitTable()) {
			$retValue = false;
		} //if (isset($recordArr) && $this->InitTable()) {
		return $retValue;
	} //function 
//----------------------------------------------------------------------------------------------------
	function DeleteRecord($Id, $Status = 0 ) {
		$this->w("DeleteRecord", "called");
		//if (isset($Id) && $this->InitTable()) {
		if (isset($Id)) {
			//$sql = "delete from ". $this->Name." where ".$this->KeyField." = ".$Id;
			$sql = "update ". $this->Name ." set ". $this->StatusField . " = ". $Status ." where ".$this->KeyField." = ".$Id;
			//echo "<div>excuting:".$sql."</div>";



			$this->w("executing", $sql);
			$result = mysql_query($sql, $this->ResouceLink);

			if (!$result) {
				$retValue = false;
				$tmp = $this->isDebugging;
				$this->isDebugging = true;
				$this->w("Could not run query",  mysql_error());
				$this->w("sql",  $sql);
				$this->isDebugging = $tmp;
			} else {
				$retValue = true;
			}
		} else { //if (isset($Id) && $this->InitTable()) {
			$retValue = false;
		} //if (isset($Id) && $this->InitTable()) {
		return $retValue;
	} //function 
//----------------------------------------------------------------------------------------------------
	function Load($Id, $version_id = "") {
		$this->w("Load", "called");
		//if (isset($Id) && $this->InitTable()) {
		if (isset($Id)) {

			if($version_id == "") 
				$sql = "select * from ". $this->Name." where ".$this->KeyField." = ".$Id;
			else
				$sql = "select * from ". $this->Name."_version where ".$this->KeyField." = ".$Id . " AND version_id = " . $version_id;

			//echo "<div>excuting:".$sql."</div>";

			$this->w("executing", $sql);
			$result = mysql_query($sql, $this->ResouceLink);

			if (!$result) {
				$retArray = false;
				$tmp = $this->isDebugging;
				$this->isDebugging = true;
				$this->w("Could not run query",  mysql_error());
				$this->w("sql",  $sql);
				$this->isDebugging = $tmp;
			} else {
				$retArray = mysql_fetch_array($result);
			}
		} else { //if (isset($Id) && $this->InitTable()) {
			$retArray = false;
		} //if (isset($Id) && $this->InitTable()) {
		return $retArray;
	} //function Load($Id) {
//----------------------------------------------------------------------------------------------------
	function DefaultRecord()
	{
		$this->w("DefaultRecord()", "called");
		foreach ($this->Fields as $FieldName => $FieldObj) {
			$retArray[$FieldName] = $FieldObj->def;
			$this->w($FieldObj->name, $FieldObj->def);
		}
		if ($this->KeyIsAutoIncrement) {
			$retArray[$this->KeyField] = 0;
		}
		return $retArray;
	}
//----------------------------------------------------------------------------------------------------	
	function IndexedListing($Fields, $Cond, $OrderBy) 
	{
		$sql = "select ".$this->KeyField.", ".$Fields." from ".$this->Name;
		if ($Cond <> '') {
			$sql .= " where ".$Cond;
		}
		if ($OrderBy <> '') {
			$sql .= " order by ".$OrderBy;
		}
		
		$this->w("executing", $sql);
		$result = mysql_query($sql, $this->ResouceLink);
		if (!$result) {
			$retArray = false;
			$tmp = $this->isDebugging;
			$this->isDebugging = true;
			$this->w("Could not run query",  mysql_error());
			$this->w("sql",  $sql);
			$this->isDebugging = $tmp;
		} else {
			while($row = mysql_fetch_array($result)) 
			{
				$id = $row[$this->KeyField];
				//$name = $row[$Fields];
				$name = $row[1];
				$retArray[$id] = $name;
			}
		}
		return $retArray;
	}

//----------------------------------------------------------------------------------------------------	
	function GetResult($Cond="", $OrderBy="", $isRandom = false, $startIndex = 0, $limit = 0) 
	{
		$sql = "select * from ".$this->Name;
		if ($Cond <> '') {
			$sql .= " where ".$Cond;
		}
		if($isRandom == true)
		{
			$sql .= " order by rand() ";	
		}
		else
		{
			if ($OrderBy <> '') 
			{
				$sql .= " order by ".$OrderBy;
			}
		}
		
		if(($startIndex > 0 || $limit > 0) && is_numeric($startIndex))
		{
			$sql .= " limit ". $startIndex;	
		}
		
		if(($startIndex > 0 || $limit > 0) && is_numeric($limit))
		{
			$sql .= ", ". $limit;		
		}
		
		$this->w("executing", $sql);
		$result = mysql_query($sql, $this->ResouceLink);
		if (!$result) {
			$ret = false;
			$tmp = $this->isDebugging;
			$this->isDebugging = true;
			$this->w("Could not run query",  mysql_error());
			$this->w("sql",  $sql);
			$this->isDebugging = $tmp;
		} else {
			$ret = $result;
		}
		return $ret;
	}
//----------------------------------------------------------------------------------------------------	
	function GetResultByField($Fields, $Cond, $OrderBy, $isRandom = false, $limit = 0)
	{
		$field = "";
		if(count($Fields)==0)
			$Fields[0] = "*";
		$sql = "select ";
		
		foreach($Fields as $x)
		{
			if($field!="")
				$field = $field.", ".$x;
			else
				$field = $x;
		}
		$sql.=$field . " from ".$this->Name;
		if ($Cond <> '') {
			$sql .= " where ".$Cond;
		}
		if($isRandom == true)
		{
			$sql .= " order by rand() ";	
		}
		else
		{
			if ($OrderBy <> '') 
			{
				$sql .= " order by ".$OrderBy;
			}
		}
		if($limit > 0 && is_numeric($limit))
		{
			$sql .= " limit ". $limit;	
		}
		
		$this->w("executing", $sql);
		$result = mysql_query($sql, $this->ResouceLink);
		if (!$result) {
			$ret = false;
			$tmp = $this->isDebugging;
			$this->isDebugging = true;
			$this->w("Could not run query",  mysql_error());
			$this->w("sql",  $sql);
			$this->isDebugging = $tmp;
		} else {
			$ret = $result;
		}
		return $ret;
	}

	function GetCount($Cond) 
	{
		$sql = "select count(" . $this->KeyField . ") as record_count from ".$this->Name;
		if ($Cond <> '') {
			$sql .= " where ".$Cond;
		}
		$this->w("executing", $sql);
		$result = mysql_query($sql, $this->ResouceLink);
		if (!$result) {
			$ret = false;
			$tmp = $this->isDebugging;
			$this->isDebugging = true;
			$this->w("Could not run query",  mysql_error());
			$this->w("sql",  $sql);
			$this->isDebugging = $tmp;
		} else {
			$row = mysql_fetch_array($result);
			return $row['record_count'];
		}
		return $ret;
	}
	

}//class
?>