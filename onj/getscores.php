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

	$cn = mysql_connect('localhost', $DBUSER ,$DBPASS);
	mysql_select_db($DBNAME, $cn);

	//Calculate the submission stats of each user
	$result = mysql_query("select username, problemid, status from users, submissions where users.id = submissions.userid");
	while($row = mysql_fetch_array($result))
	{
		$success[ "$row[username]" ][ $row[problemid] ] = $row[status];
	}

	//Get scores of users
	$query = "select * from scores";
	$result = mysql_query($query);

	$class = "row-a";
	$pos = 1;
	
	print '<tr><th>Position</th><th>User</th>';
	for($i=1 ; $i<=count($points) ; $i++)
		print "<th>$i</th>";
	print '<th>Score</th></tr>';

	if($result)
	{
		while($row = mysql_fetch_array($result))
		{											
			//Print only normal users (not admins)
			if($row[rank] == 0)
			{
				print "<tr ";
				if($row[username] == $username)
					print "style='font-weight: bold;' ";
				print "class='$class'><td>$pos</td><td>$row[username]</td>";

				for($i=1 ; $i<=count($points) ; $i++)
				{
					if($success[ "$row[username]" ][$i] == '0')
						print "<td><img src='images/checkmark.png' style='border:none; background:none;'/></td>";
					else
						print "<td style='width:25px;'>--</td>";
				}
				print "<td>$row[score]</td></tr>";
				$pos++;

				if($class == "row-a") $class = "row-b";
				else $class = "row-a";
			}
		}
	}
	else
	print 'No';
?>				
