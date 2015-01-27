<?php require_once('includes/config.php');
include('includes/sc-includes.php');

$pagetitle = 'ProfessionalDetails';

$update = 0
;

//Professional

record_set('professional',"SELECT * FROM prof_contacts WHERE prof_id = ".$_GET['pro']."");

//Professional

//Linked Clients

record_set('contactlist',"SELECT contact_id, contact_first, contact_last, contact_phone, contact_cell, contact_email FROM contacts WHERE contact_prof = ".$_GET['pro']." ORDER BY contact_last");

//END Linked clients

//Last user
record_set('lastedit',"SELECT user_name FROM users WHERE user_id = ".$row_professional['prof_lastedit']."");

//can this user edit this contact?
//$can_edit = 0;
if ($user_admin || $user_writer ||$user_administrator) {
$can_edit = 1;
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?php echo $row_professional['prof_name']; ?></title>

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
<h2><?php echo $row_professional['prof_name']; ?>
<?php if ($can_edit) { ?><a style="font-size:12px; font-weight:normal" href="professional.php?pro=<?php echo $row_professional['prof_id']; ?>">&nbsp;&nbsp;+ Edit Professional Contact </a><?php } ?></h2>
<br clear="all" />
</div>
<em>Last edited by <?php echo $row_lastedit['user_name']; ?> on <?php echo date('d/m/Y \a\t g:i a' , $row_professional['prof_updated']); ?> </em>
<hr />
<table>
	<tr>
	<td>
	<?php echo $row_professional['prof_street']  ."<br>"; ?>
    <?php echo $row_professional['prof_city']."<br>"; ?>
	<?php echo $row_professional['prof_zip']."<br>"; ?>
	<?php echo $row_professional['prof_country']; ?>
	</td>
	</tr>
	</table>
	<br/>
	<table>
	<td>
	Main Phone: <?php echo $row_professional['prof_phone']; ?>
	</td>
	</tr>
	<td>
	Main Email: <?php echo $row_professional['prof_email']; ?>
	</td>
	</tr>
    <tr>
	<td>
	<a href="http://<?php echo $row_professional['prof_website']; ?>"><?php echo $row_professional['prof_website']; ?></a>
	</td>
	</tr>
	<td width="250px">
	<br/>Representative: <?php echo $row_professional['prof_repname']; ?>
	</td>
	<td width="200px">
	<strong><br/><?php echo $row_professional['prof_repphone']; ?></strong>
	</td>
	<td width="200px">
	<br/><a href="mailto:<?php echo $row_professional['prof_repemail']; ?>"><?php echo $row_professional['prof_repemail']; ?></a>
	</td>
	</tr>
	<tr>
	<td colspan="3">
	Notes: <?php echo $row_professional['prof_details']; ?>
	</td>
	</tr>
</table>
<hr/>

<?php if ($totalRows_contactlist) { ?>
<h2>Associated Clients</h2>
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
          <th width="33%"  style="padding-left:5px"><a href="#">Name</a></th>
          <th width="27%"><a href="#">Phone</a></th>
          <th width="40%"><a href="#">Email</a></th>
        </tr>

  <?php $row_count = 1; do {  ?>
        <tr <?php if ($row_count%2) { ?>bgcolor="#F4F4F4"<?php } ?>>
          <td style="padding-left:5px"><a href="client-details.php?id=<?php echo $row_contactlist['contact_id']; ?>"><?php echo $row_contactlist['contact_last']; ?>, <?php echo $row_contactlist['contact_first']; ?></a></td>
          <td><?php echo $row_contactlist['contact_phone'] ? $row_contactlist['contact_phone'] : $row_contactlist['contact_cell']; ?></td>
          <td><a href="mailto:<?php echo $row_contactlist['contact_email']; ?>"><?php echo $row_contactlist['contact_email']; ?></a></td>
        </tr>
        <?php $row_count++; } while ($row_contactlist = sqlsrv_fetch_array($contactlist)); ?>
      </table>

    <?php } ?>

<!--<h3><a href="professional.php?pro=<?php echo $row_professional['prof_id']; ?>"><?php echo 'View Clients from ' . $row_professional['prof_name']; ?></a></h3>
<hr/>-->
</div>
  <?php include('includes/right-column.php'); ?>
  
  <br clear="all" />
</div>

<?php include('includes/footer.php'); ?>

</body>
</html>
