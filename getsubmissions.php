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

	print '<tr><th>Id</th><th>Time</th><th>User</th><th>Problem</th><th>Status</th></tr>';

	$cn = mysql_connect('localhost', $DBUSER , $DBPASS);
	mysql_select_db($DBNAME, $cn);

	$result = mysql_query("select submissions.id, time, username, problemid, status from users, submissions where users.id = submissions.userid order by time desc LIMIT 0,30");

	if($result)
	{
		while($row = mysql_fetch_array($result))
		{
			switch($row[4])
			{
				case 0:
					$row[4] = "Accepted";
					break;

				case 1:
					$row[4] = "Compile Error";
					break;

				case 2:
					$row[4] = "Wrong Answer";
					break;

				case 3:
					$row[4] = "Time Limit";
					break;

				case 4:
					$row[4] = "Invalid File";
					break;
			}

			$t = strftime('%H:%M:%S',$row[1]);

			if($row[4] == "Accepted")
				$class = "correct";
			else
				$class = "row-a";

			print "<tr class='$class'><td>$row[0]</td><td>$t</td><td>$row[2]</td><td>$row[3]</td><td>$row[4]</td></tr>";

		}
	}

?>				
