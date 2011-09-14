<?php 
session_start();
require 'SQLManager.class.php';
    if(!isset($_SESSION['isLoggedIn']) || !isset($_SESSION['UserID'])){
        header( 'Location: login.php');
    } else {
        if($_SESSION['isLoggedIn'] == true && $_SESSION['UserID'] > 0){
            
        } else {
            header( 'Location: login.php');
        }
    }
    
$action = "";
//$action = $_GET["Action"];
$action = isset($_GET["Action"]) ? $_GET["Action"] : "";
if($action == ""){
    $action = $_POST["Action"];
}

if($action == "AddWorkout"){
    $date = $_POST["workoutdate"];
    $sqlMgr = new SQLManager();
    
    $id = $sqlMgr->addWorkout();
    header("Location: workout.php?WorkoutID=$id");

}
if($action == "AddSet"){
    $exerciseId = $_POST["ExerciseId"];
    $weight = $_POST["Weight"];    
    $reps = $_POST["Repetitions"];
    $setNumber = $_POST["SetNumber"];
    $workoutId = $_POST["WorkoutId"];
    //print "Add $exerciseId Weight:$weight Reps:$reps SetNumber:$setNumber WorkoutId:$workoutId";
    $sqlMgr = new SQLManager();
    $sqlMgr->updateSet($exerciseId, $weight, $reps, $setNumber, $workoutId);
}
if($action == "RemoveSet"){
	$exerciseId = $_POST["ExerciseId"];
	$setId = $_POST["SetId"];
	$sqlMgr = new SQLManager();
	$sqlMgr->removeSet($exerciseId,$setId);
}
if($action == "GetExercises"){
	$muscleGroup = $_POST["MuscleGroup"] == "null" ? null : $_POST["MuscleGroup"];
	$sqlMgr = new SQLManager();
	$exercises = $sqlMgr->getExercises($muscleGroup);
	print json_encode($exercises);
}
if($action == "GetExerciseHistory"){
	$exerciseId = $_POST["ExerciseId"];
	$setId = $_POST["SetId"];    
    $sqlMgr = new SQLManager();
    $historicalSets = $sqlMgr->getHistoricalExerciseData($setId,$exerciseId);
    if($historicalSets != null){
        print "<span style='font-size:1.00em;font-style:bold;'>". $historicalSets["ExerciseName"] . "</span><br>";
        print "<span style='font-size:0.67em;font-style:bold;'>" . $historicalSets["DateAdded"] . "</span><br>";
        print '<div class="ui-grid-b">';
	    print '<div class="ui-block-a"><div class="ui-bar ui-bar-a" style="text-align:center;margin-right:4px;">Set</div></div>';
	    print '<div class="ui-block-b"><div class="ui-bar ui-bar-a" style="text-align:center;margin-right:4px;">Weight</div></div>';
	    print '<div class="ui-block-c"><div class="ui-bar ui-bar-a" style="text-align:center;">Reps</div></div>';
        foreach($historicalSets["Sets"] as $set){
            print '<div class="ui-block-a" style="text-align:center; margin-top:5px;">' . $set["SetNumber"] . '</div><div class="ui-block-b" style="text-align:center; margin-top:5px;">' . $set["Weight"] . ' lbs</div><div class="ui-block-c" style="text-align:center;margin-top:5px;">' . $set["Repetitions"] . "</div>";
        }
        print '</div>';
    } else {
        print "No historical information for this exercise. You should consider doing this exercise you lazy ass.";
    }
   
}



?>
