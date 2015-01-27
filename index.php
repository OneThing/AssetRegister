<?php require_once('includes/config.php'); ?><?php require_once('includes/config.php'); 
include('includes/sc-includes.php');
$pagetitle = 'Dashboard';

if (empty($_GET['s']) && isset($_GET['s'])) {
header('Location: '.$_SERVER['HTTP_REFERER']); die;
}

//$cwhere = "WHERE history_status = 1";
if (isset($_GET['s'])) {
$cwhere = "WHERE ($like_where)";


$search = 0;
$nwhere = "";
if (isset($_GET['s'])) {
$search = 1;
$nwhere = "WHERE note_text LIKE '%".addslashes($_GET['s'])."%' ";
}

//get notes
record_set('notes',"SELECT TOP 20 * FROM notes INNER JOIN assets ON note_asset = asset_id $nwhere ORDER BY note_date DESC ");


//get assets
$climit = !empty($_GET['s']) ? 1000 : 10;
record_set('assetlist',"SELECT TOP $climit asset_id, device_name, scotuser_name, asset_model, asset_serial, status_name, sim_mobile, sim_number FROM assets JOIN devices ON device_id = asset_device JOIN scotusers ON scotuser_id = asset_user JOIN status ON status_id = asset_status JOIN sims ON sim_asset = asset_id $cwhere ORDER BY scotuser_name DESC");
}

//if (!$totalRows_contactlist && !isset($_GET['s'])) { header('Location: contact.php'); }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?php echo $pagetitle; ?></title>
<link href="includes/simplecustomer.css" rel="stylesheet" type="text/css" />
</head>

<body>
<?php include('includes/header.php'); ?>
<div class="container">
  <div class="leftcolumn">
  <br/>
  <br/>
  <form id="form3" name="form3" method="GET" action="index.php" enctype="multipart/form-data">
      <input name="s" type="text" id="s" onfocus="MM_setTextOfTextfield('s','','')" value="Search" size="70" />
        <input type="submit" name="Submit_search" value="Search" />
  </form>
  <br/>
<?php if ($search==1) { ?>
Search results for <em><?php echo $_GET['s']; ?></em>.<br />
<br />
<?php } ?>
<?php if (isset($_GET['s'])) { ?>
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
		  <th width="20%"  style="padding-left:5px"><a href="#">User</a></th>
          <th width="20%"  style="padding-left:5px"><a href="#">Device</a></th>
		  <th width="25%"  style="padding-left:5px"><a href="#">Model</a></th>
		  <th width="25%"  style="padding-left:5px"><a href="#">Serial</a></th>
		  <th width="10%"  style="padding-left:5px"><a href="#">Status</a></th>
		  <th width="10%">&nbsp;</th>
        </tr>

  <?php $row_count = 1; do {  ?>
        <tr <?php if ($row_count%2) { ?>bgcolor="#F4F4F4"<?php } ?>>
		  <td style="padding-left:5px"><a href="asset-details.php?id=<?php echo $row_assetlist['asset_id']; ?>"><?php echo $row_assetlist['scotuser_name']; ?></a></td>
		  <td><a href="asset-details.php?id=<?php echo $row_assetlist['asset_id']; ?>"><?php echo $row_assetlist['device_name']; ?></a></td>
		  <td><a href="asset-details.php?id=<?php echo $row_assetlist['asset_id']; ?>"><?php echo $row_assetlist['asset_model']; ?></a></td>
		  <td><a href="asset-details.php?id=<?php echo $row_assetlist['asset_id']; ?>"><?php echo $row_assetlist['asset_serial']; ?></a></td>
		  <td><a href="asset-details.php?id=<?php echo $row_assetlist['asset_id']; ?>"><?php echo $row_assetlist['status_name']; ?></a></td>
		  <!--<td><?php if ($user_admin||$user_administrator) { ?> <a href="delete.php?asset=<?php echo $row_assetlist['asset_id']; ?>" onclick="javascript:return confirm('Are you sure?')">Delete</a><?php } ?></td>-->
		</tr>
        <?php $row_count++; } while ($row_assetlist = sqlsrv_fetch_array($assetlist)); ?>
      </table>


    <?php } ?>

<?php if ($totalRows_notes > 0) { ?>
      <br/><br/><h2> 
      Notes  
      </h2>
<br />
      <?php $i = 1; do { ?>
<div <?php if ($row_notes['note_date'] > time()-1) { ?>id="newnote"<?php } ?>>
        <span class="datedisplay"><a href="asset-details.php?id=<?php echo $row_notes['note_asset']; ?>&note=<?php echo $row_notes['note_id']; ?>"><?php echo date('F d, Y', $row_notes['note_date']); ?></a></span> for <a href="asset-details.php?id=<?php echo $row_notes['note_asset']; ?>"><?php echo $row_notes['asset_model']; ?> <?php echo $row_notes['asset_serial']; ?></a><br />
          <?php echo $row_notes['note_text']; ?>
</div>
          <?php if ($totalRows_notes!=$i) { ?><hr /><?php } ?>
              <?php $i++;  } while ($row_notes = sqlsrv_fetch_array($notes)); ?>
<?php } ?>
  <?php } ?>
  </div>
  <?php include('includes/right-column.php'); ?>
  <br clear="all" />
</div>

<?php include('includes/footer.php'); ?>

</body>
</html>