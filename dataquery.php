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
    print "Sweet";
}



?>
