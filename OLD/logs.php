<?php require_once('includes/config.php');
include('includes/sc-includes.php');

//Check Monitor
if (isset($_GET['monitor'])){
sqlsrv_query($connection,"INSERT INTO monitor (monitor_name) VALUES

(
	'".$_GET['monitor']."'
)
");
set_msg('User Monitoring Active for '.$_GET['monitor']);
header('Location: logs.php'); die;
}

if (isset($_GET['cancel'])){
sqlsrv_query($connection,"DELETE FROM monitor WHERE monitor_name = '".$_GET['cancel']."'");
set_msg('User Monitoring Cancelled for '.$_GET['cancel']);
header('Location: logs.php'); die;
}


record_set('domainid',"SELECT cust_domain FROM customer WHERE cust_id = '".$user_customerid."'");
$domain = $row_domainid['cust_domain'];
$domain_where = "log_domain = '" . $domain."'";

//Search
if (isset($_GET['s'])){
$swhere = "WHERE ($like_where)";
record_set('logs',"SELECT * FROM logs $swhere AND $domain_where ORDER BY log_on DESC LIMIT 0, 100");
}


//User Sort
if (isset($_GET['user'])){
if ($_GET['user'] == '0'){
record_set('logs',"SELECT * FROM logs WHERE $domain_where ORDER BY log_on DESC LIMIT 0, 100");
}
else{
$use = $_GET['user'];
record_set('logs',"SELECT * FROM logs WHERE log_user = '$use' AND $domain_where ORDER BY log_on DESC LIMIT 0, 100");
}
}

//PC Sort
if (isset($_GET['pc'])){
if ($_GET['pc'] == '0'){
record_set('logs',"SELECT * FROM logs WHERE $domain_where ORDER BY log_on DESC LIMIT 0, 100");
}
else{
$pc = $_GET['pc'];
record_set('logs',"SELECT * FROM logs WHERE log_pc = '$pc' AND $domain_where ORDER BY log_on DESC LIMIT 0, 100");
}
}

//IP Sort
if (isset($_GET['ip'])){
if ($_GET['ip'] == '0'){
record_set('logs',"SELECT * FROM logs WHERE $domain_where ORDER BY log_on DESC LIMIT 0, 100");
}
else{
$ip = $_GET['ip'];
record_set('logs',"SELECT * FROM logs WHERE log_ip = '$ip' AND $domain_where ORDER BY log_on DESC LIMIT 0, 100");
}
}

//Current Sort
if (isset($_GET['current'])){
record_set('logs',"SELECT * FROM logs WHERE log_off IS NULL AND $domain_where ORDER BY log_on DESC LIMIT 0, 100");
}

//Default Value
if (!isset($_GET['current']) && !isset($_GET['user']) && !isset($_GET['pc']) && !isset($_GET['ip']) && !isset($_GET['s'])){
record_set('logs',"SELECT * FROM logs WHERE $domain_where ORDER BY log_on DESC LIMIT 0, 100");
}

//Get Drop Down lists
record_set('user_list',"SELECT DISTINCT log_user FROM logs WHERE $domain_where ORDER BY log_user ");
record_set('pc_list',"SELECT DISTINCT log_pc FROM logs WHERE $domain_where ORDER BY log_pc ");
record_set('ip_list',"SELECT DISTINCT log_ip FROM logs WHERE $domain_where ORDER BY log_ip ");


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script type="text/JavaScript">
function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}
function MM_setTextOfTextfield(objName,x,newText) { //v3.0
  var obj = MM_findObj(objName); if (obj) obj.value = newText;
}
</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Logs</title>
<script src="includes/lib/prototype.js" type="text/javascript"></script>
<script src="includes/src/effects.js" type="text/javascript"></script>
<script src="includes/validation.js" type="text/javascript"></script>
<script src="includes/src/scriptaculous.js" type="text/javascript"></script>
<link href="includes/style.css" rel="stylesheet" type="text/css" />
<link href="includes/scotcall.css" rel="stylesheet" type="text/css" />
</head>

<body>
  
  <div class="container">
  <div class="leftcolumn">
	<div class="searchbox">
	<form id="form4" name="form4" method="GET" action="logs.php" enctype="multipart/form-data">
      <input name="s" type="text" id="s" onfocus="MM_setTextOfTextfield('s','','')" value="Search" size="15" />
        <input type="submit" name="Submit_search" value="Go" />
  </form>
  </div>
    <h2>Log on/off Records for <?php echo $user_customer?></h2>
	<br/>
	<p>
	
<div class="leftsort">
<form id="form2" name="form2" method="GET" action="logs.php" enctype="multipart/form-data">
Sort by User
<select id="user" name="user">
			<option value="0">Select a User...</option>
		<?php do { ?>
				<option value="<?php echo $row_user_list['log_user']; ?>" <?php selected ($row_user_list['log_user'],$_GET['user']); ?>>
<?php echo $row_user_list['log_user']; ?></option>
	<?php } while ($row_user_list = sqlsrv_fetch_array($user_list)); ?>
		</select>
<input type="submit" name="Submit2" value="Change User"/>
</form>
<div><form id="form3" name="form3" method="GET" action="logs.php" enctype="multipart/form-data">
	
	<input type="checkbox" name="current" value="yes" onChange="this.form.submit()" <?php checked($_GET['current'],"yes")?>>Only Show Currently Logged in Users
</form>
</div>
</div>
<div class="rightsort"><form id="form1" name="form1" method="GET" action="logs.php" enctype="multipart/form-data">
	Sort By PC
	<select id="pc" name="pc">
			<option value="0" <?php selected($_GET['pc'],0);?>>Display All</option>
		<?php do { ?>
				<option value="<?php echo $row_pc_list['log_pc']; ?>" <?php selected ($row_pc_list['log_pc'],$_GET['pc']); ?>>
	<?php echo $row_pc_list['log_pc']; ?></option>
	<?php } while ($row_pc_list = sqlsrv_fetch_array($pc_list)); ?>
		</select>

<input type="submit" name="Submit" value="Change PC"/>
</form>


</div>
</p>
<br />
<br />
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td colspan="5" align="right">
 </td>
        </tr>
        <tr>
          <td colspan="4">
            <?php display_msg(); ?></td>
        </tr>
        <tr>
          <th width="18%" style="padding-left:5px"><a href="#">Name</a></th>
		  <th width="15%"><a href="#">Computer</a></th>
		  <th width="15%"><a href="#">IP Address</a></th>
          <th width="20%"><a href="#">Log on</a></th>
		  <th width="20%"><a href="#">Log off</a></th>
		  <th width="8%"><a href="#">Monitoring</a></th>
		  <th width="2%"></th>
        </tr>
<form id="form3" name="form4" method="GET" action="logs.php" enctype="multipart/form-data">
  <?php $row_count = 1; do {  ?>
        <tr <?php if ($row_count%2) { ?>bgcolor="#F4F4F4"<?php } ?>>
          <td style="padding-left:5px"><?php echo $row_logs['log_user'] ? $row_logs['log_user'] : $na; ?></td>
          <td><?php echo $row_logs['log_pc']; ?></td>
		  <td><?php echo $row_logs['log_ip']; ?></td>
		  <td><?php echo $row_logs['log_on'] ? date('d/m/Y \a\t g:i a' , $row_logs['log_on']) : ' '; ?></td>
		  <td><?php echo $row_logs['log_off'] ? date('d/m/Y \a\t g:i a' , $row_logs['log_off']) : ' '; ?></td>
		  <td><a href="logs.php?<?php 
		  $query = "SELECT monitor_name from monitor where monitor_name='".$row_logs['log_user']."'";
		  $result = sqlsrv_query($connection,$query);
		  if(sqlsrv_has_rows($result) > 0) {
		  echo "cancel=" . $row_logs['log_user'] . '">Cancel';
		  }
		  Else {
		  echo "monitor=" . $row_logs['log_user'] . '">Activate';
		  }
			?></a></td>
		  <td><?php 
		  if (isset($row_logs['log_off'])) {
				echo '<img src="includes/red.png">';
		  }
		  else {
				echo '<img src="includes/green.png">';
		  }
		  ?>
		  </td>
        </tr>
		
        <?php $row_count++; } while ($row_logs = sqlsrv_fetch_array($logs)); ?>
		</form>
      </table>
	</div>
	<div>
	<?php if ($user_admin) { echo ('<span style = "float:left"><a href = "admin.php">Admin Page.</a></span>');} ?>
	<span style = "float:right"><a href = "logout.php">Log out.</a></span>
	</div>
  </div>
</body>
</html>
