<?php require_once('includes/config.php');
include('includes/sc-includes.php');

$pagetitle = 'UserDetails';

//asset


record_set('assetlist',"SELECT asset_id, device_name, asset_model, asset_serial, status_name FROM assets JOIN devices ON asset_device = device_id JOIN status ON status_id = asset_status WHERE asset_user = '".$_GET['user']."' ORDER BY device_name");
record_set('userdetails',"SELECT scotuser_id, scotuser_name, company_name, department_name FROM scotusers JOIN departments ON department_id = scotuser_department JOIN companies ON company_id = scotuser_company WHERE scotuser_id = '".$_GET['user']."'");


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?php echo $row_userdetails['scotuser_name']; ?></title>

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

<h2><?php echo $row_userdetails['scotuser_name']?><?php if ($user_admin) { ?><a style="font-size:12px; font-weight:normal" href="user.php?user=<?php echo $row_userdetails['scotuser_id']; ?>">&nbsp;&nbsp;+ Edit User </a><?php } ?><?php echo '</h2><h3>&nbsp&nbsp' . $row_userdetails['department_name'] . ' - ' . $row_userdetails['company_name']; ?></h3>


</div>

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
          <th width="20%"  style="padding-left:5px"><a href="#">Device</a></th>
		  <th width="30%"  style="padding-left:5px"><a href="#">Model</a></th>
		  <th width="30%"  style="padding-left:5px"><a href="#">Serial / IMEI</a></th>
		  <th width="10%"  style="padding-left:5px"><a href="#">Status</a></th>
		  <th width="10%">&nbsp;</th>
        </tr>

  <?php $row_count = 1; do {  ?>
        <tr <?php if ($row_count%2) { ?>bgcolor="#F4F4F4"<?php } ?>>

		  <td style="padding-left:5px"><a href="asset-details.php?id=<?php echo $row_assetlist['asset_id']; ?>"><?php echo $row_assetlist['device_name']; ?></a></td>
		  <td><a href="asset-details.php?id=<?php echo $row_assetlist['asset_id']; ?>"><?php echo $row_assetlist['asset_model']; ?></a></td>
		  <td><a href="asset-details.php?id=<?php echo $row_assetlist['asset_id']; ?>"><?php echo $row_assetlist['asset_serial']; ?></a></td>
		  <td><a href="asset-details.php?id=<?php echo $row_assetlist['asset_id']; ?>"><?php echo $row_assetlist['status_name']; ?></a></td>
		  <!--<td><?php if ($user_admin||$user_administrator) { ?> <a href="delete.php?asset=<?php echo $row_assetlist['asset_id']; ?>" onclick="javascript:return confirm('Are you sure?')">Delete</a><?php } ?></td>-->
		</tr>
        <?php $row_count++; } while ($row_assetlist = sqlsrv_fetch_array($assetlist)); ?>
      </table>

</div>
  <?php include('includes/right-column.php'); ?>
  
  <br clear="all" />
</div>

<?php include('includes/footer.php'); ?>

</body>
</html>
