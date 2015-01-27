<link href="includes/scotcall.css" rel="stylesheet" type="text/css" />
<script type="text/JavaScript">
<!--
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
//-->
</script>
<div class="rightcolumn">
<br />

<?php if ($pagetitle != 'Dashboard') { ?>
<form id="form3" name="form3" method="GET" action="index.php" enctype="multipart/form-data">
      <input name="s" type="text" id="s" onfocus="MM_setTextOfTextfield('s','','')" value="Search" size="15" />
        <input type="submit" name="Submit_search" value="Go" />
  </form>
	<?php } ?>

  <p><br />
<?php if (empty($_GET['s']) && !($user_guest)) { ?>
    <a class="addcontact" href="asset.php">Add Asset</a>  
	<a class="addcontact" href="user.php">Add User</a>
	<a class="addcontact" href="department.php">Add Department</a>
	<a class="addcontact" href="device.php">Add Device Group</a>
	<a class="addcontact" href="sim.php">Add SIM Card</a>
<?php } ?>
</p>
  </div>