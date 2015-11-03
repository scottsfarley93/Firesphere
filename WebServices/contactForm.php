<?php
?>
<!DOCTYPE HTML>
<htmL>
	<style>
	.glyphicon{
		float:right;
	}
	.form-input{
		margin:1%;
	}



	</style>
	<head>
		<title>Contact Us</title>
		 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">
		<link href="../styles/homePageStyle.css" rel='stylesheet' type='text/css' />
	    <link href="../styles/contact.css" rel='stylesheet' type='text/css' />
	     <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
	    <!-- Custom Theme files -->
	    <meta name="viewport" content="width=device-width, initial-scale=1">
	</head>
	<body>
		<div class='containter'>
			<div class='page-header'>
				                <nav class="navbar-default navbar-side" role="navigation">
            <div class="sidebar-collapse">
                <ul class="nav" id="main-menu">
				<li class="text-center">
                    <img src="../images/logo.png" class="user-image img-responsive"/>
                    <i>Crowdsourced safety for the wildland-urban interface</i>
					</li>
				
                    <li>
                        <a  href="../default.html">Home<span class='glyphicon glyphicon-home'></span></a>
                    </li>
                     <li>
                        <a  href="currentBehavior.php">Fire Behavior<span class='glyphicon glyphicon-fire'></span></a>
                    </li>
                    <li>
                        <a  href="teams.php">Teams<span class='glyphicon glyphicon-th-list'></span></a>
                    </li>
                    <li>
                        <a  href="gettingStarted.php">Getting Started<span class='glyphicon glyphicon-road'></span></a>
                    </li>
						   <li  >
                        <a   href="aboutUs.php">About<span class='glyphicon glyphicon-globe'></span></a>
                    </li>	
                      <li  >
                        <a  class="active-menu" href="contactForm.php">Contact<span class='glyphicon glyphicon-phone-alt'></span></a>
                    </li>
                </ul>
               <br/>
            </div>
            
        </nav> 
        <div id='page-wrapper'>
        	<div>
				<h1>Contact Us</h1>
				<strong>We appreciate your feedback</strong>
			</div>
			<section>
				<p>Please use this form to let us know about any bugs, issues, questions, or comments. <br>If you leave your name and email address, we will get back to you as soon as possible.</p>
 <form action="../Services/processFeedback.php" method="POST">
    <input type="text" name="name" class="form-input" placeholder="Name (optional)"  /><br >
    <input type="email" name="email" class="form-input" placeholder="Email (optional)"  /><br>
    <input type="text" name="subject" class="form-input" placeholder="Subject (optional)" /><br >
    <textarea name="message" class="form-input"  placeholder="Message (required)" cols='50' rows='10'required></textarea> <br>
    <input type="submit" value="Send Message" />
  </form>
  <i>You can also send us an email at <a href='mailto:scott@firesphere.org'>scott@firesphere.org.</a></i>
			</section>	<br>
	<footer>
		Firesphere, LLC
		2410 Parker Street
		Berkeley, California
		94704
		tel: 626-264-0741
		email: scott@firesphere.org
	</footer>
		</div>
	</div>
	</body>
	</html>
