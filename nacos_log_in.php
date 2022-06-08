<?php
ob_start();
	include "header.php";
	include "navigation.php";
	//error messages boxes
	$alertSuccess1 = ""; $alertError = ""; $mat_ema_phnErr = "";  $secrettokenErr = "";

	// this is where i destroy users regular session if it was set
    if (isset($_SESSION['mat_no']) || isset($_SESSION['email']) || isset($_SESSION['rank'])){
      session_destroy();
      $current_url_page = $_SERVER["REQUEST_URI"];
      header("location: $current_url_page");
    }

    
    //this password reset success message
    if (isset($_GET['reset_pass']) && isset($_GET['reser_mat_client']) && isset($_GET['reser_mail_client'])) {
    	if ($_GET['reset_pass'] == "successfully") {
        $reser_mat_client = htmlentities($_GET['reser_mat_client']);
        $reser_mail_client = htmlentities($_GET['reser_mail_client']);
    		$alertSuccess1 = "<b>Your passcode for <a href='#'>$reser_mat_client</a> has been reset successful<br> visit the email address <a href=''>$reser_mail_client</a>, get details login!</b>";

    	}
    }
  
 // this is where form data are collected and validated.
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['submit'])) {
     if (isset($conn) && $conn == true) {
    		//here form field are collected
    $form_good_state = 1;
   	$mat_ema_phn = strtolower(trim(htmlentities(mysqli_real_escape_string($conn, stripslashes($_POST['mat_ema_phn'])))));
    $secret_token =  trim(htmlentities(mysqli_real_escape_string($conn, stripslashes($_POST['secrettoken']))));
    	


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
     if ($mat_ema_phn != NULL && !empty($mat_ema_phn) && filter_var($mat_ema_phn, FILTER_SANITIZE_STRING) === $mat_ema_phn) {
              if ($secret_token != NULL && !empty($secret_token) && filter_var($secret_token, FILTER_SANITIZE_STRING) === $secret_token) {
           		$query1 = $conn->prepare("SELECT mat_no, email_address, phone_number, secret_token, rank, activation_status, reasons_for_disabling, lisenced_by FROM `nacosites` WHERE mat_no = ? or email_address = ? or phone_number = ?");
       	        $query1->bind_param('sss', $mat_ema_phn, $mat_ema_phn, $mat_ema_phn);
   	            $query1->execute();
                $queryrun1 = $query1->get_result();
                if ($queryrun1 == true && mysqli_num_rows($queryrun1) === 1) {
                    while ($rows = mysqli_fetch_assoc($queryrun1)) {
                      $mat_no = $rows['mat_no'];
                      $email_address = $rows['email_address'];
                      $phone_number = $rows['phone_number'];
                      $secret_token_db = $rows['secret_token'];
                      $rank = $rows['rank'];
                      $activation_disabled_status = $rows['activation_status'];
                      $reasons_for_disabling = $rows['reasons_for_disabling'];
                      $lisenced_by = $rows['lisenced_by'];
                      if ($secret_token_db === $secret_token) {
                         if ($activation_disabled_status === "1") {
                         	//here i continue
                        	$_SESSION['mat_no'] = $mat_no;
                        	$_SESSION['email'] = $email_address;
                        	$_SESSION['rank'] = $rank;
                        	$_SESSION['phone_number'] = $phone_number;
                          	header("location: index.php");
                          } else if ($activation_disabled_status != 1) {
                          	$alertError = "Sorry, The Dashboard for $mat_no is Disabled. <a href='contact.php'>Contact NACOS PLASU</a> if neccessary. <br> $reasons_for_disabling"; 
                          }
                      } else {
                      	$alertError = "Wrong Mat.NO., Email or Phone Number and Secret Token Combination !!!.";
                      	$secrettokenErr = "Values Mis-Matched!";
	                	$mat_ema_phnErr = "Values Mis-Matched!";
                      }
                    }
                } else {
                	$alertError = "Wrong Mat. No., Email or Phone Number and Secret Token Combination !!!. ";
                	$secrettokenErr = "Values Mis-Matched!";
                	$mat_ema_phnErr = "Values Mis-Matched!";
                }
              } else {
               	$alertError = "Invalid Secret Key/Token !!!. ";
               	$secrettokenErr = "Invalid Secret Token Provided!";
              }
           } else {
             $alertError = "Invalid Matriculation Number, Email or Phone_Number !!!. ";
             $mat_ema_phnErr = "Invalid Mat No., Email or phone Provided!";
           }
         }
       } else {
        	$alertError ="Sorry, Connection to the Database Server was not successful !!!";
       }
    }
}
?>	
	<section id="inner-headline">
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<h2 class="pageTitle">Member Log-In Portal</h2>
			</div>
		</div>
	</div>
	</section>
	<section id="content">
	<div class="container">
					
					<div class="about">
						<div class="row"> 
							<div class="col-md-12">
									<h3><span class="color">Reasons for Secret Passcode!</span></h3>
									<p>This will enable us Authenticate and verify your eligibility/licence</p>
							</div>
						</div>
			

<!-- this will help me maintain previous selected values by user! -->
    <?php $mat_val = ""; $email_val = ""; $phone_val = ""; $default_val = "";
       if ($_SERVER["REQUEST_METHOD"] == "POST") {
         if (isset($_POST['submit'])){
             $field_options = $_POST['field_to_show'];
             switch ($field_options) { case "Matriculation Number": $mat_val="selected"; $email_val=""; $phone_val=""; $default_val=""; break;
                  case "Email Address":  $mat_val=""; $email_val="selected"; $phone_val=""; $default_val = ""; break;
                  case "Mobile Phone Number": $mat_val=""; $email_val=""; $phone_val="selected"; $default_val=""; break;
               	  default: $default_val="selected"; $mat_val=""; $phone_val=""; $email_val=""; break; }}} 
    ?>

<!-- this javascript code determine which filed to be shown -->
<script type="text/javascript">
	function field_to_show_now(){
		var id_selected = document.getElementById('field_to_show').value;
		if (id_selected == "Matriculation Number") {
			$.post("misellinous_funtions.php", {mat_f: 'mat_f'},
		    function(data, status){
		    	document.getElementById('field_to_show_now_display').innerHTML=data; });
		} else if (id_selected == "Email Address") {
			$.post("misellinous_funtions.php", { email_f: 'email_f' },
		    function(data, status){	document.getElementById('field_to_show_now_display').innerHTML=data; });
		} else if (id_selected == "Mobile Phone Number") {
			$.post("misellinous_funtions.php", { phone_f: 'phone_f'},
		    function(data, status){	document.getElementById('field_to_show_now_display').innerHTML=data; });		
		} else {
			document.getElementById('field_to_show_now_display').innerHTML = "";
		}
	}

</script>


						<div class="row">
							<div class="col-md-12">
								<form id="contact-form" role="form" autocomplete="on" action="<?php echo htmlentities($_SERVER['REQUEST_URI']); ?>" method="post">
									 <!-- error and success display !!!. -->
		      <?php if ($alertSuccess1 != "") { echo "<br><p class='alert alert-success text-center'> $alertSuccess1 </p>"; $alertSuccess1 = "";} ?>
		      <?php if ($alertError != "") { echo "<br><p class='alert alert-danger text-center'> $alertError </p>"; $alertError = "";} ?>

 	      						<p class="jumbotron has-feedback">
								  <label>Select a Login Option. <font color="red">*</font></label>
								  <select class="form-control" onchange="field_to_show_now()" onmouseover="field_to_show_now()" id="field_to_show" name="field_to_show" autofocus>
											<option value="None selected yet" <?php echo $default_val; ?>>None selected yet</option>
											<option value="Matriculation Number" <?php echo $mat_val; ?>>Matriculation Number</option>
											<option value="Email Address" <?php echo $email_val; ?>>Email Address</option>
											<option value="Mobile Phone Number" <?php echo $phone_val; ?>>Mobile Phone Number</option>
										</select><span class='fa fa-question form-control-feedback'></span>
									</p>
									<span id="field_to_show_now_display">
										
									</span>
									<p class="jumbotron has-feedback">
										<label>Provide Secret Passcode. <font color="red">*</font></label>
										<input type="password" autocomplete="off" required="" name="secrettoken" title="Provide Secret Passcode in the field!" placeholder="Enter Secret Passcode Here" class="form-control"><?php if($secrettokenErr != ""){ echo "<span style='color: red;'><i>$secrettokenErr</i></span>";} ?><span class='fa fa-key form-control-feedback'></span>
									</p>

 					<p><a href="register_self.php"><span class="fa fa-arrow-right"></span> Not yet Registered? Create an account now</a></p>
                  <div class="col-md-12">
                        <div class="form-group">
                            <div class="g-recaptcha" data-sitekey="6LcdV8kaAAAAAKZLfK6tRSRk6x-HgG1If9rfmo_E"></div>
                            <br/>
                        </div>
                  </div>

								<input type="submit" name="submit" value="Log-In" class="btn btn-success form-control">
								<p><a href="forgot_secret.php"><span class="fa fa-repeat"></span> Forgotten Secret Passcode?</a></p>

								</form>
							</div>
						</div>
					</div>				
				</div>
	</section>
<?php
	include "footer.php";
?>