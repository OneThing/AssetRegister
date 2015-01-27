<?php require_once('includes/config.php');
include('includes/sc-includes.php');
$pagetitle = 'Users';

//get assets
record_set('userlist',"SELECT scotuser_id, scotuser_name, company_name, department_name FROM scotusers JOIN companies ON scotuser_company = company_id JOIN departments ON scotuser_department = department_id ORDER BY scotuser_name");


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?php echo $pagetitle; ?></title>
<script src="includes/lib/prototype.js" type="text/javascript"></script>
<script src="includes/src/effects.js" type="text/javascript"></script>
<script src="includes/validation.js" type="text/javascript"></script>
<script src="includes/src/scriptaculous.js" type="text/javascript"></script>

<link href="includes/style.css" rel="stylesheet" type="text/css" />
<link href="includes/scotcall.css" rel="stylesheet" type="text/css" />
</head>

<body>
<?php include('includes/header.php'); ?>
  
  <div class="container">
  <div class="leftcolumn">
    <h2>Users</h2>

	
<?php if ($totalRows_userlist) { ?>

      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td colspan="2" align="right">
 </td>
        </tr>
        <tr>
          <td colspan="2">
            <?php display_msg(); ?></td>
        </tr>
        <tr>
          <th width="30%"  style="padding-left:5px"><a href="#">User</a></th>
		  <th width="30%"  style="padding-left:5px"><a href="#">Department</a></th>
		  <th width="30%"  style="padding-left:5px"><a href="#">Company</a></th>
		  <th width="10%">&nbsp;</th>
        </tr>

  <?php $row_count = 1; do {  ?>
        <tr <?php if ($row_count%2) { ?>bgcolor="#F4F4F4"<?php } ?>>
		  <td style="padding-left:5px"><a href="user-details.php?user=<?php echo $row_userlist['scotuser_id']; ?>"><?php echo $row_userlist['scotuser_name']; ?></a></td>
		  <td><a href="user-details.php?user=<?php echo $row_userlist['scotuser_id']; ?>"><?php echo $row_userlist['department_name']; ?></a></td>
		  <td><a href="user-details.php?user=<?php echo $row_userlist['scotuser_id']; ?>"><?php echo $row_userlist['company_name']; ?></a></td>
		  <!--<td><?php if ($user_admin||$user_administrator) { ?> <a href="delete.php?user=<?php echo $row_userlist['scotuser_id']; ?>" onclick="javascript:return confirm('Are you sure?')">Delete</a><?php } ?></td>-->
		</tr>
        <?php $row_count++; } while ($row_userlist = sqlsrv_fetch_array($userlist)); ?>
      </table>


    <?php } ?>

  </div>
  <?php include('includes/right-column.php'); ?>
  <br clear="all" />
</div>

<?php include('includes/footer.php'); ?>

</body>
</html>
