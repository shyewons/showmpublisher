<?php
	header('Content-Type: text/html; charset=utf-8');

	$host = 'idbinsu.kr';
	$user = 'apidb';
	$pw = 'elql12!';
	$dbName = 'apidb';
	$mysqli = new mysqli($host, $user, $pw, $dbName);
	$mysqli ->set_charset("utf8");

	function query($sql){
		global $mysqli;
		return $mysqli->query($sql);
	}
?>