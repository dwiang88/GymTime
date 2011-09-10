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
			</script> 
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
		                    print	"$('#exercises-completed').live('pagecreate',function(event){ workoutMgr.setSetId('" . $setId . "');});";
                            $data = $sqlMgr->getExerciseData($setId);
                            print   "$('#exercises-completed').live('pagecreate',function(event){workoutMgr.load('" . $data  . "');});";
                        }
                        print '</script>';
                    ?>       
                        <fieldset class="ui-grid-a">
	                        <div class="ui-block-a"><a href="#exercise-selection" data-role="button" data-icon="plus" data-theme="b">Start Exercise</a></div>
	                        <div class="ui-block-b"><a href="index.php" data-role="button" data-icon="check" data-theme="b">Finish Workout</a></div>	   
                        </fieldset>
                        <div id="ExercisesCompleted"></div>
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
	                <h4>	
		                <?php 
			                print date("l F j, Y",strtotime($sqlMgr->getWorkoutDate($workoutId))); 
		                ?>
	                </h4>        
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


                <select name="exercises" id="exercises" >
                <option data-placeholder="true">Select Exercise</option>
                <?php
                   foreach ($sqlMgr->getExercises(null) as $exercise){
                       print '<option value="' . $exercise["ID"] .'">' . $exercise["Name"] .'</option>';
                   }           
                ?>
                </select>

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
               <div data-role="header">
	                <h4><span id="set-input-title"></span></h4> 
	            </div>        
            <div data-role="content">  
                <div id="ExercisesContainer"></div>
            </div>
            <div  data-role="footer" data-position="fixed"> 
	            <h4>
	            <input value="Complete" onclick="javascript:workoutMgr.completeSet();"  id="completesetbutton" data-icon="check" data-theme="b">
	            <a href="" data-role="button" id="removesetbutton" data-icon="delete">Remove</a>
	            <a href="#set-input-history"  data-rel="dialog" data-theme="b" data-role="button" id="removesetbutton" data-icon="delete">History</a>
	            </h4> 
            </div>            
         </div>
         
        <div data-role="page" id="set-input-history">  
               <div data-role="header">
	                <h4>Workout History</h4> 
	            </div>        
	            <script type="text/javascript">
                    $('#set-input-history').live('pagecreate',function(event){
                      workoutMgr.getExerciseHistory();
                    });
	            </script>
            <div data-role="content" id="set-input-history-content">
            </div>           
         </div>         

</body>
</html>
