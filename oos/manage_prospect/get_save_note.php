<?

if(!$_POST["subject"]) { $error .= "Missing Subject<br>"; }
if(!$_POST["note"]) { $error .= "Missing Note<br>"; }

$_SESSION["subject"] = $_POST["subject"];
$_SESSION["note"] = $_POST["note"];


if($error) {
$get_template->topHTML();
$get_template->errorHTML("Manage Prospect","Oops!","$error","Link","oos/manage-prospect.php?a=add-note&id=".$_POST["client_id"]);
$get_template->bottomHTML();
$sql_command->close();
}

$_SESSION["subject"] = "";
$_SESSION["note"] = "";

$sql_command->insert($database_notes,"client_id,subject,note,timestamp,user_id","'".addslashes($_POST["client_id"])."','".addslashes($_POST["subject"])."','".addslashes($_POST["note"])."','".$time."','".$login_record[1]."'");

$sql_command->insert($database_client_historyinfo,"client_id,user_id,comment,timestamp","'".addslashes($_POST["client_id"])."','".$login_record[1]."','Note Added (".addslashes($_POST["subject"]).")','".$time."'");

$get_template->topHTML();
?>
<h1>Manage Prospect</h1>

<?php echo $menu_line; ?>

<p>The note has now been saved</p>

<p><input type="button" name="" value="Back"  onclick="window.location='<?php echo $site_url; ?>/oos/manage-prospect.php?a=history&id=<?php echo $_POST["client_id"]; ?>'"></p>

<?
$get_template->bottomHTML();
$sql_command->close();
?>