<?php require_once('includes/config.php');
include('includes/sc-includes.php');

$pagetitle = 'DepartmentDetails';

$update = 0;
if (isset($_GET['dept'])) {
$update = 1;
}

if ($update==1) {
record_set('departmentdetails',"SELECT * FROM departments WHERE department_id = '".$_GET['dept']."'");
}

//add Department
if (!$update && $_POST['department']) {


  sqlsrv_query($connection,"INSERT INTO departments (department_name) VALUES 

	(
		'".insert('department')."'
	)

	");

$did = mysql_insert_id();

	$redirect = "department-details.php?dept=$did";
	redirect('Department Added',$redirect);
}
//end add department

// edit department
if ($update && $_POST &&  $_POST['department']) {

sqlsrv_query($connection,"UPDATE departments SET

	department_name = '".insert('department')."'
	
WHERE department_id = ".$_GET['dept']."
");

	$did = $_GET['dept'];
	$redirect = "department-details.php?dept=$did";

	redirect('Department Updated',$redirect);
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Department</title>

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

<h2><?php echo $row_departmentdetails['department_name'];?></h3>


</div>

     <form action="" method="POST" enctype="multipart/form-data" name="form1" id="form1">
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
		<hr />
        <tr>
		<td>Department Name<br />
		<input name="department" type="text" id="department" value="<?php echo $row_departmentdetails['department_name']; ?>" size="35" /></td>
		</tr>
		<tr>
          <td colspan="2"><p>
		  <br />
            <input type="submit" name="Submit2" value="<?php echo $update==1 ? 'Update' : 'Add'; ?> department" />
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
