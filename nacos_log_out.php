

<?php
include "header.php";

if (isset($_SESSION['mat_no']) || isset($_SESSION['email']) || isset($_SESSION['rank'])) {
	session_destroy();
	header("location:nacos_log_in.php");
} else {
	session_destroy();
	header("location:nacos_log_in.php");
}
?>