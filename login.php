<?php

/*
* @copyright (c) 2008 Nicolo John Davis and Sarang Bharadwaj
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*/

session_start();
include('settings.php');
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>

<meta name="Keywords" content="programming, contest, coding, judge" />
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta name="Distribution" content="Global" />
<meta name="Robots" content="index,follow" />

<link rel="stylesheet" href="images/Envision.css" type="text/css" />

<title>Programming Contest</title>

<script type="text/javascript" src="jquery-1.3.1.js"></script>
<?php include('timer.php'); ?>
<script type="text/javascript">
<!--

$(document).ready(function(){ 
		setInterval("dispTime()", 1000); 
		dispTime(); 

		$('#register').click( function() {
				if($('#registerfields').is(':hidden'))
				{
					$('#registerfields').slideDown('fast');
					$('#register').text('Cancel');
					$('#loginbutton').attr('value', 'Register');
					$('#loginbutton').attr('name', 'register');
					$('#error').hide();
				}
				else
				{
					$('#registerfields').slideUp('fast');
					$('#register').text('Create an account');
					$('#loginbutton').attr('value', 'Login');
					$('#loginbutton').attr('name', 'login');
					$('#error').hide();
				}
			});

		$('form').submit( function() {
				var username = $("input[name='username']").attr('value');
				var password = $("input[name='password']").attr('value');
				var confirmpass = $("input[name='confirm']").attr('value');
				var firstname = $("input[name='firstname']").attr('value');
				var lastname = $("input[name='lastname']").attr('value');
				var college = $("input[name='college']").attr('value');

				$('#error').hide();

				if(username.length == 0)
				{
					$('#error').text('Username field cannot be left blank');
					$('#error').attr('class', 'error');
					$('#error').fadeIn('slow');
					return false;
				}
				if(password.length == 0)
				{
					$('#error').text('Password field cannot be left blank');
					$('#error').attr('class', 'error');
					$('#error').fadeIn('slow');
					return false;
				}

				if($('#loginbutton').attr('name') == 'register')
				{
					if(password != confirmpass)
					{
						$('#error').text('Passwords entered do not match');
						$('#error').attr('class', 'error');
						$('#error').fadeIn('slow');
						return false;
					}
					if(firstname.length == 0)
					{
						$('#error').text('First name missing');
						$('#error').attr('class', 'error');
						$('#error').fadeIn('slow');
						return false;
					}
					if(lastname.length == 0)
					{
						$('#error').text('Last name missing');
						$('#error').attr('class', 'error');
						$('#error').fadeIn('slow');
						return false;
					}
					if(college.length == 0)
					{
						$('#error').text('College name missing');
						$('#error').attr('class', 'error');
						$('#error').fadeIn('slow');
						return false;
					}
				}

			});

	} );

-->
</script>
	
</head>

<body class="menu1">
<!-- wrap starts here -->
<div id="wrap">
		
		<!--header -->
		<?php include('header.php'); ?>
		
		<!-- menu -->	
		<?php include('menu.php'); ?>
			
		<!-- content-wrap starts here -->
		<div id="content-wrap">
				
			<div id="main">


<?php

if(isset($_SESSION['username']))
{
	$cn = mysql_connect('localhost', $DBUSER, $DBPASS);
	mysql_select_db($DBNAME, $cn);
	$username = $_SESSION['username'];
	$password = $_SESSION['password'];

	$query = "select * from `users` where `username` = '$username' and `password` = '$password'";
	$logged = mysql_query($query);
	$logged = mysql_fetch_array($logged);
	mysql_close($cn);
}

if($logged['id'])
{
	$_SESSION['isloggedin'] = "Yes";
	$_SESSION['userid'] = $logged['id'];
	if($logged['rank'] == 1)
		$_SESSION['admin'] = true;
	echo "<meta http-equiv='Refresh' content='0; URL=index.php' />";
}
else
{
	if(isset($_POST['username']) && isset($_POST['login']))
	{
		$_SESSION['username'] = $_POST['username'];		
		$_SESSION['password'] = $_POST['password'];
		
		echo "Logging in...<meta http-equiv='Refresh' content='0; URL=login.php'/>"; 
	}
	else
	{	
		$printedError = false;

		if(isset($_SESSION['username']))
		{
			print '<div id="error" class="error" style="display: one">Invalid username or password</div>';
			$printedError = true;
			unset($_SESSION['username']);
			unset($_SESSION['password']);
		}
		
		if(isset($_POST['register']))
		{
			$cn = mysql_connect('localhost', $DBUSER, $DBPASS);
			mysql_select_db($DBNAME, $cn);
	
			$username = $_POST['username'];
			$password = $_POST['password'];
			$firstname = $_POST['firstname'];
			$lastname = $_POST['lastname'];
			$college = $_POST['college'];

			//Filter out html entities to prevent XSS attacks
			$username = htmlentities($username);
			$password = htmlentities($password);
			$firstname = htmlentities($firstname);
			$lastname = htmlentities($lastname);
			$college = htmlentities($college);
			
			if(strlen($username) > 1)
				$query = "insert into `users` (username,password,firstname,lastname,college) values('$username', '$password', '$firstname', '$lastname', '$college')";
	
			if(!mysql_query($query))
			{
				if(mysql_errno() == 1062)
				{
					print '<div id="error" class="error" style="display: one">Username already taken</div>';
					$printedError = true;
				}
				else
				{
					print '<div id="error" class="error" style="display: one">Error creating account</div>';
					$printedError = true;
				}				
			}
			else
			{
				print '<div id="error" class="success" style="display: one">Account created</div>';
				$printedError = true;
			}
	
			mysql_close($cn);
		}

		if($printedError == false)
			print '<div id="error" class="success" style="display: none">Error</div>';

		echo <<<EOL
		<form style="position: relative; margin-left: auto; margin-right: auto; width: 250px; background-color: #ECF1EF;" action="login.php" method="post">			
		<p>			
		<label>Username</label>
		<input name="username" value="" type="text" size="30" />
		<label>Password</label>
		<input name="password" value="" type="password" size="30" />				

		<span id="registerfields" style="margin: 0; display: none">
		<label>Confirm Password</label>
		<input name="confirm" value="" type="password" size="30" />				
		<label>First Name</label>
		<input name="firstname" value="" type="text" size="30" />				
		<label>Last Name</label>
		<input name="lastname" value="" type="text" size="30" />				
		<label>College</label>
		<input name="college" value="" type="text" size="30" />				
		</span>

		<br />	
		<div style="position: relative; width: 100px; text-align: center; margin-left: auto; margin-right: auto; margin-bottom: 10px">
			<input id="loginbutton" class="button" type="submit" name="login" value="Login" />		
		</div>
		</p>		

		</form>	

		<div style="text-align: center; margin-bottom: 10px; cursor: pointer"><strong><a id="register">Create an account</a></strong></div>

EOL;

	}
}

?>


		<!-- main ends here -->
		</div>

		<div id="sidebar">

		<h3 id="timeheading"></h3>

		<ul class="sidemenu">
		<li id="time"></li>
		</ul>

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
