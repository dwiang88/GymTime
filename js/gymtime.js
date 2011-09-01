// JS Goods
//var workoutMgr = new WorkoutManager();

// Functions to call after page is loaded
$(document).ready(function(){

	
});


// JS Objects
function DataQuery(){
	var QueryType = {Move: "Move", Question :"Question"};
	
	DataQuery.prototype.updateSet = function(id, weight, reps, setNumber, workoutId){
	    return this.queryData({Action: "AddSet", ExerciseId:id, Weight: weight, Repetitions:reps, SetNumber:setNumber, WorkoutId:workoutId});
	}
	
	DataQuery.prototype.updateRepetitions = function (reps){
		return this.queryData("");
	}
	
	DataQuery.prototype.updateWeight = function (){
		return this.queryData("");
	}	
	this.queryData = function (params){
		return $.ajax({
						async: false,
						type : 'POST',
						url : 'dataquery.php',
						data: params,
				}).responseText;
		}	
}

function WorkoutManager(id,date){
	this.workout = new Workout(id, date);
	this.dataQuery = new DataQuery();
	this.workoutId = id;
	
	WorkoutManager.prototype.load = function(jsonExercises){
	    var exercises = jQuery.parseJSON(jsonExercises);
	    for(var x in exercises){
	    // References for Data
	        //exercises[x].Name;
	        //exercises[x].ID;
	        //exercises[x].Set	        
	        for(var i in exercises[x].Set){
	        //exercises[x].Set[i].Weight
	        //exercises[x].Set[i].Reps
	        //exercises[x].Set[i].SetNumber
	        }
	    }
	}
	
	WorkoutManager.prototype.addExercise = function(){
		this.workout.addExercise(this.getExercise().Name,this.getExercise().ID);
		this.refresh();
	}
	
	WorkoutManager.prototype.removeExercise = function(id){
		this.workout.removeExercise(id);
		this.refresh();
	}
	
	this.refresh = function(){
		var html_title = '';
		var html_inputs = '';
		var html_exercise = '';
		for(var x in this.workout.getExercises()){
			var name = this.workout.getExercises()[x].getExerciseName();
			var id = this.workout.getExercises()[x].getExerciseID();
			
			html_title = '<div class="workout-set-title">' + name  + '</div>';
			html_inputs = '';
			for(var i =0; i < 4; i++){
			    var setNum = i + 1;
				html_inputs +='<div class="workout-sets" id="setnumber' + setNum +'">';
				html_inputs +='		<div>';
				html_inputs +='			<input type="text" class="workout-input weight" />lbs x';
				html_inputs +='			<input type="text" class="workout-input repetitions" />';
				html_inputs +='		</div>';
				html_inputs +=' </div>';		
			}
			html_exercise += '<div class="workout-set" id="' +  id +'">' + html_title + html_inputs + '</div>';
			html_exercise += '<a href="javascript:workoutMgr.removeExercise(' + id +');">Remove</a>';
		}
		$("#ExercisesContainer").html(html_exercise);
		this.addInputEventHandlers();
	}
	
	this.addInputEventHandlers = function(){
		var _this = this;
		$(".workout-input").change(function(event){
			var id = $(this).parent().parent().parent().attr("id");
			var parent = $(this).parent().parent().parent();
			var setNumber = $(this).parent().parent().attr("id").substring(9,10);
			var weight = $("#setnumber" + setNumber + " .weight", parent).val() == "" ? 0 : $("#setnumber" + setNumber + " .weight", parent).val();
			var reps = $("#setnumber" + setNumber + " .repetitions", parent).val() == "" ? 0 : $("#setnumber" + setNumber + " .repetitions", parent).val();
            if(reps != 0 && weight != 0){
		        var result = _this.dataQuery.updateSet(id, weight, reps, setNumber,_this.workout.getWorkoutId());
		    }


		});
	}
	
	this.getExercise = function(){
		var id = $("#exercises option:selected").val();
		var text = $("#exercises option:selected").text();
		if(id != -1){
			return {"Name": text, "ID" : id};
		} else {
			alert("Must select value");
		}
	}
	
}

function Workout(id, date) {
	this.date = date;
	this.exercises = [];
	this.workoutId = id;
	
	Workout.prototype.setWorkoutId = function(id){
	    this.workoutId = id;
	}
	
	Workout.prototype.getWorkoutId = function(){
	    return this.workoutId;
	}
	
	Workout.prototype.setDate = function(date){
		this.date = date;
	}
	
	Workout.prototype.addExercise = function(name, id){
		if(this.exerciseExists(id)){
			alert("IT EXISTS");
		} else {
			this.exercises[this.exercises.length] = new ExerciseSets(name, id);
		}
	}
	Workout.prototype.removeExercise = function(id){
		for (var x in this.exercises){
			if(id == this.exercises[x].getExerciseID()){
				this.exercises.splice(x, 1);
			}
		}
	}
	
	Workout.prototype.getExercises = function(){
		return this.exercises;
	}
		
		//alert(this.exercises[this.exercises.length - 1].getExerciseID());
	
	
	// Private functions
	this.exerciseExists = function(id){
		var exists = false;
		var idToFind;
		for(var x in this.exercises){
			idToFind = this.exercises[x].getExerciseID();
			if(idToFind == id){
				exists = true;
			}
		}
		return exists;
	}
}


function ExerciseSets(name,id){
	this.exerciseName = name;
	this.sets = [];
	this.id = id;
	
	ExerciseSets.prototype.setExerciseName = function(name){
		this.exerciseName = name;
	}
	ExerciseSets.prototype.getExerciseName = function(){
		return this.exerciseName;
	}	
	ExerciseSets.prototype.getExerciseID = function(){
		return this.id;
	}
	ExerciseSets.prototype.addSet = function(reps, weight){
		this.sets[this.sets.length] = new Set(reps,weight);
	}
}

function Set(){
	this.repetitions;
	this.weight;
	this.setNumber;
	this.id;
	
	Set.Prototype.setRepetitions = function(){
	
	}
	Set.Prototype.getRepetitions = function(){
		return this.repititions;
	}	
	Set.Prototype.setWeight = function(){
	
	}
	Set.Prototype.getWeight = function(){
		return this.weight;
	}		
}


