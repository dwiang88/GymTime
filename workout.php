<html>
<head>
<title>Workout</title>
<link type="text/css" rel="stylesheet" href="css/gymtime.css" /> 
  <script type="text/javascript" src="js/jquery-1.6.2.min.js"></script> 
  <script type="text/javascript" src="js/gymtime.js"></script> 
</head>

<body>

<div class="workout-date-header">
	<span>Friday August 26th 2011</span>
</div>
<a href="javascript:workoutMgr.addExercise();">Add Exercise</a>
	<div class="workout-set-exercise" style="display:inline;">
		<select name="exercises" id="exercises" >
			<option value="1">Curls</option>
			<option value="2">Barbell Bench Press</option>
			<option value="3">Squat</option>
		</select>
	</div>

<!--<div class="workout-set">
<div class="workout-set-title">Barbell Bench Press</div>
		<div class="workout-sets" >
			<div>
				<input type="text" class="workout-input" /> x
				<input type="text" class="workout-input" />
			</div>
		</div>
		<div class="workout-sets" >
			<div>
				<input type="text" class="workout-input" /> x
				<input type="text" class="workout-input" />
			</div>
		</div>
		<div class="workout-sets" >
			<div>
				<input type="text" class="workout-input" /> x 
				<input type="text" class="workout-input" />
			</div>
		</div>
		<div class="workout-sets">
			<div>
				<input type="text" class="workout-input" /> x 
				<input type="text" class="workout-input" />
			</div>
		</div>		
</div>
-->
<div id="ExercisesContainer"></div>

</body>
</html>