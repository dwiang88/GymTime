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
<link rel="stylesheet" href="http://code.jquery.com/mobile/1.0b2/jquery.mobile-1.0b2.min.css" />
<script src="http://code.jquery.com/jquery-1.6.2.min.js"></script>
<script src="http://code.jquery.com/mobile/1.0b2/jquery.mobile-1.0b2.min.js"></script>
  <!--
   <link type="text/css" href="css/redmond/jquery-ui-1.8.16.custom.css" rel="stylesheet" />	
   <script type="text/javascript" src="js/jquery-1.6.2.min.js"></script>
   <script type="text/javascript" src="js/jquery-ui-1.8.16.custom.min.js"></script> 
   -->
</head>

<body>

<div data-role="header">
    <h1>Gym Time</h1>
</div>    
<form action="dataquery.php?Action=AddWorkout" method="post">
<?php
    $today = date("Y-m-d");
    $id = $sqlMgr->getWorkoutID($today);
    if($id == ""){
?>
    <input type="submit" name="submit" data-theme="b" value="Create New Workout" id="newworkout" />
    
    <?php
    } else {
    ?>
    <input type="submit" name="submit" data-theme="b" value="Continue Workout" id="newworkout" />
    <?php 
        }
    ?>
</form>
<a href="updateweight.php" data-theme="b" id="weighin" data-role="button">Weigh-in</a>

<?php
   print '<h3>Workouts Completed</h3>';
   print '<ul data-role="listview" data-inset="true" data-split-theme="b" data-split-icon="search">';
   $containsData = false;
   foreach($sqlMgr->getWorkouts() as $workout){
      $containsData = true;
      $id = $workout['WorkoutID'];
      print '<li data-role="list-divider">'. date("l F j, Y",strtotime($workout['Date'])) .'</li>';
      print "<li><a rel=\"external\" href=\"workout.php?WorkoutID=$id\">";
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
</body>
</html>
