<?php
	session_start();
	session_regenerate_id();
	header("location: index.php");
?>