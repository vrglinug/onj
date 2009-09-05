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

<style>
button#confirm {
	background-color: #FAFAFA;
	border: 1px solid #F2F2F2;
	font-size: 15px;
	color: #AAAAAA;
	padding: 2px;
	margin: 10px;
}
button#confirm:hover {
	background-color: #EDFDCE;
}
</style>

<title>Programming Contest</title>

<!--[if IE]><script language="javascript" type="text/javascript" src="../excanvas.pack.js"></script><![endif]-->
<script type="text/javascript" src="../jquery-1.3.1.js"></script>
<script type="text/javascript">
<!--

$(document).ready(
	function()
	{ 
		$("#sday,#eday").val('DD').focus( function() { $(this).val(''); } );
		$("#smonth,#emonth").val('MM').focus( function() { $(this).val(''); } );
		$("#syear,#eyear").val('YYYY').focus( function() { $(this).val(''); } );
		$("#shour,#ehour").val('hh').focus( function() { $(this).val(''); } );
		$("#smin,#emin").val('mm').focus( function() { $(this).val(''); } );
		$("#ssec,#esec").val('ss').focus( function() { $(this).val(''); } );

		$("#sday,#eday").blur( function() { if($(this).val().length == 0) $(this).val('DD'); });
		$("#smonth,#emonth").blur( function() { if($(this).val().length == 0) $(this).val('MM'); });
		$("#syear,#eyear").blur( function() { if($(this).val().length == 0) $(this).val('YYYY'); });
		$("#shour,#ehour").blur( function() { if($(this).val().length == 0) $(this).val('hh'); });
		$("#smin,#emin").blur( function() { if($(this).val().length == 0) $(this).val('mm'); });
		$("#ssec,#esec").blur( function() { if($(this).val().length == 0) $(this).val('ss'); });

		$("#sday,#eday,#smonth,#emonth,#shour,#ehour,#smin,#emin,#ssec,#esec").keypress( function(e) { 
				//Allow only tab, backspace, delete, arrow keys and numeric keys
				if(e.keyCode==9 || e.keyCode==8 || e.keyCode==46 || e.keyCode==37 || e.keyCode==38 || e.keyCode==39 || e.keyCode==40 || (e.which>=48 && e.which<=57))
				{
					//Prevent numbers if the length of the field is already 2
					if($(this).val().length>=2 && e.which>=48 && e.which<=57)
						return false;
				}
				else
					return false;
			});

		$("#syear,#eyear").keypress( function(e) { 
				//Allow only tab, backspace, delete, arrow keys and numeric keys
				if(e.keyCode==9 || e.keyCode==8 || e.keyCode==46 || e.keyCode==37 || e.keyCode==38 || e.keyCode==39 || e.keyCode==40 || (e.which>=48 && e.which<=57))
				{
					//Prevent numbers if the length of the field is already 4
					if($(this).val().length>=4 && e.which>=48 && e.which<=57)
						return false;
				}
				else
					return false;
			});
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
						<input class=".timefield" type="text" id="sday" size="2" />
						<input class=".timefield" type="text" id="smonth" size="2" />
						<input class=".timefield" type="text" id="syear" size="4" />
						<input class=".timefield" type="text" id="shour" size="2" />
						<input class=".timefield" type="text" id="smin" size="2" />
						<input class=".timefield" type="text" id="ssec" size="2" />
					</p>
					<p>
						<label>End Time:</label>
						<input class=".timefield" type="text" id="eday" size="2" />
						<input class=".timefield" type="text" id="emonth" size="2" />
						<input class=".timefield" type="text" id="eyear" size="4" />
						<input class=".timefield" type="text" id="ehour" size="2" />
						<input class=".timefield" type="text" id="emin" size="2" />
						<input class=".timefield" type="text" id="esec" size="2" />
					</p>
				</form>

				<button id="confirm">Confirm</button>

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
