<?php
	$servername='localhost';
	$username='root';
	$password='';
	$dbname='banhangonline';
	$conn = new mysqli($servername, $username, $password, $dbname);
	mysqli_set_charset($conn, 'UTF8');
?>