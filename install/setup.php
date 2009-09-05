<?php

	/*
	* @copyright (c) 2008 Nicolo John Davis
	* @license http://opensource.org/licenses/gpl-license.php GNU Public License
	*/

	session_start();

	include('../settings.php');

	$mode = htmlentities($_GET['mode']);

	if($mode == "setup")
	{
		$dbuser = $dbpass = "hopefullynobodyhascreatedanaccountwiththisname";
		$dbname = "onj";

		if(isset($_GET['dbuser']) && isset($_GET['dbpass']))
		{
			$dbuser = htmlentities($_GET['dbuser']);
			$dbpass = htmlentities($_GET['dbpass']);
		}

		if(strlen($_GET['dbname']) > 0)
			$dbname = htmlentities($_GET['dbname']);

		$args = "dbuser-$dbuser\ndbpass-$dbpass\ndbname-$dbname\n";

		$cn = mysql_connect('localhost', $dbuser, $dbpass);

		$successful = false;

		if($cn)
		{
			$successful = true;
			mysql_close($cn);
		}
		else
		{
			$ret = array('status' => 'dberror', 'args' => $args);
			echo json_encode($ret);
			exit(0);
		}

		$sday = intval(htmlentities($_GET['sday']));
		$smonth = intval(htmlentities($_GET['smonth']));
		$syear = intval(htmlentities($_GET['syear']));
		$shour = intval(htmlentities($_GET['shour']));
		$smin = intval(htmlentities($_GET['smin']));
		$ssec = intval(htmlentities($_GET['ssec']));

		$eday = intval(htmlentities($_GET['eday']));
		$emonth = intval(htmlentities($_GET['emonth']));
		$eyear = intval(htmlentities($_GET['eyear']));
		$ehour = intval(htmlentities($_GET['ehour']));
		$emin = intval(htmlentities($_GET['emin']));
		$esec = intval(htmlentities($_GET['esec']));

		//Time is in the format 'YYYY-MM-DD HH:MM:SS'
		if(is_int($sday) && 
			is_int($smonth) &&
			is_int($syear) &&
			is_int($shour) &&
			is_int($smin) &&
			is_int($ssec) &&
			$sday>=1 && $sday<=31 &&
			$smonth>=1 && $smonth<=12 &&
			$shour>=0 && $shour<=24 &&
			$smin>=0 && $smin<=60 &&
			$ssec>=0 && $ssec<=60 &&
			is_int($eday) &&
			is_int($emonth) &&
			is_int($eyear) &&
			is_int($ehour) &&
			is_int($emin) &&
			is_int($esec) &&
			$eday>=1 && $eday<=31 &&
			$emonth>=1 && $emonth<=12 &&
			$ehour>=0 && $ehour<=24 &&
			$emin>=0 && $emin<=60 &&
			$esec>=0 && $esec<=60)
		{
			$startTime = "$syear-$smonth-$sday $shour:$smin:$ssec";
			$endTime = "$eyear-$emonth-$eday $ehour:$emin:$esec";
		}
		else
		{
			$ret = array('status' => 'timeformaterror','args' => $args);
			echo json_encode($ret);
			exit(0);
		}

		$ret = array('status' => 'success', 'args' => $args);
		echo json_encode($ret);
	}
?>
