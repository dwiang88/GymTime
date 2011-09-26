<?php session_start();
    require 'SQLManager.class.php';
    require 'validate.php';   
?>
<!DOCTYPE html>
<html>
<head>
<title>Settings</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
  <link type="text/css" rel="stylesheet" href="css/gymtime.css" /> 
  <script src="js/gymtime.js"></script>
<link rel="stylesheet" href="http://code.jquery.com/mobile/1.0b3/jquery.mobile-1.0b3.min.css" />
<script src="http://code.jquery.com/jquery-1.6.2.min.js"></script>
<script src="http://code.jquery.com/mobile/1.0b3/jquery.mobile-1.0b3.min.js"></script>
</head>

<body>
<div data-role="page" id="completed-workouts">
<div data-role="header">
	<a href="index.php" data-icon="back" data-theme="b">Back</a>
    <h1>Settings</h1>
</div>    
 <div data-role="content">
 <?php
    print 'Your username: <b>' .  $_SESSION['Username'] . '</b>';
 ?>
<br>
<div style="text-align:center;">
<?php
if(isset($_POST['submit'])){
    if(strlen(trim($_POST['pw'])) != 0 && strlen(trim($_POST['newpw'])) != 0 && strlen(trim($_POST['confirmpw'])) != 0){
        $sqlMgr = new SQLManager();
        $result = $sqlMgr->validateUser($_SESSION['Username'],md5($_POST['pw']));
        if($result != -1){
            if(strcmp(md5($_POST['newpw']), md5($_POST['confirmpw'])) == 0){
                $result = $sqlMgr->changePassword($_POST['newpw']);
                if($result == 1){
                    print ' Your password was successfully changed!';
                } else {
                    print 'Error changing the password. Contact the administrator.';
                }
            } else {
                print 'Your new passwords do not match';
            }
        } else {
            print 'Current password entered is invalid.';
        }
    } else {
        print 'Must enter a value for each of the fields.';
    }
            
} else {
?>
    <form action="<?php print $_SERVER['PHP_SELF']; ?>" method="post">
        <span style="margin-top:20px; display:block;">Current Password: </span>
        <input type="password" id="pw" name="pw"/>

        <span style="margin-top:20px; display:block;">New Password: </span>
        <input type="password" id="newpw" name="newpw"/>  

        <span style="margin-top:20px; display:block;">Confirm New Password: </span>
        <input type="password" id="confirmpw" name="confirmpw"/>  

        <input type="submit" id="submit" name="submit" value="Submit" data-theme="b"/>
    </form>
<?php
    }
?>
</div>
</div>
</div>

</body>
</html>
