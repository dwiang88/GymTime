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
<div data-role="page" id="completed-workouts">
<div data-role="header">
	<a href="index.php" data-icon="back" data-theme="b">Back</a>
    <h1>Completed Workouts</h1>
</div>    
 <div data-role="content">
 <table width="100%"><tr><td width="100%">
<?php
   print '<h3>Workouts Completed</h3>';
   print '<br>';
   print '<ul data-role="listview" data-split-theme="b" data-split-icon="search" id="completedworkoutslist" >';
   $containsData = false;
   foreach($sqlMgr->getWorkouts() as $workout){
      $containsData = true;
      $id = $workout['WorkoutID'];
      print '<li data-role="list-divider">'. date("l F j, Y",strtotime($workout['Date'])) .'</li>';
      print "<li><a   data-ajax=\"false\" href=\"workout.php?WorkoutID=$id\">";
//print "<li><a href=\"javascript:showWorkout($id);\">";
      $x = 1;
      $containsSets = false;
      foreach($data = $sqlMgr->getWorkoutMuscleGroups($workout['SetID']) as $muscleGroup){
        $containsSets = true;
        $count = count($data);
        print $muscleGroup . ($x < $count ? ", " : "") ;
        $x++;
      }
      if(!$containsSets){
        print "You have not started any exercise sets. Click here to begin your workout.";
      }
      
      print '</a>';
      print '<a href="#">Modify</a>';
      print '</li>';
   }
   if($containsData == false){
      print '<li>No workouts have been added. Click the Create New Workout button to start your new workout.</li>';
   }
   print '</ul>'
   
?>
</td>
</tr>
</table>

</div>
</div>

</body>
</html>
