<?php session_start();
    require 'SQLManager.class.php';
  
 
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
  <!--
   <link type="text/css" href="css/redmond/jquery-ui-1.8.16.custom.css" rel="stylesheet" />	
   <script type="text/javascript" src="js/jquery-1.6.2.min.js"></script>
   <script type="text/javascript" src="js/jquery-ui-1.8.16.custom.min.js"></script> 
   -->
</head>

<body style="text-align:center;">
<div data-role="header">
    <h1>Gym Time</h1>
</div>    
<h3>Login</h3>

<form action="<?php print $_SERVER['PHP_SELF']; ?>" method="post">
    Username <input type="text" name="username" /> <div style="margin-top:15px;"/>
    Password <input type="password" name="pw" />
    <div style="margin-left:auto;margin-right:auto; width:40%;">
        <input type="submit" name="submit" value="Validate" data-theme="b" id="submitlogin"/>
    </div>
</form>
<?php
    if(isset($_POST['submit'])){
        $sqlMgr = new SQLManager();
        $username = mysql_real_escape_string($_POST['username']);
        $pw = mysql_real_escape_string($_POST['pw']);
        $result = $sqlMgr->validateUser($username, md5($pw));
        if($result != -1){
            $_SESSION['isLoggedIn'] = true;
            $_SESSION['UserID'] = $result;
            $_SESSION['Username'] = $username;
            $sqlMgr->logLogin("SUCCESS", $result);
            header( 'Location: index.php');
        } else {
            $sqlMgr->logLogin("FAILED", '-1');
            print 'You have provided an incorrect username/password. Please try again.';
        }
        
    }
?>  



</body>
</html>
