<?php session_start();
    require 'SQLManager.class.php';    
    require 'validate.php'; 
    $sqlMgr = new SQLManager();   
	
?>

<!DOCTYPE html>
<html>
<head>
<title>Workouts</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
  <link type="text/css" rel="stylesheet" href="css/gymtime.css" /> 
  <script src="js/gymtime.js"></script>
<link rel="stylesheet" href="http://code.jquery.com/mobile/1.0b3/jquery.mobile-1.0b3.min.css" />
<script src="http://code.jquery.com/jquery-1.6.2.min.js"></script>
<script src="http://code.jquery.com/mobile/1.0b3/jquery.mobile-1.0b3.min.js"></script>
</head>

<body>
	<div data-role="page" id="gymtime-home">
      <div data-role="header">
         <h1>Gym Time</h1>
         <div data-role="navbar">
            <ul>
               <?php
	               $today = date("Y-m-d");
	               $id = $sqlMgr->getWorkoutID($today);
	               if($id == ""){
               ?>
               <li><a href="dataquery.php?Action=AddWorkout" rel="external" data-theme="b" data-role="button" data-icon="plus"  id="newworkout">Create New Workout</a></li>

               <?php
               } else {
               ?>
               <li><a href="workout.php?WorkoutID=<?php print $id; ?>" rel="external" data-theme="b"  data-iconpos="right" data-icon="plus"  id="newworkout">Continue Today's Workout</a></li>
               <?php 
	               }
               ?>
               <li><a href="completedworkouts.php" rel="external" data-theme="b" data-role="button" data-icon="search"  id="newworkout" data-iconpos="right" >Completed Workouts</a></li>
               <li><a href="settings.php" rel="external" data-theme="b" data-role="button" data-icon="settings" id="settings">Settings</a></li>
            </ul>
         </div>
      </div>    
		 <div data-role="content">
       Welcome <b><?php print $_SESSION['Username']; ?> </b> to Gymtime v1.0.9b <br><br>

		</div>
	</div>
</body>
</html>
