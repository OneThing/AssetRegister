<?php require_once('includes/config.php');
include('includes/sc-includes.php');
$pagetitle = 'SIM Cards';

//get assets
record_set('simlist',"SELECT * FROM sims JOIN assets on sim_asset = asset_id JOIN devices ON device_id = sim_device JOIN scotusers ON scotuser_id = asset_user ORDER BY devices.device_name");
record_set('unassignedsimlist',"SELECT * FROM sims JOIN devices ON device_id = sim_device WHERE sim_asset IS NULL ORDER BY devices.device_name");

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
    <h2>SIM Cards</h2>

	
<?php if ($totalRows_unassignedsimlist) { ?>
	
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td colspan="2" align="right">
 </td>
        </tr>
        <tr>
          <td colspan="2">
            <?php display_msg(); ?></td>
        </tr>
		<tr><br/><h4>Unassigned SIM's</h4></tr>
        <tr>
          <th width="20%"  style="padding-left:5px"><a href="#">Devices</a></th>
		  <th width="25%"  style="padding-left:5px"><a href="#">Model</a></th>
		  <th width="20%"  style="padding-left:5px"><a href="#">Mobile</a></th>
		  <th width="25%"  style="padding-left:5px"><a href="#">SIM No.</a></th>
		  <th width="10%">&nbsp;</th>
        </tr>

  <?php $row_count = 1; do {  ?>
        <tr <?php if ($row_count%2) { ?>bgcolor="#F4F4F4"<?php } ?>>
		  <td style="padding-left:5px"><a href="sim.php?sim=<?php echo $row_unassignedsimlist['sim_id']; ?>"><?php echo $row_unassignedsimlist['device_name']; ?></a></td>
		  <td><a href="sim.php?sim=<?php echo $row_unassignedsimlist['sim_id']; ?>"><?php echo $row_unassignedsimlist['sim_model']; ?></a></td>
		  <td><a href="sim.php?sim=<?php echo $row_unassignedsimlist['sim_id']; ?>"><?php echo $row_unassignedsimlist['sim_mobile']; ?></a></td>
		  <td><a href="sim.php?sim=<?php echo $row_unassignedsimlist['sim_id']; ?>"><?php echo $row_unassignedsimlist['sim_number']; ?></a></td>
		  <!--<td><?php if ($user_admin||$user_administrator) { ?> <a href="delete.php?asset=<?php echo $row_unassignedsimlist['asset_id']; ?>" onclick="javascript:return confirm('Are you sure?')">Delete</a><?php } ?></td>-->
		</tr>
        <?php $row_count++; } while ($row_unassignedsimlist = sqlsrv_fetch_array($unassignedsimlist)); ?>
      </table>


    <?php } ?>
	
<?php if ($totalRows_simlist) { ?>

      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td colspan="2" align="right">
 </td>
        </tr>
        <tr>
          <td colspan="2">
            <?php display_msg(); ?></td>
        </tr>
		<tr><br/><h4>Assigned SIM's</h4></tr>
        <tr>
          <th width="15%"  style="padding-left:5px"><a href="#">Devices</a></th>
		  <th width="15%"  style="padding-left:5px"><a href="#">Model</a></th>
		  <th width="15%"  style="padding-left:5px"><a href="#">Mobile</a></th>
		  <th width="15%"  style="padding-left:5px"><a href="#">SIM No.</a></th>
		  <th width="15%"  style="padding-left:5px"><a href="#">User</a></th>
		  <th width="15%"  style="padding-left:5px"><a href="#">Related Asset</a></th>
		  <th width="10%">&nbsp;</th>
        </tr>

  <?php $row_count = 1; do {  ?>
        <tr <?php if ($row_count%2) { ?>bgcolor="#F4F4F4"<?php } ?>>
		  <td style="padding-left:5px"><a href="sim.php?sim=<?php echo $row_simlist['sim_id']; ?>"><?php echo $row_simlist['device_name']; ?></a></td>
		  <td><a href="sim.php?sim=<?php echo $row_simlist['sim_id']; ?>"><?php echo $row_simlist['sim_model']; ?></a></td>
		  <td><a href="sim.php?sim=<?php echo $row_simlist['sim_id']; ?>"><?php echo $row_simlist['sim_mobile']; ?></a></td>
		  <td><a href="sim.php?sim=<?php echo $row_simlist['sim_id']; ?>"><?php echo $row_simlist['sim_number']; ?></a></td>
		  <td><a href="asset-details.php?id=<?php echo $row_simlist['asset_id']; ?>"><?php echo $row_simlist['scotuser_name']; ?></a></td>
		  <td><a href="asset-details.php?id=<?php echo $row_simlist['asset_id']; ?>"><?php echo $row_simlist['asset_model']; ?></a></td>
		  <!--<td><?php if ($user_admin||$user_administrator) { ?> <a href="delete.php?asset=<?php echo $row_simlist['asset_id']; ?>" onclick="javascript:return confirm('Are you sure?')">Delete</a><?php } ?></td>-->
		</tr>
        <?php $row_count++; } while ($row_simlist = sqlsrv_fetch_array($simlist)); ?>
      </table>


    <?php } ?>

  </div>
  <?php include('includes/right-column.php'); ?>
  <br clear="all" />
</div>

<?php include('includes/footer.php'); ?>

</body>
</html>
