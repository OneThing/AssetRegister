<?php require_once('includes/config.php');
include('includes/sc-includes.php');
$pagetitle = 'Reports';
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
	<h2>Reports</h2><br/>
    <a href="errors.php"><h4>Error Report</h4>
	<em>- Any missed or mis-typed data errors for fixing.</em></a>

  </div>
  <?php include('includes/right-column.php'); ?>
  <br clear="all" />
</div>

<?php include('includes/footer.php'); ?>

</body>
</html>
