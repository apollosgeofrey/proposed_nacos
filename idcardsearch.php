<?php
ob_start();
	include "header.php";
	include "navigation.php";
	$alertSuccess1 = ""; $alertError = ""; $mat_no_Err=""; $new_email_address_Err=""; $phone_num_Err=""; $gender_Err="";

//get values now for success
	if (isset($_GET['fhsk87698lsklhflk9097sfklsf']) && isset($_GET['khjkhjkhoo89o9io9uhhk8']) && isset($_GET['matno']) && isset($_GET['fullname']) && isset($_GET['gender'])) {
		if (trim($_GET['fhsk87698lsklhflk9097sfklsf']) == "jhksjh89fyskjfi8fyksfsi8" && trim($_GET['khjkhjkhoo89o9io9uhhk8'] == "kdjkduidukju8989hkjh8y98k8")) {
			$matno_get = trim($_GET['matno']);
			$fullname_get = trim($_GET['fullname']);
			$gender_get = trim($_GET['gender']);
			
			$alertSuccess1 = "The Id card for <b>$matno_get</b> is ready for collection!
			<br><br><b>Student's Matriculation Number: &nbsp </b><i><u> $matno_get </u></i><br>
			<b>Student's Full Name: &nbsp </b><i><u> $fullname_get </u></i><br>
			<b>Student's Gender: &nbsp </b><i><u> $gender_get </u></i><br><br>
			<strong>Reach out to the Association Excos' for collection as soon as possible!	</strong>";	
		}
	}

http://localhost/proposed_nacos/idcardsearch.php?fhsk87698lsklhflk9097sfklsf=jhksjh89fyskjfi8fyksfsi8&khjkhjkhoo89o9io9uhhk8=kdjkduidukju8989hkjh8y98k8&matno=plasu/2016/fnas/0211&fullname=Yadang%20solomon%20n.&gender=Male

 // this is where form data are collected and validated.
if ($_SERVER["REQUEST_METHOD"] == "POST") {
     if (isset($conn) && $conn == true && isset($_POST['searchnow'])) {
     	$form_good_state = 1;

//recaptcha back end
      $captcha = "";
      if (isset($_POST['g-recaptcha-response'])) {
        $captcha = $_POST['g-recaptcha-response'];
      } else {
        $captcha = "";
      }
      $secret_key = "6LcdV8kaAAAAAGAHiiZvNe02e9IGQBgULan-qSvU";
      $url = "https://www.google.com/recaptcha/api/siteverify?secret=". urldecode($secret_key) . "&response=" . urldecode($captcha) . " ";
      $responder = file_get_contents($url);
      $responderkey = json_decode($responder, TRUE);
      if ($responderkey["success"] == true) {
        //
      } else {
        $form_good_state = 1;
        echo "<script> alert('Could not verify the Re-captcha'); </script>";
      }

    if ($form_good_state == 1) {
     	$matno = strtoupper(trim(htmlentities(mysqli_real_escape_string($conn, stripslashes($_POST['matno'])))));
     	if ($matno != null && $matno != "" && !empty($matno)) {
     		if (!preg_match("/^[a-zA-Z0-9\/]*$/", $matno)) {
      			$alertError = "Provide a Valid Matriculation Number only. (Example: PLASU/2026/FNAS/0000)";
    			} else {
    				$select_now = "SELECT * FROM idcards WHERE matno = '$matno'";
			     $select_now_run = mysqli_query($conn, $select_now);
			     if ($select_now_run == true) { 
			     	if (mysqli_num_rows($select_now_run) == 1) {
			     		while($rows = mysqli_fetch_assoc($select_now_run)){
			     			$id_id = $rows['id'];
			     			$matno_id = $rows['matno'];
			     			$fname_id = $rows['fname'];
			     			$oname_id = $rows['oname'];
			     			$gender_id = $rows['gender'];
			     			$ready_status_id = $rows['status'];
			     			//$collected_status_id = $rows['collect_status'];

			     			$fullname_id = "$fname_id $oname_id";

			     			if ($ready_status_id == "1") {
			     				header("Location: idcardsearch.php?fhsk87698lsklhflk9097sfklsf=jhksjh89fyskjfi8fyksfsi8&khjkhjkhoo89o9io9uhhk8=kdjkduidukju8989hkjh8y98k8&matno=$matno_id&fullname=$fullname_id&gender=$gender_id");
			     			} else {
			     				$alertError = "The Id card for <b>$matno</b> is not ready for collection!";
			     			}
			     		}
			     	} else {
			     		$alertError = "No record found for <b>$matno</b>";
			     	}
			     } else {
			     	$alertError = "Sorry, We could not Query the Database !";
			     }
    			}	
     	} else {
     		$alertError = "Sorry, your input field can not be empty!";
       	} 
       }else {
		$alertError = "Please pass the Re-captcha test to initiate a search!";
	  }
   } else {
    	$alertError = "Sorry, Connection to the Database Server was not successful !!!";
    }
}
?>	
<div class="container-fluid center-block text-center">
	<?php if ($alertSuccess1 != "") { echo "<br><p class='alert alert-success text-center'> $alertSuccess1 </p>"; $alertSuccess1 = "";} ?>
	<?php if ($alertError != "") { echo "<br><p class='alert alert-danger text-center'> $alertError </p>"; $alertError = "";} ?>

	<form action="idcardsearch.php?fhsk87698lsklhflk9097sfklsf=jhksjh89fyskjfi8fyksfsi8&khjkhjkhoo89o9io9uhhk8=kdjkduidukju8989hkjh8y98k8" method="post" autocomplete="on"><br>
		<fieldset class="jumbotron">
		<label class="alert alert-info" style="width: 100%;">Search for your ID Status</label>
		<input type="text" class="form-control text-center" name="matno" minlength="19" maxlength="20" autofocus="" required="" placeholder="Matriculation Number only. (Example: PLASU/2026/FNAS/0000)" title="provide a valid matriculation number here. (Example: PLASU/2026/FNS/0000)" value="<?php if(isset($_POST['matno'])){ echo $_POST['matno']; } ?>"><br>
		<div class="form-group">
               <div class="g-recaptcha" data-sitekey="6LcdV8kaAAAAAKZLfK6tRSRk6x-HgG1If9rfmo_E"></div>
               <br/>
          </div>
		<input type="submit" name="searchnow" value="Proceed Search" class="btn btn-primary"><br>
		<span><i style="color: red;">Note: ID card are produced for those who paid the session's departmental dues and submitted Bio-data forms.</i></span>

	</fieldset>
	</form>
</div>



	
<?php
	include "footer.php";
	ob_flush();
?>