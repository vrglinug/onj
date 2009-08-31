<?php

/*
* @copyright (c) 2008 Nicolo John Davis
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*/

session_start();

include('../settings.php');
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>

<meta name="Keywords" content="programming, contest, coding, judge" />
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta name="Distribution" content="Global" />
<meta name="Robots" content="index,follow" />

<link rel="stylesheet" href="../images/Envision.css" type="text/css" />

<title>Programming Contest</title>

<!--[if IE]><script language="javascript" type="text/javascript" src="../excanvas.pack.js"></script><![endif]-->
<script type="text/javascript" src="../jquery-1.3.1.js"></script>
<script type="text/javascript">
<!--

$(document).ready(
	function()
	{ 
	} 
);

-->
</script>
	
</head>

<body class="menu1">
<!-- wrap starts here -->
<div id="wrap">
		
		<!--header -->
		<?php include('../header.php'); ?>
		
		<!-- menu -->	
			
		<!-- content-wrap starts here -->
		<div id="content-wrap">
								
			<div id="main">
				
				<h2>Database</h2>
				<form>
					<p>
						<label>Username:</label>
						<input type="text" id="dbuser"/>
					</p>
					<p>
						<label>Password:</label>
						<input type="text" id="dbpass"/>
					</p>
					<p>
						<label>Database Name:</label>
						<input type="text" id="dbname"/>
					</p>
				</form>

				<h2>Contest Time</h2>
				<form>
					<p>
						<label>Start Time:</label>
						<input type="text" id="user"/>
					</p>
					<p>
						<label>End Time:</label>
						<input type="text" id="user"/>
					</p>
				</form>

			</div>

			<div id="sidebar">
			</div>
		
		<!-- content-wrap ends here -->	
		</div>
					
		<!--footer starts here-->
		<div id="footer">
			<?php include('../footer.php'); ?>
		</div>	

<!-- wrap ends here -->
</div>

</body>
</html>
