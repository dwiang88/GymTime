<?php
    class SQLManager {
        public $con = "";
        
        function __construct() {
            $this->con = mysql_connect("localhost","root","@admin1@admin1");
            if (!$this->con){
              die('Could not connect: ' . mysql_error());
            }
            mysql_select_db("GymTime", $this->con);            
        }
        
        public function addWorkout(){
            $today = date("Y-m-d");
            //print $today;
            if(!$this->workoutExists($today)){
                $sql = "INSERT INTO Workouts (Date, SetID, UserID) VALUES ('$today', '-1', '1');";
                mysql_query($sql);
                $id = $this->getWorkoutID($today);
                return $id;
            } else {
                return $this->getWorkoutID($today);
            }
        }
        
        public function getWorkoutDate($id){
            $date;
            $sql = "SELECT Date FROM Workouts WHERE WorkoutID = '$id'";
            $result = mysql_query($sql, $this->con);
            while($row = mysql_fetch_array($result)) {
                $date = $row['Date'];
            }
            return $date;              
        }
                
        private function getWorkoutID($date){
            $id;
            $sql = "SELECT * FROM Workouts WHERE Date = \"$date\"";
            $result = mysql_query($sql, $this->con);
            while($row = mysql_fetch_array($result)) {
                $id = $row['WorkoutID'];
            }
            return $id;                
        }
        
        private function workoutExists($date){
            $sql = "SELECT * FROM Workouts WHERE Date = \"$date\"";
            $result = mysql_query($sql, $this->con);
            $count = mysql_num_rows($result);
            if($count == 0){
                return false;
            } else {
                return true;
            }
        }
        
        public function getExercises(){
            $data = array();
            $sql = "SELECT * FROM Exercises";
            $result = mysql_query($sql, $this->con);
            while($row = mysql_fetch_array($result)) {
                //print $row['Name'];
                array_push($data, array("ID"=>$row['ExerciseID'], "Name"=>$row['Name']));
            }
            return $data;   
        }
        
        public function UpdateSet($exerciseId, $weight, $reps, $setNumber, $workoutId){
            $setId = $this->getWorkoutSetID($workoutId);
            if($setId == -1){
                $newSetId = $this->generateSetID();
                //$this->updateWorkoutSetID($workoutId,$newSetId);
                if(!$this->setNumberExists($newSetId, $exerciseId,$setNumber)){
                    $this->addNewSet($setId,$exerciseId,$setNumber,$weight,$reps);
                }
                
            } else {
            
            }
        }
        
        private function addNewSet($setId,$exerciseId,$setNumber,$weight,$reps){
            
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
        
        private function getWorkoutSetID($id){
            $setId;
            $sql = "SELECT * FROM Workouts WHERE WorkoutID = \"$id\"";
            $result = mysql_query($sql, $this->con);
            while($row = mysql_fetch_array($result)) {
                $setId = $row['SetID'];
            }
            return $setId;         
        }

    }


?>
