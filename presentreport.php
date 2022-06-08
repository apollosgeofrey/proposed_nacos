<?php
	include "header.php";
	include "navigation.php";
?>	
	<section id="inner-headline">
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<h2 class="pageTitle">Report Presentation</h2>
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
									<h3><span class="color">Enter Secret Token to Proceed!</span></h3>
									<p>This will enable us Authenticate and verify your eligibility/licence</p>

								</div>
								<!-- <a href="#" class="btn btn-color">Read more</a> -->  
							</div>
						</div>
						
						<hr>
						
						<div class="row">
							<div class="col-md-12">
								<form id="contact-form" role="form" autocomplete="on" action="" method="post">
									<p class="jumbotron">
										<label>Provide Secret Token</label>
										<input type="text" required="" name="secrettoken" placeholder="Enter Secret Token Here" class="form-control">
									</p>
									<input type="submit" name="submit" value="Send" class="form-control">
								</form>
							</div>
						</div>
					</div>				
				</div>
	</section>
<?php
	include "footer.php";
?>