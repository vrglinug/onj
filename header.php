<?php

/*
* @copyright (c) 2008 Nicolo John Davis and Sarang Bharadwaj
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*/

	//The user name of your database
	$DBUSER = 'dbusername';
	//The password of your database
	$DBPASS = 'dbpass';
	//The name of the database
	$DBNAME = 'judge';

	//The point values of the problems
	//Set it to the values you wish to use
	//The number of elements in this array determines the number of problems
	$points = array(10,25,25,25,50);

	//Start time of the contest in the format 'YYYY-MM-DD HH:MM:SS'
	$startTime = date_create('2009-03-30 16:00:00');

	//End time of the contest 'YYYY-MM-DD HH:MM:SS'
	$endTime = date_create('2009-04-30 17:00:00');

	//Interval between refreshes of the leaderboard (milliseconds)
	$getLeaderInterval = 10000;

	//Interval between refreshes of the chat room (milliseconds)
	$getChatInterval = 1000;

	//This is used to disable PHP error messages
	ini_set('display_errors', false);

	//You can use the variable $running to determine if the contest is running or not
	$time = date_create();
	$running = false;
	if($time >= $startTime && $time <= $endTime)
		$running = true;
?>
