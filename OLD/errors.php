<?php require_once('includes/config.php');
include('includes/sc-includes.php');
$pagetitle = 'Errors';

//get data
record_set('investments_date', "SELECT investments.*, policies.policy_contact, contacts.contact_first, contacts.contact_last FROM investments LEFT JOIN policies ON policy_id = inv_policy LEFT JOIN contacts ON policy_contact = contact_id WHERE inv_date <= 0");
record_set('investments_type', "SELECT investments.*, policies.policy_contact, contacts.contact_first, contacts.contact_last FROM investments LEFT JOIN policies ON policy_id = inv_policy LEFT JOIN contacts ON policy_contact = contact_id WHERE inv_type is null or inv_type='' or inv_frequency is null or inv_frequency='' ");
record_set('policies', "SELECT policies.*, contacts.contact_first, contacts.contact_last FROM policies LEFT JOIN contacts ON policy_contact = contact_id WHERE policy_start = -3600 OR (policy_end = -3600 AND policy_noend = 0)");

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
    <h2>Records with Errors</h2>
	<br/><em>Any missed or mis-typed data appears below, Clicking on the ID number in Blue takes you to the correct Record and allows you to change it.</em><br/>
<?php if ($totalRows_investments_date > 0) { ?>
	<br/>
	<hr/><h4>Investment Date</h4>
	  <em>Any investment with a date that hasn't been set or left as 01/01/1970.</em><br/>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td colspan="2">
            <?php display_msg(); ?></td>
        </tr>
		<tr>
		<th><a href="#">Investment ID</a></th>
		<th><a href="#">Value</a></th>
		<th><a href="#">Date</a></th>
		<th><a href="#">Client</a></th>
		<th><a href="#">Policy ID</a></th>
		</tr>
  <?php $row_count = 1; do {  ?>
        <tr <?php if ($row_count%2) { ?>bgcolor="#F4F4F4"<?php } ?>>
		<td><?php echo $row_investments_date['inv_id']; ?></td>
		<td><?php echo $row_investments_date['inv_value']; ?></td>
		<td><?php echo date('d/m/Y' , $row_investments_date['inv_date']); ?></td>
		<td><?php echo $row_investments_date['contact_first'] . ' ' . $row_investments_date['contact_last'] ; ?></td>
		<td><a href="policies.php?id=<?php echo $row_investments_date['policy_contact']; ?>&p=<?php echo $row_investments_date['inv_policy']; ?>"><?php echo $row_investments_date['inv_policy']; ?></a></td>
	</tr>
	<?php $row_count++; } while ($row_investments_date = sqlsrv_fetch_array($investments_date)); ?>
		</table>
<?php } ?>

<?php if ($totalRows_investments_type > 0) { ?>
	<br/>
	<hr/><h4>Investment Type</h4>
	<em>Any investment without a value in the type or frequency requires opening, selecting the correct value and re-saving.</em><br/>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
		<tr>
		<th><a href="#">Investment ID</a></th>
		<th><a href="#">Value</a></th>
		<th><a href="#">Type</a></th>
		<th><a href="#">Frequency</a></th>
		<th><a href="#">Client</a></th>		
		<th><a href="#">Policy ID</a></th>
		</tr>
  <?php $row_count = 1; do {  ?>
        <tr <?php if ($row_count%2) { ?>bgcolor="#F4F4F4"<?php } ?>>
		<td><?php echo $row_investments_type['inv_id']; ?></td>
		<td><?php echo $row_investments_type['inv_value']; ?></td>
		<td><?php echo $row_investments_type['inv_type']; ?></td>
		<td><?php echo $row_investments_type['inv_frequency']; ?></td>
		<td><?php echo $row_investments_type['contact_first'] . ' ' . $row_investments_type['contact_last'] ; ?></td>
		<td><a href="policies.php?id=<?php echo $row_investments_type['policy_contact']; ?>&p=<?php echo $row_investments_type['inv_policy']; ?>"><?php echo $row_investments_type['inv_policy']; ?></a></td>
	</tr>
	<?php $row_count++; } while ($row_investments_type = sqlsrv_fetch_array($investments_type)); ?>
		</table>

<?php } ?>
		
<?php if ($totalRows_policies > 0) { ?>
<br/>
<hr/><h2>Policies</h2>
<em>Any Policies with a start date of 01/01/1970 hasn't been changed. If the expiry date is 01/01/1970 the "no end date" tick box needs to be set or the correct date entered.</em><br/>
<table width="100%" border="0" cellspacing="0" cellpadding="5">
		  <th><a href="#">Company</a></th>
		  <th><a href="#">Reference</a></th>
		  <th><a href="#">Start Date</a></th>
		  <th><a href="#">Expiry Date</a></th>
		  <th><a href="#">Client</a></th>
		  <th><a href="#">ID</a></th>
		</tr>
		<?php $row_count = 1; do { ?>
		
		<tr <?php if ($row_count%2) { ?>bgcolor="#F4F4F4"<?php } ?>>
			  <td><?php echo $row_policies['policy_company']; ?></td>
			  <td><?php echo $row_policies['policy_number']; ?></td>
			  <td align="right"><?php echo date('d/m/Y', $row_policies['policy_start']); ?></td>
			  <td align="right"><?php if ($row_policies['policy_noend'] == '1') {
			  echo '-';
			  }
			  else {
			  echo date('d/m/Y', $row_policies['policy_end']); 
			  }?>
			  </td>
			  <td><?php echo $row_policies['contact_first'] . ' ' . $row_policies['contact_last'] ; ?></td>
			  <td><a href="policies.php?id=<?php echo $row_policies['policy_contact']; ?>&p=<?php echo $row_policies['policy_id']; ?>"><?php echo $row_policies['policy_id']; ?></a></td>
		</tr>
		<?php $row_count++; } while ($row_policies = sqlsrv_fetch_array($policies)); ?>
		</table>
<br/>
<?php } ?>
	
  </div>
  <?php include('includes/right-column.php'); ?>
  <br clear="all" />
</div>

<?php include('includes/footer.php'); ?>

</body>
</html>
