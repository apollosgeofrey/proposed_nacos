<?php
ob_start();
	include "header.php";
	//require "session_checker.php";
	include "navigation.php";
	$alertSuccess1 = ""; $alertError = ""; $mat_no_Err=""; $new_email_address_Err=""; $phone_num_Err=""; $gender_Err="";

 // this is where form data are collected and validated.
if ($_SERVER["REQUEST_METHOD"] == "POST") {
     if (isset($conn) && $conn == true && isset($_POST['send'])) {
     	$form_good_state = 1;

     	$matno = strtoupper(trim(htmlentities(mysqli_real_escape_string($conn, stripslashes($_POST['matno'])))));
     	$fname =  ucwords(trim(htmlentities(mysqli_real_escape_string($conn, stripslashes($_POST['fname'])))));
     	$onames =  ucwords(trim(htmlentities(mysqli_real_escape_string($conn, stripslashes($_POST['onames'])))));
     	$gender =  ucwords(trim(htmlentities(mysqli_real_escape_string($conn, stripslashes($_POST['gender'])))));


        $insert_now = "INSERT INTO idcards(matno, fname, oname, gender, status) VALUES ('$matno', '$fname', '$onames', '$gender', '1')";
                    
        $insert_now_run = mysqli_query($conn, $insert_now);
        if ($insert_now_run == true) {
        	echo "<script>alert('Successfully We added to the Database !')</script>";
			echo "<script>window.location.href='idcard.php'</script>";
        } else {
        	echo "<script>alert('Sorry, We could not Query the Database !')</script>";
        }
     } else {
     	echo "<script>alert('Sorry, Connection to the Database Server was not successful !!!')</script>";
     }

}
?>	
<section class="" style=" width: 60%; margin: auto;">
<div class="center-block text-center ">
	<form action="idcard.php" method="post" autocomplete="on"><br><br>
		<label>Matric. No.</label>
		<input type="text" name="matno" autofocus="" required="" placeholder="mat no" class="form-control"><br><br>
		<label>First Name</label>
		<input type="text" name="fname" required="" placeholder="F name" class="form-control"><br><br>
		<label>Other Names</label>
		<input type="text" name="onames" required="" placeholder="O names" class="form-control"><br><br>
		<label>Gender</label>
		<select name="gender" required="" placeholder="gender" class="form-control">
			<option value=""></option>
			<option value="Male">Male</option>
			<option value="Female">Female</option>
		</select><br><br>
	

		<input type="submit" name="send" value="Send"><br><br><br>
	</form>
</div>
</section>



	
<?php
	include "footer.php";
	ob_flush();
?>