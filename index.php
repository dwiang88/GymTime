<?php session_start();
    require 'SQLManager.class.php';    
    if(!isset($_SESSION['isLoggedIn']) || !isset($_SESSION['UserID'])){
        header( 'Location: login.php');
    } else {
        if($_SESSION['isLoggedIn'] == true && $_SESSION['UserID'] > 0){
            
        } else {
            header( 'Location: login.php');
        }
    }
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
		</div>    
		 <div data-role="content">
			<?php
				$today = date("Y-m-d");
				$id = $sqlMgr->getWorkoutID($today);
				if($id == ""){
			?>
		   <a href="workout.php?WorkoutID=<?php print $id; ?>" rel="external" data-theme="b" data-role="button" data-icon="plus"  id="newworkout">Create New Workout</a>
			
			<?php
			} else {
			?>
			<a href="workout.php?WorkoutID=<?php print $id; ?>" rel="external" data-theme="b" data-role="button" data-icon="plus"  id="newworkout">Continue Workout</a>
			<?php 
				}
			?>
			<a href="completedworkouts.php" rel="external" data-theme="b" data-role="button" data-icon="plus"  id="newworkout">Completed Workouts</a>
		</div>
	</div>
</body>
</html>
