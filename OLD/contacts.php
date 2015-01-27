<?php require_once('includes/config.php');
include('includes/sc-includes.php');
$pagetitle = 'Contact';


//get contacts
//if (isset($_GET['t'])) {

record_set('contactlist',"SELECT * FROM contacts WHERE contact_type = '2' ORDER BY contact_first");

/*
}
elseif (isset($_GET['c'])) {

record_set('contactlist',"SELECT * FROM contacts WHERE contact_company = '".$_GET['c']."'");}

else {
record_set('contactlist',"SELECT * FROM contacts $sorder $limit");
}*/
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
    <h2>Contacts</h2>
	
<?php if (!$totalRows_contactlist) { ?>
<br />
No contacts have been added yet.
<br />
<br />
<strong><a href="contact.php">Add</a> or <a href="import.php">Import</a> Contacts </strong><br />
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
          <th width="26%"  style="padding-left:5px"><a href="?page=<?php echo $page_number; ?>&amp;<?php echo $name; ?>">Name</a></th>
          <th width="27%"><a href="?page=<?php echo $page_number; ?>&amp;<?php echo $phone; ?>">Phone</a></th>
          <th width="40%"><a href="?page=<?php echo $page_number; ?>&amp;<?php echo $email; ?>">Email</a></th>
          <th width="7%">&nbsp;</th>
        </tr>

  <?php $row_count = 1; do {  ?>
        <tr <?php if ($row_count%2) { ?>bgcolor="#F4F4F4"<?php } ?>>
          <td style="padding-left:5px"><a href="contact-details.php?id=<?php echo $row_contactlist['contact_id']; ?>"><?php echo $row_contactlist['contact_first']; ?> <?php echo $row_contactlist['contact_last']; ?></a></td>
          <td><?php echo $row_contactlist['contact_phone'] ? $row_contactlist['contact_phone'] : $na; ?></td>
          <td><a href="mailto:<?php echo $row_contactlist['contact_email']; ?>"><?php echo $row_contactlist['contact_email']; ?></a></td>
          <td><?php if ($user_admin || $user_writer ||$user_administrator) { ?> <a href="delete.php?contact=<?php echo $row_contactlist['contact_id'] . "&ref=" . $row_contactlist['contact_first'] . '%20' . $row_contactlist['contact_last'] ; ?>" onclick="javascript:return confirm('Are you sure?')">Delete</a><?php } ?></td>
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
