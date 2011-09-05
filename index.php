<?php session_start();
   if(!isset($_SESSION['isLoggedIn'])){
        //header( 'Location: login.php');
   } else {
   
}
?>
<html>
<head>
<title>Workouts</title>
  <link type="text/css" rel="stylesheet" href="css/gymtime.css" /> 
  <link type="text/css" href="css/redmond/jquery-ui-1.8.16.custom.css" rel="stylesheet" />	
  <script type="text/javascript" src="js/jquery-1.6.2.min.js"></script>
  <script type="text/javascript" src="js/jquery-ui-1.8.16.custom.min.js"></script> 
  <script type="text/javascript">
    $(document).ready(function(){
        $("#newworkout").button();
    });
  </script>
</head>

<body>
<form action="dataquery.php?Action=AddWorkout" method="post">
    <input type="submit" name="submit" value="New Workout" id="newworkout" /><br>
</form>

<?php
   print "v0.2";
         


?>

</body>
</html>
