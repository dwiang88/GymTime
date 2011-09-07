<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
<?php
    if(!isset($_SESSION['isLoggedIn']) || !isset($_SESSION['UserID'])){
        //header( 'Location: login.php');
    } else {
        if($_SESSION['isLoggedIn'] == true && $_SESSION['UserID'] > 0){
            
        } else {
            //header( 'Location: login.php');
        }
    }
   require 'SQLManager.class.php';
   $sqlMgr = new SQLManager();
?>

<title>
<?php
   print "Body Progress";
?>
</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link type="text/css" rel="stylesheet" href="css/gymtime.css" /> 
<script type="text/javascript" src="js/gymtime.js"></script> 
<link rel="stylesheet" href="http://code.jquery.com/mobile/1.0b2/jquery.mobile-1.0b2.min.css" />
<script src="http://code.jquery.com/jquery-1.6.2.min.js"></script>
<script src="http://code.jquery.com/mobile/1.0b2/jquery.mobile-1.0b2.min.js"></script>  
</head>
<body> 

<!-- Start of Progress Home Page -->
<div data-role="page" id="progress-home">

<div data-role="header" data-position="inline">
	<a href="index.php" data-icon="back">Workouts</a>
	<h1>Workouts</h1>
</div>

	<div data-role="content">	
     Test
	</div>
</div>


<!-- Start of second page -->
<div data-role="page" id="progress-weight">

	<div data-role="header">
		<h1>Bar</h1>
	</div><!-- /header -->

	<div data-role="content">	
		<p>I'm first in the source order so I'm shown as the page.</p>		
		<p><a href="#foo">Back to foo</a></p>	
	</div><!-- /content -->

</div>
</body>
</html>
