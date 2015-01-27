<?php

//   Copyright 2014 scotcallgroup.com - Nicky McBride
//
//   Licensed under the Apache License, Version 2.0 (the "License");
//   you may not use this file except in compliance with the License.
//   You may obtain a copy of the License at
//
//       http://www.apache.org/licenses/LICENSE-2.0
//
//   Unless required by applicable law or agreed to in writing, software
//   distributed under the License is distributed on an "AS IS" BASIS,
//   WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
//   See the License for the specific language governing permissions and
//   limitations under the License.

//mysql_select_db($database_contacts, $query);

include('includes/functions.php');

session_start();
if (!isset($_SESSION['user'])) {
header('Location: login.php');
}

//GET USER INFORMATION
record_set('userinfo',"SELECT * FROM users WHERE user_email = '".$_SESSION['user']."'");
$user_admin = $row_userinfo['user_level'] == 1 ? 1 : 0;
$user_writer = $row_userinfo['user_level'] == 2 ? 1 : 0;
$user_guest = $row_userinfo['user_level'] == 3 ? 1 : 0;
$user_administrator = $row_userinfo['user_level'] == 4 ? 1 : 0;
$userid = $row_userinfo['user_id'];
//

//not applicable
$na = '<span style="color:#CCCCCC">N/A</span>';
//

//search array
if (isset($_GET['s'])){
$like_where_array = array();
$like_where_array[] = 'scotuser_name';
$like_where_array[] = 'device_name';
$like_where_array[] = 'asset_model';
$like_where_array[] = 'asset_serial';
$like_where_array[] = 'asset_tag';
$like_where_array[] = 'sim_number';
$like_where_array[] = 'sim_mobile';

$i = 1;
foreach ($like_where_array as $key => $value) {

$and = '';
if ($i > 1) {
$and = 'OR';
}
$like_where .= "$and $value LIKE '%".$_GET['s']."%' ";
$i++;
}
}
?>