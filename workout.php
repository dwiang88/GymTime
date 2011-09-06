<!DOCTYPE html>
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
<meta name="viewport" content="width=device-width, initial-scale=1">
  <link type="text/css" rel="stylesheet" href="css/gymtime.css" /> 
  <!--<link type="text/css" href="css/redmond/jquery-ui-1.8.16.custom.css" rel="stylesheet" />	
  <script type="text/javascript" src="js/jquery-1.6.2.min.js"></script>
  <script type="text/javascript" src="js/jquery-ui-1.8.16.custom.min.js"></script> 
  <script type="text/javascript" src="js/jquery.cycle.all.js"></script> 
  -->
	<script type="text/javascript" src="js/gymtime.js"></script> 
	<link rel="stylesheet" href="http://code.jquery.com/mobile/1.0b2/jquery.mobile-1.0b2.min.css" />
	<script src="http://code.jquery.com/jquery-1.6.2.min.js"></script>
	<script src="http://code.jquery.com/mobile/1.0b2/jquery.mobile-1.0b2.min.js"></script>  
</head>

<body>
<?php
    print '<script type="text/javascript">';
    print   "var workoutMgr = new WorkoutManager('" . $workoutId . "','" . $sqlMgr->getWorkoutDate($workoutId)  . "');";
    if($sqlMgr->getWorkoutSetID($workoutId) != -1){
        $setId = $sqlMgr->getWorkoutSetID($workoutId);
		print	"$(document).ready(function(){ workoutMgr.setSetId('" . $setId . "');});";
        $data = $sqlMgr->getExerciseData($setId);
        print   "$(document).ready(function(){workoutMgr.load('" . $data  . "');});";
		
    }
    print '</script>';

?>
<div id="GymTimeContainer">
<div data-role="header">
		<h4>	
		<?php 
			print date("l F j, Y",strtotime($sqlMgr->getWorkoutDate($workoutId))); 
		?>
	</h4>
</div>

<table style="width:100%;">
<tr>
<td valign="top">
<div id="StartExercisePanel" style="width:100%;">
<fieldset class="ui-grid-a">
	<div class="ui-block-a"><a href="javascript:workoutMgr.startExercise();" data-role="button" data-icon="plus" data-theme="b">Start Exercise</a></div>
	<div class="ui-block-b"><a href="index.php" data-role="button" data-icon="check" data-theme="b">Finish Workout</a></div>	   
</fieldset>
   
   

   <div id="ExercisesCompletedContainer">
      <div id="ExercisesCompleted"></div>
   </div>
</div>

<div id="ExercisePanel" style="display:none;">
<div data-role="fieldcontain">
	   <div class="workout-set-exercise-types" style="">
	   <label for="exercise_categories" class="select">Choose Muscle Group</label>
		   <select name="exercise_categories" id="exercise_categories" >
		   <option value="null" >All</option>
		   <?php
               foreach ($sqlMgr->getExerciseCategories() as $exercise){
                   print '<option value="' . $exercise["MuscleGroup"] .'">' . $exercise["MuscleGroup"] .'</option>';
               }           
		   ?>		
		   </select>
	   </div>
</div>
<script type="text/javascript">$("#exercise_categories").change(workoutMgr.muscleGroup);</script>

	   <div class="workout-set-exercise">
<div data-role="fieldcontain">
	   <label for="exercises" class="select">Choose Exercise</label>
		   <select name="exercises" id="exercises" >
		   <?php
               foreach ($sqlMgr->getExercises(null) as $exercise){
                   print '<option value="' . $exercise["ID"] .'">' . $exercise["Name"] .'</option>';
               }           
		   ?>
		   </select>
	   </div>
</div>	   

<fieldset class="ui-grid-a">
	<div class="ui-block-a"> <a href="javascript:workoutMgr.addExercise();" data-theme="b" data-role="button" data-icon="check">Start Set</a></div>
	<div class="ui-block-b"><a href="javascript:workoutMgr.completeSet();" data-theme="b" data-role="button" data-icon="back" class="button">Return to Workout</a></div>	   
</fieldset>
	  
	   
</div>
<div id="ExercisesContainer"></div>

</td>
</tr>
</table>

</div>
</body>
</html>
