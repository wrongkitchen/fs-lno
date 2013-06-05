<?
//	include_once "simple_html_dom.php";

	function postBack($parameter, $url){
?>
	<html>
		<body onLoad="document.form1.submit();">
			<form name="form1" method="post" action="<?= $url ?>">
				<? foreach($parameter as $rKey => $rValue) { ?>
					<input type="hidden" name="<?= $rKey ?>" value="<?= htmlspecialchars($rValue) ?>"/>
				<? } ?>
			</form>
		</body>
	</html>
<?
	}
	function real_escape_string($arr_values,$link)
	{
		foreach($arr_values as $key=>$value)
		{
			$arr_values[$key] = mysql_real_escape_string($value);
		}
		return $arr_values;
	}

	function createConn($db_host, $db_username, $db_password, $db_name, $db_encoding, $db_collation){
		$link = mysql_connect($db_host, $db_username, $db_password);
		mysql_select_db($db_name, $link);
		mysql_query("SET collation_connection = '" . $db_collation . "' ", $link);
		mysql_query("SET NAMES '" . $db_encoding . "' ", $link);
		return $link;
	}

	function getCurrentTimestamp(){
		setupTimeZone();
		return date("Y-m-d H:i:s");
	}

	function getCurrentDate(){
		setupTimeZone();
		return date("Y-m-d");
	}

	function getTimestamp($offset = ''){
		setupTimeZone();
		if($offset != '')
			return date('Y-m-d H:i:s', strtotime($offset));
		else
			return date("Y-m-d H:i:s");
	}

	function setupTimeZone(){
		if(function_exists('date_default_timezone_set'))
			date_default_timezone_set("Asia/Hong_Kong");
		else
			putenv("TZ=Asia/Hong_Kong");
	}

	function strRand($length=0)
	{
		$pattern = "1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUWXYZ";
		$pattern_len = strlen($pattern);
		for($i=0;$i<$length;$i++)
		{
			$key .= $pattern{rand(0,$pattern_len-1)}; // $pattern_len-1 for index
		}
		return $key;
	}

	function copyDirectory($sourceDir, $destDir){
		if(!file_exists($destDir)){
			mkdir($destDir);
		}

		$command = "cp -r " . $sourceDir . "/* " . $destDir;
		exec($command);
	}

	function file_ext($x){
		$pos = strripos($x,".");
		return strtolower(substr($x,$pos+1,strlen($x)-1));
	}
	function file_name($x){
	$pos = strripos($x,".");
	return strtolower(substr($x,0,$pos));
	}
	function getFileContent($url) 
	{ 
		$handle = fopen($url, "r");
		$result = '';
		while (!feof($handle)) {
		  $result .= fread($handle, 8192);
		}
		fclose($handle);

		return $result;
	}

function resizeImage($inputFile, $newWidth, $outputFile)
{
	 
	 //Check if GD extension is loaded
	 if (!extension_loaded('gd') && !extension_loaded('gd2')) {
	  trigger_error("GD is not loaded", E_USER_WARNING);
	  return false;
	 }
	$imgInfo = getimagesize($inputFile);
	$width = $imgInfo[0];
	$height = $imgInfo[1];
	$extension = $imgInfo[2];
	if($newWidth != $width)
	{
		$newHeight = round($newWidth / $width  * $height, 2);

		$thumb = ImageCreateTrueColor($newWidth,$newHeight);
		$source = createImage($inputFile, $extension);

		 if(($extension==3)){
		  imagealphablending($thumb, false);
		  imagesavealpha($thumb,true);
		  $transparent = imagecolorallocatealpha($thumb, 255, 255, 255, 127);
		  imagefilledrectangle($thumb, 0, 0, $newWidth, $newHeight, $transparent);
			  
		 }
		 if($extension==1)
		{
			$transparent_index = imagecolortransparent($source);

			imagepalettecopy($source, $thumb);
			imagefill($thumb, 0, 0, $transparent_index);
			imagecolortransparent($thumb, $transparent_index);
			imagetruecolortopalette($thumb, true, 256); 
		}
		
		imagecopyresampled($thumb, $source, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

			
		if (file_exists($outputFile))
		{
			unlink($outputFile);
		}
		
		saveImage($thumb, $outputFile , 100, $extension);
		
		imagedestroy($source);
		imagedestroy($thumb);
	}
}
function resizeImagebyHeight($inputFile, $newHeight, $outputFile)
{
	
	 if (!extension_loaded('gd') && !extension_loaded('gd2')) {
	  trigger_error("GD is not loaded", E_USER_WARNING);
	  return false;
	 }
	$imgInfo = getimagesize($inputFile);
	$width = $imgInfo[0];
	$height = $imgInfo[1];
	$extension = $imgInfo[2];

	$newWidth = round($newHeight / $height  * $width, 2);

	$thumb = ImageCreateTrueColor($newWidth,$newHeight);
	$source = createImage($inputFile, $extension);

	 if(($extension==3)){
	  imagealphablending($thumb, false);
	  imagesavealpha($thumb,true);
	  $transparent = imagecolorallocatealpha($thumb, 255, 255, 255, 127);
	  imagefilledrectangle($thumb, 0, 0, $newWidth, $newHeight, $transparent);
		  
	 }
	 if($extension==1)
	{
		
		$transparent_index = imagecolortransparent($source);

		imagepalettecopy($source, $thumb);
		imagefill($thumb, 0, 0, $transparent_index);
		imagecolortransparent($thumb, $transparent_index);
		imagetruecolortopalette($thumb, true, 256); 
		
	}
	
	imagecopyresampled($thumb, $source, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

		
	if (file_exists($outputFile))
	{
		unlink($outputFile);
	}
	
	saveImage($thumb, $outputFile , 100, $extension);
	
	imagedestroy($source);
	imagedestroy($thumb);

}
function resizeImage2($inputFile, $newWidth, $newHeight, $outputFile)
{
	
	 if (!extension_loaded('gd') && !extension_loaded('gd2')) {
	  trigger_error("GD is not loaded", E_USER_WARNING);
	  return false;
	 }
	$imgInfo = getimagesize($inputFile);
	$width = $imgInfo[0];
	$height = $imgInfo[1];
	$extension = $imgInfo[2];

	$thumb = ImageCreateTrueColor($newWidth,$newHeight);
	$source = createImage($inputFile, $extension);

	 if(($extension==3)){
	  imagealphablending($thumb, false);
	  imagesavealpha($thumb,true);
	  $transparent = imagecolorallocatealpha($thumb, 255, 255, 255, 127);
	  imagefilledrectangle($thumb, 0, 0, $newWidth, $newHeight, $transparent);
		  
	 }
	 if($extension==1)
	{
		
		$transparent_index = imagecolortransparent($source);

		imagepalettecopy($source, $thumb);
		imagefill($thumb, 0, 0, $transparent_index);
		imagecolortransparent($thumb, $transparent_index);
		imagetruecolortopalette($thumb, true, 256); 
		
	}
	
	imagecopyresampled($thumb, $source, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

		
	if (file_exists($outputFile))
	{
		unlink($outputFile);
	}
	
	saveImage($thumb, $outputFile , 100, $extension);
	
	imagedestroy($source);
	imagedestroy($thumb);
	

}
function createImage($inputFile, $extension){
	switch ($extension) {
	  case 1: $im = imagecreatefromgif($inputFile); break;
	  case 2: $im = imagecreatefromjpeg($inputFile);  break;
	  case 3: $im = imagecreatefrompng($inputFile); break;
	  default:  trigger_error('Unsupported filetype!', E_USER_WARNING);  break;
	 }
	 return $im;
}

function saveImage($imgfile,$outputFile,$qty,$extension){
	//
	 switch ($extension) {
	  case 1: imagegif($imgfile,$outputFile); break;
	  case 2: imagejpeg($imgfile,$outputFile, 100);  break;
	  case 3: imagepng($imgfile,$outputFile,0); break;
	  default:  trigger_error('Failed resize image!', E_USER_WARNING);  break;
	 }

}

	function compress_javascript($buffer)
	{
	  $buffer = preg_replace('/\/\/.+/', ' ', $buffer);
	  $buffer = str_replace("\t", " ", $buffer);
	  $buffer = str_replace("\n", " ", $buffer);
	  $buffer = preg_replace('/\s\s+/', ' ', $buffer);
	  return $buffer;
	}

	function convertHTML($input){
		$dom = new simple_html_dom();
		$dom->load($input);

		$buffer = "";

		$array = $dom->find('body');

		foreach($array as $body){
			$buffer = $buffer . $body->innertext . "\n";
		}

		unset($array);

		$array = $dom->find('style');

		foreach($array as $style){
			$content = $style->outertext;
			$content = str_replace("<!--", "", $content);
			$content = str_replace("-->", "", $content);

			$buffer = $buffer . $content . "\n";
		}

		$array = $dom->find('script');

		foreach($array as $style){
			$content = $style->outertext;

			$buffer = $buffer . $content . "\n";
		}

		return $buffer;
	}

	function convertLink($input, $self_url, $menu_array){
		// Create DOM object
		$dom = new simple_html_dom();

		// Load HTML from a string
		$dom->load($input);

		$array = $dom->find('a');

		for($i = 0; $i < count($array); $i++){
			if(strpos($array[$i]->href, "#") === 0) {
				$array[$i]->href = $self_url . $array[$i]->href;
			} else if(strpos($array[$i]->href, "../") === 0 || strpos($array[$i]->href, "/") === 0 || !strpos($array[$i]->href, "/")) {

				if(strpos($array[$i]->href, "#") !== false) {
					$link_prefix = $array[$i]->href;
					$link_subfix = "";
				} else {
					list($link_prefix, $link_subfix) = split("#", $array[$i]->href);
				}

				if(!strpos($link_prefix, "?")){
					$link_prefix .= "?";
				} else {
					$link_prefix .= "&";
				}

				if(strpos($link_prefix, "mid=") === false) { 
					$mid = "";

					for($j = 0; $j < count($menu_array); $j++){
						if($j > 0) 
							$mid .= "-";
						$mid .= $menu_array[$j];
					}

					$array[$i]->href = $link_prefix . "mid=" . $mid . ($link_subfix == "" ? "" : "#" . $link_subfix);
				} else {
					$array[$i]->href = $link_prefix . ($link_subfix == "" ? "" : "#" . $link_subfix);
				}
			}
		}
		
		$result = $dom->save();

		unset($dom);

		return $result;
	}

	function mod($a,$b)
	{
		$x1=(int) abs($a/$b);
		$x2=$a/$b;
		return $a-($x1*$b);
	}

	function IsLeapYear($y)
	{
		$bulis=((mod($y,4)==0) && ((mod ($y,100)<>0) || (mod($y,400)==0)));
		return $bulis;
	}

	function daycount($dc_month, $dc_year)
	{
		switch ($dc_month)
		{
			case  1:
			case  3:
			case  5:
			case  7:
			case  8:
			case 10:
			case 12:
				return 31;
				break;
			case  4:
			case  6:
			case  9:
			case 11:
				return 30;
				break;
			case 2:
				if (IsLeapYear($dc_year)) { return 29; } else { return 28; };
				break;
		}
	}

	function convertUnit($size) {
		$bytes = array('B','KB','MB','GB','TB');
		foreach($bytes as $val) {
			if($size > 1024){
				$size = $size / 1024;
			}else{
				break;
			}
		}
		return round($size, 2)." ".$val;
	}

	function directory_size($dir){
		if( !$dir or !is_dir( $dir ) )
		{
			return 0;
		}

		$ret = 0;
		$sub = opendir( $dir );
		while( $file = readdir( $sub ) )
		{
			if( is_dir( $dir . '/' . $file ) && $file !== ".." && $file !== "." )
			{
				$ret += dir_size( $dir . '/' . $file );
				unset( $file );
			}
			elseif( !is_dir( $dir . '/' . $file ) )
			{
				$stats = stat( $dir . '/' . $file );
				$ret += $stats['size'];
				unset( $file );
			}
		}
		closedir( $sub );
		unset( $sub );
		return $ret; 
	}

	function recursive_remove_directory($directory, $empty=FALSE)
	{
		// if the path has a slash at the end we remove it here
		if(substr($directory,-1) == '/')
		{
			$directory = substr($directory,0,-1);
		}

		// if the path is not valid or is not a directory ...
		if(!file_exists($directory) || !is_dir($directory))
		{
			// ... we return false and exit the function
			return FALSE;

		// ... if the path is not readable
		}elseif(!is_readable($directory))
		{
			// ... we return false and exit the function
			return FALSE;

		// ... else if the path is readable
		}else{

			// we open the directory
			$handle = opendir($directory);

			// and scan through the items inside
			while (FALSE !== ($item = readdir($handle)))
			{
				// if the filepointer is not the current directory
				// or the parent directory
				if($item != '.' && $item != '..')
				{
					// we build the new path to delete
					$path = $directory.'/'.$item;

					// if the new path is a directory
					if(is_dir($path)) 
					{
						// we call this function with the new path
						recursive_remove_directory($path);

					// if the new path is a file
					}else{
						// we remove the file
						unlink($path);
					}
				}
			}
			// close the directory
			closedir($handle);

			// if the option to empty is not set to true
			if($empty == FALSE)
			{
				// try to delete the now empty directory
				if(!rmdir($directory))
				{
					// return false if not possible
					return FALSE;
				}
			}
			// return success
			return TRUE;
		}
	}

	function isInteger($input){
	  if(is_array($input))
		  return false;
	  return preg_match('@^[-]?[0-9]+$@',$input) === 1;
	}

	function rebuildUrl($base_url, $get_array){
		$parameter = "";

		foreach($get_array as $rKey => $rValue){

			if(is_array($rValue)){
				foreach($rValue as $innerValue){
					if($innerValue == "")
						continue;

					$parameter .= htmlspecialchars($rKey) . "[]=" . urlencode($innerValue);
				}
			} else {
				$rValue = trim($rValue);

				if($rValue == "")
					continue;

				if($rKey == "lang")
					continue;

				if($parameter == "")
					$parameter .= "?";
				else 
					$parameter .= "&";

				$parameter .= htmlspecialchars($rKey) . "=" . urlencode($rValue);
			}
		}

		$base_url = $base_url . $parameter;

		return $base_url;
	}

	function rebuildMid($mid_str){
		$mid_str = str_replace(":", "-", $mid_str);

		$mid_array = split("-", $mid_str);

		$selected_menu = "";

		foreach($mid_array as $mid){
			if($mid != "" && isInteger($mid)){
				if($selected_menu != "")
					$selected_menu .= "-";
				$selected_menu .= $mid;
			}
		}

		return $selected_menu;
	}

	function rebuildMidArray($mid_str){
		$menu_array = array();

		$mid_str = str_replace(":", "-", $mid_str);

		$mid_array = split("-", $mid_str);

		foreach($mid_array as $mid){
			if($mid != "" && isInteger($mid)){
				$menu_array[] = $mid;
			}
		}

		return $menu_array;
	}

	function extractStyle($content){
		// Create DOM object
		$dom = new simple_html_dom();

		// Load HTML from a string
		$dom->load($content);

		$array = $dom->find('style');

		$result = "";

		if(count($array)){
			for($i = 0; $i < count($array); $i++){
				$result .= $array[$i]->innertext;
			}
		}

		return $result;
	}

	function removeStyle($content){
		// Create DOM object
		$dom = new simple_html_dom();

		// Load HTML from a string
		$dom->load($content);

		$array = $dom->find('style');

		if(count($array)){
			for($i = 0; $i < count($array); $i++){
				$array[$i]->outertext = '';
			}
		}

		$result = $dom->save();

		unset($dom);

		return $result;
	}

	function checkMenuValid($menuObj, $menuId){
		$menuRec = $menuObj->Load($menuId);

		if($menuRec == "" || $menuRec['menu_status'] == 0 || $menuRec['menu_parent_id'] == $menuId){
			return false;
		} else {
			if($menuRec['menu_parent_id'] == "0")
				return true;
			return checkMenuValid($menuObj, $menuRec['menu_parent_id']);
		}
	}
	function is_event_reg_period($obj, $user_page_header_id, $member_id){
		$flag = true;
		$link = $obj->createConnection();		
		if($member_id==""||$user_page_header_id==""){
			$flag = false;
		}
		$obj_row = $obj->Load($user_page_header_id);
		if($obj_row['user_page_header_event_sjoining_date']>getCurrentTimestamp()||$obj_row['user_page_header_event_ejoining_date']<getCurrentTimestamp()||$obj_row['user_page_header_event_allow_reg']!="Y"||$obj_row['user_page_header_status']==STATUS_DISABLE||$obj_row['user_page_header_type']!=USERPAGE_TYPE_EVENT){
			$flag = false;
		}
		return $flag;
	}
	function is_event_reg($obj, $user_page_header_id, $member_id){
		$flag = true;
		$link = $obj->createConnection();		
		if($member_id==""||$user_page_header_id==""){
			$flag = false;
		}
		$obj_row = $obj->Load($user_page_header_id);
		if($obj_row['user_page_header_event_sjoining_date']>getCurrentTimestamp()||$obj_row['user_page_header_event_ejoining_date']<getCurrentTimestamp()||$obj_row['user_page_header_event_allow_reg']!="Y"||$obj_row['user_page_header_status']==STATUS_DISABLE||$obj_row['user_page_header_type']!=USERPAGE_TYPE_EVENT){
			$flag = false;
		}
		$sql = "select * from member where member_id='$member_id'";
		$result = mysql_query($sql, $link);
		$row = mysql_fetch_array($result);
		$member_type = $row['member_type'];
		$sql_stmt = "select * from access_level where access_level_relative_id='$user_page_header_id' and access_level_type='user_page_header_reg' and access_level_status=".STATUS_ENABLE." and access_level_value='".$member_type."'";
		$result = mysql_query($sql_stmt, $link);
		$row = mysql_fetch_array($result);
		if($row==''){
			$flag = false;
		}
		return $flag;
	}
	
	function is_member_to_event($obj, $user_page_header_id, $member_id){
		$flag = false;
		$link = $obj->createConnection();		
		$sql_stmt = "select * from member_to_event where member_to_event_member_id='$member_id' and member_to_event_user_page_header_id='$user_page_header_id' and member_to_event_status=".STATUS_ENABLE;
		$result = mysql_query($sql_stmt, $link);
		if (mysql_num_rows($result)>0){
			$flag = true;
		}
		return $flag;
	}
	function is_event_limited($obj, $user_page_header_id){
		$flag = false;
		$link = $obj->createConnection();		
		$sql_stmt = "select user_page_header_event_is_limited,user_page_header_event_no_of_spaces from user_page_header where user_page_header_id='$user_page_header_id'";
		$result = mysql_query($sql_stmt, $link);
		$row = mysql_fetch_array($result);
		if($row['user_page_header_event_is_limited']!='Y'){
			$flag = false;
		}else{
			$user_page_header_event_no_of_spaces = $row['user_page_header_event_no_of_spaces'];
			$sql_stmt = "select count(*) as b from member_to_event where member_to_event_user_page_header_id='$user_page_header_id' and member_to_event_status=".STATUS_ENABLE;
			$result = mysql_query($sql_stmt, $link);
			$row = mysql_fetch_array($result);
			if($row['b']<$user_page_header_event_no_of_spaces){
				$flag = false;
			}else{
				$flag = true;
			}
		}
		return $flag;
	}
	function is_mentor($obj, $member_id){
		$flag = false;
		$link = $obj->createConnection();		
		$sql_stmt = "select * from mentorship where mentorship_status=".STATUS_ENABLE." order by mentorship_id desc";
		$result = mysql_query($sql_stmt, $link);
		$row_period = mysql_fetch_array($result);
		$sql_stmt = "select * from mentor where mentor_status=".STATUS_ENABLE." and mentor_member_id='$member_id' and mentor_period='".$row_period['mentorship_id']."'";
		$result = mysql_query($sql_stmt, $link);
		if (mysql_num_rows($result)>0&&$row_period!=""){
			$flag = true;
		}
		return $flag;
	}
	function is_mentee($obj, $member_id){
		$flag = false;
		$link = $obj->createConnection();	
		$sql_stmt = "select * from mentorship where mentorship_status=".STATUS_ENABLE." order by mentorship_id desc";
		$result = mysql_query($sql_stmt, $link);
		$row_period = mysql_fetch_array($result);
		$sql_stmt = "select * from mentee where mentee_status=".STATUS_ENABLE." and mentee_member_id='$member_id' and mentee_period='".$row_period['mentorship_id']."'";
		$result = mysql_query($sql_stmt, $link);
		if (mysql_num_rows($result)>0&&$row_period!=""){
			$flag = true;
		}
		return $flag;
	}
	function is_reg_period($obj, $type){
		if($type==""){
			return false;
		}
		$link = $obj->createConnection();				
		if($type=="mentor"){
			$sql_stmt = "select * from mentorship where mentorship_status=".STATUS_ENABLE." order by mentorship_id desc";
			$result = mysql_query($sql_stmt);
			$row = mysql_fetch_array($result);
			if(date("Y-m-d")>=$row['mentorship_mentor_reg_start']&&date("Y-m-d")<=$row['mentorship_mentor_reg_close']){
				return true;
			}else{
				return false;
			}
		}
		if($type=="mentee"){
			$sql_stmt = "select * from mentorship where mentorship_status=".STATUS_ENABLE." order by mentorship_id desc";
			$result = mysql_query($sql_stmt);
			$row = mysql_fetch_array($result);
			if(date("Y-m-d")>=$row['mentorship_mentee_reg_start']&&date("Y-m-d")<=$row['mentorship_mentee_reg_close']){
				return true;
			}else{
				return false;
			}
		}
		if($type=="interest_interviewer"){
			$row = load_interview_program($obj);
			if(date("Y-m-d")>=$row['interview_program_start_date']&&date("Y-m-d")<=$row['interview_program_end_date']){
				return true;
			}else{
				return false;
			}
		}
	}
	function url_chop_msg($str){
		$str = preg_replace('/&msg=(\w+\d+)/','',$str);
		if (strpos($str, '?')===false){
			$str.="?";
		}
		return $str;
	}
	function is_access_level($obj, $id, $sess_array, $type, $action){
		if($obj==""||$type==""||$action==""){
			return false;
		}
	$link = $obj->createConnection();
		if($type=="account"){
			if($action=="activate"){
				
				if(in_array(9, $sess_array['sess_action_permission'])){
					return true;
				}else{
					return false;
				}
			}
		}
		
		if($type=="job"){
			if($action=="apply"){
				
				//$sql_stmt = "select * from access_level where access_level_status=".STATUS_ENABLE." and access_level_type='action_type' and access_level_relative_id='1' and access_level_value='".$sess_array['member_type']."'";
			//	$result = mysql_query($sql_stmt, $link);
				//if(mysql_num_rows($result)>0){
				if(in_array(1, $sess_array['sess_action_permission'])){
					return true;
				}else{
					return false;
				}
/*				if($sess_array['sess_access_group_type']==MEMBER_TYPE_ALUMNI||$sess_array['sess_access_group_type']==MEMBER_TYPE_STUDENT){
					if($sess_array['sess_student_allow_access_job'] =="Y"){
						return true;
					}else{
						return true;//NOT YET IMPLEMENT
					}
				}
*/			}
			if($action=="details"){
				$sql_stmt = "select * from job where job_id='$id' and job_status=".STATUS_ENABLE;
				$result = mysql_query($sql_stmt, $link);
				$row = mysql_fetch_array($result);
				if($row!=""&&($row['job_corporate_id']==$sess_array['sess_member_id']&&$sess_array['sess_access_group_type']==MEMBER_TYPE_CORPORATE)||(in_array(1, $sess_array['sess_action_permission']))){				
					return true;
				}else{	
					return false;
				}

			}
			if($action=="listing"){
//				if(($sess_array['sess_access_group_type']==MEMBER_TYPE_STUDENT&&$sess_array['sess_student_allow_access_job']=='Y')||($sess_array['sess_access_group_type']==MEMBER_TYPE_ALUMNI&&$sess_array['sess_student_allow_access_job']=='Y')){				
	//	if(($sess_array['sess_access_group_type']==MEMBER_TYPE_STUDENT)||($sess_array['sess_access_group_type']==MEMBER_TYPE_ALUMNI)){				
				if(in_array(1, $sess_array['sess_action_permission'])){
					return true;
				}else{
					return false;
				}
			}
			if($action=="posting"){
			//	if ($sess_array['sess_access_group_type']==MEMBER_TYPE_CORPORATE){
				if (in_array(6, $sess_array['sess_action_permission'])){
					return true;
				}else{
					return false;
				}
			}
			if($action=="job_history_details"){
				$sql_stmt = "select * from job_to_applicant_view where job_to_applicant_id='$id' and job_status=".STATUS_ENABLE;
				$result = mysql_query($sql_stmt, $link);
				$row = mysql_fetch_array($result);
				if($row!=""&&$row['job_to_applicant_member_id']==$sess_array['sess_member_id']){
					return true;
				}else{
					return false;
				}
			}
		}
		if($type=="forum_message"){
			if($action=="posting"){
			//	if ($sess_array['sess_member_id']!=""&&$sess_array['sess_access_group_type']==MEMBER_TYPE_ALUMNI){
				if (in_array(2, $sess_array['sess_action_permission'])){
					return true;
				}else{
					return false;
				}
				
			}
			if($action=="listing"){
				if (in_array(3, $sess_array['sess_action_permission'])){
					return true;
				}else{
					return false;
				}
			}
		}
		if($type=="survey"){
			if($action=="answer"){
				if (in_array($id, $sess_array['sess_survey_permission'])){
					return true;
				}else{
					return false;
				}
			}
		}
		if($type=="interview"){
			if($action=="interest_interviewer"){
				if (in_array(7, $sess_array['sess_action_permission'])){
					return true;
				}else{
					return false;
				}
			}
			if($action=="confirm_interviewer"){
				if (in_array(7, $sess_array['sess_action_permission'])&&is_interviewer($obj, $sess_array['sess_member_id'], 1)){
					return true;
				}else{
					return false;
				}
			}
		}
		if($type=="member"){
			if($action=="login_page"){
				if($sess_array['sess_member_id']==""){
					return true;
				}else{
					return false;
				}
			}
			if($action=="reg_alumni"){//alumni registration
				$system_page_id = 23;//DB id
				if(is_access_system_page($link, $system_page_id, $_SESSION)){
					return true;
				}else{
					return false;
				}
			}
			if($action=="reg_corp"){//corporate registration
				$system_page_id = 22;//DB id			
				if(is_access_system_page($link, $system_page_id, $_SESSION)){
					return true;
				}else{
					return false;
				}
			}
			if($action=="reg_mentor"){//corporate registration
				if (in_array(4, $sess_array['sess_action_permission'])){
					return true;
				}else{
					return false;
				}
			}
			if($action=="reg_mentee"){//corporate registration
				if (in_array(5, $sess_array['sess_action_permission'])){
					return true;
				}else{
					return false;
				}
			}
			if($action=="edit_alumni"){//corporate registration
				if ($sess_array['sess_member_id']!=""&&($sess_array['sess_access_group_type']==MEMBER_TYPE_ALUMNI||$sess_array['sess_access_group_type']==MEMBER_TYPE_STUDENT||$sess_array['sess_access_group_type']==MEMBER_TYPE_TEACHER)){
					return true;
				}else{
					return false;
				}
			}
			if($action=="edit_corp"){//corporate registration
				if ($sess_array['sess_member_id']!=""&&$sess_array['sess_access_group_type']==MEMBER_TYPE_CORPORATE){
					return true;
				}else{
					return false;
				}
			}
			if($action=="event_history"){//corporate registration
				if ($sess_array['sess_member_id']!=""){
					if($id==''){
						return true;
					}else{
						$sql_stmt = "select * from member_to_event where member_to_event_member_id='".$sess_array['sess_member_id']."' and member_to_event_user_page_header_id='$id' and member_to_event_status=".STATUS_ENABLE;
						$result = mysql_query($sql_stmt, $link);
						if(mysql_num_rows($result)>0){
							return true;
						}else{
							return false;
						}
					}
				}else{
					return false;
				}
			}
		}
		//corporate download attachment
		if($action=="attachment"){
			$sql_stmt = "select * from job_to_applicant where job_to_applicant_id='$id' and job_to_applicant_status=".STATUS_ENABLE;
			$result = mysql_query($sql_stmt, $link);
			$row_jta = mysql_fetch_array($result);
			$jid = $row_jta['job_to_applicant_job_id'];
			$sql_stmt = "select * from job where job_id='$jid' and job_status=".STATUS_ENABLE;
			$result = mysql_query($sql_stmt, $link);
			$row = mysql_fetch_array($result);
			if($row!=""&&(($row['job_corporate_id']==$sess_array['sess_member_id']&&$sess_array['sess_access_group_type']==MEMBER_TYPE_CORPORATE)||($row_jta['job_to_applicant_member_id']==$sess_array['sess_member_id']&&($sess_array['sess_access_group_type']==MEMBER_TYPE_ALUMNI||$sess_array['sess_access_group_type']==MEMBER_TYPE_STUDENT)))){				
				return true;
			}else{	
				return false;
			}

		}
		
		return false;
	}
	function gen_url($_REQUEST, $page_no){
		$i = 0;
		$str = "";
		foreach($_REQUEST as $key=>$value){

			if($key!="page"){
				if($key!='PHPSESSID'){
					if(!is_array($value)){
						if($i!=0) $str.="&";				
						$str.="$key=$value";
						$i++;
					}
				}
			}
		}
		if($i!=0) $str.="&";				
		$str.="page=$page_no";
		
		return $str;
	}
	function return_salary($from, $to){
		if($from==""&&$to==""){
			return "-";
		}
		if(!is_float($from)&&!isInteger($from)&&$from!=""||!isInteger($to)&&$to!=""){
			return "N/A";
		}
		$str = "";
		if($from>=1000){
			$str.= '$'.round($from/1000,1)."k";
		}else{
			$str.='$'.$from;
		}
		if($to==""){
			$str.=" + ";
		}else{
			$str.=" - ";
			if($to>=1000){
				$str.='$'.round($to/1000,1)."k";
			}else{
				$str.='$'.$to;
			}
		}
		return $str;
	}
	function return_re_apply_job($job_to_applicant, $job_id, $applicant_id){
		$sql_stmt = "job_to_applicant_job_id='$job_id' and job_to_applicant_status=".STATUS_ENABLE." and job_to_applicant_member_id='$applicant_id'";
		$no = $job_to_applicant->GetCount($sql_stmt);
		return $no;
	}
	function return_MAX_RE_APPLY_JOB($obj){
		$link=$obj->createConnection();
		$sql = "select * from config_table";
		$result = mysql_query($sql, $link);
		$row = mysql_fetch_array($result);
		return $row['config_max_re_apply_job'];
	}
	function is_access_page($link, $page_id, $sVar){
		if($link==""||$page_id==""){
			return true;
		}else{
			$sql_stmt = "select * from access_level where access_level_relative_id='$page_id' and access_level_type='user_page_header' and access_level_status=".STATUS_ENABLE." and access_level_value='".$sVar['sess_member_type']."'";
			$result = mysql_query($sql_stmt, $link);
			if (mysql_num_rows($result)>0){
				return true;
			}else{
				return false;
			}
		}
	}
	function is_access_system_page($link, $system_page_id, $sVar){
		if($link==""||$system_page_id==""){
			return true;
		}else{
			$sql_stmt = "select * from access_level where access_level_relative_id='$system_page_id' and access_level_type='system_page' and access_level_status=".STATUS_ENABLE." and access_level_value='".$sVar['sess_member_type']."'";
			$result = mysql_query($sql_stmt, $link);
			if (mysql_num_rows($result)>0){
				return true;
			}else{
				return false;
			}
		}
	}
	function is_access_survey($link, $survey_id, $sVar){
		if($link==""||$system_page_id==""){
			return true;
		}else{
			$sql_stmt = "select * from access_level where access_level_relative_id='$survey_id' and access_level_type='survey' and access_level_status=".STATUS_ENABLE." and access_level_value='".$sVar['sess_member_type']."'";
			$result = mysql_query($sql_stmt, $link);
			if (mysql_num_rows($result)>0){
				return true;
			}else{
				return false;
			}
		}
	}
	
	function return_public_alumni($link){
		$sql_stmt = "select * from access_group where access_group_status=".STATUS_ENABLE." and access_group_type='".MEMBER_TYPE_ALUMNI."' and access_group_is_web_access='Y'";
		$result = mysql_query($sql_stmt, $link);
		$row = mysql_fetch_array($result);
		if($row==""){
			return 'A';
		}else{
			return $row['access_group_code'];
		}
	}
	function return_public_corporate($link){
		$sql_stmt = "select * from access_group where access_group_status=".STATUS_ENABLE." and access_group_type='".MEMBER_TYPE_CORPORATE."' and access_group_is_web_access='Y'";
		$result = mysql_query($sql_stmt, $link);
		$row = mysql_fetch_array($result);
		if($row==""){
			return 'C';
		}else{
			return $row['access_group_code'];
		}
	}
	function return_permission($link, $group, $type){
		$temp = array();
		$sql_stmt = "select * from access_level where access_level_type='$type' and access_level_status=".STATUS_ENABLE." and access_level_value='".$group."'";
		$access_level_result = mysql_query($sql_stmt, $link);
		while($row = mysql_fetch_array($access_level_result)){
			$temp[] = $row['access_level_relative_id'];
		}
		return $temp;
	}
	function return_group_access($obj, $id, $type){
		$link = $obj->createConnection();
		$str = "";
		if($type=='menu'){
			$menu_id = end(explode(",", $id));
			$sql_stmt = "select * from access_level where access_level_relative_id='$menu_id' and access_level_type='menu' and access_level_status=".STATUS_ENABLE;
			$result = mysql_query($sql_stmt, $link);
			$k = 0;
			while($row = mysql_fetch_array($result)){
				if($k++>0){
					$str.=",";
				}
				$str.=$row['access_level_value'];
			}
		}
		if($type=='user_page_header'){
			$sql_stmt = "select * from access_level where access_level_relative_id='$id' and access_level_type='user_page_header' and access_level_status=".STATUS_ENABLE;
			$result = mysql_query($sql_stmt, $link);
			$k = 0;
			while($row = mysql_fetch_array($result)){
				if($k++>0){
					$str.=",";
				}
				$str.=$row['access_level_value'];
			}
		}
		if($type=='system_page'){
			$sql_stmt = "select * from access_level where access_level_relative_id='$id' and access_level_type='system_page' and access_level_status=".STATUS_ENABLE;
			$result = mysql_query($sql_stmt, $link);
			$k = 0;
			while($row = mysql_fetch_array($result)){
				if($k++>0){
					$str.=",";
				}
				$str.=$row['access_level_value'];
			}
		}
		if($type=='action_type'){
			$sql_stmt = "select * from access_level where access_level_relative_id='$id' and access_level_type='action_type' and access_level_status=".STATUS_ENABLE;
			$result = mysql_query($sql_stmt, $link);
			$k = 0;
			while($row = mysql_fetch_array($result)){
				if($k++>0){
					$str.=",";
				}
				$str.=$row['access_level_value'];
			}
		}
		if($type=='survey'){
			$sql_stmt = "select * from access_level where access_level_relative_id='$id' and access_level_type='survey' and access_level_status=".STATUS_ENABLE;
			$result = mysql_query($sql_stmt, $link);
			$k = 0;
			while($row = mysql_fetch_array($result)){
				if($k++>0){
					$str.=",";
				}
				$str.=$row['access_level_value'];
			}
		}
		return $str;
	}
	function load_interview_program($obj){
		$link = $obj->createConnection();
		$sql_stmt = "select * from interview_program where interview_program_status=".STATUS_ENABLE." and interview_program_start_date<=NOW() and interview_program_end_date>=NOW() order by interview_program_id desc";
		$result = mysql_query($sql_stmt, $link);
		$row = mysql_fetch_array($result);
		return $row;
	}
	function is_interviewer($obj, $member_id, $times_of_reply){
		$link = $obj->createConnection();
		$row = load_interview_program($obj);
		$sql_stmt = "select * from interviewer where interviewer_status=".STATUS_ENABLE." and interviewer_interview_program_id='".$row['interview_program_id']."' and interviewer_member_id='$member_id'";
		$result = mysql_query($sql_stmt, $link);
		$row = mysql_fetch_array($result);
		if($row ==''){
			return false;
		}else{
			if($times_of_reply==1){
				if($row['interviewer_first_reply'] == 'Y'){
					return true;
				}else{
					return false;
				}
			}
			if($times_of_reply==2){
				if($row['interviewer_second_reply'] == 'Y'){
					return true;
				}else{
					return false;
				}
			}
			return true;
		}
	}
	function is_on_waiting_list($obj, $pid, $member_id){
		$link = $obj->createConnection();		
		$sql = "select * from member_to_event where member_to_event_status=".STATUS_ENABLE." and member_to_event_user_page_header_id=$pid and member_to_event_member_id=$member_id";
		$result = mysql_query($sql, $link);
		$row = mysql_fetch_array($result);
		if($row['member_to_event_type']=='w'){
			return true;
		}else{
			return false;
		}
	}
	function is_mentorship_mentee_limit($obj){
		$link = $obj->createConnection();		
		$sql = "select * from mentorship where mentorship_status=".STATUS_ENABLE." order by mentorship_id desc";
		$result = mysql_query($sql, $link);
		$row = mysql_fetch_array($result);
		$sql = "select count(*) as b from mentee where mentee_status=".STATUS_ENABLE." and mentee_period='".$row['mentorship_id']."'";
		$result = mysql_query($sql, $link);
		$row2 = mysql_fetch_array($result);
		$mentee_number = $row2['b'];
		if($row['mentorship_mentee_limited']=='Y'&&($mentee_number>=$row['mentorship_mentee_inventory'])){
			return true;
		}else{
			return false;
		}
	}
	function is_mentorship_mentor_limit($obj){
		$link = $obj->createConnection();		
		$sql = "select * from mentorship where mentorship_status=".STATUS_ENABLE." order by mentorship_id desc";
		$result = mysql_query($sql, $link);
		$row = mysql_fetch_array($result);
		$sql = "select count(*) as b from mentor where mentor_status=".STATUS_ENABLE." and mentor_period='".$row['mentorship_id']."'";
		$result = mysql_query($sql, $link);
		$row2 = mysql_fetch_array($result);
		$mentor_number = $row2['b'];
		if($row['mentorship_mentor_limited']=='Y'&&($mentor_number>=$row['mentorship_mentor_inventory'])){
			return true;
		}else{
			return false;
		}
	}
	function is_on_mentee_waiting_list($obj, $member_id){
		$link = $obj->createConnection();		
		$sql = "select * from mentorship where mentorship_status=".STATUS_ENABLE." order by mentorship_id desc";
		$result = mysql_query($sql, $link);
		$row = mysql_fetch_array($result);
		$sql = "select * from mentee where mentee_status=".STATUS_ENABLE." and mentee_member_id=$member_id and mentee_period='".$row['mentorship_id']."'";
		$result = mysql_query($sql, $link);
		$row = mysql_fetch_array($result);
		if($row['mentee_type']=='w'){
			return true;
		}else{
			return false;
		}
	}
	function is_on_mentor_waiting_list($obj, $member_id){
		$link = $obj->createConnection();		
		$sql = "select * from mentorship where mentorship_status=".STATUS_ENABLE." order by mentorship_id desc";
		$result = mysql_query($sql, $link);
		$row = mysql_fetch_array($result);
		$sql = "select * from mentor where mentor_status=".STATUS_ENABLE." and mentor_member_id=$member_id and mentor_period='".$row['mentorship_id']."'";
		$result = mysql_query($sql, $link);
		$row = mysql_fetch_array($result);
		if($row['mentor_type']=='w'){
			return true;
		}else{
			return false;
		}
	}

	function convertToHtml($str) { 
    $html_entities = array ( 
        "&" =>  "&amp;",     #ampersand   
        "á" =>  "&aacute;",     #latin small letter a 
        "Â" =>  "&Acirc;",     #latin capital letter A 
        "â" =>  "&acirc;",     #latin small letter a 
        "Æ" =>  "&AElig;",     #latin capital letter AE 
        "æ" =>  "&aelig;",     #latin small letter ae 
        "À" =>  "&Agrave;",     #latin capital letter A 
        "à" =>  "&agrave;",     #latin small letter a 
        "Å" =>  "&Aring;",     #latin capital letter A 
        "å" =>  "&aring;",     #latin small letter a 
        "Ã" =>  "&Atilde;",     #latin capital letter A 
        "ã" =>  "&atilde;",     #latin small letter a 
        "Ä" =>  "&Auml;",     #latin capital letter A 
        "ä" =>  "&auml;",     #latin small letter a 
        "Ç" =>  "&Ccedil;",     #latin capital letter C 
        "ç" =>  "&ccedil;",     #latin small letter c 
        "É" =>  "&Eacute;",     #latin capital letter E 
        "é" =>  "&eacute;",     #latin small letter e 
        "Ê" =>  "&Ecirc;",     #latin capital letter E 
        "ê" =>  "&ecirc;",     #latin small letter e 
        "È" =>  "&Egrave;",     #latin capital letter E 
/*... sorry cutting because limitation of php.net ... 
... but the principle is it ;) ... */ 
        "û" =>  "&ucirc;",     #latin small letter u 
        "Ù" =>  "&Ugrave;",     #latin capital letter U 
        "ù" =>  "&ugrave;",     #latin small letter u 
        "Ü" =>  "&Uuml;",     #latin capital letter U 
        "ü" =>  "&uuml;",     #latin small letter u 
        "Ý" =>  "&Yacute;",     #latin capital letter Y 
        "ý" =>  "&yacute;",     #latin small letter y 
        "ÿ" =>  "&yuml;",     #latin small letter y 
        "Ÿ" =>  "&Yuml;",     #latin capital letter Y 
    ); 

    foreach ($html_entities as $key => $value) { 
        $str = str_replace($key, $value, $str); 
    } 
    return $str; 
	} 
?>