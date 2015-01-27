<?php require_once('includes/config.php');
include('includes/sc-includes.php');
$pagetitle = 'History';

//get data
record_set('login',"SELECT TOP 15 * FROM login ORDER BY login_date DESC");
record_set('history',"SELECT TOP 15* FROM history ORDER BY history_date DESC");

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
    <h2>Admin Panel</h2>

<?php if ($totalRows_login) { ?>
	<br/>
	<h4>Login Attempts</h4>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td colspan="2">
            <?php display_msg(); ?></td>
        </tr>
        <tr>
          <th style="padding-left:5px"><a href="#">Login ID</a></th>
          <th><a href="#">IP Address</a></th>
		  <th><a href="#">Login Name</a></th>
		  <th><a href="#">Date - Time</a></th>
		  <th><a href="#">Attempts</a></th>
		  <th><a href="#">Sucess</a></th>
		  <th>&nbsp;</th>
        </tr>

  <?php $row_count = 1; do {  ?>
        <tr <?php if ($row_count%2) { ?>bgcolor="#F4F4F4"<?php } ?>>
		  <td style="padding-left:5px" align="center"><?php echo $row_login['login_id']; ?></td>
		  <td><?php echo $row_login['login_IP']; ?></td>
		  <td><?php echo $row_login['login_user']; ?></td>
		  <td><?php echo date('d/m/Y - g:i a' , $row_login['login_date']); ?></td>
		  <td align="center"><?php echo $row_login['login_attempts']; ?></td>
		  <td align="center"><?php echo $row_login['login_success']; ?></td>
		</tr>
        <?php $row_count++; } while ($row_login = sqlsrv_fetch_array($login)); ?>
      </table>


    <?php } ?>

	
	<?php if ($totalRows_history) { ?>
	<br/>
	<hr/>
	<br/>
	<h4>Change History</h4>
	
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td colspan="2">
            <?php display_msg(); ?></td>
        </tr>
        <tr>
          <th style="padding-left:5px"><a href="#">History ID</a></th>
          <th><a href="#">Date - Time</a></th>
		  <th><a href="#">Type</a></th>
		  <th><a href="#">Operation</a></th>
		  <th><a href="#">Page ID</a></th>
		  <th><a href="#">Parent ID</a></th>		  
		  <th><a href="#">Reference</a></th>		  
		  <th><a href="#">User</a></th>
        </tr>

  <?php $row_count = 1; do {  ?>
        <tr <?php if ($row_count%2) { ?>bgcolor="#F4F4F4"<?php } ?>>
		  <td style="padding-left:15px" ><?php echo $row_history['history_id']; ?></td>
		  <td><?php echo date('d/m/Y - g:i a' , $row_history['history_date']); ?></td>
		  <td><?php echo $row_history['history_type']; ?></td>
		  <td><?php echo $row_history['history_operation']; ?></td>
		  <td align="center" width="50px"><?php echo $row_history['history_pageid']; ?></td>
		  <td align="center" width="70px"><?php echo $row_history['history_parentid']; ?></td>
		  <td><?php echo $row_history['history_ref']; ?></td>
		  <td><?php $username = sqlsrv_query($connection,"SELECT user_name FROM users WHERE user_id = ".$row_history['history_user']."");
	list($username) = sqlsrv_fetch_array( $username );
	 echo $username; ?></td>
		</tr>
        <?php $row_count++; } while ($row_history = sqlsrv_fetch_array($history)); ?>
      </table>

<?php } ?>
	  
  </div>
  <?php include('includes/right-column.php'); ?>
  <br clear="all" />
</div>

<?php include('includes/footer.php'); ?>

</body>
</html>
