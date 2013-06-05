<?
function createConnection($dbhost,$dbuser,$dbpwd,$dbname)
{
	$link = mysql_connect($dbhost,$dbuser,$dbpwd);
	mysql_select_db($dbname);
	return $link;

}

function postBack($parameter, $url){
?>
<html>
	<body onLoad="document.form1.submit();">
		<form name="form1" method="post" action="<?= $url ?>"  target="_self">
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
		if(!is_array($value))
			$arr_values[$key] = mysql_real_escape_string(trim($value));
	}
	return $arr_values;
}
function strRand($length=0)
{
	$pattern = "1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
	$pattern_len = strlen($pattern);
	for($i=0;$i<$length;$i++)
	{
	 	$key .= $pattern{rand(0,$pattern_len-1)}; // $pattern_len-1 for index
	}
	return $key;
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

function mod($a,$b)
{
	$x1=(int) abs($a/$b);
	$x2=$a/$b;
	return $a-($x1*$b);
}

function isInteger($input){
  return preg_match('@^[-]?[0-9]+$@',$input) === 1;
}

function cleanForNumeric($input){
	$possible_invalid_character = array('_', '(', ')', ',');

	return str_replace($possible_invalid_character, '', $input);
}

function parseDate($date){
	$result = false;

	list($year, $month, $day) = explode('-', $date);

	if(isInteger($year)) {
		$year = (int) $year;
	} else {
		$year = 0;
	}

	if(isInteger($month)) {
		$month = (int) $month;
	} else {
		$month = 0;
	}

	if(isInteger($day)) {
		$day = (int) $day;
	} else {
		$day = 0;
	}

	if(checkdate($month, $day, $year)) {
		$result = array('year' => $year, 'month' => $month, 'day' => $day);
	}

	return $result;
}

function parseDate2($date){
	$result = false;

	list($day, $month, $year) = explode('/', $date);

	if(isInteger($year)) {
		$year = (int) $year;
	} else {
		$year = 0;
	}

	if(isInteger($month)) {
		$month = (int) $month;
	} else {
		$month = 0;
	}

	if(isInteger($day)) {
		$day = (int) $day;
	} else {
		$day = 0;
	}

	if(checkdate($month, $day, $year)) {
		$result = array('year' => $year, 'month' => $month, 'day' => $day);
	}

	return $result;
}

function removeExcelFormat($input_file, $output_file){
	global $java_path;
	global $root_path;

	exec($java_path . " -Xmx512m -Xms128m -server -jar " . $root_path . "include/function/ExcelConverter.jar " . $input_file . " " . $output_file);
}

function toFixed($number, $round=2)
{
	if(is_numeric($number)) {
		$number = (float) $number;
		$tempd = $number * pow(10,$round);
		$tempd1 = round($tempd);
		$number = $tempd1/pow(10,$round);
		return $number;
	} else
		return "";
}

function truncateString($input, $length){
	if(strlen($input) <= $length)
		return $input;
	return substr($input, 0, $length);
}

function isObjectValid($obj, $target_class_name){
	if(is_object($obj)) {
		$class_name = get_class($obj);
		return strtolower($class_name) == strtolower($target_class_name);
	}
	return false;
}

function linebreak()
{
	return "<BR>";

}

//new thumbnail functions
if(!function_exists('stripos')){
function stripos($haystack, $needle, $offset = 0) {
   return strpos(strtolower($haystack), strtolower($needle),$offset);
}
}

if(!function_exists('strripos')){
	function strripos($haystack, $needle) {
	   $iter = stripos($haystack, $needle);
	   $pos = -1;
	   while ($iter !== false) {
	       $pos = $iter + ($pos+1);
	       $iter = stripos(substr($haystack,$pos+1), $needle);
	     }
	     return ($pos != -1) ? $pos : false;
	}
}

function file_ext($x){
	$pos = strripos($x,".");
	return strtolower(substr($x,$pos+1,strlen($x)-1));
}
function file_name($x){
	$pos = strripos($x,".");
	return strtolower(substr($x,0,$pos));
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



function replaceContent($content, $arr_keyword)
{
	if(count($arr_keyword)>0)
	{
		foreach($arr_keyword as $key=>$value)
		{
			$content = str_replace("{".$key."}",$value,$content);	
		}
	}
	return $content;
}

function filesize2bytes($str) { 
    $bytes = 0; 

    $bytes_array = array( 
        'B' => 1, 
        'KB' => 1024, 
        'MB' => 1024 * 1024, 
        'GB' => 1024 * 1024 * 1024, 
        'TB' => 1024 * 1024 * 1024 * 1024, 
        'PB' => 1024 * 1024 * 1024 * 1024 * 1024, 
    ); 

    $bytes = floatval($str); 

    if (preg_match('#([KMGTP]?B)$#si', $str, $matches) && !empty($bytes_array[$matches[1]])) { 
        $bytes *= $bytes_array[$matches[1]]; 
    } 

    $bytes = intval(round($bytes, 2)); 

    return $bytes; 
}

function formatBytes($bytes, $precision = 2) { 
    $units = array('B', 'KB', 'MB', 'GB', 'TB'); 
   
    $bytes = max($bytes, 0); 
    $pow = floor(($bytes ? log($bytes) : 0) / log(1024)); 
    $pow = min($pow, count($units) - 1); 
   
    $bytes /= pow(1024, $pow); 
   
    return round($bytes, $precision) . ' ' . $units[$pow]; 
} 
function checksession($require_login = true)
{
	if($require_login)
	{
		if($_SESSION['sess_front_login'] == "")
		{
			header("location:login.php");	
			return;
		}
	}
	else
	{
		if($_SESSION['sess_front_login'] != "")
		{
			header("location:member.php");	
			return;
		}
	}
	
}
function str_rand($length)
{
  $random= "";
  srand((double)microtime()*1000000);
  $char_list = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
  $char_list .= "abcdefghijklmnopqrstuvwxyz";
  $char_list .= "1234567890";
  // Add the special characters to $char_list if needed

  for($i = 0; $i < $length; $i++)
  { 
    $random .= substr($char_list,(rand()%(strlen($char_list))), 1);
  }
  return $random;
} 
?>