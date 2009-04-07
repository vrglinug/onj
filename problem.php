<?php

/*
* @copyright (c) 2008 Nicolo John Davis and Sarang Bharadwaj
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*/

session_start();
if(!isset($_SESSION['isloggedin']))
{
	echo "<meta http-equiv='Refresh' content='0; URL=login.php' />";
	exit(0);
}
else
{
	$username = $_SESSION['username'];
	$userid = $_SESSION['userid'];
}

include('header.php');
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>

<meta name="Keywords" content="programming, contest, coding, judge" />
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta name="Distribution" content="Global" />
<meta name="Robots" content="index,follow" />

<link rel="stylesheet" href="images/Envision.css" type="text/css" />
<link rel="stylesheet" href="images/Tabs.css" type="text/css" />

<title>Programming Contest</title>
	
<script type="text/javascript" src="jquery-1.3.1.js"></script>
<script type="text/javascript" src="jquery.form.js"></script>
<?php include('timer.php'); ?>
<script type="text/javascript">
<!--

function onSucess(data)
{
	if(data.verdict == 0)
	{
		$('#status' + data.problemid).attr('class', 'accepted');
		$('#upload' + data.problemid).hide();
		$('#status' + data.problemid).html('<strong>Accepted</strong>');
		$('#status' + data.problemid).hide();
		$('#status' + data.problemid).fadeIn('slow');

		getDetails();
		getLeaders();
	}
	else if(data.verdict == 1)
	{
		$('#status' + data.problemid).attr('class', 'compile');
		$('#status' + data.problemid).html('<strong>Compile Error</strong>');
		$('#status' + data.problemid).hide();
		$('#status' + data.problemid).fadeIn('slow');
	}
	else if(data.verdict == 2)
	{
		$('#status' + data.problemid).attr('class', 'wrong');
		$('#status' + data.problemid).html('<strong>Wrong Answer</strong>');
		$('#status' + data.problemid).hide();
		$('#status' + data.problemid).fadeIn('slow');
	}
	else if(data.verdict == 3)
	{
		$('#status' + data.problemid).attr('class', 'time');
		$('#status' + data.problemid).html('<strong>Time Limit</strong>');
		$('#status' + data.problemid).hide();
		$('#status' + data.problemid).fadeIn('slow');
	}
	else if(data.verdict == 4)
	{
		$('#status' + data.problemid).attr('class', 'invalid');
		$('#status' + data.problemid).html('<strong>Invalid File</strong>');
		$('#status' + data.problemid).hide();
		$('#status' + data.problemid).fadeIn('slow');
	}
}

$(document).ready(function() { 
		dispTime();
		getLeaders();
		getDetails();
		setInterval("dispTime()", 1000);  
		setInterval("getLeaders()", getLeaderInterval);  
		setInterval("getDetails()", getLeaderInterval);  

		$('.uploadform').ajaxForm({
				dataType: 'json',
				success: onSucess
			});
	} );

-->
</script>

</head>

<?php
	$problemid = $_GET['id'];
	$problemid = htmlentities($problemid);

	$good = false;
	for($i=1 ; $i<=count($points) ; $i++)
		if($problemid == $i)
			$good = true;
	if($good == false)
		$problemid = 1;
	
	print '<body class="menu2" id="tab'; print $problemid; print '">';
?>

<!-- wrap starts here -->
<div id="wrap">
		
		<!--header -->
		<div id="header">			
				
			<h1 id="logo-text"><a href="index.php">Programming Contest</a></h1>		
			<p id="slogan"></p>		
			
		</div>
		
		<!-- menu -->	
		<?php include('menu.php'); ?>
			
		<!-- content-wrap starts here -->
		<div id="content-wrap">
				
			<div id="main">
				
				<?php
					
					$time = date_create();

					if($time < $startTime)
						echo '<h2>The contest has not yet begun</h2>';
					else
					{
						print '<ul id="tabnav">';
						for($i=1 ; $i<=count($points) ; $i++)
							print "<li class='tab$i'><a href='problem.php?id=$i'>Problem $i</a></li>\n";
						print '</ul>';

						$value = $points[$problemid-1];

						print "<h2>Problem $problemid</h2>";

						if($running)
						{
							include('uploadform.php');
						}

						print "<p><code class='statement'>";
						
						readfile("problems/$problemid/statement") or print "Problem is not available at this time";	
						
						print "</code></p>";
					}

				?> 
				
			</div>
			
			<div id="sidebar">
				
				<?php 
				
				if($time >= $startTime)
				{
					 echo <<<EO
					 <h3>Point Value</h3>				
					 <ul class="sidemenu">
					 <li><strong>$value</strong></li>			 
					 </ul>
EO;

					 if($problemid == 1)
					 {
						/*echo <<<EO
					 <h3>Hints</h3>				
					 <ul class="sidemenu">
					 <li>Be careful when you read the input.</li>			 
					 </ul>
EO;*/
					 }
					 else if($problemid == 2)
					 {
					 }
					 else if($problemid == 3)
					 {
					 }
					 else if($problemid == 4)
					 {
					 }
					 else if($problemid == 5)
					 {
					 }
				}
					echo <<<EOHTML
					</li>
					</ul>
EOHTML;

				include('sidebar.php');
				?>

			</div> 
		
		<!-- content-wrap ends here -->	
		</div>
					
		<!--footer starts here-->
		<div id="footer">
			<?php include('footer.php'); ?>
		</div>	

<!-- wrap ends here -->
</div>

</body>
</html>
