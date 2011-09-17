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
	<link rel="stylesheet" href="http://code.jquery.com/mobile/1.0b3/jquery.mobile-1.0b3.min.css" />
	<script src="http://code.jquery.com/jquery-1.6.2.min.js"></script>
	<script type="text/javascript" src="js/gymtime.js"></script>
	<script src="http://code.jquery.com/mobile/1.0b3/jquery.mobile-1.0b3.min.js"></script>  
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
<div data-role="navbar" id="set-input-navbar">
<ul>
<li><a href="#exercise-selection" data-role="button" data-theme="b">Start</a></li>
<li><a href="index.php" data-role="button"  data-theme="b">Finish</a></li>
</ul>
</div>	                
                </div>            
                <div data-role="content">    
                    <?php
                        print '<script type="text/javascript">';
                        print   "var workoutMgr = new WorkoutManager('" . $workoutId . "','" . $sqlMgr->getWorkoutDate($workoutId)  . "');";
                        if($sqlMgr->getWorkoutSetID($workoutId) != -1){
                            $setId = $sqlMgr->getWorkoutSetID($workoutId);
		                    print	"$('#exercises-completed').live('pagecreate',function(event){ workoutMgr.setSetId('" . $setId . "');});";
                            $data = $sqlMgr->getExerciseData($setId);
                            print   "$('#exercises-completed').live('pagecreate',function(event){workoutMgr.load('" . $data  . "');});";
                        }
                        print '</script>';
                    ?>    <!--   
                        <fieldset class="ui-grid-a">
	                        <div class="ui-block-a"><a href="#exercise-selection" data-role="button" data-icon="plus" data-theme="b">Start</a></div>
	                        <div class="ui-block-b"><a href="index.php" data-role="button" data-icon="check" data-theme="b">Finish</a></div>	   
                        </fieldset>
                        -->
                        <br>
                        <div id="ExercisesCompleted">
						<?php
							print '<br>';
							print '<ul data-role="listview" data-theme="g" id="completedexerciseslist"><li data-role="list-divider">Completed Exercises</li><li>You have no exercises. Click Start Exercise to begin your workout sets.</li></ul>';
						?>
						</div>
                </div>    
            </div>
         <! -- Exercises Selection -->
         <div data-role="page" id="exercise-selection">  
         <script>
            $('#exercise-selection').live('pagecreate',function(event){
                //$.mobile.selectmenu.prototype.options.nativeMenu = false;
                
            });  
                   
         </script>
                <div data-role="header">
	                <span style="text-align:center;">	
		                <?php 
			                print date("l F j, Y",strtotime($sqlMgr->getWorkoutDate($workoutId))); 
		                ?>
	                </span>        
	            </div>          
            <div data-role="content">
            <table align="center" style="width:100%;">
            <tr>
            <td align="center">          
                <select name="exercise_categories" id="exercise_categories">
                <option data-placeholder="true">Select Muscle Group</option>
                <option value="null" >All</option>
                <?php
                   foreach ($sqlMgr->getExerciseCategories() as $exercise){
                       print '<option value="' . $exercise["MuscleGroup"] .'">' . $exercise["MuscleGroup"] .'</option>';
                   }           
                ?>		
                </select>
                <script type="text/javascript">$("#exercise_categories").change(workoutMgr.muscleGroup);</script>

				<div id="exercises-select-container">
					<select name="exercises" id="exercises" >
					<?php
					   //foreach ($sqlMgr->getExercises(null) as $exercise){
						//   print '<option value="' . $exercise["ID"] .'">' . $exercise["Name"] .'</option>';
					   //}           
					?>
					</select>
				</div>
                <fieldset class="ui-grid-a">
                <div class="ui-block-a"> <a href="javascript:workoutMgr.addExercise();" data-theme="b" data-role="button" data-icon="check">Start Set</a></div>
                <div class="ui-block-b"><a href="javascript:workoutMgr.completeSet();" data-theme="b" data-role="button" data-icon="back" class="button">Return to Workout</a></div>	   
                </fieldset> 
             </td>
             </tr>
             </table>   
           </div>
       </div>
       
 <! -- Set -->
        <div data-role="page" id="set-input">  
               <div data-role="header" data-position="inline" id="set-input-header">
	                <h4 id="set-input-title"></h4>
	            </div>        
            <div data-role="content">  
                <div id="ExercisesContainer" style="width:100%;"></div>
            </div>
            <div data-role="footer" data-position="fixed"> 
                <div data-role="navbar" id="set-input-navbar">
		                <ul>
			                <li><a onclick="javascript:workoutMgr.completeSet();" data-role="button"  id="completesetbutton" data-theme="b">Done</a></li>
			                <li><a href="#set-input-history" data-role="button" data-theme="b">History</a></li>
			                <li><a href="javascript:workoutMgr.completeSet();" class="remove" data-theme="b" >Remove</a></li>
		                </ul>
                </div>            
                <!--<h4>
	                <input value="Done" onclick="javascript:workoutMgr.completeSet();"  id="completesetbutton" data-icon="check" data-theme="b">
	                <a href="#set-input-history" data-role="button" data-rel="dialog" data-transition="pop">History</a>
	            </h4>
	            -->
            </div>            
         </div>
         
        <div data-role="page" id="set-input-history" data-theme="b">  
               <div data-role="header">
	                <h4>Workout History</h4> 
	            </div>        
	            <script type="text/javascript">
                    $('#set-input-history').live('pageshow',function(event){
                      workoutMgr.getExerciseHistory();
                    });
	            </script>
            <div data-role="content" id="set-input-history-content" data-theme="b"></div>
              <div data-role="footer" data-position="fixed"> 
                <div data-role="navbar" id="set-input-navbar">
		            <ul><li><a data-rel="back" data-role="button" data-theme="b">Back</a></li></ul>
                </div> 
              </div>                         
        </div>         

</body>
</html>
