<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<title>L&O</title>
<meta name="description" content="">
<meta name="viewport" content="width=device-width">

<!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
<link href='http://fonts.googleapis.com/css?family=Cabin:400,700' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="components/bootstrap/css/bootstrap.min.css" />
<link rel="stylesheet" href="components/jaysalvat-vegas/jquery.vegas.css" />
<link rel="stylesheet" href="components/fancybox/source/jquery.fancybox.css" />
<link rel="stylesheet" href="components/jscrollpane/style/jquery.jscrollpane.css" />
<link rel="stylesheet" href="css/common.css" />
<link rel="stylesheet" href="css/main.css" />
<script type="text/javascript" src="components/jquery/jquery.min.js"></script>
</head>

<body>

<div class="wrapper">

	<?php require_once("include/header.php") ?>
	
	<div id="mainContent">
		<div class="section" id="homeContent">
			<table width="100%" height="100%">
				<tr>
					<td align="center" valign="middle">
						<img src="img/home-content.png" alt="">
					</td>
				</tr>
			</table>
		</div>
	
		<div class="section" id="aboutContent"></div>
		
		<div class="section" id="projectContent"></div>
	
		<div class="section" id="newsContent"></div>
		
		<div class="section" id="awardContent"></div>
	
		<div class="section" id="susContent"></div>
	
		<div class="section" id="careerContent"></div>
	
		<div class="section" id="contactContent"></div>
	
	</div>
	
	<?php require_once("include/footer.php") ?>
</div>

<script type="text/javascript" data-main="js/main.js" src="components/requirejs/require.js"></script>
</body>
</html>