<?php
ob_start();
session_start();

function loggedin()
{
	if(isset($_SESSION['username']) && !empty($_SESSION['username']))
	return true;
	else return false;
}
?>