<?php require_once('includes/config.php');
include('includes/sc-includes.php');
$pagetitle = 'Professional Contacts';

//get contacts
record_set('proflist',"SELECT * FROM prof_contacts ORDER BY prof_name");


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
    <h2>Professional Contacts</h2>

	
<?php if ($totalRows_proflist) { ?>

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
          <th width="26%"  style="padding-left:5px"><a href="#">Name</a></th>
          <th width="27%"><a href="#">Phone</a></th>
          <th width="40%"><a href="#">Email</a></th>
          <th width="7%">&nbsp;</th>
        </tr>

  <?php $row_count = 1; do {  ?>
        <tr <?php if ($row_count%2) { ?>bgcolor="#F4F4F4"<?php } ?>>
          <td style="padding-left:5px"><a href="professional-details.php?pro=<?php echo $row_proflist['prof_id']; ?>"><?php echo $row_proflist['prof_name']; ?></a></td>
          <td><?php echo $row_proflist['prof_phone']; ?></td>
          <td><a href="mailto:<?php echo $row_proflist['prof_email']; ?>"><?php echo $row_proflist['prof_email']; ?></a></td>
          <td><?php if ($user_admin || $user_administrator) { ?> <a href="delete.php?professional=<?php echo $row_proflist['prof_id'] . "&ref=" . $row_proflist['prof_name']; ?>" onclick="javascript:return confirm('Are you sure?')">Delete</a><?php } ?></td>
        </tr>
        <?php $row_count++; } while ($row_proflist = sqlsrv_fetch_array($proflist)); ?>
      </table>


    <?php } ?>

  </div>
  <?php include('includes/right-column.php'); ?>
  <br clear="all" />
</div>

<?php include('includes/footer.php'); ?>

</body>
</html>
