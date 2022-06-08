<?php
ob_start();
	include "header.php";
	include "navigation.php";
	//error messages boxes
	$alertSuccess1 = ""; $alertError = ""; $mat_no_Err=""; $email_reset_Err="";

	// this is where i destroy users regular session if it was set
    if (isset($_SESSION['mat_no']) || isset($_SESSION['email']) || isset($_SESSION['rank'])){
      session_destroy();
      $current_url_page = $_SERVER["REQUEST_URI"];
      header("location: $current_url_page");
    }
	 
 // this is where form data are collected and validated.
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['submit'])) {
     if (isset($conn) && $conn == true) {
    		//here form field are collected
    $form_good_state = 1;
   	$mat_no = strtolower(trim(htmlentities(mysqli_real_escape_string($conn, stripslashes($_POST['mat_no'])))));
    $email_reset =  strtolower(trim(htmlentities(mysqli_real_escape_string($conn, stripslashes($_POST['email_reset'])))));

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
      }

        if ($form_good_state == 1) {
        	if ($mat_no != NULL && !empty($mat_no) && filter_var($mat_no, FILTER_SANITIZE_STRING) === $mat_no) {
              if ($email_reset != NULL && !empty($email_reset) && filter_var($email_reset, FILTER_SANITIZE_EMAIL) === $email_reset && filter_var($email_reset, FILTER_VALIDATE_EMAIL) == true) {
              	$query1 = $conn->prepare("SELECT mat_no, email_address, phone_number FROM `nacosites` WHERE mat_no = ? and email_address = ?");
       	        $query1->bind_param('ss', $mat_no, $email_reset);
   	            $query1->execute();
                $queryrun1 = $query1->get_result();
                if ($queryrun1 == true && mysqli_num_rows($queryrun1) === 1) {
	              while ($rows = mysqli_fetch_assoc($queryrun1)) {
                	$db_mat_no = $rows['mat_no'];
                    $db_email_address = $rows['email_address'];
                    $db_phone_number = $rows['phone_number'];

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
                $subject = "Congratulations! Your Passcode Reset With NACOS PLASU CHAPTER was Successful.";
                $db_mat_no_upper = strtoupper($db_mat_no);
                $body = "<b>Good Day <font color='red'> $db_mat_no_upper </font>, Your request for a passcode reset was successful.<br><br> A new system/machine generated passcode for your NACOS PLASU CHAPTER Account is:</b><h3><u> $gen_password </u></h3><b> Use it to login your registered account with NACOS PLASU CHAPTER. Thereafter, proceed for change of password. <br><br> Make sure your password is kept saved and secured. <br><br> We also advise you to delete this message from your email trash box for better protection and security. <br><br> From NACOS PLASU CHAPTER. <br><br> Best Regards !.</b>";

                $replyer = '';
                $status = mailFunction($db_email_address, $subject, $body, $replyer); 

                if ($status == true) {
                    //here data is sent to database !           
                    $update_pass_now = "UPDATE nacosites SET secret_token = '$gen_password' WHERE email_address = '$db_email_address' and mat_no = '$db_mat_no'";
                    $update_pass_now_run = mysqli_query($conn, $update_pass_now);
                    if ($update_pass_now_run == true) { 
                  	  	header("Location: nacos_log_in.php?reset_pass=successfully&reser_mat_client=$db_mat_no&reser_mail_client=$db_email_address");
                    } else {
                    	   $alertError = "Sorry, We could not Query the Database !";
                     }
                } else {
                    $alertError = "Sorry! We Could not Send an Email to $db_email_address.";
                }
                   
                 }
                } else {
                	$alertError = "Wrong Mat. Number and Email Address Combination!... ";
                }
              }  else {
               	$alertError = "Invalid Email Address Entered!... ";
               	$email_reset_Err = "Invalid Email Address Provided!";
              }
          }	else {
             $alertError = "Invalid Matriculation Number, Scroll to Fix it!...";
             $mat_no_Err = "Invalid Mat Number Provided!";
           }
        }
		}	else {
        	$alertError ="Sorry, Connection to the Database Server was not successful !!!";
       }
	}
}

?>	
	<section id="inner-headline">
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<h2 class="pageTitle">Reseting Secret Passcode</h2>
			</div>
		</div>
	</div>
	</section>
	<section id="content">
	<div class="container">
					
					<div class="about">
					
						<div class="row"> 
							<div class="col-md-12">
								<div class="about-logo">
									<h3><span class="color">Reasons for Secret Passcode!</span></h3>
									<p>This will enable us Authenticate and verify your eligibility/licence</p>

								</div>
								<!-- <a href="#" class="btn btn-color">Read more</a> -->  
							</div>
						</div>
						
						<hr>
						
						<div class="row">
							<div class="col-md-12">
								<form id="contact-form" role="form" autocomplete="on" action="<?php echo htmlentities($_SERVER['REQUEST_URI']); ?>" method="post">
									<!-- error and success display !!!. -->
		      <?php if ($alertSuccess1 != "") { echo "<br><p class='alert alert-success text-center'> $alertSuccess1 </p>"; $alertSuccess1 = "";} ?>
		      <?php if ($alertError != "") { echo "<br><p class='alert alert-danger text-center'> $alertError </p>"; $alertError = "";} ?>

									<p class="jumbotron">
										<label>Provide Matriculation Number. </label>
										<input type="text" required="" name="mat_no" placeholder="Eg: PLASU/2050/FNS/1000" class="form-control" value="<?php if(isset($_POST['mat_no'])){echo $_POST['mat_no'];} ?>">
										<?php if($mat_no_Err != ""){ echo "<span style='color: red;'><i>$mat_no_Err</i></span>";} ?>
									</p>
									<p class="jumbotron">
										<label>Registered Email Address. </label>
										<input type="email_reset" required="" name="email_reset" placeholder="Eg: blablabla@nacosplasu.org.ng" class="form-control" value="<?php if(isset($_POST['email_reset'])){echo $_POST['email_reset'];} ?>">
										<?php if($email_reset_Err != ""){ echo "<span style='color: red;'><i>$email_reset_Err</i></span>";} ?>
									</p>

									<p><a href="nacos_log_in.php"><span class="fa fa-sign-in"></span> Log In Dashboard! </a></p>

				                  <div class="col-md-12">
				                        <div class="form-group">
				                            <div class="g-recaptcha" data-sitekey="6LcdV8kaAAAAAKZLfK6tRSRk6x-HgG1If9rfmo_E
"></div>
				                            <br/>
				                        </div>
				                  </div>

									<input type="submit" name="submit" value="Reset Secret Token" class="form-control btn btn-success">
								</form>
							</div>
						</div>
					</div>				
				</div>
	</section>
<?php
	include "footer.php";
	ob_flush();
?>