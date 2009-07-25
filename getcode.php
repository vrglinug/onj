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

		if($username != 'admin')
		{
			print "You need to be the administrator to access this file";
			exit(0);
		}
	}

	include('settings.php');

	$username = htmlentities($_GET['username']);
	$problemid = htmlentities($_GET['problemid']);

	$path = "code/$username/$problemid/";

	$dir = dir($path) or print "File not available";
	$filePresent = false;

	while(($entry = $dir->read()) != false)
	{
		if($entry!='.' && $entry!='..' && $entry!='a.out' && $entry!='op')
		{
			$f = fopen($path.$entry, "r");

			while(!feof($f))
				print htmlentities(fgets($f));
			fclose($f);

			$filePresent = true;
			break;
		}
	}

	if($filePresent == false)
		print "File not available";
?>				
