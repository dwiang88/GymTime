<?php session_start();
   if(!isset($_SESSION['isLoggedIn'])){
        //header( 'Location: login.php');
   } else {
   
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Workouts</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
  <link type="text/css" rel="stylesheet" href="css/gymtime.css" /> 
  <script src="js/gymtime.js"></script>
<link rel="stylesheet" href="http://code.jquery.com/mobile/1.0b2/jquery.mobile-1.0b2.min.css" />
<script src="http://code.jquery.com/jquery-1.6.2.min.js"></script>
<script src="http://code.jquery.com/mobile/1.0b2/jquery.mobile-1.0b2.min.js"></script>
  <!--
   <link type="text/css" href="css/redmond/jquery-ui-1.8.16.custom.css" rel="stylesheet" />	
   <script type="text/javascript" src="js/jquery-1.6.2.min.js"></script>
   <script type="text/javascript" src="js/jquery-ui-1.8.16.custom.min.js"></script> 
   -->
</head>

<body>
<form action="dataquery.php?Action=AddWorkout" method="post">
    <input type="submit" name="submit" value="New Workout" id="newworkout" /><br>
</form>

<?php
   print "v0.3";
         


?>

</body>
</html>
