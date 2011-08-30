<?php 
require 'SQLManager.class.php';
$action = "";
$action = $_GET["Action"];
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



?>
