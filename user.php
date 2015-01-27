<?php require_once('includes/config.php');
include('includes/sc-includes.php');

$pagetitle = 'UserDetails';

$update = 0;
if (isset($_GET['user'])) {
$update = 1;
}

//User

record_set('companylist',"SELECT * FROM companies ORDER BY company_name");
record_set('departmentlist',"SELECT * FROM departments ORDER BY department_name");

if ($update==1) {
record_set('userlist',"SELECT * FROM scotusers WHERE scotuser_id = '".$_GET['user']."'");
}

//add User
if (!$update && $_POST['user_name']) {


  sqlsrv_query($connection,"INSERT INTO scotusers (scotuser_name, scotuser_company, scotuser_department) VALUES 

	(
		'".insert('user_name')."',
		'".insert('company')."',
		'".insert('department')."'
	)

	");

$uid = mysql_insert_id();

	$redirect = "user-details.php?user=$uid";
	redirect('User Added',$redirect);
}
//end add asset

// edit asset
if ($update && $_POST &&  $_POST['user_name']) {

sqlsrv_query($connection,"UPDATE scotusers SET

	scotuser_name = '".insert('user_name')."',
	scotuser_company = '".insert('company')."',
	scotuser_department = '".insert('department')."'

	
WHERE scotuser_id = ".$_GET['user']."
");

	$uid = $_GET['user'];
	$redirect = "user-details.php?user=$uid";

	redirect('User Updated',$redirect);
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>User</title>

<script src="includes/src/unittest.js" type="text/javascript"></script>
<link href="includes/style.css" rel="stylesheet" type="text/css" />
<link href="includes/scotcall.css" rel="stylesheet" type="text/css" />
</head>

<body>
<?php include('includes/header.php'); ?>
<div class="container">
  <div class="leftcolumn">

    <?php display_msg(); ?>

<div style="display:block; margin-bottom:5px">

<h2><?php echo $row_userdetails['scotuser_name'] . '</h2><h3>&nbsp&nbsp' . $row_userdetails['department_name'] . ' - ' . $row_userdetails['company_name']; ?></h3>


</div>

     <form action="" method="POST" enctype="multipart/form-data" name="form1" id="form1">
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
		<hr />
        <tr>
		<td>User Name<br />
		<input name="user_name" type="text" id="user_name" value="<?php echo $row_userlist['scotuser_name']; ?>" size="35" /></td>
		<td>Company<br />
			<select id="company" name="company">
			<option value="0">Select a Company...</option>
			<?php do { ?>
				<option value="<?php echo $row_companylist['company_id']; ?>" <?php selected ($row_userlist['scotuser_company'],$row_companylist['company_id']); ?>>
				<?php echo $row_companylist['company_name']; ?></option>
			<?php } while ($row_companylist = sqlsrv_fetch_array($companylist)); ?>
			</select>
		</td>
		<td>Department<br />
			<select id="department" name="department">
			<option value="0">Select a Department...</option>
			<?php do { ?>
				<option value="<?php echo $row_departmentlist['department_id']; ?>" <?php selected ($row_userlist['scotuser_department'],$row_departmentlist['department_id']); ?>>
				<?php echo $row_departmentlist['department_name']; ?></option>
			<?php } while ($row_departmentlist = sqlsrv_fetch_array($departmentlist)); ?>
			</select>
		</td>
		</tr>
		<tr>
          <td colspan="2"><p>
		  <br />
            <input type="submit" name="Submit2" value="<?php echo $update==1 ? 'Update' : 'Add'; ?> user" />
          </p></td>
        </tr>
      </table>
    </form>

</div>
  <?php include('includes/right-column.php'); ?>
  
  <br clear="all" />
</div>

<?php include('includes/footer.php'); ?>

</body>
</html>
