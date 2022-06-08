<?php
ob_start();
	include "header.php";
	include "navigation.php";
	$alertSuccess1 = ""; $alertError = ""; $mat_no_Err=""; $new_email_address_Err=""; $phone_num_Err=""; $gender_Err=""; $recaptche_Err="";

	if (isset($_GET['adder_mem']) && isset($_GET['mat_client']) && isset($_GET['mail_client'])) {
		if ($_GET['adder_mem'] == 'successfully') {
			$mat_client_get = htmlentities($_GET['mat_client']);
			$mail_client_get = htmlentities($_GET['mail_client']);
			$alertSuccess1 = "The NACOS Member with <a href=''><b> $mat_client_get</b></a> and <a href='#'><b>$mail_client_get</b></a> was added and sent a verification email only if it exist!";
		}
	}

 // this is where form data are collected and validated.
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (isset($_POST['add_nacossite'])) {
     if (isset($conn) && $conn == true) {
     	$form_good_state = 1;

     	$mat_no = strtolower(trim(htmlentities(mysqli_real_escape_string($conn, stripslashes($_POST['mat_no'])))));
     	$new_email_address =  strtolower(trim(htmlentities(mysqli_real_escape_string($conn, stripslashes($_POST['new_email_address'])))));
     	$phone_num =  strtolower(trim(htmlentities(mysqli_real_escape_string($conn, stripslashes($_POST['phone_num'])))));
     	$gender =  trim(htmlentities(mysqli_real_escape_string($conn, stripslashes($_POST['new_gender']))));


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
	        $form_good_state = 0;
	        echo "<script> alert('Could not verify the Re-captcha'); </script>";
	        $recaptche_Err = "Please pass the Re-captcha test to initiate registration!";
	      }


     	// for sname validation
        if ($mat_no != null && !empty($mat_no)) {
        	//checking mat_num on DBase
            $queryCheckMat = "SELECT mat_no FROM nacosites WHERE mat_no = '$mat_no'";
            $queryCheckMatRun = mysqli_query($conn, $queryCheckMat);
            if ($queryCheckMatRun == true and mysqli_num_rows($queryCheckMatRun) >= 1) {
                  $form_good_state = 0;
                  $mat_no_Err = "Error, This Matriculation Number has been Registered.";
              }
        } else {
          $mat_no_Err = "Invalid Matriculation Number Provided!";
          $form_good_state = 0;
        }

         // for email validation
        if ($new_email_address != null && !empty($new_email_address) && filter_var($new_email_address, FILTER_SANITIZE_EMAIL) === $new_email_address) {
        	if (filter_var($new_email_address, FILTER_VALIDATE_EMAIL)) {
	          //checking email on DBase
	            $queryCheckMail = "SELECT email_address FROM nacosites WHERE email_address = '$new_email_address'";
	            $queryCheckMailRun = mysqli_query($conn, $queryCheckMail);
	            if ($queryCheckMailRun == true and mysqli_num_rows($queryCheckMailRun) >= 1) {
	                  $form_good_state = 0;
	                  $new_email_address_Err = "Error, This email has been Registered.";
	              }
	        } else {
                $form_good_state = 0;
                $new_email_address_Err = "Invalid email format !";
            }
        } else {
          $new_email_address_Err = "Invalid Email Entered !";
          $form_good_state = 0;
        }


     // for phonenumber validation
      	if ($phone_num != null && !empty($phone_num) && filter_var($phone_num, FILTER_SANITIZE_NUMBER_INT) === $phone_num) {
           //checking phone_num on DBase
            $queryCheckPhone = "SELECT phone_number FROM nacosites WHERE phone_number = '$phone_num'";
            $queryCheckPhoneRun = mysqli_query($conn, $queryCheckPhone);
            if ($queryCheckPhoneRun == true and mysqli_num_rows($queryCheckPhoneRun) >= 1) {
                  $form_good_state = 0;
                  $phone_num_Err = "Error, This Phone Number has been Registered.";
              }
     	} else {
        	$form_good_state = 0;
        	$phone_num_Err = "Invalid Mobile Phone Number Provided ! ";
    	}

 // for gender validation
        if ($gender != null && !empty($gender) && filter_var($gender, FILTER_SANITIZE_STRING) === $gender) {
            if ($gender == "Male" || $gender == "Female") {

            } else {
                $form_good_state = 0;
                $gender_Err = "Invalid Gender Specification Provided ! ";
            }
        } else {
        	$form_good_state = 0;
            $gender_Err = "Invalid Gender Selected!";
        }
     
//here the final verification and insertion is executed
        if ($mat_no != null && !empty($mat_no) && $new_email_address != null && !empty($new_email_address) && $phone_num != null && !empty($phone_num) && $gender != null && !empty($gender) && $form_good_state == 1) {
					 $daters = strval(date("Y-m-d (l)"));
	                 $timers = strval(date("h:i:s a"));
	                 $joindate_time = $daters . "  " . $timers;
	                 $password = rand(10000000, 10000000000);
	                 $decider = rand(0,3);
	                 if ($decider == 0) {
	                    $gen_password = 'plasu'.$password.'nacos'; 
	                 } else if ($decider == 1) {
	                    $gen_password = 'nacos'.$password.'plasu'; 
	                 } else if ($decider == 2){
	                    $gen_password = 'plasu'.$password.'chapter'; 
	                 } else if ($decider == 3){
	                     $gen_password = 'chapter'.$password.'nacos'; 
	                 }

	                 //mail sender
                require "PHPMailer/emailer.php";
                $subject = "Congratulations! Your Account with NACOS PLASU CHAPTER was Successfully created.";
                $mat_no_upper = strtoupper($mat_no);
                $body = "<b>Good Day <font color='red'> $mat_no_upper </font>, Your Account with NACOS PLASU CHAPTER was successfully created.<br><br> A new system/machine generated passcode for your new NACOS PLASU CHAPTER Account is:</b><h3><u> $gen_password </u></h3><b> Use it to login your registered account with NACOS PLASU CHAPTER. Thereafter, proceed for change of password. <br><br> Make sure your password is kept saved and secured. <br><br> We also advise you to delete this message from your email trash box for better protection and security. <br><br> From NACOS PLASU CHAPTER. <br><br> Best Regards !.</b>";

                $replyer = '';
                $status = mailFunction($new_email_address, $subject, $body, $replyer); 

                if ($status == true) {
                    //here data is sent to database !  
                    $lisenced_by_mat = "Self Registeration";
                	

                    $update_pass_now = "INSERT INTO nacosites(mat_no, email_address, mobile_country_code, phone_number, secret_token, lisenced_by, date_time_of_registration, activation_status, rank, gender) VALUES ('$mat_no', '$new_email_address', '+234', '$phone_num', '$gen_password', '$lisenced_by_mat', '$joindate_time', '1', '1', '$gender')";
                    
                    $update_pass_now_run = mysqli_query($conn, $update_pass_now);
                    if ($update_pass_now_run == true) { 
                  	  	header("Location: register_self.php?adder_mem=successfully&mat_client=$mat_no&mail_client=$new_email_address");
                    } else {
                    	   $alertError = "Sorry, We could not Query the Database ! "; 
                     }
                } else {
                    $alertError = "Sorry! We Could not Send an Email to $new_email_address.";
                }

        } else {
            $alertError = "Invalid Form Fields Data Were Provided. See Errors and Fix them!";
        }

     } else {
        	$alertError ="Sorry, Connection to the Database Server was not successful !!!";
     }
  }
}
?>	
	<!-- modal start -->
<div class="modal fade" id="popUpWindow">
		<div class="modal-dialog	">
			<div class="modal-content">

				<!-- header -->
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h2 class="modal-title">PLASU NACOSITE Registration Modal</h2>
				</div>

				<!-- body -->
				<div class="modal-body">
					<form role="form" method="post" action="<?php echo htmlentities($_SERVER['REQUEST_URI']); ?>">
						<div class="form-group"> <label>Matric Number.</label>
							<input type="text" name="mat_no" required="" placeholder="Provide a Valid PLASU Matric No." value="<?php if(isset($_POST['mat_no'])) { echo $_POST['mat_no']; } ?>" class="form-control">
							<?php if($mat_no_Err != ""){ echo "<span style='color: red;'><i>$mat_no_Err</i></span>";} ?>
						</div>

						<div class="form-group"> <label>Valid Email Address:</label>
							<input type="email" name="new_email_address" required="" placeholder="Provide a valid Email Address!" value="<?php if(isset($_POST['new_email_address'])) { echo $_POST['new_email_address']; } ?>" class="form-control">
							<?php if($new_email_address_Err != ""){ echo "<span style='color: red;'><i>$new_email_address_Err</i></span>";} ?>
						</div>

						<div class="form-group"> <label>Phone Number:</label>
							<input type="number" name="phone_num" required="" placeholder="Provide registered Mobile Phone Number!" value="<?php if(isset($_POST['phone_num'])) { echo $_POST['phone_num']; } ?>" class="form-control">
							<?php if($phone_num_Err != ""){ echo "<span style='color: red;'><i>$phone_num_Err</i></span>";} ?>
						</div>

						<div class="form-group"> <label>Gender:</label><br>
							<select class="form-control" name="new_gender">
								<option value="None Selected">None Selected</option>
								<option value="Male">Male?</option>
								<option value="Female">Female?</option>
							</select>
							<?php if($gender_Err != ""){ echo "<span style='color: red;'><i>$gender_Err</i></span>";} ?>
						</div>
						
						<div class="form-group">
                            <div class="g-recaptcha" data-sitekey="6LcdV8kaAAAAAKZLfK6tRSRk6x-HgG1If9rfmo_E"></div>
                            <br/>
                            <?php if($recaptche_Err != ""){ echo "<span style='color: red;'><i>$recaptche_Err</i></span>";} ?>
                        </div><br>

                        <p><a href="nacos_log_in.php"><span class="fa fa-sign-in"></span> Already Registered? Login Now. </a></p>
						<div class="form-group">
							<input type="submit" name="add_nacossite" class="btn btn-success form-control">
						</div>

					</form>
				</div>

				<!-- footer -->
				<div class="modal-footer"></div>
				
			</div>
			
		</div>
		
	</div>

<!-- end of Modal -->

	<section id="inner-headline">
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<h2 class="pageTitle">Registration Dashboard</h2>
			</div>
		</div>
	</div>
	</section>


<section id="content">
	<div class="container">
		<!-- error and success display !!!. -->
		      <?php if ($alertSuccess1 != "") { echo "<br><p class='alert alert-success text-center'> $alertSuccess1 </p>"; $alertSuccess1 = "";} ?>
		      <?php if ($alertError != "") { echo "<br><p class='alert alert-danger text-center'> $alertError </p>"; $alertError = "";} ?>
		      <?php if($mat_no_Err != ""){ echo "<span style='color: red;'><i> <br>-$mat_no_Err</i></span>";} ?>
		      <?php if($new_email_address_Err != ""){ echo "<span style='color: red;'><i> <br>-$new_email_address_Err</i></span>";} ?>
		      <?php if($phone_num_Err != ""){ echo "<span style='color: red;'><i> <br>-$phone_num_Err</i></span>";} ?>
		      <?php if($gender_Err != ""){ echo "<span style='color: red;'><i> <br>-$gender_Err</i></span>";} ?>
		      <?php if($recaptche_Err != ""){ echo "<span style='color: red;'><i> <br>-$recaptche_Err</i></span>";} ?>

		<h4 class="alert alert-success"><strong><center>
			Welcome to PLASU NACOS Registration Board!
		</center></strong></h4><br>
		
		<div class="alert alert-danger"><i><strong><u>Note:</u></strong> Before proceeding for registration, make sure you have a <b><u title="your can create one with Gmail by visiting https://www.gmail.com">valid and active Email Address</u></b> alongside your <b><u title="The System does not permit two existing accounts with same matriculation identity number.">Matriculation Number correctly Entered</u></b> as the System is supper <b>sensitive</b> in dictecting/restricting fake and false Registrations</div>
		

		<button data-toggle="modal" data-target="#popUpWindow" class="btn btn-success btn-md col-xs-10">
			Proceed for Membership Regitration Now
		</button><br><br><br>
		<p><a href="nacos_log_in.php"><span class="fa fa-sign-in"></span> Already Registered? Login Now. </a></p>

		<table type="table" border="4px solid"><br><br>
	        <img src="img/logo/nacos_logo_white.jpg" width="20%" height="20%" style="border-radius:5px;">	
		</table>	

	</div>
</section><br>


	
<?php
	include "footer.php";
	ob_flush();
?>