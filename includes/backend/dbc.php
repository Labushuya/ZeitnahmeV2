<?php
	//	Binde Config ein
	include_once 'config.php';
	
	$mysqli = new mysqli(HOST, USER, PASSWORD, DATABASE);
	
	//	Stelle DB Verbindung auf UTF-8
	mysqli_query($mysqli, "SET NAMES 'utf8'");
?>