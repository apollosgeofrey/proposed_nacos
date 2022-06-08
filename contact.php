<?php
	include "header.php";
	include "navigation.php";
?>	
	<section id="inner-headline">
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<h2 class="pageTitle">Contact Us</h2>
			</div>
		</div>
	</div>
	</section>
	<section id="content">
	
	<div class="container">
	<div class="row">
								<div class="col-md-6">
									<p class="alert alert-info">NOTE: The email address and phone number you are to provide below will be used to reach you if neccessary.</p>
									<div class="alert alert-success hidden" id="contactSuccess">
										<strong>Success!</strong> Your message has been sent to us.
									</div>
									<div class="alert alert-danger hidden" id="contactError">
										<strong>Error!</strong> There was an error sending your message.
									</div>
									<div class="contact-form">
										<form id="contact-form" role="form" autocomplete="on" action="#" method="post">
											<div class="form-group has-feedback">
												<label for="name">Name*</label>
												<input type="text" required="" class="form-control" id="name" name="name" placeholder="Enter Full Name" value="<?php if(isset($_POST['name'])){echo $_POST['name'];} ?>">
												<i class="fa fa-user form-control-feedback"></i>
											</div>
											<div class="form-group has-feedback">
												<label for="email">Email*</label>
												<input type="email" required="" class="form-control" id="email" name="email" placeholder="Enter Email Address" value="<?php if(isset($_POST['email'])){echo $_POST['email'];} ?>">
												<i class="fa fa-envelope form-control-feedback"></i>
											</div>
											<div class="form-group has-feedback">
												<label for="email">Phone Number*</label>
												<input type="number" required="" class="form-control" id="phonenumber" name="phonenumber" placeholder="Enter Phone Number" value="<?php if(isset($_POST['phonenumber'])){echo $_POST['phonenumber'];} ?>">
												<i class="fa fa-phone form-control-feedback"></i>
											</div>
											<div class="form-group has-feedback">
												<label for="subject">Subject*</label>
												<input type="text" required="" class="form-control" id="subject" name="subject" placeholder="Enter Message Subject" value="<?php if(isset($_POST['subject'])){echo $_POST['subject'];} ?>">
												<i class="fa fa-navicon form-control-feedback"></i>
											</div>
											<div class="form-group has-feedback">
												<label for="message">Message</label>
												<textarea class="form-control" rows="6" id="message" name="message" placeholder="Enter Message Content/Body" value="<?php if(isset($_POST['message'])){echo $_POST['message'];} ?>"></textarea>
												<i class="fa fa-pencil form-control-feedback"></i>
											</div>
											<input type="submit" value="Submit" class="btn btn-default">
										</form>
									</div>
								</div>
								<div class="col-md-6">
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script><div style="overflow:hidden;height:500px;width:100%;"><div id="gmap_canvas" style="height:500px;width:100%;"></div><style>#gmap_canvas img{max-width:none!important;background:none!important}</style><a class="google-map-code" href="http://www.trivoo.net" id="get-map-data">trivoo</a></div><script type="text/javascript"> function init_map(){var myOptions = {zoom:14,center:new google.maps.LatLng(40.805478,-73.96522499999998),mapTypeId: google.maps.MapTypeId.ROADMAP};map = new google.maps.Map(document.getElementById("gmap_canvas"), myOptions);marker = new google.maps.Marker({map: map,position: new google.maps.LatLng(40.805478, -73.96522499999998)});infowindow = new google.maps.InfoWindow({content:"<b>The Breslin</b><br/>2880 Broadway<br/> New York" });google.maps.event.addListener(marker, "click", function(){infowindow.open(map,marker);});infowindow.open(map,marker);}google.maps.event.addDomListener(window, 'load', init_map);</script>
								</div>
							</div>
	</div>
 
	</section>
<?php
	include "footer.php";
?>