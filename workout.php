<html>
<head>
<?php
   require 'SQLManager.class.php';
   $workoutId = $_GET['WorkoutID'];
   $sqlMgr = new SQLManager();
?>

<title>
<?php
   print "Workout - " . $sqlMgr->getWorkoutDate($workoutId);
?>
</title>
  <link type="text/css" rel="stylesheet" href="css/gymtime.css" /> 
  <link type="text/css" href="css/redmond/jquery-ui-1.8.16.custom.css" rel="stylesheet" />	
  <script type="text/javascript" src="js/jquery-1.6.2.min.js"></script>
  <script type="text/javascript" src="js/jquery-ui-1.8.16.custom.min.js"></script> 
  <script type="text/javascript" src="js/gymtime.js"></script> 
</head>

<body>
<?php
    print '<script type="text/javascript">';
    print   "var workoutMgr = new WorkoutManager('" . $workoutId . "','" . $sqlMgr->getWorkoutDate($workoutId)  . "');";
    if($sqlMgr->getWorkoutSetID($workoutId) != -1){
        $setId = $sqlMgr->getWorkoutSetID($workoutId);
        $data = $sqlMgr->getExerciseData($setId);
        print   "$(document).ready(function(){workoutMgr.load('" . $data  . "');});";
    }
    print '</script>';

?>
<div class="workout-date-header">
	<span>
	<?php 
	    print date("l F j, Y",strtotime($sqlMgr->getWorkoutDate($workoutId))); 
	?></span>
</div>


<a href="javascript:workoutMgr.addExercise();">Add Exercise</a>
	<div class="workout-set-exercise" style="display:inline;">
		<select name="exercises" id="exercises" >
		<?php
            foreach ($sqlMgr->getExercises() as $exercise){
                print '<option value="' . $exercise["ID"] .'">' . $exercise["Name"] .'</option>';
            }           
		?>
		</select>
	</div>

<div id="ExercisesContainer"></div>

</body>
</html>
