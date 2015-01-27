<link href="scotcall.css" rel="stylesheet" type="text/css" />
<div class="headercontainer"> 
  <div class="header">
    <img src="includes/logo.png" align="left"/>
	<h1>scotcall asset register</h1>

    <a href="index.php" class="menubuttons <?php if ($pagetitle == 'Dashboard') { echo menubuttonsactive; } ?>">Dashboard</a>
	<a href="assets.php" class="menubuttons <?php if ($pagetitle == 'Assets' || $pagetitle == 'AssetDetails') { echo menubuttonsactive; } ?>">Assets</a>
    <a href="users.php" class="menubuttons <?php if ($pagetitle == 'Users' || $pagetitle == 'UserDetails') { echo menubuttonsactive; } ?>">Users</a>
    <a href="departments.php" class="menubuttons <?php if ($pagetitle== 'Departments' || $pagetitle == 'DepartmentDetails') { echo 'menubuttonsactive'; } ?>">Departments</a>
	<a href="devices.php" class="menubuttons <?php if ($pagetitle== 'Devices' || $pagetitle == 'DeviceDetails') { echo 'menubuttonsactive'; } ?>">Devices</a>
	<a href="sims.php" class="menubuttons <?php if ($pagetitle== 'SIM Cards' || $pagetitle == 'SIM CardDetails') { echo 'menubuttonsactive'; } ?>">SIM Cards</a>
	<a href="history.php" class="menubuttons <?php if ($pagetitle== 'History') { echo 'menubuttonsactive'; } ?>">History</a>
	<!--<a href="settings.php" class="menubuttons <?php if ($pagetitle== 'Settings') { echo 'menubuttonsactive'; } ?>">Settings</a>-->
	<!--<a href="reports.php" class="menubuttons <?php if ($pagetitle == 'Reports') { echo 'menubuttonsactive'; } ?>">Reports</a>-->
	<?php if ($user_admin) { ?><a href="admin.php" class="menubuttons <?php if ($pagetitle == 'Admin') { echo 'menubuttonsactive'; } ?>">Admin</a><?php } ?>

 
	 <span class="headerright">Logged in as <?php echo $row_userinfo['user_name']; ?> | <a href="logout.php">Log Out</a></span><br clear="all" />
  </div>
  </div>
