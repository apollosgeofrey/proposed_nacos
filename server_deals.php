<?php
	//server connection function
	function serverconnector(){
		$servername = "localhost";
		$serverusername = "root";
		$serverpass = "";
		$databasename = "nacos_plasu";
		global $conn;
		$conn = mysqli_connect($servername, $serverusername, $serverpass, $databasename);
	}
?>