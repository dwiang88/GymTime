<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
<?php
    if(!isset($_SESSION['isLoggedIn']) || !isset($_SESSION['UserID'])){
        header( 'Location: login.php');
    } else {
        if($_SESSION['isLoggedIn'] == true && $_SESSION['UserID'] > 0){
            
        } else {
            header( 'Location: login.php');
        }
    }
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
	<script type="text/javascript" src="js/gymtime.js"></script> 
	<link rel="stylesheet" href="http://code.jquery.com/mobile/1.0b2/jquery.mobile-1.0b2.min.css" />
	<script src="http://code.jquery.com/jquery-1.6.2.min.js"></script>
	<script src="http://code.jquery.com/mobile/1.0b2/jquery.mobile-1.0b2.min.js"></script>  
</head>

<body>
        <!-- Exercises Completed -->
            <div data-role="page" id="exercises-completed">
                <div data-role="header">
	                <h4>	
		                <?php 
			                print date("l F j, Y",strtotime($sqlMgr->getWorkoutDate($workoutId))); 
		                ?>
	                </h4>
                </div>            
                <div data-role="content">    
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
                        <fieldset class="ui-grid-a">
	                        <div class="ui-block-a"><a href="#exercise-selection" data-role="button" data-icon="plus" data-theme="b">Start Exercise</a></div>
	                        <div class="ui-block-b"><a href="index.php" data-role="button" data-icon="check" data-theme="b">Finish Workout</a></div>	   
                        </fieldset>
                        <div>Blah</div>
                        <div id="ExercisesCompleted"></div>
                </div>    
            </div>
         <! -- Exercises Selection -->
         <div data-role="page" id="exercise-selection">   
            <div data-role="content">  
                <div data-role="header">
	                <h4>	
		                <?php 
			                print date("l F j, Y",strtotime($sqlMgr->getWorkoutDate($workoutId))); 
		                ?>
	                </h4>        
	            </div>        
                    <div id="ExercisePanel">
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
	                    <div class="ui-block-a"> <a href="#set-input" data-theme="b" data-role="button" data-icon="check">Start Set</a></div>
	                    <div class="ui-block-b"><a href="javascript:workoutMgr.completeSet();" data-theme="b" data-role="button" data-icon="back" class="button">Return to Workout</a></div>	   
                    </fieldset>
                    </div>
           </div>
       </div>
 <! -- Set -->
        <div data-role="page" id="set-input">  
         <script>alert(1);</script> 
            <div data-role="content">  
                <div id="ExercisesContainer"></div>
            </div>
         </div>

</body>
</html>
