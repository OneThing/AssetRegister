<?php require_once('includes/config.php');
include('includes/sc-includes.php');
$pagetitle = 'Children';

$update = 0;
if (isset($_GET['ch'])) {
$update = 1;
}

//
record_set('children',"SELECT * FROM children WHERE children_name = -1");
if ($update==1) {
record_set('children',"SELECT * FROM children WHERE children_id = ".$_GET['ch']."");
}
//

//if not admin or writer and trying to edit
if (!$user_admin && !$user_writer  && !$user_administrator && $update) {
$cid = $_GET['id'];
	$redirect = "client-details.php?id=$cid";
	redirect('You don\'t have permission to access that page.',$redirect);
}
//


//add child
if (!$update && $_POST['children_name']) {

$childdob = strtotime($_POST['dobyear'] . '-' . $_POST['dobmonth'] . '-' . $_POST['dobday']);


  sqlsrv_query($connection,"INSERT INTO children (children_name, children_dob, children_relationship, children_details, children_contact) VALUES 

	(
		'".insert('children_name')."',
		'".$childdob."',
		'".insert('children_relationship')."',
		'".insert('children_details')."',
		'".$_GET['id']."'
	)

	");

	sqlsrv_query($connection,"UPDATE contacts SET
	contact_updated = '".time()."',
	contact_lastedit = '".$userid."'
WHERE contact_id = ".$_GET['id']."
");
	
$cid = $_GET['id'];

	$redirect = "client-details.php?id=$cid";
	redirect('Child / Dependant Added',$redirect);
	

	
}
//end add child

//update child


if ($update && $_POST &&  $_POST['children_name']) {

$childdob = strtotime($_POST['dobyear'] . '-' . $_POST['dobmonth'] . '-' . $_POST['dobday']);

sqlsrv_query($connection,"UPDATE children SET

	children_name =	'".insert('children_name')."',
	children_dob = '".$childdob."',
	children_relationship = '".insert('children_relationship')."',
	children_details = '".insert('children_details')."',
	children_contact = '".$_GET['id']."'

WHERE children_id = ".$_GET['ch']."
");
	$pid = $_GET['id'];

//
sqlsrv_query($connection,"UPDATE contacts SET

	contact_updated = '".time()."',
	contact_lastedit = '".$userid."'
	
WHERE contact_id = ".$_GET['id']."
");


	$cid = $_GET['id'];
	$redirect = "client-details.php?id=$cid";

	redirect('Child / Dependant Updated',$redirect);
	

}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?php if ($update==0) { echo "Add Child / Dependant"; } ?></title>
<script src="includes/lib/prototype.js" type="text/javascript"></script>
<script src="includes/src/effects.js" type="text/javascript"></script>
<script src="includes/validation.js" type="text/javascript"></script>
<script src="includes/src/scriptaculous.js" type="text/javascript"></script>
<script language="javascript">
function toggleLayer(whichLayer)
{
if (document.getElementById)
{
// this is the way the standards work
var style2 = document.getElementById(whichLayer).style;
style2.display = style2.display? "":"block";
}
else if (document.all)
{
// this is the way old msie versions work
var style2 = document.all[whichLayer].style;
style2.display = style2.display? "":"block";
}
else if (document.layers)
{
// this is the way nn4 works
var style2 = document.layers[whichLayer].style;
style2.display = style2.display? "":"block";
}
}
</script>


<link href="includes/style.css" rel="stylesheet" type="text/css" />
<link href="includes/scotcall.css" rel="stylesheet" type="text/css" />
</head>
<body>
<?php include('includes/header.php'); ?>
<div class="container">
  <div class="leftcolumn">
    <h2><?php if ($update==1) { echo 'Update'; } else { echo 'Add'; } ?> Child / Dependant 
	<?php if ($update==1) { ?>
	<?php if ($user_admin) { ?><a style="font-size:12px; font-weight:normal" href="delete.php?child=<?php echo $row_children['children_id'] . '&ref=' . $row_children['children_name']; ?>&id=<?php echo $_GET['id']; ?>" onclick="javascript:return confirm('Are you sure?')">+ Delete child / dependant  </a><?php } ?>
    <?php } ?>
	
	</h2>
    <p>&nbsp;</p>
    <form action="" method="POST" enctype="multipart/form-data" name="form1" id="form1">
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
		<td>Name<br/>
                    <input name="children_name" type="text" id="children_name" value="<?php echo $row_children['children_name']; ?>" size="45" /></td>
        </tr>
		
		
		<tr>
		<td>Date of Birth<br/>
		<?php if ($update==1) { 
		$date = $row_children['children_dob'];
		echo date_picker("dob", $date);	
		}  
		else {
		echo date_picker("dob");
		}
		?>
		</td>
		</tr>
		
		<tr>
		<td>Relationship<br/>
                    <input name="children_relationship" type="text" id="children_relationship" value="<?php echo $row_children['children_relationship']; ?>" size="45" /></td>
        </tr>
		
		<tr>
		<td>Details<br/>
                    <input name="children_details" type="text" id="children_details" value="<?php echo $row_children['children_details']; ?>" size="45" /></td>
        </tr>
		
        <tr>
          <td colspan="2"><p>
            <input type="submit" name="Submit2" value="<?php echo $update==1 ? 'Update' : 'Add'; ?> child / dependant" />
          </p></td>
        </tr>
      </table>
    </form>

<script type="text/javascript">
	var valid2 = new Validation('form1', {useTitles:true});
</script>

  </div>
  <?php include('includes/right-column.php'); ?>

  <br clear="all" />
</div>

<?php include('includes/footer.php'); ?>

</body>
</html>
