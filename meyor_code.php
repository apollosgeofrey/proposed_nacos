<?php
ob_start();
	include "header.php";
	include "navigation.php";

	require "session_checker.php";
?>	
	<!-- modal start profile Editing -->
<div class="modal fade" id="popUpWindow">
		<div class="modal-dialog	">
			<div class="modal-content">

				<!-- header -->
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h2 class="modal-title">Edit Profile</h2>
				</div>

				<!-- body -->
				<div class="modal-body">
					<form role="form" method="POST" action="" enctype="multipart/form-data">
							<div class="form-group">passport

							<input type="file" name="postimage" class="form-control" type="file"> 
							</div>
						<div class="form-group"> <label> Surname</label>
							<input type="text" name="sn" class="form-control" value="<? echo $db_surname;?>" required="" >
						</div>

						<div class="form-group"><label>othernames</label>
							<input type="text" name="otn" class="form-control" value="<? echo $db_othernames;?>"required="">
						</div><div class="form-group"> <label>phone_no</label>
							<input type="number" name="phn" class="form-control" value="<? echo $db_phone_number;?>"required="">
						</div><div class="form-group"> <label>Interest</label>
							<input type="text" name="inte" class="form-control" value="<? echo $db_Interested_skills;?>"required="">
						</div><div class="form-group"><label>Marital_status</label>
							<input type="text" name="ms" class="form-control" value="<? echo $db_marital_status;?>"required="">
						</div><div class="form-group"><label>Graduate</label>
							<input type="text" name="gd" class="form-control" value="<? echo $db_graduation_status;?>"required="">
						</div><div class="form-group"><labe>Residential</labe>
							<input type="text" required="" name="rd"class="form-control" value="<? echo $db_my_res_address;?>">
						</div><div class="form-group"><label> About_me</label>
						<textarea type="text" required="" class="form-control" name="about"><? echo $db_about_me;?></textarea>
						</div>
						<center>
						<input type="submit" name="update" class="btn btn-primary"> 
						</center>
					</form>
				</div>

				<!-- footer -->
				<div class="modal-footer">
		 <button class="btn btn-danger" data-dismiss="modal">Close</button>
				</div>
				
			</div>
			
		</div>
		
	</div>

<!-- end of Modal -->



<div class="modal fade" id="opUpWindow">
		<div class="modal-dialog	">
			<div class="modal-content">

				<!-- header -->
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h2 class="modal-title">CHANG PASSWORD</h2>
				</div>

				<!-- body -->
				<div class="modal-body">
					<form role="form" action="	" method="POST">


						<div class="form-group"> <label> Previous Password</label>
							<input type="Password" id="pass" required="" name="pass" class="form-control"require >
						</div>

						<div class="form-group"><label>New Password</label>
							<input type="text" required="" id="Npass" name="Npass" class="form-control" >
						</div>
						<div class="form-group"> <label>Re enter</label>
							<input type="text"required="" id="RNpass" name="RNpass" class="form-control">
						</div>
						<center>
						<button type="submit" name="updatep" class="btn btn-primary"> Update</button> 
						</center>
					</form>
				</div>

				<!-- footer -->
				<div class="modal-footer">
		 <button class="btn btn-danger" data-dismiss="modal">Close</button>
				</div>
				
			</div>
			
		</div>
		
	</div>

	<section id="inner-headline">
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<h2 class="pageTitle">My DAshboard</h2>
			</div>
		</div>
	</div>
	</section>
	<section id="content">

		<a id="user"></a> 
	<div class="container">


<center>

          
               <a id="success"></a>
               <?php if (!empty($db_passport_img)) {
      echo '<img id ="lk"class="img-fluid rounded"style="width: 30%; height: 30%;border-radius: 30%; " src="uploads/'.$db_passport_img.'"';
      }else{
 echo '<img id ="lk" onclick="zoomout()" dbonclick="zoomin()" class="img-fluid rounded" style="width: 30%; height: 30%;border-radius: 30%; " src="img/logo/nacos_logo_black.jpg"';
}

 ?>
           <br>

		
	<br><p style="font-size: 110%; "><strong>
	<?php echo $db_surname . " " . $db_othernames;  ?>, Welcome to Your Dashboard &nbsp;<a href="#edit">Edit</a> </strong></p>

<?

	if (isset($_POST['updatep'])) {

	$pass=$_POST['pass'];
	
	$Npass=htmlentities(mysqli_real_escape_string($conn, stripslashes($_POST['Npass'])));
	$RNpass=$_POST['RNpass'];
	$id=$db_id;
if ($pass== $db_secret_token ) {


	if ($Npass==$RNpass) {

		$sql =$conn->prepare( "UPDATE nacosites SET secret_token =? WHERE id=?");
	$sql->bind_param('si',$Npass,$id);
	$sql->execute();
	if ($sql==True) {

			echo "<script> alert('Password successfully updated'), document.location='upcoming.php#success'  </script>";
		
		echo "<div class='btn btn-success'>Password successfully updated</div>";
		
		
	}
		
	}else{
		echo "<script> alert('Sorry, passwords Not matched'), document.location='upcoming.php#success'  </script>";
		echo "<div class='btn btn-danger'>Sorry, passwords Not matched</div>";
	}
}else {
	echo "<script> alert('Sorry, wrong Previous password'), document.location='upcoming.php#edit'  </script>";
	echo "<div class='btn btn-danger'>Sorry, wrong Previous password</div>";

	}	
}

$id=$db_id;

if (isset($_POST['update'])) {
 $imgfile=$_FILES["postimage"]["name"];
// get the image extension
$extension = substr($imgfile,strlen($imgfile)-4,strlen($imgfile));
// allowed extensions
$allowed_extensions = array(".jpg","jpeg",".png",".gif");

	$surname=htmlentities(mysqli_real_escape_string($conn, stripslashes($_POST['sn'])));

	$othernames=htmlentities(mysqli_real_escape_string($conn, stripslashes($_POST['otn'])));

	$phn=htmlentities(mysqli_real_escape_string($conn, stripslashes($_POST['phn'])));

	$interest=htmlentities(mysqli_real_escape_string($conn, stripslashes($_POST['inte'])));
	$married=htmlentities(mysqli_real_escape_string($conn, stripslashes($_POST['ms'])));	
	$certified=htmlentities(mysqli_real_escape_string($conn, stripslashes($_POST['gd'])));
	$adress=htmlentities(mysqli_real_escape_string($conn, stripslashes($_POST['rd'])));
	$about=htmlentities(mysqli_real_escape_string($conn, stripslashes($_POST['about'])));

	// checking image
if (!empty($imgfile)) {
$sql=$conn->prepare("UPDATE nacosites SET surname= ?, othernames = ?, phone_number = ?,Interested_skills = ?,marital_status = ?, about_me = ?, passport_img = ?, graduation_status = ?, my_res_address =? WHERE  id = ?");
$sql->bind_param('sssssssssi',$surname,$othernames,$phn,$interest,$married,$about,$imgfile,$certified,$adress,$id);
$sql->execute();
if ($sql == TRUE) {
	move_uploaded_file($_FILES["postimage"]["tmp_name"],"uploads/".$imgfile);
    echo "<script> alert('Profile Successfully updated'), document.location='upcoming.php#success'  </script>";
		
		echo "<div class='btn btn-success'>Profile Successfully updated</div>";
} else {
  echo "<script> alert('Couldn`t Update Profile'), document.location='upcoming.php#edit'  </script>";
	echo "<div class='btn btn-danger'>Couldn`t Update Profile</div>";
}
}
$sql=$conn->prepare("UPDATE nacosites SET surname= ?, othernames = ?, phone_number = ?,Interested_skills = ?,marital_status = ?, about_me = ?, graduation_status = ?, my_res_address =? WHERE  id = ?");
$sql->bind_param('ssssssssi',$surname,$othernames,$phn,$interest,$married,$about,$certified,$adress,$id);
$sql->execute();
if ($sql == TRUE) {
	// move_uploaded_file($_FILES["postimage"]["tmp_name"],"uploads/".$imgfile);
    echo "<script> alert('Profile Successfully updated'), document.location='upcoming.php#success'  </script>";
		
		echo "<div class='btn btn-success'>Profile Successfully updated</div>";
} else {
  echo "<script> alert('Couldn`t Update Profile'), document.location='upcoming.php#edit'  </script>";
	echo "<div class='btn btn-danger'>Couldn`t Update Profile</div>";
}
}
?>



</center><br>
		<div class="alert alert-success" role="alert" style="font-size: 110%;">
		<p>

<?php

echo "Matriculation Number: &nbsp &nbsp <input type='text' name='' value='$db_mat_no' disabled='' class='form-control'> <hr>" ;

echo "Email Address: &nbsp &nbsp <input type='text' name='' value='$db_email_address' disabled='' class='form-control'> <hr>" ;


echo "Phone Number: &nbsp &nbsp  <input type='number' name='' value='$db_phone_number' disabled='' class='form-control'> <hr>" ;


echo "Account Lisenced by__: &nbsp &nbsp  <input type='text' name='' value='$db_lisenced_by' disabled='' class='form-control'> <hr>" ;

echo "Interested Skill: &nbsp &nbsp <input type='text' name='' value='$db_Interested_skills' disabled='' class='form-control'> <hr>" ;

echo "Marital Status: &nbsp &nbsp <input type='text' name='' value='$db_marital_status' disabled='' class='form-control'> <hr>" ;

echo "About Me (Bio): &nbsp &nbsp <textarea name='' value='$$db_about_me' disabled='' class='form-control'> $db_about_me </textarea> <hr>";

echo "Graduation Status: &nbsp &nbsp <select disabled='' class='form-control' name=''><option selected>$db_graduation_status </option> <hr>";

?>


		</p>
		</div>
	

		
		<button data-toggle="modal" data-target="#popUpWindow"  style="font-size: 120%; text-align: center;" style="margin-top: 3%;" class="btn btn-success btn-lg">
		Edit profile<a id="edit"></a> </button>

	<button data-toggle="modal" data-target="#opUpWindow" style="font-size: 120%; text-align: center;" style="margin-top: 3%;" class="btn btn-success btn-lg" >Change Password</button>
		<br><br>
									
				</div>
	</section>


	
<?php
	include "footer.php";
	ob_flush();
?>
