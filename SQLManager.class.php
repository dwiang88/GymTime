<?php
session_start();
    class SQLManager {
        public $con = "";
        
        function __construct() {
		try{
		      $env = json_decode(file_get_contents("/home/dotcloud/environment.json"), true);
			 } catch (Exception $ex){
			 
			 }
		      if(!isset($env)){
		         // Debug Environment. Don't bother using ha.
               $this->con = mysql_connect('localhost',
                     'root',
                     '@admin1@admin1');
               if (!$this->con){
                 die('Could not connect: ' . mysql_error());
               }
               mysql_select_db("gymtime", $this->con); 		         
		      } else {
		      // Real deal. 
               $this->con = mysql_connect($env['DOTCLOUD_DB_MYSQL_HOST']. ":" . $env['DOTCLOUD_DB_MYSQL_PORT'],
                     $env['DOTCLOUD_DB_MYSQL_LOGIN'], 
                     $env['DOTCLOUD_DB_MYSQL_PASSWORD']);
               if (!$this->con){
                 die('Crap, it screwed up. Check the database.');
               }
               mysql_select_db("gymtime1", $this->con);       
            }
        }
        
        public function getWorkouts(){
            $userId = $_SESSION['UserID'];
            $sql = "SELECT * FROM Workouts WHERE UserID=\"$userId\" ORDER BY Date DESC";
            $data = array();
            $result = mysql_query($sql, $this->con);
            while($row = mysql_fetch_array($result)) {
                $data[] = array("WorkoutID"=>$row['WorkoutID'], "Date"=>$row['Date'], "SetID"=>$row['SetID']);
            }
            return $data;             
        }
        
        public function addWorkout(){
            $today = date("Y-m-d");
            //print $today;
            $userId = $_SESSION['UserID'];
            if(!$this->workoutExists($today)){
                $sql = "INSERT INTO Workouts (Date, SetID, UserID) VALUES ('$today', '-1', '$userId');";
                mysql_query($sql);
                $id = $this->getWorkoutID($today);
                return $id;
            } else {
                return $this->getWorkoutID($today);
            }
        }
        
        public function getWorkoutDate($id){
            $date;
            $userId = $_SESSION['UserID'];
            $sql = "SELECT Date FROM Workouts WHERE WorkoutID = '$id' AND UserID=\"$userId\"";
            $result = mysql_query($sql, $this->con);
            while($row = mysql_fetch_array($result)) {
                $date = $row['Date'];
            }
            return $date;              
        }
                
        public function getWorkoutID($date){
            $id;
            $userId = $_SESSION['UserID'];
            $sql = "SELECT * FROM Workouts  WHERE Date = \"$date\" AND UserID=\"$userId\"";
            $result = mysql_query($sql, $this->con);
            while($row = mysql_fetch_array($result)) {
                $id = $row['WorkoutID'];
            }
            return $id;                
        }
        
        private function workoutExists($date){
            $userId = $_SESSION['UserID'];
            $sql = "SELECT * FROM Workouts WHERE UserID=\"$userId\" AND Date = \"$date\"";
            $result = mysql_query($sql, $this->con);
            $count = mysql_num_rows($result);
            if($count == 0){
                return false;
            } else {
                return true;
            }
        }
        
        public function getExercises($muscleGroup){
            $data = array();
            $sql = $muscleGroup == null ? "SELECT * FROM Exercises ORDER BY MuscleGroup ASC" : "SELECT * FROM Exercises WHERE MuscleGroup =\"$muscleGroup\" ORDER BY MuscleGroup ASC";
            $result = mysql_query($sql, $this->con);
            while($row = mysql_fetch_array($result)) {
                //print $row['Name'];
                array_push($data, array("ID"=>$row['ExerciseID'], "Name"=>$row['Name']));
            }
            return $data;   
        }
		
        public function getExerciseCategories(){
            $data = array();
            $sql = "SELECT ExerciseID, MuscleGroup FROM Exercises GROUP BY MuscleGroup ASC";
            $result = mysql_query($sql, $this->con);
            while($row = mysql_fetch_array($result)) {
                //print $row['Name'];
                array_push($data, array("ID"=>$row['ExerciseID'], "MuscleGroup"=>$row['MuscleGroup']));
            }
            return $data;   
        }		
        
        public function UpdateSet($exerciseId, $weight, $reps, $setNumber, $workoutId){
            $setId = $this->getWorkoutSetID($workoutId);
            if($setId == -1){
                $newSetId = $this->generateSetID();
                $this->updateWorkoutSetID($workoutId,$newSetId);
                if(!$this->setNumberExists($newSetId, $exerciseId,$setNumber)){
                    $this->addNewSet($newSetId,$exerciseId,$setNumber,$weight,$reps);
                    //print 'Added!';
                }  else {print 'Blah';}
                
            } else {
                if(!$this->setNumberExists($setId, $exerciseId,$setNumber)){
                    //print 'Adding set';
                    $this->addNewSet($setId,$exerciseId,$setNumber,$weight,$reps);
                } else {
                    $sql = "UPDATE Sets SET Weight='$weight', Repetitions='$reps' WHERE SetID='$setId' AND ExerciseID='$exerciseId' AND SetNumber='$setNumber';";
                    mysql_query($sql);                
                }
            }
        }
        
        private function addNewSet($setId,$exerciseId,$setNumber,$weight,$reps){
            $sql = "INSERT INTO Sets (SetID, ExerciseID, Weight, Repetitions, SetNumber) VALUES ('$setId', '$exerciseId', '$weight', '$reps', '$setNumber');";
            mysql_query($sql);            
        }
        
        private function setNumberExists($setId,$exerciseId,$setNumber){            
            $sql = "SELECT * FROM Sets WHERE SetID = $setId AND ExerciseID=$exerciseId AND SetNumber=$setNumber";
            $result = mysql_query($sql, $this->con);
            $row = mysql_fetch_row($result);
            if($row[0] == ""){
                return false;
            } else {
                return true;
            }
            
        }
        
        private function updateWorkoutSetID($workoutId, $setId){
            $sql = "UPDATE Workouts SET SetID = '$setId' WHERE WorkoutID = $workoutId;";
            mysql_query($sql);
        }
        
        private function generateSetID(){
            $newSetId;
            $sql = "SELECT DISTINCT SetID FROM Sets ORDER BY SetID DESC";
            $result = mysql_query($sql, $this->con);
            $row = mysql_fetch_row($result);
            return ++$row[0];
        }
        
        public function getWorkoutSetID($id){
            $setId;
            $userId = $_SESSION['UserID'];
            $sql = "SELECT * FROM Workouts WHERE WorkoutID = \"$id\" AND UserID=\"$userId\"";
            $result = mysql_query($sql, $this->con);
            while($row = mysql_fetch_array($result)) {
                $setId = $row['SetID'];
            }
            return $setId;         
        }
        
        public function getExerciseData($setId){
            $exerciseIds = $this->getSetExercisesIDs($setId);
            $exercises = array();
            foreach ($exerciseIds as $exerciseId){
                $sql = "SELECT Sets.ExerciseID, Weight, Name, Repetitions, SetNumber FROM Sets, Exercises WHERE Exercises.ExerciseID = Sets.ExerciseID AND SetID=\"$setId\" AND Sets.ExerciseID = \"$exerciseId\" ORDER BY Sets.SetNumber;";
                $result = mysql_query($sql, $this->con);
                $sets = array();
                $exerciseName = "";
                while($row = mysql_fetch_array($result)) {
                    $sets[] = array('Weight' => $row["Weight"], 'Repetitions' => $row['Repetitions'], 'SetNumber'=> $row['SetNumber']);
                    $exerciseName = $exerciseName == "" ? $row["Name"] : $exerciseName;
                    //$exercises[] = "JOhn";
                }
                $exercises[] = array("Name"=>$exerciseName, "ID"=>$exerciseId, "Set" => $sets);        
            }
            
            return json_encode($exercises); 
           
            
        }
		public function getWorkoutMuscleGroups($setId){
		    $sql = "SELECT DISTINCT Exercises.MuscleGroup FROM Sets,Exercises WHERE SetID = \"$setId\" AND Sets.ExerciseID = Exercises.ExerciseID;";
            $result = mysql_query($sql, $this->con);
            $data = array();
            $x = 1;
            while($row = mysql_fetch_array($result)) {
                $cnt = count($row);
                $data[] = $row['MuscleGroup'];
                $x++;
            }
            return $data;		    
		}
		
		public function removeSet($exerciseId,$setId){
			mysql_query("DELETE FROM Sets WHERE ExerciseID=\"$exerciseId\" AND SetID =\"$setId\" ");
			$removed = mysql_affected_rows();
			mysql_close($this->con);
			print $removed;
		}
        
        private function getSetExercisesIDs($setId){
            $exerciseIds = array();
            $sql = "SELECT DISTINCT SetID, ExerciseID FROM Sets WHERE SetID=\"$setId\"";
            $result = mysql_query($sql, $this->con);
            while($row = mysql_fetch_array($result)) {
                $exerciseIds[] = $row['ExerciseID'];
            }
            return $exerciseIds;         
        }
        public function validateUser($username, $pw){
            $userId = "-1";
            $sql = "SELECT UserID FROM Users WHERE Username=\"$username\" AND Password=\"$pw\"";
            $result = mysql_query($sql, $this->con);
            while($row = mysql_fetch_array($result)) {
                $userId = $row['UserID'];
            }
            return $userId;            
        }

    }


?>
