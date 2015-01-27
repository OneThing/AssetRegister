<?php require_once('includes/config.php');
include('includes/sc-includes.php');
$pagetitle = 'Assets';

/*PAGINATION
$limit = "";
$epp = 50;  //entries per page

record_set('results',"SELECT asset_id FROM assets");

$entries_per_page = $epp;

$page_number = empty($_GET['page']) ? 1 : $_GET['page']; //current page

$numRows
$total_pages = ceil($numRows_results / $entries_per_page); 
$offset = ($page_number - 1) * $entries_per_page; 

$prev = $page_number -1;
$next = $page_number + 1;

$limit = "LIMIT $offset, $entries_per_page";
*/

//get assets
record_set('assetlist',"SELECT asset_id, device_name, scotuser_name, asset_model, asset_serial, status_name FROM assets JOIN devices ON device_id = asset_device JOIN scotusers ON scotuser_id = asset_user JOIN status ON status_id = asset_status ORDER BY device_name $limit");


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
    <h2>Assets</h2>
	<?php echo "number:" . $numRows_results;?>
	
<?php if ($totalRows_assetlist) { ?>

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
		  <th width="25%"  style="padding-left:5px"><a href="#">Model</a></th>
		  <th width="25%"  style="padding-left:5px"><a href="#">Serial</a></th>
		  <th width="20%"  style="padding-left:5px"><a href="#">User</a></th>
		  <th width="10%"  style="padding-left:5px"><a href="#">Status</a></th>
		  <th width="10%">&nbsp;</th>
        </tr>

  <?php $row_count = 1; do {  ?>
        <tr <?php if ($row_count%2) { ?>bgcolor="#F4F4F4"<?php } ?>>
		  <td style="padding-left:5px"><a href="asset-details.php?id=<?php echo $row_assetlist['asset_id']; ?>"><?php echo $row_assetlist['device_name']; ?></a></td>
		  <td><a href="asset-details.php?id=<?php echo $row_assetlist['asset_id']; ?>"><?php echo $row_assetlist['asset_model']; ?></a></td>
		  <td><a href="asset-details.php?id=<?php echo $row_assetlist['asset_id']; ?>"><?php echo $row_assetlist['asset_serial']; ?></a></td>
		  <td><a href="asset-details.php?id=<?php echo $row_assetlist['asset_id']; ?>"><?php echo $row_assetlist['scotuser_name']; ?></a></td>
		  <td><a href="asset-details.php?id=<?php echo $row_assetlist['asset_id']; ?>"><?php echo $row_assetlist['status_name']; ?></a></td>
		  <!--<td><?php if ($user_admin||$user_administrator) { ?> <a href="delete.php?asset=<?php echo $row_assetlist['asset_id']; ?>" onclick="javascript:return confirm('Are you sure?')">Delete</a><?php } ?></td>-->
		</tr>
        <?php $row_count++; } while ($row_assetlist = sqlsrv_fetch_array($assetlist)); ?>
      </table>
<?php
include('includes/pagination.php');
?>

    <?php } ?>

  </div>
  <?php include('includes/right-column.php'); ?>
  <br clear="all" />
</div>

<?php include('includes/footer.php'); ?>

</body>
</html>
