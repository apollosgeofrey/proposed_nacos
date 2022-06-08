<?php
if (isset($_POST['mat_f'] )) {
	echo "<p class='jumbotron has-feedback' id='mat_f'>
		<label>Provide Matriculation Number. <font color='red'>*</font></label>
		<input type='text' required='' pattern='[A-Z,a-z,0-9,/]{19}' title='Eg: PLASU/2000/FNS/0000 (no spacing & spaces @ both ends is allowed)' name='mat_ema_phn' placeholder='Eg: PLASU/2050/FNS/1000' class='form-control' value=''><span class='fa fa-user form-control-feedback'></span></p>";
} else if (isset($_POST['email_f'])) {
	echo"<p class='jumbotron has-feedback' id='email_f'>
		<label>Provide Email Address. <font color='red'>*</font></label>
		<input type='email' required='' title='Please Provide a valid email' name='mat_ema_phn' placeholder='Eg: blablalba@mail.com' class='form-control' value=''><span class='fa fa-envelope form-control-feedback'></span></p>";
} else if (isset($_POST['phone_f'])) {
	echo"<p class='jumbotron has-feedback' id='phone_f'>
		<label>Provide Phone Number. <font color='red'>*</font></label><br>
		<span class='form-control'><select class='col-sm-2' style='height: 25px;'><option> Nig. +234</option></select> <input type='number' style='height: 25px;' pattern='[0-9]{10}' title='Provide a valid phone number Eg: 8022334455' maxlength='10' minlength='10' required='' name='mat_ema_phn' placeholder='Eg: 8012345678' class='col-sm-10' value=''></span><span class='fa fa-phone form-control-feedback'></span> </p> ";
}

?> 