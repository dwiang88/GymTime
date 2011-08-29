// JS Goods

function WorkoutManager(){
	WorkoutManager.prototype.addExercise = function(){
		
	}
}

function Workout() {
	this.date;
	this.exercises = [];
	
	Workout.prototype.setDate = function(date){
		this.date = date;
	}
	
	Workout.prototype.addExercise = function(name){
		this.exercises[this.exercises.length] = new ExerciseSets(name);
	}
	

}

function ExerciseSets(name){
	this.exerciseName = name;
	this.sets = [];
	this.id = 0;
	
	ExerciseSets.prototype.setExerciseName = function(name){
		this.exerciseName = name;
	}
	ExerciseSets.prototype.getExerciseName = function(){
		return this.exerciseName;
	}	
	
	ExerciseSets.prototype.addSet = function(reps, weight){
		this.sets[this.sets.length] = new Set(reps,weight);
	}
}

function Set(){
	this.repetitions;
	this.weight;
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

var workout = new Workout();
workout.addExercise("Curls");
workout.addExercise("Curls");

