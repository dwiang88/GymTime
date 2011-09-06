// JS Goods
//var workoutMgr = new WorkoutManager();



// JS Objects
function DataQuery(){
	var QueryType = {Move: "Move", Question :"Question"};
	
	DataQuery.prototype.removeSet = function(exerciseId, setId){
		return this.queryData({Action: "RemoveSet", SetId: setId, ExerciseId:exerciseId});
	}
	
	DataQuery.prototype.updateSet = function(id, weight, reps, setNumber, workoutId){
	    return this.queryData({Action: "AddSet", ExerciseId:id, Weight: weight, Repetitions:reps, SetNumber:setNumber, WorkoutId:workoutId});
	}
	
	DataQuery.prototype.getExercises = function (muscleGroup){
		return this.queryData({Action: "GetExercises", MuscleGroup: muscleGroup});
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
	this.setId;
	this.currentExerciseId;
	
	// Used for instances where a handle to the JS object is needed inside a jQuery function. jQuery overrides this to refer to the current DOM element.
	var _this = this; 
	
	WorkoutManager.prototype.completeSet = function(){
	   $("#StartExercisePanel").attr("style", "");
	   $("#ExercisePanel").hide();	
	   $("#CompleteSet").hide();
	   $("#ExercisesContainer").hide();  
	   this.refreshExercises();
	   $("#completedexerciseslist").listview();
	   
	   

	}
	
	WorkoutManager.prototype.startExercise = function(){
	   $("#StartExercisePanel").hide();
	   $("#ExercisePanel").show();
		   
	}
	
	WorkoutManager.prototype.showCompletedExercise = function (id){
	   this.addToScreen(id);
	   $("#StartExercisePanel").hide();
	   $("#ExercisesContainer").show();
	   $("#completesetbutton").button();
	   $("#removesetbutton").button();	   
	   
	}
	
	WorkoutManager.prototype.muscleGroup = function(){
		var selectedGroup = $(this).val();
		$("#exercises").attr("disabled","disabled");
		$.mobile.pageLoading();
		var exercises = jQuery.parseJSON(_this.dataQuery.getExercises(selectedGroup));
		var html = '';
		for(var x in exercises){
			html += '<option value="' + exercises[x].ID + '" >' + exercises[x].Name + '</a>';
		}
		$("#exercises").html(html);
		$("#exercises").removeAttr("disabled");
		$.mobile.pageLoading(true);
		var myselect = $("select#exercises");
        myselect[0].selectedIndex = 3;
        myselect.selectmenu("refresh");
		
		
	}
	
	WorkoutManager.prototype.cycle = function(motion){
			var indexCount = this.workout.getExercises().length - 1;
			if(motion == "next"){
				if(this.currentExerciseId < indexCount){
					this.addToScreen(this.currentExerciseId + 1);
				} else {
					this.addToScreen(0);
				}
			} else if(motion == "previous"){
				if(this.currentExerciseId > 0){
					this.addToScreen(this.currentExerciseId - 1);
				} else {
					this.addToScreen(indexCount);
				}
			}
			
	}


	WorkoutManager.prototype.setSetId = function(setId){
		this.setId = setId;
		//alert(this.setId);
	}
	WorkoutManager.prototype.getSetId = function(){
		return this.setId;
	}
	WorkoutManager.prototype.load = function(jsonExercises){
	    var exercises = jQuery.parseJSON(jsonExercises);
	    for(var x in exercises){     
	        this.loadExercise(exercises[x].Name,exercises[x].ID, exercises[x].Set);
	    }
	}
	WorkoutManager.prototype.loadExercise = function(name, id, sets){
	    this.workout.addExercise(name,id);
	    var id = this.workout.getExerciseIdIndex(id);
        for(var i in sets){
            var weight = sets[i].Weight;
            var reps = sets[i].Repetitions;
            var setNumber = sets[i].SetNumber;
            this.workout.getExercises()[id].addSet(weight,reps,setNumber);
        }
        //$("#ExercisesCompleted").append("<div><a href='javascript:workoutMgr.addToScreen(" + id + ");'>" + name + "</a></div>");	    
        
        this.refreshExercises();
	    //this.addToScreen(id);
    }
    WorkoutManager.prototype.refreshExercises = function(){
    var html = '';
      for(var x in this.workout.getExercises()){
         var exerciseName = this.workout.getExercises()[x].getExerciseName();
         var id = this.workout.getExercises()[x].getExerciseID();
         var idx = this.workout.getExerciseIdIndex(id);
         html += "<li><a href='javascript:workoutMgr.showCompletedExercise(" + idx + ");'>" + exerciseName + "</li>";
      }
      $("#ExercisesCompleted").html('<ul data-role="listview" data-theme="g" id="completedexerciseslist"><li data-role="list-divider">Completed Exercises</li>' + html + '</ul>');
	  
      
    }
    
	WorkoutManager.prototype.addExercise = function(){
		var isValid = this.workout.addExercise(this.getExercise().Name,this.getExercise().ID);
		//this.refresh();
		if(isValid){
			this.addToScreen(this.workout.getExerciseIdIndex(this.getExercise().ID));
			$("#CompleteSet").show();
			$("#ExercisePanel").hide();
			$("#ExercisesContainer").show();
	        $("#completesetbutton").button();
	        $("#removesetbutton").button();			
		}
	}
	
	WorkoutManager.prototype.removeExercise = function(exerciseId,setId){
		var rowsRemoved = this.dataQuery.removeSet(exerciseId,setId);
		
		this.workout.removeExercise(exerciseId);
      this.completeSet();
		// Remove the element with class value of workout-set and id of exerciseId
		//$(".workout-set#" + exerciseId).remove();
		//this.addToScreen(0);
		
		
	}

	this.addToScreen = function(x){
		var html_title = '';
		var html_inputs = '';
		html_exercise = '';
		this.currentExerciseId = x;
		
		var name = this.workout.getExercises()[x].getExerciseName();
		var id = this.workout.getExercises()[x].getExerciseID();
		var sets = this.workout.getExercises()[x].getSets();

		
		html_title = '<div class="workout-set-title"><h3>' + name  + '</h3></div>';
		html_inputs = '';

		for(var i =0; i < 4; i++){
			var setNum = i + 1;
		  
			html_inputs +='<div class="workout-sets" id="setnumber' + setNum +'">';
			html_inputs +='		<div>';
			html_inputs +='			<input type="text" value="' + (sets[i] == undefined ? "" : sets[i].getWeight()) + '" class="workout-input weight" />lbs x';
			html_inputs +='			<input type="text" value="' + (sets[i] == undefined ? "" : sets[i].getRepetitions()) + '" class="workout-input repetitions" />';
			html_inputs +='		</div>';
			html_inputs +=' </div>';		
		}
		html_remove = '<a href="javascript:workoutMgr.removeExercise(' + id +', ' + this.setId + ');" data-role="button" id="removesetbutton" data-icon="delete">Remove</a>';
		html_exercise += '<div class="workout-set" id="' +  id +'">' + html_title + html_inputs + '</div>';
		
		var html_complete = '<div id="CompleteSet"><a href="javascript:workoutMgr.completeSet();" data-role="button" id="completesetbutton" data-icon="check">Complete Set</a></div>';
		$("#ExercisesContainer").html('<table><tr><td valign="top">' + html_exercise + '</td><td valign="center"><br><br>' + html_remove + '' + html_complete + '</td></tr></table>');

		//$("#ExercisesContainer").append(html_exercise);
		this.addInputEventHandlers();
	}
	
	this.refresh = function(){
		var html_title = '';
		var html_inputs = '';
		var html_exercise = '';
		for(var x in this.workout.getExercises()){
			html_exercise = '';
			var name = this.workout.getExercises()[x].getExerciseName();
			var id = this.workout.getExercises()[x].getExerciseID();
			var sets = this.workout.getExercises()[x].getSets();

			
			html_title = '<div class="workout-set-title">' + name  + '</div>';
			html_inputs = '';

		    for(var i =0; i < 4; i++){
		        var setNum = i + 1;
		      
			    html_inputs +='<div class="workout-sets" id="setnumber' + setNum +'">';
			    html_inputs +='		<div>';
			    html_inputs +='			<input type="text" value="' + (sets[i] == undefined ? "" : sets[i].getWeight()) + '" class="workout-input weight" />lbs x';
			    html_inputs +='			<input type="text" value="' + (sets[i] == undefined ? "" : sets[i].getRepetitions()) + '" class="workout-input repetitions" />';
			    html_inputs +='		</div>';
			    html_inputs +=' </div>';		
		    }
		    
			html_exercise += '<div class="workout-set" id="' +  id +'">' + html_title + html_inputs + '</div>';
			
			//$("#ExercisesContainer").append(html_exercise);
		}
		$("#ExercisesContainer").html('<table width="100%"><tr><td valign="top">' + html_exercise + '</td><td><a href="javascript:workoutMgr.removeExercise(' + id +', '+  + ');">1Remove</a></td></tr></table>');
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
				_this.workout.getExercises()[_this.workout.getExerciseIdIndex(id)].addSet(weight,reps,setNumber);
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
	
	Workout.prototype.addExercise = function(name, id, sets){
		var isValid;
		if(this.exerciseExists(id)){
			alert("This exercise has already been added.");
			isValid = false;
		} else if(name == "" || id == "") {
		    alert('Select an exercise.');
		} else {
			this.exercises[this.exercises.length] = new ExerciseSets(name, id);
			isValid = true;
		}
		return isValid;
	}
	Workout.prototype.getExerciseIdIndex = function(exerciseId){
		var idx = -1;
		for (var x in this.exercises){
			if(exerciseId == this.exercises[x].getExerciseID()){

				idx = x;
			}
		}
		return idx;	    
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
	ExerciseSets.prototype.addSet = function(weight, reps, setNumber){
		var exists = false;
		for(var x in this.sets){
			if(this.sets[x].getSetNumber() == setNumber){
				this.sets[x].setWeight(weight);
				this.sets[x].setRepetitions(reps);
				exists = true;
			}
		}
		if(!exists){
			this.sets[this.sets.length] = new Set(reps,weight,setNumber);
		}
		
	}
	ExerciseSets.prototype.getSets = function(){
	    return this.sets;
	}
}

function Set(reps, weight,setNumber){
	this.repetitions = reps;
	this.weight = weight;
	this.setNumber = setNumber;	
	
	Set.prototype.getSetNumber = function(){
	    return this.setNumber;
    }
    Set.prototype.getWeight = function(){
        return this.weight;
    }		
    Set.prototype.getRepetitions = function(){
        return this.repetitions;
    }
	Set.prototype.setWeight = function(weight){
		this.weight = weight;
	}
	Set.prototype.setRepetitions = function(reps){
		this.repetitions = reps;
	}
}

// Functions to call after page is loaded

        $(document).bind('mobileinit',function(){
		    
		    	//$("#exercise_categories").change(workoutMgr.muscleGroup);
	            //$('.button').css("font-size", "12").button();
		});	

