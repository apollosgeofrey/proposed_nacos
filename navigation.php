<?php
        include "sitevisitors.php";
?>
<body>
    <style type="text/css">
        #nacos_logo{
            width: 20%;
        }
        ul #dash_black:hover{
            color: black;
        }
        @media (min-width: 660px){
            #nacos_logo{
                width: 10%;
            }
        }
    </style>
<div id="wrapper">
<!-- start header navigation bar-->
	<header>
	<section class="contactInfo">
	<div class="container"> 
      <div class="col-md-12"> 
               <div class="contact-area">
                     <ul>
                        <li><i class="fa fa-phone-square"></i><a href='tel:+2348095635395' style="color: white;">009-234-8095-635-395</a></li>
                        <li><i class="fa fa-envelope-o"></i><a href="mailto:info@nacosplasuchapter.org.ng?subject=Good Day NACOS, i got the email address from NACOS PLASU CHAPTER official Website." style='color: white;'>info@nacosplasuchapter.org.ng</a></li>
                   `</ul>
             </div> 
        </div> 
    </div>
		</section>	
        <div class="navbar navbar-default">
            <div class="container">
                    <?php
                        if (isset($_SESSION['mat_no']) && isset($_SESSION['phone_number']) && isset($_SESSION['email']) && isset($_SESSION['rank']) ) {
                          echo"<ul class='nav navbar-nav'>
                          <a href='upcoming.php' class='btn btn-success' id='dash_black' title='Visit and control your dashboard' >My &nbsp Dashboard</a>
                          <a href='nacos_dash.php?jksdfjkhs?ujkdsjk' class='btn btn-success' id='dash_black' title='Visit and view NACOS latest'>NACOS Dashboard</a> </ul>";
                        }
                      ?> 
                <a class="navbar-brand pull-left" href="index.php">   <img src="img/logo/nacos_logo_white.jpg" alt="logo" id="nacos_logo"/> </a>
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                </div><br>
                <div class="navbar-collapse collapse ">
                    <ul class="nav navbar-nav">
                        <li class="active"><a href="index.php" title="Visit Our Index Page">Home</a></li> 
						<li><a href="services.php" title="Association Events and Services">Events/Services</a></li>
                        <li><a href="about.php" title="Briefing about NACOS">About NACOS</a></li>
                        <li><a href="contact.php" title="Contact NACOS Here">Contact NACOS</a></li>
                <?php
                    if (isset($_SESSION['mat_no']) && isset($_SESSION['phone_number']) && isset($_SESSION['email']) && isset($_SESSION['rank']) ) {
                        echo"<li><a href='nacos_log_out.php' class='btn btn-success' title='Members Login Dashboard'>Log Out</a></li>";
                    } else {
                       echo"<li><a href='nacos_log_in.php' class='btn btn-success' title='Members Login Dashboard'>Log In</a></li>";
                   }
                ?>
                    </ul>
                </div>
            </div>
        </div>
	</header>
	<!-- end header navigation bar-->