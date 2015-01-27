<?php require_once('includes/config.php'); 
include('includes/functions.php');
session_start();
if (isset($_SESSION['user'])) {
header('Location: index.php');
}

//mysql_select_db($database_contacts, $contacts);
$pagetitle = "Login";

if ($_POST['email']  && $_POST['password']) {
record_set('logincheck',"SELECT * FROM users WHERE user_email = '".addslashes($_POST['email'])."'");


$pass = $row_logincheck['user_password'];
if(crypt($_POST['password'],$pass) == $pass)
{
if (!isset($_SESSION['login_id'])) {
//record login attempt
sqlsrv_query($contacts,"INSERT INTO login (login_IP, login_user, login_date, login_attempts, login_success) VALUES 

	(
		'".getUserIP()."',
		'".$_POST['email']."',
		'".time()."',
		'0',
		'1'
	)

	");
	$_SESSION['login_id'] = sqlsrv_query($contacts,"SELECT TOP 1 login_id FROM login ORDER BY login_id DESC");
	}
	else {
	sqlsrv_query($contacts,"UPDATE login SET 
	login_IP = '".getUserIP()."',
	login_user = '".$_POST['email']."',
	login_date = '".time()."',
	login_success = '1' 
	
	WHERE login_id = '".$_SESSION['login_id']."'");
	}
	

$_SESSION['user'] = addslashes($_POST['email']);
	$redirect = 'index.php';
	header(sprintf('Location: %s', $redirect)); die;
}
else {
if (!isset($_SESSION['login_id'])) {
sqlsrv_query($contacts,"INSERT INTO login (login_IP, login_user, login_date, login_attempts, login_success) VALUES 

	(
		'".getUserIP()."',
		'".$_POST['email']."',
		'".time()."',
		'0',
		'0'
	)

	");

$_SESSION['login_id'] = sqlsrv_query($contacts,"SELECT TOP 1 login_id FROM login ORDER BY login_id DESC");
}
else {

sqlsrv_query($contacts,"UPDATE login SET 
	login_IP = '".getUserIP()."',
	login_user = '".$_POST['email']."',
	login_date = '".time()."',
	login_attempts = login_attempts + 1,
	login_success = '0' 
	
	WHERE login_id = '".$_SESSION['login_id']."'");
}

$_SESSION['login_attempts'] = $_SESSION['login_attempts'] + 1;

if ($_SESSION['login_attempts'] >= 5) {
$sleep_time = pow(2,($_SESSION['login_attempts'] ) - 5);
sleep($sleep_time);

if ($_SESSION['login_attempts'] == 5 || $_SESSION['login_attempts'] %10 == 0 ) {
//SEND EMAIL WITH PASSWORD
$emailfrom = "assets@scotcallgroup.com";
$name = "scotcall assets";
$subject = "Log in Error";
$message = "Login attempt:<br/>IP: " . getUserIP() . "<br/>Username: " . $_POST['email'] . "<br/> Session ID: " . $_SESSION['login_id'] . "<br/> Time: " . date("d/m/y - g:i:s a") . "<br/> No. of Attempts: " . $_SESSION['login_attempts'];
$emailto = "nmcbride@scotcallgroup.com";

mail($emailto, $subject, $message, 
	"From: $name <$emailfrom>\n" .
	"MIME-Version: 1.0\n" .
	"Content-type: text/html; charset=iso-8859-1");

//END SEND EMAIL
}
}
if ($_SESSION['login_attempts'] >= 5) {
redirect('Incorrect Username or Password<br/> Too many attempts. Next lockout: ' . ($sleep_time*2) . ' second(s)',"login.php");
}
else{
redirect('Incorrect Username or Password',"login.php");
}
}
}
/*if ($totalRows_logincheck==1) { 
	$_SESSION['user'] = addslashes($_POST['email']);
	$redirect = 'index.php';
	header(sprintf('Location: %s', $redirect)); die;	
	}
*/

/*if ($totalRows_logincheck < 1) { 
redirect('Incorrect Username or Password',"login.php");
}
*/



?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?php echo $pagetitle; ?></title>
<script src="includes/lib/prototype.js" type="text/javascript"></script>
<script src="includes/src/effects.js" type="text/javascript"></script>
<script src="includes/validation.js" type="text/javascript"></script>
<link href="includes/style.css" rel="stylesheet" type="text/css" />
<link href="includes/scotcall.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div class="logincontainer">
  <img src="includes/logo.png" align="left"/>
	<h1>scotcall asset register</h1><br/>
  <form id="form1" name="form1" method="post" action="">

    <?php display_msg(); ?>
Email Address <br />
    <input name="email" type="text" size="35" class="required validate-email" title="You must enter your email address." />
    <br />
    <br />
    Password<br />
    <input type="password" name="password" class="required" title="Please enter your password." />
    <br />
    <br />
    <input type="submit" name="Submit" value="Login" />
    <a href="password.php">Forgotten your password?</a>
	<br/>
	<br/>
	You are logging on from IP address: <em><strong><?php echo getUserIP(); ?></strong></em>
	<br/> <?php if ($_SESSION['login_attempts']){ echo 'Logon Attempt - ' . $_SESSION['login_attempts']; }?>
  </form>
					<script type="text/javascript">
						var valid2 = new Validation('form1', {useTitles:true});
					</script>
</div>
</body>
</html>