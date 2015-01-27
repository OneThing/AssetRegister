<?php require_once('includes/config.php'); 
include('includes/sc-includes.php');
$pagetitle = 'Admin';

mysql_select_db($database_contacts, $contacts);

//restrict access
if (!$user_admin) {
header('Location: index.php'); die;
}
//

$update = isset($_GET['id']) ? 1 : 0;
$add = isset($_GET['add']) ? 1 : 0;


if (!$update && !$add) {
record_set('users',"SELECT * FROM users ORDER BY user_email ASC");
}


if ($update) {
record_set('userp',"SELECT * FROM users WHERE user_id = ".$_GET['id']."");
}

$password = $row_userp['user_password'];

if ($_POST['password']) {
$password = $_POST['password'];
}

//ADD user
if ($add && $_POST['user_email']) {
$password = crypt($password);

sqlsrv_query($connection,"INSERT INTO users (user_level, user_name, user_email, user_password) VALUES

(
	'".$_POST['user_level']."',
	'".$_POST['user_name']."',
	'".trim($_POST['user_email'])."',
	'".$password."'
)

");
set_msg('User Added');
header('Location: admin.php'); die;
}
//

//don't let an admin change their own status to anything but admin
$ulevel = $_POST['user_level'];
if ($user_admin == $_GET['id'] && $_POST['user_level'] != 1) {
$ulevel = 1;
}
//

//UPDATE user
if ($_POST['user_email'] && $update) {
$password = crypt($password);

	sqlsrv_query($connection,"UPDATE users SET 
		user_level = '".$ulevel."',
		user_name = '".$_POST['user_name']."',
		user_email = '".trim($_POST['user_email'])."', 
		user_password = '".trim($password)."' 
	WHERE user_id = ".$_GET['id']."
	");
	
	set_msg('User Updated');
	if ($row_userp['user_id'] == $userid) {
	$_SESSION['user'] = $_POST['email'];
	}
	
	
	header('Location: admin.php'); die;
}
//

$user_status[1] = 'System Admin';
$user_status[2] = 'Writer';
$user_status[3] = 'Read Only';
$user_status[4] = 'Administrator';

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>IT Users</title>
<script src="includes/lib/prototype.js" type="text/javascript"></script>
<script src="includes/src/effects.js" type="text/javascript"></script>
<script src="includes/validation.js" type="text/javascript"></script>
<link href="includes/style.css" rel="stylesheet" type="text/css" />
<link href="includes/scotcall.css" rel="stylesheet" type="text/css" />
</head>

<body>
<?php include('includes/header.php'); ?>
<div class="container">
  <div class="leftcolumn">
    <h2>IT Users</h2>
    <?php display_msg(); ?>
 <a href="admin.php?add"><br />
    <strong>Add User</strong> </a><br />
    <br />

<?php if (!$add && !$update) { ?>
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td scope="row"><strong>Name</strong></td>
        <td><strong>Email</strong></td>
		<td><strong>Level</strong></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>

<?php $row_count = 1; do { ?>
      <tr <?php if ($row_count%2) { ?>bgcolor="#E9E9E9"<?php } ?>>
	  	<td scope="row" style="padding-left:5px"><?php echo $row_users['user_name']; ?></td>
        <td><?php echo $row_users['user_email']; ?></td>
        <td><?php echo $user_status[$row_users['user_level']]; ?></td>
        <td>&nbsp;</td>
        <td><a href="admin.php?id=<?php echo $row_users['user_id']; ?>">Edit</a><?php if ($userid != $row_users['user_id']) { ?> | <a onclick="javascript:return confirm('Are you sure?')" href="delete.php?user=<?php echo $row_users['user_id'] . '&ref=' . $row_users['user_name']; ?>">Delete</a><?php } ?></td>
      </tr>
<?php $row_count++; } while ($row_users = sqlsrv_fetch_array($users)); ?>

    </table>
    <br />
<?php } ?>


<?php if ($update || $add) { ?>
    <form id="form1" name="form1" method="post" action="">
	  <p>Name
        <br />
        <input name="user_name" type="text" id="user_name" value="<?php echo $row_userp['user_name']; ?>" size="35" />
      </p><br/>
	  <p>Email
        <br />
        <input name="user_email" type="text" id="user_email" value="<?php echo $row_userp['user_email']; ?>" class="required validate-email" size="35" />
      </p>
      <p><br />
        Password (leave blank to keep current password) <br />
        <input name="password" type="password" id="password" />
          <br />
          <br />
          Level<br />

            <input name="user_level" type="radio" id="user_level" value="1" <?php checked($row_userp['user_level'],1); ?>/>
            System Admin<br />
            <br />
			<input name="user_level" type="radio" id="user_level" value="4" <?php checked($row_userp['user_level'],4); ?>/>
            Administrator<br />
			<em>Can create, delete & edit all client and contact information.</em> <br />
            <br />
			<input name="user_level" type="radio" id="user_level" value="2" <?php checked($row_userp['user_level'],2); ?>/>
            Writer<br />
			<em>Can create & edit all client and contact information.</em> <br />
            <br />
            <input type="radio" name="user_level" id="user_level" value="3" <?php checked($row_userp['user_level'],3); ?>/>
            Regular User<br />
            <em>Cannot delete contacts or notes, and cannot edit contact information.</em> <br />
          <br />
      </p>
      <p>
        <input name="Submit2" type="submit" id="Submit2" value="Submit" /> 
      </p>
    </form>

<script type="text/javascript">
	var valid2 = new Validation('form1', {useTitles:true});
</script>

<?php } ?>

    
    <p>&nbsp;</p>
  </div>
  <?php include('includes/right-column.php'); ?>
  <br clear="all" />
</div>

<?php include('includes/footer.php'); ?>

</body>
</html>
