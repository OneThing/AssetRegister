<?php require_once('includes/config.php');
include('includes/sc-includes.php');

$pagetitle = 'CompanyDetails';

$update = 0
;

//company

record_set('companies',"SELECT * FROM companies WHERE company_id = ".$_GET['com']."");

//company

//Last user
record_set('lastedit',"SELECT user_name FROM users WHERE user_id = ".$row_companies['company_lastedit']."");

//can this user edit this contact?
//$can_edit = 0;
if ($user_admin || $user_writer || $user_administrator) { 
$can_edit = 1;
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?php echo $row_companies['company_name']; ?></title>

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
<h2><?php echo $row_companies['company_name']; ?>
<?php if ($can_edit) { ?><a style="font-size:12px; font-weight:normal" href="company.php?com=<?php echo $row_companies['company_id']; ?>">&nbsp;&nbsp;+ Edit Company </a><?php } ?></h2>
<br clear="all" />
</div>
<em>Last edited by <?php echo $row_lastedit['user_name']; ?> on <?php echo date('d/m/Y \a\t g:i a' , $row_companies['company_updated']); ?> </em>
<hr />
<table>
	<tr>
	<td>
	Adviser Website: <a target="_blank" href="http://<?php echo $row_companies['company_url']; ?>"><?php echo $row_companies['company_url']; ?></a>
	</td>
	</tr>
	<tr>
	<td>
	Agency Number: <?php echo $row_companies['company_agency']; ?>
	</td>
	</tr>
	<tr>
	<td>
	<?php echo $row_companies['company_street']  ."<br>"; ?>
    <?php echo $row_companies['company_city']."<br>"; ?>
	<?php echo $row_companies['company_zip']."<br>"; ?>
	<?php echo $row_companies['company_country']; ?>
	</td>
	</tr>
	</table>
	<br/>
	<table>
    <tr>
	<td width="250px">
	Sales Consultant: <?php echo $row_companies['company_sales']; ?>
	</td>
	<td>
	Sales Phone: <strong><?php echo $row_companies['company_salesphone']; ?></strong>
	</td>
	</tr>
	<tr>
	<td width="250px">
	Admin Support: <?php echo $row_companies['company_admin']; ?>
	</td>
	<td>
	Admin Phone: <strong><?php echo $row_companies['company_adminphone']; ?></strong>
	</td>
	</tr>
	<tr>
	<td colspan="2">
	Notes: <?php echo $row_companies['company_details']; ?>
	</td>
	</tr>
</table>
<hr/>
<h3><a href="clients.php?co=<?php echo $row_companies['company_id']; ?>"><?php echo 'View Clients from ' . $row_companies['company_name']; ?></a></h3>
<hr/>
</div>
  <?php include('includes/right-column.php'); ?>
  
  <br clear="all" />
</div>

<?php include('includes/footer.php'); ?>

</body>
</html>
