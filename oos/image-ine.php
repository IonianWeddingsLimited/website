<?
require ("../_includes/settings.php");
require ("../_includes/function.templates.php");
include ("../_includes/function.database.php");
include ("../_includes/function.genpass.php");

// Connect to sql database
$sql_command = new sql_db();
$sql_command->connect($database_host,$database_name,$database_username,$database_password);

$get_template = new main_template();
include("run_login.php");

// Get Templates
$get_template = new oos_template();


$meta_title = "Admin";
$meta_description = "";
$meta_keywords = "";

if($_GET["action"] == "Continue") {
	
if(!$_GET["id"]) {
header("Location: $site_url/oos/image-ine.php");
$sql_command->close();
}

$result = $sql_command->select("$database_clients,$database_gallery_mason",
												"DISTINCT 
												$database_clients.id,
												$database_clients.firstname,
												$database_clients.lastname,
												$database_clients.email,
												$database_clients.tel,
												$database_clients.wedding_date,
												$database_clients.archive",
									"WHERE		$database_clients.id='".addslashes($_GET["id"])."'
									AND			$database_clients.deleted='No' 
									AND			$database_clients.imageine='Yes' 
									AND			$database_clients.id=$database_gallery_mason.img_id");
$record = $sql_command->result($result);

$resultdate = $sql_command->select("$database_gallery_mason",
												"$database_gallery_mason.timestamp",
									"WHERE		$database_gallery_mason.img_id='".addslashes($_GET["id"])."'
									AND			$database_gallery_mason.meta_id=10
									ORDER BY	$database_gallery_mason.timestamp");
$recorddate = $sql_command->result($resultdate);

$weddingdate = date("jS F Y",$record[5]);

$dateline = date("jS F Y",$recorddate[0]);
$dateline2 = date("g:i a",$recorddate[0]);

$result2 = $sql_command->select("$database_gallery_mason","$database_gallery_mason.meta_value","WHERE 
								   $database_gallery_mason.img_id = ".addslashes($_GET["id"])." AND
								   $database_gallery_mason.meta_id = 10");
	$row2 = $sql_command->results($result2);
	
	
	
		
	foreach($row2 as $record2) {
	$linklist.='<a href="http://www.ionianweddings.co.uk/image-ine/'.$record2[0].'#" target="_blank">http://www.ionianweddings.co.uk/image-ine/'.$record2[0].'#</a><br/>';
}

$get_template->topHTML();
?>
<h1>Form - Image-ine</h1>
<p><b>Submitted on:</b> <?php echo $dateline; ?> at <?php echo $dateline2; ?></p>
<script language="javascript" type="text/javascript">

function deletechecked()
{
    var answer = confirm("Confirm Delete")
    if (answer){
        document.messages.submit();
    }
    
    return false;  
}  

</script>
<div>
<form action="<?php echo $site_url; ?>/oos/image-ine.php" method="POST" class="pageform">
<input type="hidden" name="id" value="<?php echo stripslashes($record[0]); ?>" />
<div class="formheader">
		<h1>Personal Details</h1>
	</div>
	<div class="formrow">

		<label class="formlabel" for="imageine_firstname">First name</label>
		<div class="formelement">
			<?php echo stripslashes($record[1]); ?>

		</div>
		<div class="clear"></div>
	</div>
	<div class="formrow">

		<label class="formlabel" for="imageine_lastname">Last name</label>
		<div class="formelement">
			<?php echo stripslashes($record[2]); ?>
		</div>

		<div class="clear"></div>
	</div>
	<div class="formrow">

		<label class="formlabel" for="imageine_email">Email</label>
		<div class="formelement">
			<a href="mailto:<?php echo stripslashes($record[3]); ?>"><?php echo stripslashes($record[3]); ?></a>
		</div>
		<div class="clear"></div>

	</div>
	<div class="formrow">

		<label class="formlabel" for="imageine_tel">Telephone</label>
		<div class="formelement">
			<?php echo stripslashes($record[4]); ?>
		</div>
		<div class="clear"></div>

	</div>
	<div class="formrow">

		<label class="formlabel" for="imageine_weddingdate">Wedding Date</label>
		<div class="formelement">
			<?php echo $weddingdate; ?>
		</div>
		<div class="clear"></div>

	</div>
	<div class"formrow">
		<label class="formlabel" for="imageine_links">Image-ine Links</label>
		<div class="formelement">
			<?php echo $linklist;?>
		</div>
		<div class="clear"></div>
	</div>
</div>
<?php if($_GET["action_type"] == "view_archive") { ?>
<div style="float: left;  margin-left:20px; width:570px;"><input type="submit" name="action" value="Remove From Archive">
</form></div>

<?php } else { ?>
<div style="float: left;  margin-left:20px;  width:570px;"><input type="submit" name="action" value="Archive">
</form></div>
<?php } ?>

<div style="float: left;">
<form action="<?php echo $site_url; ?>/oos/image-ine.php" method="POST">
<input type="hidden" name="id" value="<?php echo stripslashes($record[0]); ?>" />
<input type="submit" name="action" value="Create Client"></div>
<div style="clear:left;"></div>
</form>
<?
$get_template->bottomHTML();
$sql_command->close();

} elseif($_POST["action"] == "Remove From Archive") {
	
	
$sql_command->update($database_clients,"archive='No'","id='".addslashes($_POST["id"])."'");

$get_template->topHTML();
?>
<h1>Message Removed From Archive</h1>

<p>The message has now been removed from archived</p>
<?
$get_template->bottomHTML();
$sql_command->close();	
	
} elseif($_POST["action"] == "Archive") {
	

$sql_command->update($database_clients,"archive='Yes'","id='".addslashes($_POST["id"])."'");

$get_template->topHTML();
?>
<h1>Message Archived</h1>

<p>The message has now been archived</p>
<?
$get_template->bottomHTML();
$sql_command->close();


} elseif($_POST["action"] == "Create Client") {
	
$result = $sql_command->select("$database_clients,$database_gallery_mason",
												"DISTINCT 
												$database_clients.id,
												$database_clients.firstname,
												$database_clients.lastname,
												$database_clients.email,
												$database_clients.tel,
												$database_clients.wedding_date,
												$database_clients.archive",
									"WHERE		$database_clients.id='".addslashes($_POST["id"])."'
									AND			$database_clients.deleted='No' 
									AND			$database_clients.imageine='Yes' 
									AND			$database_clients.id=$database_gallery_mason.img_id");
$record = $sql_command->result($result);
$_SESSION["title"] = "";
$_SESSION["firstname"] = stripslashes($record[1]);
$_SESSION["lastname"] = stripslashes($record[2]);
$_SESSION["email"] = stripslashes($record[3]);
$_SESSION["tel"] = stripslashes($record[4]);
$_SESSION["address"] = "";
$_SESSION["address2"] = "";
$_SESSION["address3"] = "";
$_SESSION["town"] = "";
$_SESSION["county"] = "";
$_SESSION["country"] = "";
$_SESSION["postcode"] = "";
$_SESSION["mob"] = "";
$_SESSION["fax"] = "";
$_SESSION["dob"] = "";
$_SESSION["mailinglist"] = "";
$_SESSION["wedding_date"] = date("d-m-Y", stripslashes($record[5]));
$_SESSION["destination"] = "";
$_SESSION["iwcuid"] = "";
$_SESSION["groom_title"] = "";
$_SESSION["groom_firstname"] = "";
$_SESSION["groom_surname"] = "";
$_SESSION["groom_dob"] = "";
$_SESSION["wedding_time"] = "";
$_SESSION["prospect_id"] = stripslashes($record[0]);
$_SESSION["survey"] = $database_clients;


if($record[14] == "Yes") { $_SESSION["mailinglist"] = "Yes"; } else {  $_SESSION["mailinglist"] = "No"; }

header("Location: $site_url/oos/add-client.php");
$sql_command->close();	
	
} else {
	
if($_GET["surname"]) {
$result = $sql_command->select("$database_clients,$database_gallery_mason",
												"DISTINCT
												$database_clients.id,
												$database_clients.firstname,
												$database_clients.lastname,
												$database_clients.archive,
												$database_clients.wedding_date",
									"WHERE		$database_clients.deleted='No' 
									AND			$database_clients.imageine='Yes' 
									AND			$database_clients.lastname like '".addslashes($_GET["surname"])."%' 
									AND			$database_clients.id=$database_gallery_mason.img_id 
									ORDER BY	$database_clients.lastname");
	$row = $sql_command->results($result);
} else {
	$result = $sql_command->select("$database_clients,$database_gallery_mason",
												"DISTINCT 
												$database_clients.id,
												$database_clients.firstname,
												$database_clients.lastname,
												$database_clients.archive,
												$database_clients.wedding_date",
									"WHERE		$database_clients.deleted='No' 
									AND			$database_clients.imageine='Yes' 
									AND			$database_clients.id=$database_gallery_mason.img_id 
									ORDER BY	$database_gallery_mason.timestamp DESC");
	$row = $sql_command->results($result);
}


foreach($row as $record) {
	
$dateline = date("jS F Y",$record[4]);
//if($record[5]) { $ip = " - ".$record[5]; } else { $ip = ""; }

if($record[3] == "Yes") {
$archive_list .= "<option value=\"".stripslashes($record[0])."\" style=\"font-size:10px;\">".stripslashes($record[1])." ".stripslashes($record[2])." ".$dateline."</option>\n";
} else {
$active_list .= "<option value=\"".stripslashes($record[0])."\" style=\"font-size:10px;\">".stripslashes($record[1])." ".stripslashes($record[2])." ".$dateline."</option>\n";
}
}


$total_rows = $sql_command->count_rows($database_info_contactus,"id","");


$total_rows = 0;

if($_POST["action"] == "Download CSV") {
header("Location: ".$site_url."/oos/download-data.php?type=csv&data=".$_POST["data"]."&from=".$_POST["date_from"]."&to=".$_POST["date_to"]."&bclient=".$_POST["bclient"]);
exit();
}


//$get_ip_results = $sql_command->select($database_info_contactus,"ip,count(id)","WHERE ip!='' GROUP BY ip");
//$get_ip_results_row = $sql_command->results($get_ip_results);

//foreach($get_ip_results_row as $get_ip_results_record) {
//if($get_ip_results_record[1] > 1) {
//$ip_html .= stripslashes($get_ip_results_record[0])." (".$get_ip_results_record[1].")<br>";	
//}
//}
$get_template->topHTML();
?>
<h1>Form - Contact US</h1>


<form method="post" action"<?php echo $site_url; ?>/wedding-questionaire.php" name="getcsvdata">
<input type="hidden" name="data" value="contactus" />
<?php //if ($the_username == "u1") {
	$select_l .= "<option value=\"1\">Select All</option>";
	$select_l .= "<option value=\"2\">Clients Only</option>";
	$select_l .= "<option value=\"3\">Prospects Only</option>";
	echo "<div style=\"float:left; width:140px; margin:5px;\"><b>Download Filter</b></div><div style=\"float:left; margin:5px;\"><select name=\"bclient\" style=\"width:150px;\">$select_l</select> * Filter out clients or prospects.</div><div style=\"clear:left;\"></div>";
//}
?>
<div style="float:left; width:140px; margin:5px;"><b>Date From</b></div>
<div style="float:left; margin:5px;"><input type="text" name="date_from"/>
	<script language="JavaScript">
	new tcal ({
		// form name
		'formname': 'getcsvdata',
		// input name
		'controlname': 'date_from'
	});

	</script></div>
<div style="clear:left;"></div>
<div style="float:left; width:140px; margin:5px;"><b>Date To</b></div>
<div style="float:left; margin:5px;"><input type="text" name="date_to"/>
	<script language="JavaScript">
	new tcal ({
		// form name
		'formname': 'getcsvdata',
		// input name
		'controlname': 'date_to'
	});

	</script></div>
<div style="clear:left;"></div>
<input type="submit" name="action" value="Download CSV" />
</form>

<p><hr /></p>
<form action="<?php echo $site_url; ?>/oos/image-ine.php" method="get">
<p><strong>Search Surname</strong> <input type="text" name="surname" value="" /> <input type="submit" name="" value="Search"></p>
</form>

<p><b>Active Messages</b></p>

<form action="<?php echo $site_url; ?>/oos/image-ine.php" method="get">
<input type="hidden" name="action" value="Continue" />
<select name="id" class="inputbox_town" size="20" style="width:700px;" onclick="this.form.submit();"><?php echo $active_list; ?></select>
<p style="margin-top:10px;"><input type="submit" name="action" value="Continue"></p>
</form>
<p><hr /></p>
<p><b>Archived Messages</b></p>
<form action="<?php echo $site_url; ?>/oos/image-ine.php" method="get">
<input type="hidden" name="action" value="Continue" />
<input type="hidden" name="action_type" value="view_archive" />
<select name="id" class="inputbox_town" size="20" style="width:700px;" onclick="this.form.submit();"><?php echo $archive_list; ?></select>
<p style="margin-top:10px;"><input type="submit" name="action" value="Continue"></p>
</form>
<p><hr /></p>
<p><b>Contact Us Results</b> (Total: <?php echo $total_rows; ?>)</p>
<?php //if($ip_html) { ?>
<!--<h2>Duplicate IP Addresses</h2>
<p><?php echo $ip_html; ?></p>-->
<?php //} ?>

<?
$get_template->bottomHTML();
$sql_command->close();
}

?>