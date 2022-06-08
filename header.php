<!DOCTYPE html>
<html lang="en">
<?php
	session_start();
	//error_reporting(0);
	date_default_timezone_set('Africa/Lagos');
	$ip_address = trim($_SERVER['REMOTE_ADDR']);

	//this is where we validate and filter the IPaddress of users
	if (!filter_var($ip_address, FILTER_VALIDATE_IP)) {
	session_destroy();
	die("<h4><p><br><br> <center style='color: red;'> <h3>Oops....!</h3> <b>Access Denied:</b> <i>NACOSITE'S identity looks suspicious!</i> </center> </p></h4>");
	}

	 require "server_deals.php";
	 serverconnector();

	 //$master_admin_email = "apollosgeofrey@gmail.com";
	 //$master_admin_phone_number = "+2348095635395";
?>

<head>
	<meta charset="utf-8">
	<title>NACOS PLASU CHAPTER</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<meta name="description" content="NACOS PLASU CHAPTER, PLATEAU STATE UNIVERSITY, BOKKOS" />
	<meta name="author" content="PLATEAU STATE UNIVERSITY'S NACOS CHAPTER!" />
	<meta name="keywords" content="NACOS PLASU CHAPTER, NIGERIA ASSOCIATION OF COMPUTING STUDENTS, PLASU CHAPTER !!!." />
	<!-- css -->
	
	<!-- this is for recaptcha-->
	<script src="https://www.google.com/recaptcha/api.js" async defer></script>

	<link href="css/fancybox/jquery.fancybox.css" rel="stylesheet">
	<link href="css/jcarousel.css" rel="stylesheet" />
	<link href="css/flexslider.css" rel="stylesheet" />
	<link href="js/owl-carousel/owl.carousel.css" rel="stylesheet"> 
	<link href="css/style.css" rel="stylesheet" />
	<link rel="stylesheet" href="css/bootstrap.min.css">
  	<link rel="stylesheet" href="font-awesome/4.5.0/css/font-awesome.min.css" />


 <link rel="apple-touch-icon" sizes="57x57" href="img/favicon/apple-icon-57x57.png">
<link rel="apple-touch-icon" sizes="60x60" href="img/favicon/apple-icon-60x60.png">
<link rel="apple-touch-icon" sizes="72x72" href="img/favicon/apple-icon-72x72.png">
<link rel="apple-touch-icon" sizes="76x76" href="img/favicon/apple-icon-76x76.png">
<link rel="apple-touch-icon" sizes="114x114" href="img/favicon/apple-icon-114x114.png">
<link rel="apple-touch-icon" sizes="120x120" href="img/favicon/apple-icon-120x120.png">
<link rel="apple-touch-icon" sizes="144x144" href="img/favicon/apple-icon-144x144.png">
<link rel="apple-touch-icon" sizes="152x152" href="img/favicon/apple-icon-152x152.png">
<link rel="apple-touch-icon" sizes="180x180" href="img/favicon/apple-icon-180x180.png">
<link rel="icon" type="image/png" sizes="192x192"  href="img/favicon/android-icon-192x192.png">
<link rel="icon" type="image/png" sizes="32x32" href="img/favicon/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="96x96" href="img/favicon/favicon-96x96.png">
<link rel="icon" type="image/png" sizes="16x16" href="img/favicon/favicon-16x16n.png">
<link rel="manifest" href="img/favicon/manifest.json">
<meta name="msapplication-TileColor" content="#ffffff">
<meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
<meta name="theme-color" content="#ffffff">

</head>