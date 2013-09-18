<div class="navbar navbar-inverse">
<div class="navbar-inner">
<a class="brand" href="index.php">Programming Contest codeMSRIT</a>

<ul class="nav nav-pills pull-right">
<?php
if(!isset($_SESSION['isloggedin']))
{
?>
<li id="menu1"><a href="login.php">Login</a></li>
<li id="menu5"><a href="faq.php">Faq</a></li>
<?php
}
else
{
?>
<li id="menu1"><a href="index.php">Dashboard</a></li>
<li id="menu2"><a href="problem.php">Problems</a></li>
<li id="menu3"><a href="submissions.php">Submissions</a></li>
<li id="menu4"><a href="scores.php">Scoreboard</a></li>
<li id="menu5"><a href="faq.php">Faq</a></li>
<li id="menu6"><a href="chat.php">Chat</a></li>
<li id="menu7"><a href="admin.php">Admin</a></li>
<li id="menu8"><a href="logout.php">Logout</a></li>
<?php
}
?>
</ul>

</div>
</div>
