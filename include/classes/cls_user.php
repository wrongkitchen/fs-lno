<?
/*----------------------------------------------------------------------------------------------------
AUTHOR : Eason Chan
DATE : 20100319
LAST UPDATE : 20100319
----------------------------------------------------------------------------------------------------*/
class user extends TableRecord {
//----------------------------------------------------------------------------------------------------	
	function user($resource_link)
	{
		//initiallize the basic properties for by accessing the table directly
		$this->TableRecord($resource_link, "user");
	} // function
//----------------------------------------------------------------------------------------------------	

}//class
?>