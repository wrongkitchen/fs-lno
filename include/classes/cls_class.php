<?
/*----------------------------------------------------------------------------------------------------
AUTHOR : Eason Chan
DATE : 20120130
LAST UPDATE : 20120130
CLASS NAME : cls_class

REQUIRED CLASS(ES) : 
PARENT : /Classes/TableRecord.php
DEPENDENTS : (NIL)


PROPERTIES : 
+	(Parent properties)

METHODS (-:Private, +:Public) : 
+	(Parent methods)

----------------------------------------------------------------------------------------------------*/
class cls extends TableRecord {
//----------------------------------------------------------------------------------------------------	
	/*
	function cls($Host, $HUName, $HUPwd, $DB,$Table)
	{
		//initiallize the basic properties for by accessing the table directly
		$this->TableRecord($Host, $HUName, $HUPwd, $DB, $Table);
	} // function
*/
	function cls($Link_id,$Table)
	{
		//initiallize the basic properties for by accessing the table directly
		$this->TableRecord($Link_id, $Table);
	} // function
//----------------------------------------------------------------------------------------------------	
//Other required methods



}//class
?>