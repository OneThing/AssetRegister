<?php require_once('includes/config.php'); ?><?php
include('includes/sc-includes.php');

$pagetitle = 'ClientDetails';

$update = 0;
if (isset($_GET['note'])) {
$update = 1;
}



//contact
record_set('contact',"SELECT * FROM contacts WHERE contact_id = ".$_GET['id']."");

//policies
record_set('policies',"SELECT * FROM policies WHERE policy_contact = ".$_GET['id']."");

$pol_details_small = substr($row_policies['policy_details'],0,35);


//Children/Dependants
record_set('children',"SELECT * FROM children WHERE children_contact = ".$_GET['id']."");

//Partner
record_set('partner',"SELECT * FROM partner WHERE partner_contact = ".$_GET['id']."");

//Last user
record_set('lastedit',"SELECT user_name FROM users WHERE user_id = ".$row_contact['contact_lastedit']."");

//notes SELECT * FROM `notes` LEFT JOIN users ON note_user = user_id
record_set('notes',"SELECT * FROM `notes` LEFT JOIN users ON note_user = user_id WHERE note_contact = ".$_GET['id']." ORDER BY note_date DESC");

record_set('note',"SELECT * FROM `notes` LEFT JOIN users ON note_user = user_id WHERE note_id = -1");
if ($update==1) {
record_set('note',"SELECT * FROM `notes` LEFT JOIN users ON note_user = user_id WHERE note_id = ".$_GET['note']."");
}
// prof contact
if (!is_null($row_contact['contact_prof'])){
record_set('professional',"SELECT prof_name, prof_id FROM prof_contacts WHERE prof_id = ".$row_contact['contact_prof']."");
}
//Last note user
//record_set('noteedit',"SELECT user_name FROM users WHERE user_id = ".$row_notes['note_user']."");


// First upload code

   if ($_FILES["file"]["error"] > 0){
   if ($_FILES["file"]["error"] == 4){
	 $goto = "client-details.php?id=$_GET[id]";
        redirect('Please select a file first',$goto);
		}
     echo "Return Code: " . $_FILES["file"]["error"] . "<br />";
     }
	 
   else
     {
	    if (isset($_FILES["file"]["name"])){
		$time = date('d-m-Y');
	    $file_name = $_FILES['file']['name'];
		$file_name= str_replace(" ","_",$file_name);
		$file_name = $time . "_" . $file_name;
        move_uploaded_file($_FILES['file']['tmp_name'], "files/" . $file_name);
		$msga = "File: " . $file_name . " upload Uploaded";
        set_msg($msga);
		
		sqlsrv_query($connection,"INSERT INTO notes (note_contact, note_text, note_date, note_status, note_user) VALUES 
                (
                ".$row_contact['contact_id'].",
                '".addslashes("<a href=" . "/apc/files/" . "$file_name>Uploaded File - $file_name</a>")."',
                ".time().",
                1,
				'".$userid."'
                )
        ");
		$goto = "client-details.php?id=$_GET[id]";
        redirect('File  ' . $file_name .  ' Uploaded',$goto);
		}
	 }
     
   
//

//INSERT NOTE FOR CONTACT
if ($update==0 && !empty($_POST['note_text'])) {
        sqlsrv_query($connection,"INSERT INTO notes (note_contact, note_text, note_date, note_status, note_user) VALUES 
                (
                ".$row_contact['contact_id'].",
                '".addslashes($_POST['note_text'])."',
                ".time().",
                1,
				'".$userid."'
                )
        ");
		
				sqlsrv_query($connection,"UPDATE contacts SET
	contact_updated = '".time()."',
	contact_lastedit = '".$userid."'
WHERE contact_id = ".$_GET['id']."
");

        $goto = "client-details.php?id=$_GET[id]";
        redirect('Note Added',$goto);

}
//

//UPDATE NOTE
if ($update==1 && !empty($_POST['note_text'])) {
        sqlsrv_query($connection,"UPDATE notes SET 
                note_text = '".addslashes($_POST['note_text'])."' 
        WHERE note_id = ".$_GET['note']."");

				sqlsrv_query($connection,"UPDATE contacts SET
	contact_updated = '".time()."',
	contact_lastedit = '".$userid."'
WHERE contact_id = ".$_GET['id']."
");
		
        $goto = "client-details.php?id=$_GET[id]";
        redirect('Note Updated',$goto);
}
//

//can this user edit this contact?
$can_edit = 0;
if ($user_admin || $user_writer || $user_administrator) {
$can_edit = 1;
}
//

//automatically add custom field data to contacts contact_custom field
record_set('cfields',"SELECT * FROM fields_assoc WHERE cfield_contact = ".$_GET['id']."");
do {
        $data .= $row_cfields['cfield_value'].", ";
        sqlsrv_query($connection,"UPDATE contacts SET contact_custom = '".$data."' WHERE contact_id = ".$_GET['id']."");
} while ($row_cfields = sqlsrv_fetch_array($cfields));
//


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?php echo $row_contact['contact_first']; ?> <?php echo $row_contact['contact_last']; ?></title>

<script src="includes/src/unittest.js" type="text/javascript"></script>
<link href="includes/style.css" rel="stylesheet" type="text/css" />
<link href="includes/scotcall.css" rel="stylesheet" type="text/css" />
</head>

<body <?php if ($row_notes['note_date'] > time()-1) { ?>onload="new Effect.Highlight('newnote'); return false;"<?php } ?>>
<?php include('includes/header.php'); ?>
<div class="container">
  <div class="leftcolumn">

    <?php display_msg(); ?>

<div style="display:block; margin-bottom:5px">
<h2><?php echo $row_contact['contact_first']; ?> <?php echo $row_contact['contact_last']; ?><?php if ($row_contact['contact_company']) { ?><span style="color:#999999"> with <?php echo $row_contact['contact_company']; ?><?php } ?></span>
<?php if ($can_edit) { ?><a style="font-size:12px; font-weight:normal" href="client.php?id=<?php echo $row_contact['contact_id']; ?>">&nbsp;&nbsp;+ Edit contact </a><?php } ?>    </h2>
<br clear="all" />
</div>
<em>Last edited by <?php echo $row_lastedit['user_name']; ?> on <?php echo date('d/m/Y \a\t g:i a' , $row_contact['contact_updated']); ?> </em>
<hr />
<table>
<tr>
<h2>Client Information </h2><br />
<td width="190px" VALIGN="top">
	<strong>Client</strong><br/>
	<?php echo $row_contact['contact_title']; ?> <?php echo $row_contact['contact_first']; ?> <?php echo $row_contact['contact_middle']; ?> <?php echo $row_contact['contact_last'] ."<br>"; ?>
	<br />
    <?php if ($row_contact['contact_street']) { echo $row_contact['contact_street']  ."<br>"; } ?>
    <?php if ($row_contact['contact_city']) { echo $row_contact['contact_city']."<br>"; } ?>
	<?php if ($row_contact['contact_zip']) { echo $row_contact['contact_zip']."<br>"; } ?>
	<?php if ($row_contact['contact_country']) { echo $row_contact['contact_country']; } ?></p>
    <?php if ($row_contact['contact_street'] && $row_contact['contact_city']){ ?><p><a href="http://maps.google.com/maps?f=q&amp;hl=en&amp;q=<?php echo $row_contact['contact_street']; ?>,+<?php echo $row_contact['contact_city']; ?>+<?php echo $row_contact['contact_zip']; ?>" target="_blank">+ View Map </a></p>
    <?php } ?>
	<hr/>
	<?php if ($row_contact['contact_dob']) { echo 'Date of Birth: ' . date('d/m/Y', $row_contact['contact_dob']) ."<br>"; } ?>
	<?php if ($row_contact['contact_ni']) { echo 'NI no.: ' . $row_contact['contact_ni'] ."<br>"; } ?>
	<?php if ($row_contact['contact_marital']) { echo 'Marital Status: ' . $row_contact['contact_marital'] ."<br>"; } ?>
	<?php if ($row_contact['contact_smoker']) { echo 'Smoker?: ' . $row_contact['contact_smoker'] ."<br>"; } ?>
	</td>
	
	<?php if ($row_partner['partner_name']) { ?>

<td width="190px" VALIGN="top">
	
	<strong>Partner</strong><?php if ($can_edit) { ?><a href="partner.php?pa=<?php echo $row_partner['partner_id']; ?>&id=<?php echo $row_contact['contact_id']; ?>"> + Edit</a><?php } ?>
	<br />
	<?php echo $row_partner['partner_name']  . ' - ' . '<em>' . $row_partner['partner_relationship'] . "</em><br>"; ?>
	<br />
    <?php echo $row_partner['partner_street']  ."<br>"; ?>
    <?php echo $row_partner['partner_city']."<br>"; ?>
	<?php echo $row_partner['partner_zip']."<br>"; ?>
	<?php echo $row_partner['partner_country']; ?>
    <?php if ($row_partner['partner_street'] && $row_partner['partner_city']){ ?><p><a href="http://maps.google.com/maps?f=q&amp;hl=en&amp;q=<?php echo $row_partner['partner_street']; ?>,+<?php echo $row_partner['partner_city']; ?>+<?php echo $row_partner['partner_zip']; ?>" target="_blank">+ View Map </a>
    <?php } ?>
	<hr/>
	<?php if ($row_partner['partner_dob']) { echo 'Date of Birth: ' . date('d/m/Y', $row_partner['partner_dob']) ."<br>"; } ?>
	<?php if ($row_partner['partner_ni']) { echo 'NI no.: ' . $row_partner['partner_ni'] ."<br>"; } ?>
	<?php if ($row_partner['partner_marital']) { echo 'Marital Status: ' . $row_partner['partner_marital'] ."<br>"; } ?>
	<?php if ($row_partner['partner_smoker']) { echo 'Smoker?: ' . $row_partner['partner_smoker'] ."<br>"; } ?>
	
</td>
<?php } ?>
	
	<td style="padding-left:5px" VALIGN="top">
	<?php if ($row_contact['contact_phone']) { ?>Phone: <?php echo $row_contact['contact_phone']; ?><br /><?php } ?>
	<?php if ($row_contact['contact_cell']) { ?>Mobile: <?php echo $row_contact['contact_cell']; ?><br /><?php } ?>
	<?php if ($row_contact['contact_email']) { ?>
    <a href="mailto:<?php echo$row_contact['contact_email']; ?>"><?php echo $row_contact['contact_email']; ?></a>        
	<hr/>
	<?php } ?>
	<?php if ($row_contact['contact_adviser']) { echo 'Adviser: ' . $row_contact['contact_adviser'] ."<br>"; } ?>
	<?php if ($row_contact['contact_employment']) { echo 'Employment Status: ' . $row_contact['contact_employment'] ."<br>"; } ?>
	<?php if ($row_contact['contact_referral']) { echo '<hr/> Referrer: ' . $row_contact['contact_referral'] ."<br>"; } ?>
<?php if ($row_contact['contact_referralnotes']) { echo 'Referrer Notes: ' . $row_contact['contact_referralnotes'] ."<br>"; } ?>
</td>
</tr>
</table>
<hr/>

<?php if ($row_contact['contact_prof'] > '0') { ?>
This user is linked to the contact <strong><a href="professional-details.php?pro=<?php echo $row_professional['prof_id'];?>"><?php echo $row_professional['prof_name'];?></a></strong>
<hr/>
<?php } ?>

<?php if ($row_policies['policy_lifeassured']) { ?>
<h2>Policies</h2><br />
<table width="830px" border="0" cellspacing="0" cellpadding="5">
		<tr bgcolor="#cde8f4">
		  <th></th>
		  <th>Company</th>
		  <th>Life Assured</th>
		  <th>Type</th><th>Reference</th>
		  <th>Start Date</th>
		  <th>Expiry Date</th>
		  <th width="200px">Investment - Date</th>
		  <th >Sum Assured</th>
		  <th width="150px">Details</th>
		  <th></th>
		</tr>
		<?php $row_count = 1; do { ?>
		<tr <?php if ($row_count%2) { ?>bgcolor="#F4F4F4"<?php } ?>>
			  <td><?php if ($row_policies['policy_owner'] == '1') { echo '(P)'; }?></td>
              <td><?php echo $row_policies['policy_company']; ?></td>
			  <td><?php echo $row_policies['policy_lifeassured']; ?></td>
			  <td><?php echo $row_policies['policy_type']; ?></td>
			  <td><?php echo $row_policies['policy_number']; ?></td>
			  <td align="right"><?php echo date('d/m/Y', $row_policies['policy_start']); ?></td>
			  <td align="right"><?php if ($row_policies['policy_noend'] == '1') {
			  echo '-';
			  }
			  else {
			  echo date('d/m/Y', $row_policies['policy_end']); 
			  }?>
			  </td>
			  <td align="right">
			  <?php record_set('investments',"SELECT * FROM investments WHERE inv_policy = ".$row_policies['policy_id']." ORDER BY inv_date ASC");
			  do { ?>
			  <?php if (isset($row_investments['inv_value'])) { echo '<strong>£' . $row_investments['inv_value'] . '</strong> - ' . date('d/m/Y', $row_investments['inv_date']); }?>
			  <?php $type = $row_investments['inv_type'];
			  switch ($type) {
			  case "Single":
				echo "(S)";
				break;
			  case "Transfer":
				echo "(T)";
				break;
			  case "Additional":
				echo "(A)";
				break;
			  }
			  ?>
			  <?php $freq = $row_investments['inv_frequency'];
			  switch ($freq) {
			  case "One-off":
			  	echo "(O)";
				break;
			  case "Monthly":
				echo "(M)";
				break;
			  case "Yearly":
				echo "(Y)";
				break;
			  }
			  ?>
			  <br/>
			  <?php } while ($row_investments = sqlsrv_fetch_array($investments)); ?>
			  </td>
			  
			  <td align="right"><?php echo '£' . $row_policies['policy_sumassured']; ?></td>
			  <td><?php if ($_GET[full] || !$row_policies['policy_details']) { echo $row_policies['policy_details']; } else {echo substr($row_policies['policy_details'],0,40) . '<a href="client-details.php?id=' . $_GET[id] . '&full=1"> - more';}?></a></td>
			  <td><?php if ($can_edit) { ?><a href="policies.php?id=<?php echo $row_contact['contact_id']; ?>&p=<?php echo $row_policies['policy_id']; ?>">Edit</a><?php } ?></td>
		</tr>
		<?php $row_count++; } while ($row_policies = sqlsrv_fetch_array($policies)); ?>
		</table>
<br/>
<hr />
<?php } ?>
<?php if ($row_children['children_name']) { ?>
<table>
<h2>Children / Dependants</h2><br />
	<tr>
		<th>Name</th>
		<th>Date of Birth</th>
		<th>Relationship</th>
		<th>Details</th>
		<th></th>
	</tr>
<?php do { ?>
	<tr>
		<td><?php echo $row_children['children_name']; ?></td>
		<td><?php echo date('d/m/Y', $row_children['children_dob']); ?></td>
		<td><?php echo $row_children['children_relationship']; ?></td>
		<td><?php echo $row_children['children_details']; ?></td>
		<td><?php if ($can_edit) { ?><a href="children.php?id=<?php echo $row_contact['contact_id']; ?>&ch=<?php echo $row_children['children_id']; ?>">Edit</a><?php } ?></td>
	</tr>
	<?php } while ($row_children = sqlsrv_fetch_array($children)); ?>
</table>
	<hr />
<?php } ?>

		<table>
		<tr>
		<h2>Other Information</h2><br />
			<?php if ($row_contact['contact_company']) { ?>
			<td VALIGN="top">
<strong>Employer Information</strong><br />
<?php if ($row_contact['contact_company']) { echo $row_contact['contact_company'] ."<br>"; } ?>
<?php if ($row_contact['contact_jobtitle']) { echo 'Job Title: ' . $row_contact['contact_jobtitle'] ."<br>"; } ?>

<br/>
<?php if ($row_contact['contact_companystreet']) { echo $row_contact['contact_companystreet']  ."<br>"; } ?>
<?php if ($row_contact['contact_companycity']) { echo $row_contact['contact_companycity']  ."<br>"; } ?>
<?php if ($row_contact['contact_companyzip']) { echo $row_contact['contact_companyzip']  ."<br>"; } ?>
<?php if ($row_contact['contact_companycountry']) { echo $row_contact['contact_companycountry'] ."<br>"; } ?>
<?php if ($row_contact['contact_companystreet'] && $row_contact['contact_companycity'] ) { ?><p><a href="http://maps.google.com/maps?f=q&amp;hl=en&amp;q=<?php echo $row_contact['contact_companystreet']; ?>,+<?php echo $row_contact['contact_companycity']; ?>+<?php echo $row_contact['contact_companyzip']; ?>" target="_blank">+ View Map </a></p>
<?php } ?>
    </td>
	<td style="padding-left:50px" VALIGN="top">
<?php if ($row_contact['contact_worktelephone']) { echo 'Phone: ' . $row_contact['contact_worktelephone'] ."<br>"; } ?>
<?php if ($row_contact['contact_workemail']) { ?>
      <a href="mailto:<?php echo$row_contact['contact_workemail']; ?>"><?php echo $row_contact['contact_workemail']; ?><br /></a>        
<?php } ?><?php if ($row_contact['contact_web']) { ?>
      <a href="<?php echo 'http://' . $row_contact['contact_web']; ?>" target="_blank"><?php echo $row_contact['contact_web']; ?><br /></a>        
<?php } ?>
<?php } ?>
<?php 

//additional fields
record_set('additional',"SELECT * FROM fields INNER JOIN fields_assoc ON cfield_field = field_id WHERE cfield_contact = ".$row_contact['contact_id']." AND cfield_value IS NOT NULL AND cfield_value != ''");

if ($totalRows_additional) { ?>
<br />
<strong>Additional Information</strong>
<br />
<?php do { ?>
<?php echo $row_additional['field_title'].": ".$row_additional['cfield_value']; ?><br />
<?php } while ($row_additional = sqlsrv_fetch_array($additional)); ?>
<br />
<?php } ?>

  <?php if ($row_contact['contact_profile']) { echo '<br/><strong>Extra Information</strong><br />' . $row_contact['contact_profile'] ."<br>"; } ?>

</td>
</tr>
</table>
	<hr/>
	
        <?php if (!$update) { echo "Add a new note <br />"; } ?>
        <form action="" method="post" enctype="multipart/form-data" name="form1" id="form1">
          <textarea name="note_text" style="width:95%" rows="2" id="note_text">
<?php echo $row_note['note_text']; ?>
</textarea><br />
          <input type="submit" name="Submit2" value="<?php if ($update==1) { echo 'Update'; } else { echo 'Add'; } ?> note" />
        </form>
		<br />
		<?php if (!$update) { echo "Upload a file <br />"; } ?>
		<form action="" method="post" enctype="multipart/form-data">
          <input type="file" name="file" id="file" style="width:95%"/><br />
          <input type="submit" name="submit" value="Upload File" />
        </form>
		<?php if ($update==1) { ?>  <a href="delete.php?clientnote=<?php echo $row_note['note_id']; ?>&amp;id=<?php echo $row_note['note_contact']; ?>" onclick="javascript:return confirm('Are you sure you want to delete this note?')">Delete Note</a><?php } ?>
<?php if ($totalRows_notes > 0) { ?>
        <hr />
		
        <?php do { ?>
<div <?php if ($row_notes['note_date'] > time()-1) { ?>id="newnote"<?php } ?>>
        <span class="datedisplay"><a href="?id=<?php echo $row_contact['contact_id']; ?>&note=<?php echo $row_notes['note_id']; ?>"><?php echo date('F d, Y', $row_notes['note_date']); ?></a></span><em> - Last edited by <?php echo $row_notes['user_name']; ?></em><br />
          <?php echo $row_notes['note_text']; ?>
</div>
          <hr />
              <?php } while ($row_notes = sqlsrv_fetch_array($notes)); ?>

<?php } ?>


  </div>
  <?php include('includes/right-column.php'); ?>
  
  <br clear="all" />
</div>

<?php include('includes/footer.php'); ?>

</body>
</html>
