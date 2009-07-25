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

include('settings.php');
?>

<?php
	/*
	#define RIGHT 0
	#define COMPILE_ERROR 1
	#define WRONG 2
	#define TIME_EXCEEDED 3
	#define ILLEGAL_FILE 4
	*/

	if($running == true)
	{
		$isUpload = false;
		$problemid = -1;
		$file = -1;

		for($i=1 ; $i<=count($points) ; $i++)
		{
			if(isset($_FILES[$i]))
			{
				$isUpload = true;
				$file = $i;
				$problemid = $i;
			}
		}

		if($isUpload == true)
		{
			$cn = mysql_connect('localhost', $DBUSER, $DBPASS);
			mysql_select_db($DBNAME, $cn);

			$status = 0;

			$query = "select problemid, status from submissions where userid=$userid and problemid=$problemid order by time desc";
			$result = mysql_query($query);

			if($result)
			{
				$result = mysql_fetch_array($result);
			}

			if(isset($result['status']))
				$status = $result['status'];
			else
				$status = -1;
			
			$status++;
			
			$statString = array('-', 'Accepted', 'Compile Error', 'Wrong Answer', 'Time Limit', 'Invalid File');

			mysql_close($cn);

			if($statString[$status] != "Accepted")
			{
				$userDir = "code/".$username."/";
				$uploadDir = $userDir . $file . "/";
				
				if(!file_exists("code/"))
				{
					mkdir("code/") or die("Could not create upload directory");
				}
				if(!file_exists($userDir))
				{
					mkdir($userDir);
				}
				if(!file_exists($uploadDir))
				{
					mkdir($uploadDir);
				}
				
				$destFile = $uploadDir . $_FILES[$file]["name"];
				
				if($_FILES[$file]["error"] > 0)
				{
					//echo $_FILES[$file]["error"];
				}
				else
				{
					move_uploaded_file($_FILES[$file]["tmp_name"], $destFile);

					//----Invoke online judge-----------
					exec("./onj $destFile $file", $output, $verdict);		
					
					$cn = mysql_connect('localhost', $DBUSER, $DBPASS);
					mysql_select_db($DBNAME, $cn);
					
					$t = time();
					$query = "insert into `submissions` (userid, problemid, status, time) values($userid, $file, $verdict, $t)";
					mysql_query($query);
					
					if($verdict == 0)
					{
							$score=0;
							if($file>=1 && $file<=count($points));
								$score = $points[$file-1];
							$query = "update `users` set score = score + $score where `id` = $userid";
							mysql_query($query);
					}
					
					$verdict = array('verdict' => $verdict, 'problemid' => $problemid);
					echo json_encode($verdict);

					mysql_close($cn);
				}
			}
		}
	}
?>
