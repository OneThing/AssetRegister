<?php require_once('includes/config.php');
include('includes/sc-includes.php');
$pagetitle = 'Client';

//get contacts

if (isset($_GET['co'])) {
record_set('contactlist',"SELECT DISTINCT company_name, contact_id, contact_first, contact_last, contact_phone, contact_cell, contact_email FROM contacts LEFT JOIN policies ON policy_contact = contact_id RIGHT JOIN companies ON company_name = policy_company WHERE company_id = ".$_GET['co']." ORDER BY contact_last");}

elseif (isset($_GET['c'])) {

record_set('contactlist',"SELECT * FROM contacts WHERE contact_company = '".$_GET['c']."' ORDER BY contact_last");}

elseif (isset($_GET['sort'])) {

record_set('contactlist',"SELECT * FROM contacts WHERE contact_last LIKE '".$_GET['sort']."%' ORDER BY contact_last");}


else {
record_set('contactlist',"SELECT * FROM contacts WHERE contact_type = '1' ORDER BY contact_last");}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?php echo $pagetitle; ?>s</title>
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
    <h2>Clients
	<?php if (isset($_GET['co'])){?>
	<span style="color:#999999"> supplied by <?php echo $row_contactlist['company_name'];?> </span>
	<?php } ?>
	</h2>
	<hr/>
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
	<?php 
		for ($abc = 65; $abc <=90; $abc++) { 
		$x = chr($abc); 
		echo '<td><a href="clients.php?sort=' . $x . '">' . $x  . '</a></td>';
		} 
	?>
	<td><a href="clients.php">ALL</a></td>
	</tr>
	</table>
	<hr/>
	<?php if (!$totalRows_contactlist) { ?>
	
<br />
No contacts available, starting with the letter - <strong><em><?php echo $_GET['sort']; ?></strong></em>
<br />
<?php } ?>

<?php if ($totalRows_contactlist) { ?>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td colspan="4" align="right">
 </td>
        </tr>
        <tr>
          <td colspan="4">
            <?php display_msg(); ?></td>
        </tr>
        <tr>
          <th width="26%"  style="padding-left:5px"><a href="#">Name</a></th>
          <th width="27%"><a href="#">Phone</a></th>
          <th width="40%"><a href="#">Email</a></th>
          <th width="7%">&nbsp;</th>
        </tr>

  <?php $row_count = 1; do {  ?>
        <tr <?php if ($row_count%2) { ?>bgcolor="#F4F4F4"<?php } ?>>
          <td style="padding-left:5px"><a href="client-details.php?id=<?php echo $row_contactlist['contact_id']; ?>"><?php echo $row_contactlist['contact_last']; ?>, <?php echo $row_contactlist['contact_first']; ?></a></td>
          <td><?php echo $row_contactlist['contact_phone'] ? $row_contactlist['contact_phone'] : $row_contactlist['contact_cell']; ?></td>
          <td><a href="mailto:<?php echo $row_contactlist['contact_email']; ?>"><?php echo $row_contactlist['contact_email']; ?></a></td>
          <td><?php if ($user_admin || $user_administrator) { ?> <a href="delete.php?client=<?php echo $row_contactlist['contact_id'] . "&ref=" . $row_contactlist['contact_first'] . '%20' . $row_contactlist['contact_last'] ; ?>" onclick="javascript:return confirm('Are you sure?')">Delete</a><?php } ?></td>
        </tr>
        <?php $row_count++; } while ($row_contactlist = sqlsrv_fetch_array($contactlist)); ?>
      </table>

    <?php } ?>



  </div>
  <?php include('includes/right-column.php'); ?>
  <br clear="all" />
</div>

<?php include('includes/footer.php'); ?>

</body>
</html>
