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

if($_POST["action"] == "Update") {
header("Location: $site_url/oos/hmrc-report-1.php?year=".$_POST["year"]);
$sql_command->close();
}




$current_year = 2011;
$end_year = date("Y",$time);
$end_year++;
$end_year2 = $end_year + 15;
while($current_year < $end_year2) {
if($_GET["year"] == $current_year) { $selected = "selected=\"selected\""; } else { $selected = ""; }
$list_years .= "<option value=\"".$current_year."\" $selected>".$current_year."</option>";	
$current_year++;
}

if(!$_GET["year"]) { $_GET["year"] = $end_year-1; }


		

$january_start = mktime(0, 0, 0, 1, 1, $_GET["year"]);
$february_start = mktime(0, 0, 0, 2, 1, $_GET["year"]);
$march_start = mktime(0, 0, 0, 3, 1, $_GET["year"]);
$april_start = mktime(0, 0, 0, 4, 1, $_GET["year"]);
$may_start = mktime(0, 0, 0, 5, 1, $_GET["year"]);
$june_start = mktime(0, 0, 0, 6, 1, $_GET["year"]);
$july_start = mktime(0, 0, 0, 7, 1, $_GET["year"]);
$august_start = mktime(0, 0, 0, 8, 1, $_GET["year"]);
$september_start = mktime(0, 0, 0, 9, 1, $_GET["year"]);
$october_start = mktime(0, 0, 0, 10, 1, $_GET["year"]);
$november_start = mktime(0, 0, 0, 11, 1, $_GET["year"]);
$december_start = mktime(0, 0, 0, 12, 1, $_GET["year"]);
$january2_start = mktime(0, 0, 0, 1, 1, $_GET["year"]+1);

$january_result = $sql_command->select("$database_clients,
										$database_order_details,
										$database_customer_invoices,
										$database_package_info,
										$database_packages",
										"$database_customer_invoices.cost,
										$database_customer_invoices.iw_cost,
										$database_customer_invoices.vat,
										$database_customer_invoices.type,
										$database_customer_invoices.included_package,
										$database_customer_invoices.order_id,
										$database_customer_invoices.exchange_rate",
										"WHERE	$database_clients.id					=	$database_order_details.client_id
										and		$database_order_details.id				=	$database_customer_invoices.order_id
										and		$database_order_details.package_id		=	$database_package_info.id
										and		$database_package_info.package_id		=	$database_packages.id
										and		$database_clients.wedding_date			>=	".$january_start."
										and		$database_clients.wedding_date			<	".$february_start."
										and		$database_clients.deleted				=	'No'
										and		$database_customer_invoices.status		=	'Paid'");
$january_rows = $sql_command->results($january_result);

foreach($january_rows as $january_record) {
	
$remove_deposit_value = 0;
if($january_record[4] == "Yes") {
	$deposit_check_result = $sql_command->select($database_customer_invoices,"order_id,cost,iw_cost,exchange_rate","WHERE status='Paid' and (type='Deposit' or type='Recce Fee' or type='Consultation Fee') and order_id='".addslashes($january_record[5])."'");
	$deposit_check_record = $sql_command->result($deposit_check_result);
	$remove_deposit_value = round($deposit_check_record[2],2);
}

$newcost		=	round($january_record[1],2) - $remove_deposit_value;
$january_cost	+=	round($january_record[0] / $january_record[6],2);
$january_iwcost	+=	$newcost;
$january_vat	+=	round(($newcost / 100) * $january_record[2],2);
}
$january_profit	=	$january_iwcost - $january_cost;


$february_result = $sql_command->select("$database_clients,
										$database_order_details,
										$database_customer_invoices,
										$database_package_info,
										$database_packages",
										"$database_customer_invoices.cost,
										$database_customer_invoices.iw_cost,
										$database_customer_invoices.vat,
										$database_customer_invoices.type,
										$database_customer_invoices.included_package,
										$database_customer_invoices.order_id,
										$database_customer_invoices.exchange_rate",
										"WHERE	$database_clients.id					=	$database_order_details.client_id
										and		$database_order_details.id				=	$database_customer_invoices.order_id
										and		$database_order_details.package_id		=	$database_package_info.id
										and		$database_package_info.package_id		=	$database_packages.id
										and		$database_clients.wedding_date			>=	".$february_start."
										and		$database_clients.wedding_date			<	".$march_start."
										and		$database_clients.deleted				=	'No'
										and		$database_customer_invoices.status		=	'Paid'");
$february_rows = $sql_command->results($february_result);

foreach($february_rows as $february_record) {
	
$remove_deposit_value = 0;
if($february_record[4] == "Yes") {
$deposit_check_result = $sql_command->select($database_customer_invoices,"order_id,cost,iw_cost,exchange_rate","WHERE status='Paid' and (type='Deposit' or type='Recce Fee' or type='Consultation Fee') and order_id='".addslashes($february_record[5])."'");
$deposit_check_record = $sql_command->result($deposit_check_result);
$remove_deposit_value = round($deposit_check_record[2],2);
}

$newcost = round($february_record[1],2) - $remove_deposit_value;
$february_cost += round($february_record[0] / $february_record[6],2);
$february_iwcost += $newcost;
$february_vat += round(($newcost / 100) * $february_record[2],2);
}
$february_profit = $february_iwcost - $february_cost;


$march_result = $sql_command->select("$database_clients,
										$database_order_details,
										$database_customer_invoices,
										$database_package_info,
										$database_packages",
										"$database_customer_invoices.cost,
										$database_customer_invoices.iw_cost,
										$database_customer_invoices.vat,
										$database_customer_invoices.type,
										$database_customer_invoices.included_package,
										$database_customer_invoices.order_id,
										$database_customer_invoices.exchange_rate",
										"WHERE	$database_clients.id					=	$database_order_details.client_id
										and		$database_order_details.id				=	$database_customer_invoices.order_id
										and		$database_order_details.package_id		=	$database_package_info.id
										and		$database_package_info.package_id		=	$database_packages.id
										and		$database_clients.wedding_date			>=	".$march_start."
										and		$database_clients.wedding_date			<	".$april_start."
										and		$database_clients.deleted				=	'No'
										and		$database_customer_invoices.status		=	'Paid'");
$march_rows = $sql_command->results($march_result);

foreach($march_rows as $march_record) {
	
$remove_deposit_value = 0;
if($march_record[4] == "Yes") {
$deposit_check_result = $sql_command->select($database_customer_invoices,"order_id,cost,iw_cost,exchange_rate","WHERE status='Paid' and (type='Deposit' or type='Recce Fee' or type='Consultation Fee') and order_id='".addslashes($march_record[5])."'");

$deposit_check_record = $sql_command->result($deposit_check_result);
$remove_deposit_value = round($deposit_check_record[2],2);
}

$newcost = round($march_record[1],2) - $remove_deposit_value;
$march_cost += round($march_record[0] / $march_record[6],2);
$march_iwcost += $newcost;
$march_vat += round(($newcost / 100) * $march_record[2],2);
}
$march_profit = $march_iwcost - $march_cost;


$april_result = $sql_command->select("$database_clients,
										$database_order_details,
										$database_customer_invoices,
										$database_package_info,
										$database_packages",
										"$database_customer_invoices.cost,
										$database_customer_invoices.iw_cost,
										$database_customer_invoices.vat,
										$database_customer_invoices.type,
										$database_customer_invoices.included_package,
										$database_customer_invoices.order_id,
										$database_customer_invoices.exchange_rate",
										"WHERE	$database_clients.id					=	$database_order_details.client_id
										and		$database_order_details.id				=	$database_customer_invoices.order_id
										and		$database_order_details.package_id		=	$database_package_info.id
										and		$database_package_info.package_id		=	$database_packages.id
										and		$database_clients.wedding_date			>=	".$april_start."
										and		$database_clients.wedding_date			<	".$may_start."
										and		$database_clients.deleted				=	'No'
										and		$database_customer_invoices.status		=	'Paid'");
$april_rows = $sql_command->results($april_result);

foreach($april_rows as $april_record) {
	
$remove_deposit_value = 0;
if($april_record[4] == "Yes") {
$deposit_check_result = $sql_command->select($database_customer_invoices,"order_id,cost,iw_cost,exchange_rate","WHERE status='Paid' and (type='Deposit' or type='Recce Fee' or type='Consultation Fee') and order_id='".addslashes($april_record[5])."'");
$deposit_check_record = $sql_command->result($deposit_check_result);
$remove_deposit_value = round($deposit_check_record[2],2);
}

$newcost = round($april_record[1],2) - $remove_deposit_value;
$april_cost += round($april_record[0] / $april_record[6],2);
$april_iwcost += $newcost;
$april_vat += round(($newcost / 100) * $april_record[2],2);
}
$april_profit = $april_iwcost - $april_cost;


$may_result = $sql_command->select("$database_clients,
										$database_order_details,
										$database_customer_invoices,
										$database_package_info,
										$database_packages",
										"$database_customer_invoices.cost,
										$database_customer_invoices.iw_cost,
										$database_customer_invoices.vat,
										$database_customer_invoices.type,
										$database_customer_invoices.included_package,
										$database_customer_invoices.order_id,
										$database_customer_invoices.exchange_rate",
										"WHERE	$database_clients.id					=	$database_order_details.client_id
										and		$database_order_details.id				=	$database_customer_invoices.order_id
										and		$database_order_details.package_id		=	$database_package_info.id
										and		$database_package_info.package_id		=	$database_packages.id
										and		$database_clients.wedding_date			>=	".$may_start."
										and		$database_clients.wedding_date			<	".$june_start."
										and		$database_clients.deleted				=	'No'
										and		$database_customer_invoices.status		=	'Paid'");
$may_rows = $sql_command->results($may_result);

foreach($may_rows as $may_record) {
	
$remove_deposit_value = 0;
if($may_record[4] == "Yes") {
$deposit_check_result = $sql_command->select($database_customer_invoices,"order_id,cost,iw_cost,exchange_rate","WHERE status='Paid' and (type='Deposit' or type='Recce Fee' or type='Consultation Fee') and order_id='".addslashes($may_record[5])."'");
$deposit_check_record = $sql_command->result($deposit_check_result);
$remove_deposit_value = round($deposit_check_record[2],2);
}

$newcost = round($may_record[1],2) - $remove_deposit_value;
$may_cost += round($may_record[0] / $may_record[6],2);
$may_iwcost += $newcost;
$may_vat += round(($newcost / 100) * $may_record[2],2);
}
$may_profit = $may_iwcost - $may_cost;


$june_result = $sql_command->select("$database_clients,
										$database_order_details,
										$database_customer_invoices,
										$database_package_info,
										$database_packages",
										"$database_customer_invoices.cost,
										$database_customer_invoices.iw_cost,
										$database_customer_invoices.vat,
										$database_customer_invoices.type,
										$database_customer_invoices.included_package,
										$database_customer_invoices.order_id,
										$database_customer_invoices.exchange_rate",
										"WHERE	$database_clients.id					=	$database_order_details.client_id
										and		$database_order_details.id				=	$database_customer_invoices.order_id
										and		$database_order_details.package_id		=	$database_package_info.id
										and		$database_package_info.package_id		=	$database_packages.id
										and		$database_clients.wedding_date			>=	".$june_start."
										and		$database_clients.wedding_date			<	".$july_start."
										and		$database_clients.deleted				=	'No'
										and		$database_customer_invoices.status		=	'Paid'");
$june_rows = $sql_command->results($june_result);

foreach($june_rows as $june_record) {
	
$remove_deposit_value = 0;
if($june_record[4] == "Yes") {
$deposit_check_result = $sql_command->select($database_customer_invoices,"order_id,cost,iw_cost,exchange_rate","WHERE status='Paid' and (type='Deposit' or type='Recce Fee' or type='Consultation Fee') and order_id='".addslashes($june_record[5])."'");
$deposit_check_record = $sql_command->result($deposit_check_result);
$remove_deposit_value = round($deposit_check_record[2],2);
}

$newcost = round($june_record[1],2) - $remove_deposit_value;
$june_cost += round($june_record[0] / $june_record[6],2);
$june_iwcost += $newcost;
$june_vat += round(($newcost / 100) * $june_record[2],2);
}
$june_profit = $june_iwcost - $june_cost;


$july_result = $sql_command->select("$database_clients,
										$database_order_details,
										$database_customer_invoices,
										$database_package_info,
										$database_packages",
										"$database_customer_invoices.cost,
										$database_customer_invoices.iw_cost,
										$database_customer_invoices.vat,
										$database_customer_invoices.type,
										$database_customer_invoices.included_package,
										$database_customer_invoices.order_id,
										$database_customer_invoices.exchange_rate",
										"WHERE	$database_clients.id					=	$database_order_details.client_id
										and		$database_order_details.id				=	$database_customer_invoices.order_id
										and		$database_order_details.package_id		=	$database_package_info.id
										and		$database_package_info.package_id		=	$database_packages.id
										and		$database_clients.wedding_date			>=	".$july_start."
										and		$database_clients.wedding_date			<	".$august_start."
										and		$database_clients.deleted				=	'No'
										and		$database_customer_invoices.status		=	'Paid'");
$july_rows = $sql_command->results($july_result);

foreach($july_rows as $july_record) {
	
$remove_deposit_value = 0;
if($july_record[4] == "Yes") {
$deposit_check_result = $sql_command->select($database_customer_invoices,"order_id,cost,iw_cost,exchange_rate","WHERE status='Paid' and (type='Deposit' or type='Recce Fee' or type='Consultation Fee') and order_id='".addslashes($july_record[5])."'");
$deposit_check_record = $sql_command->result($deposit_check_result);
$remove_deposit_value = round($deposit_check_record[2],2);
}

$newcost = round($july_record[1],2) - $remove_deposit_value;
$july_cost += round($july_record[0] / $july_record[6],2);
$july_iwcost += $newcost;
$july_vat += round(($newcost / 100) * $july_record[2],2);
}
$july_profit = $july_iwcost - $july_cost;


$august_result = $sql_command->select("$database_clients,
										$database_order_details,
										$database_customer_invoices,
										$database_package_info,
										$database_packages",
										"$database_customer_invoices.cost,
										$database_customer_invoices.iw_cost,
										$database_customer_invoices.vat,
										$database_customer_invoices.type,
										$database_customer_invoices.included_package,
										$database_customer_invoices.order_id,
										$database_customer_invoices.exchange_rate",
										"WHERE	$database_clients.id					=	$database_order_details.client_id
										and		$database_order_details.id				=	$database_customer_invoices.order_id
										and		$database_order_details.package_id		=	$database_package_info.id
										and		$database_package_info.package_id		=	$database_packages.id
										and		$database_clients.wedding_date			>=	".$august_start."
										and		$database_clients.wedding_date			<	".$september_start."
										and		$database_clients.deleted				=	'No'
										and		$database_customer_invoices.status		=	'Paid'");
$august_rows = $sql_command->results($august_result);

foreach($august_rows as $august_record) {
	
$remove_deposit_value = 0;
if($august_record[4] == "Yes") {
$deposit_check_result = $sql_command->select($database_customer_invoices,"order_id,cost,iw_cost,exchange_rate","WHERE status='Paid' and (type='Deposit' or type='Recce Fee' or type='Consultation Fee') and order_id='".addslashes($august_record[5])."'");
$deposit_check_record = $sql_command->result($deposit_check_result);
$remove_deposit_value = round($deposit_check_record[2],2);
}

$newcost = round($august_record[1],2) - $remove_deposit_value;
$august_cost += round($august_record[0] / $august_record[6],2);
$august_iwcost += $newcost;
$august_vat += round(($newcost / 100) * $august_record[2],2);
}
$august_profit = $august_iwcost - $august_cost;



$september_result = $sql_command->select("$database_clients,
										$database_order_details,
										$database_customer_invoices,
										$database_package_info,
										$database_packages",
										"$database_customer_invoices.cost,
										$database_customer_invoices.iw_cost,
										$database_customer_invoices.vat,
										$database_customer_invoices.type,
										$database_customer_invoices.included_package,
										$database_customer_invoices.order_id,
										$database_customer_invoices.exchange_rate",
										"WHERE	$database_clients.id					=	$database_order_details.client_id
										and		$database_order_details.id				=	$database_customer_invoices.order_id
										and		$database_order_details.package_id		=	$database_package_info.id
										and		$database_package_info.package_id		=	$database_packages.id
										and		$database_clients.wedding_date			>=	".$september_start."
										and		$database_clients.wedding_date			<	".$october_start."
										and		$database_clients.deleted				=	'No'
										and		$database_customer_invoices.status		=	'Paid'");
$september_rows = $sql_command->results($september_result);

foreach($september_rows as $september_record) {
	
$remove_deposit_value = 0;
if($september_record[4] == "Yes") {
	$deposit_check_result = $sql_command->select($database_customer_invoices,"order_id,cost,iw_cost,exchange_rate","WHERE status='Paid' and (type='Deposit' or type='Recce Fee' or type='Consultation Fee') and order_id='".addslashes($september_record[5])."'");
	$deposit_check_record = $sql_command->result($deposit_check_result);
	$remove_deposit_value = round($deposit_check_record[2],2);

}
	
//$reportorder_id	=	$september_record[5];
//include("reports_net_gross.php");
//$september_cost += $total_cost;

$newcost = round($september_record[1],2) - $remove_deposit_value;
$september_cost	+= round($september_record[0] / $september_record[6],2);
$september_iwcost += $newcost;
$september_vat += round(($newcost / 100) * $september_record[2],2);
}
$september_profit = $september_iwcost - $september_cost;

$october_result = $sql_command->select("$database_clients,
										$database_order_details,
										$database_customer_invoices,
										$database_package_info,
										$database_packages",
										"$database_customer_invoices.cost,
										$database_customer_invoices.iw_cost,
										$database_customer_invoices.vat,
										$database_customer_invoices.type,
										$database_customer_invoices.included_package,
										$database_customer_invoices.order_id,
										$database_customer_invoices.exchange_rate",
										"WHERE	$database_clients.id					=	$database_order_details.client_id
										and		$database_order_details.id				=	$database_customer_invoices.order_id
										and		$database_order_details.package_id		=	$database_package_info.id
										and		$database_package_info.package_id		=	$database_packages.id
										and		$database_clients.wedding_date			>=	".$october_start."
										and		$database_clients.wedding_date			<	".$november_start."
										and		$database_clients.deleted				=	'No'
										and		$database_customer_invoices.status		=	'Paid'");
$october_rows = $sql_command->results($october_result);

foreach($october_rows as $october_record) {
	
$remove_deposit_value = 0;
if($october_record[4] == "Yes") {
$deposit_check_result = $sql_command->select($database_customer_invoices,"order_id,cost,iw_cost,exchange_rate","WHERE status='Paid' and (type='Deposit' or type='Recce Fee' or type='Consultation Fee') and order_id='".addslashes($october_record[5])."'");
$deposit_check_record = $sql_command->result($deposit_check_result);
$remove_deposit_value = round($deposit_check_record[2],2);
}

$newcost = round($october_record[1],2) - $remove_deposit_value;
$october_cost += round($october_record[0] / $october_record[6],2);
$october_iwcost += $newcost;
$october_vat += round(($newcost / 100) * $october_record[2],2);
}
$october_profit = $october_iwcost - $october_cost;



$november_result = $sql_command->select("$database_clients,
										$database_order_details,
										$database_customer_invoices,
										$database_package_info,
										$database_packages",
										"$database_customer_invoices.cost,
										$database_customer_invoices.iw_cost,
										$database_customer_invoices.vat,
										$database_customer_invoices.type,
										$database_customer_invoices.included_package,
										$database_customer_invoices.order_id,
										$database_customer_invoices.exchange_rate",
										"WHERE	$database_clients.id					=	$database_order_details.client_id
										and		$database_order_details.id				=	$database_customer_invoices.order_id
										and		$database_order_details.package_id		=	$database_package_info.id
										and		$database_package_info.package_id		=	$database_packages.id
										and		$database_clients.wedding_date			>=	".$november_start."
										and		$database_clients.wedding_date			<	".$december_start."
										and		$database_clients.deleted				=	'No'
										and		$database_customer_invoices.status		=	'Paid'");
$november_rows = $sql_command->results($november_result);

foreach($november_rows as $november_record) {
	
$remove_deposit_value = 0;
if($november_record[4] == "Yes") {
$deposit_check_result = $sql_command->select($database_customer_invoices,"order_id,cost,iw_cost,exchange_rate","WHERE status='Paid' and (type='Deposit' or type='Recce Fee' or type='Consultation Fee') and order_id='".addslashes($november_record[5])."'");
$deposit_check_record = $sql_command->result($deposit_check_result);
$remove_deposit_value = round($deposit_check_record[2],2);
}

$newcost = round($november_record[1],2) - $remove_deposit_value;
$november_cost += round($november_record[0] / $november_record[6],2);
$november_iwcost += $newcost;
$november_vat += round(($newcost / 100) * $november_record[2],2);
}
$november_profit = $november_iwcost - $november_cost;



$december_result = $sql_command->select("$database_clients,
										$database_order_details,
										$database_customer_invoices,
										$database_package_info,
										$database_packages",
										"$database_customer_invoices.cost,
										$database_customer_invoices.iw_cost,
										$database_customer_invoices.vat,
										$database_customer_invoices.type,
										$database_customer_invoices.included_package,
										$database_customer_invoices.order_id,
										$database_customer_invoices.exchange_rate",
										"WHERE	$database_clients.id					=	$database_order_details.client_id
										and		$database_order_details.id				=	$database_customer_invoices.order_id
										and		$database_order_details.package_id		=	$database_package_info.id
										and		$database_package_info.package_id		=	$database_packages.id
										and		$database_clients.wedding_date			>=	".$december_start."
										and		$database_clients.wedding_date			<	".$january2_start."
										and		$database_customer_invoices.status		=	'Paid'");
$december_rows = $sql_command->results($december_result);

foreach($december_rows as $december_record) {
	
$remove_deposit_value = 0;
if($december_record[4] == "Yes") {
$deposit_check_result = $sql_command->select($database_customer_invoices,"order_id,cost,iw_cost,exchange_rate","WHERE status='Paid' and (type='Deposit' or type='Recce Fee' or type='Consultation Fee') and order_id='".addslashes($december_record[5])."'");
$deposit_check_record = $sql_command->result($deposit_check_result);
$remove_deposit_value = round($deposit_check_record[2],2);
}

$newcost = round($december_record[1],2) - $remove_deposit_value;
$december_cost += round($december_record[0] / $december_record[6],2);
$december_iwcost += $newcost;
$december_vat += round(($newcost / 100) * $december_record[2],2);
}
$december_profit = $december_iwcost - $december_cost;


$get_template->topHTML();
?>
<h1>HMRC Report Per Billing Month</h1>

<form action="<?php echo $site_url; ?>/oos/hmrc-report-1.php" method="POST" >
<div style="float:left; width:100px; margin:5px;"><strong>Tax Year</strong></div>
<div style="float:left;  margin:5px;"><select name="year">
<?php echo $list_years; ?>
</select> <input type="submit" name="action" value="Update" /> - <a href="<?php echo $site_url; ?>/oos/hmrc-report-1-download.php?year=<?php echo $_GET["year"]; ?>">Download Report</a></div>
<div style="clear:left;"></div>
</form>


<p><hr /></p>
<p><strong>Current Year:</strong> <?php echo $_GET["year"];   ?></p>

<div style="float:left; width:150px; margin:5px; margin-top:20px;">&nbsp;</div>
<div style="float:left; width:100px; margin:5px; margin-top:20px;"><strong>Cost</strong></div>
<div style="float:left; width:100px; margin:5px; margin-top:20px;"><strong>IW Cost</strong></div>
<div style="float:left; width:100px; margin:5px; margin-top:20px;"><strong>VAT</strong></div>
<div style="float:left; width:100px; margin:5px; margin-top:20px;"><strong>Margin</strong></div>
<div style="clear:left;"></div>
<hr /></p>
<div style="float:left; width:150px; margin:5px;"><strong>January <?php echo $_GET["year"]; ?></strong></div>
<div style="float:left; width:100px; margin:5px;">&pound; <?php echo number_format($january_cost,2); ?></div>
<div style="float:left; width:100px; margin:5px;">&pound; <?php echo number_format($january_iwcost,2); ?></div>
<div style="float:left; width:100px; margin:5px;">&pound; <?php echo number_format($january_vat,2); ?></div>
<div style="float:left; width:100px; margin:5px;">&pound; <?php echo number_format($jauary_profit,2); ?></div>
<div style="clear:left;"></div>
<div style="float:left; width:150px; margin:5px;"><strong>February <?php echo $_GET["year"]; ?></strong></div>
<div style="float:left; width:100px; margin:5px;">&pound; <?php echo number_format($february_cost,2); ?></div>
<div style="float:left; width:100px; margin:5px;">&pound; <?php echo number_format($february_iwcost,2); ?></div>
<div style="float:left; width:100px; margin:5px;">&pound; <?php echo number_format($february_vat,2); ?></div>
<div style="float:left; width:100px; margin:5px;">&pound; <?php echo number_format($february_profit,2); ?></div>
<div style="clear:left;"></div>
<div style="float:left; width:150px; margin:5px;"><strong>March <?php echo $_GET["year"]; ?></strong></div>
<div style="float:left; width:100px; margin:5px;">&pound; <?php echo number_format($march_cost,2); ?></div>
<div style="float:left; width:100px; margin:5px;">&pound; <?php echo number_format($march_iwcost,2); ?></div>
<div style="float:left; width:100px; margin:5px;">&pound; <?php echo number_format($march_vat,2); ?></div>
<div style="float:left; width:100px; margin:5px;">&pound; <?php echo number_format($march_profit,2); ?></div>
<div style="clear:left;"></div>
<div style="float:left; width:150px; margin:5px;"><strong>April <?php echo $_GET["year"]; ?></strong></div>
<div style="float:left; width:100px; margin:5px;">&pound; <?php echo number_format($april_cost,2); ?></div>
<div style="float:left; width:100px; margin:5px;">&pound; <?php echo number_format($april_iwcost,2); ?></div>
<div style="float:left; width:100px; margin:5px;">&pound; <?php echo number_format($april_vat,2); ?></div>
<div style="float:left; width:100px; margin:5px;">&pound; <?php echo number_format($april_profit,2); ?></div>
<div style="clear:left;"></div>
<div style="float:left; width:150px; margin:5px;"><strong>May <?php echo $_GET["year"]; ?></strong></div>
<div style="float:left; width:100px; margin:5px;">&pound; <?php echo number_format($may_cost,2); ?></div>
<div style="float:left; width:100px; margin:5px;">&pound; <?php echo number_format($may_iwcost,2); ?></div>
<div style="float:left; width:100px; margin:5px;">&pound; <?php echo number_format($may_vat,2); ?></div>
<div style="float:left; width:100px; margin:5px;">&pound; <?php echo number_format($may_profit,2); ?></div>
<div style="clear:left;"></div>
<div style="float:left; width:150px; margin:5px;"><strong>June <?php echo $_GET["year"]; ?></strong></div>
<div style="float:left; width:100px; margin:5px;">&pound; <?php echo number_format($june_cost,2); ?></div>
<div style="float:left; width:100px; margin:5px;">&pound; <?php echo number_format($june_iwcost,2); ?></div>
<div style="float:left; width:100px; margin:5px;">&pound; <?php echo number_format($june_vat,2); ?></div>
<div style="float:left; width:100px; margin:5px;">&pound; <?php echo number_format($june_profit,2); ?></div>
<div style="clear:left;"></div>
<div style="float:left; width:150px; margin:5px;"><strong>July <?php echo $_GET["year"]; ?></strong></div>
<div style="float:left; width:100px; margin:5px;">&pound; <?php echo number_format($july_cost,2); ?></div>
<div style="float:left; width:100px; margin:5px;">&pound; <?php echo number_format($july_iwcost,2); ?></div>
<div style="float:left; width:100px; margin:5px;">&pound; <?php echo number_format($july_vat,2); ?></div>
<div style="float:left; width:100px; margin:5px;">&pound; <?php echo number_format($july_profit,2); ?></div>
<div style="clear:left;"></div>
<div style="float:left; width:150px; margin:5px;"><strong>August <?php echo $_GET["year"]; ?></strong></div>
<div style="float:left; width:100px; margin:5px;">&pound; <?php echo number_format($august_cost,2); ?></div>
<div style="float:left; width:100px; margin:5px;">&pound; <?php echo number_format($august_iwcost,2); ?></div>
<div style="float:left; width:100px; margin:5px;">&pound; <?php echo number_format($august_vat,2); ?></div>
<div style="float:left; width:100px; margin:5px;">&pound; <?php echo number_format($august_profit,2); ?></div>
<div style="clear:left;"></div>
<div style="float:left; width:150px; margin:5px;"><strong>September <?php echo $_GET["year"]; ?></strong></div>
<div style="float:left; width:100px; margin:5px;">&pound; <?php echo number_format($september_cost,2); ?></div>
<div style="float:left; width:100px; margin:5px;">&pound; <?php echo number_format($september_iwcost,2); ?></div>
<div style="float:left; width:100px; margin:5px;">&pound; <?php echo number_format($september_vat,2); ?></div>
<div style="float:left; width:100px; margin:5px;">&pound; <?php echo number_format($september_profit,2); ?></div>
<div style="clear:left;"></div>
<div style="float:left; width:150px; margin:5px;"><strong>October <?php echo $_GET["year"]; ?></strong></div>
<div style="float:left; width:100px; margin:5px;">&pound; <?php echo number_format($october_cost,2); ?></div>
<div style="float:left; width:100px; margin:5px;">&pound; <?php echo number_format($october_iwcost,2); ?></div>
<div style="float:left; width:100px; margin:5px;">&pound; <?php echo number_format($october_vat,2); ?></div>
<div style="float:left; width:100px; margin:5px;">&pound; <?php echo number_format($october_profit,2); ?></div>
<div style="clear:left;"></div>
<div style="float:left; width:150px; margin:5px;"><strong>November <?php echo $_GET["year"]; ?></strong></div>
<div style="float:left; width:100px; margin:5px;">&pound; <?php echo number_format($november_cost,2); ?></div>
<div style="float:left; width:100px; margin:5px;">&pound; <?php echo number_format($november_iwcost,2); ?></div>
<div style="float:left; width:100px; margin:5px;">&pound; <?php echo number_format($november_vat,2); ?></div>
<div style="float:left; width:100px; margin:5px;">&pound; <?php echo number_format($november_profit,2); ?></div>
<div style="clear:left;"></div>
<div style="float:left; width:150px; margin:5px;"><strong>December <?php echo $_GET["year"]; ?></strong></div>
<div style="float:left; width:100px; margin:5px;">&pound; <?php echo number_format($december_cost,2); ?></div>
<div style="float:left; width:100px; margin:5px;">&pound; <?php echo number_format($december_iwcost,2); ?></div>
<div style="float:left; width:100px; margin:5px;">&pound; <?php echo number_format($december_vat,2); ?></div>
<div style="float:left; width:100px; margin:5px;">&pound; <?php echo number_format($december_profit,2); ?></div>
<div style="clear:left;"></div>
<p><hr /></p>
<div style="float:left; width:150px; margin:5px;"><strong>First Quarter</strong></div>
<div style="float:left; width:100px; margin:5px;">&pound; <?php echo number_format($january_cost+$february_cost+$march_cost,2); ?></div>
<div style="float:left; width:100px; margin:5px;">&pound; <?php echo number_format($january_iwcost+$february_iwcost+$march_iwcost,2); ?></div>
<div style="float:left; width:100px; margin:5px;">&pound; <?php echo number_format($january_vat+$february_vat+$march_vat,2); ?></div>
<div style="float:left; width:100px; margin:5px;">&pound; <?php echo number_format($january_profit+$february_profit+$march_profit,2); ?></div>
<div style="clear:left;"></div>
<div style="float:left; width:150px; margin:5px;"><strong>Second Quarter</strong></div>
<div style="float:left; width:100px; margin:5px;">&pound; <?php echo number_format($april_cost+$may_cost+$june_cost,2); ?></div>
<div style="float:left; width:100px; margin:5px;">&pound; <?php echo number_format($april_iwcost+$may_iwcost+$june_iwcost,2); ?></div>
<div style="float:left; width:100px; margin:5px;">&pound; <?php echo number_format($april_vat+$may_vat+$june_vat,2); ?></div>
<div style="float:left; width:100px; margin:5px;">&pound; <?php echo number_format($april_profit+$may_profit+$june_profit,2); ?></div>
<div style="clear:left;"></div>
<div style="float:left; width:150px; margin:5px;"><strong>Third Quarter</strong></div>
<div style="float:left; width:100px; margin:5px;">&pound; <?php echo number_format($july_cost+$august_cost+$september_cost,2); ?></div>
<div style="float:left; width:100px; margin:5px;">&pound; <?php echo number_format($july_iwcost+$august_iwcost+$september_iwcost,2); ?></div>
<div style="float:left; width:100px; margin:5px;">&pound; <?php echo number_format($july_vat+$august_vat+$september_vat,2); ?></div>
<div style="float:left; width:100px; margin:5px;">&pound; <?php echo number_format($july_profit+$august_profit+$september_profit,2); ?></div>
<div style="clear:left;"></div>
<div style="float:left; width:150px; margin:5px;"><strong>Fourth Quarter</strong></div>
<div style="float:left; width:100px; margin:5px;">&pound; <?php echo number_format($october_cost+$november_cost+$december_cost,2); ?></div>
<div style="float:left; width:100px; margin:5px;">&pound; <?php echo number_format($october_iwcost+$november_iwcost+$december_iwcost,2); ?></div>
<div style="float:left; width:100px; margin:5px;">&pound; <?php echo number_format($october_vat+$november_vat+$december_vat,2); ?></div>
<div style="float:left; width:100px; margin:5px;">&pound; <?php echo number_format($october_profit+$november_profit+$december_profit,2); ?></div>
<div style="clear:left;"></div>

<p><hr /></p>
<div style="float:left; width:150px; margin:5px;"><strong>Total</strong></div>
<div style="float:left; width:100px; margin:5px;">&pound; <?php echo number_format($april_cost+$may_cost+$june_cost+$july_cost+$august_cost+$september_cost+$october_cost+$november_cost+$december_cost+$january_cost+$february_cost+$march_cost,2); ?></div>
<div style="float:left; width:100px; margin:5px;">&pound; <?php echo number_format($april_iwcost+$may_iwcost+$june_iwcost+$july_iwcost+$august_iwcost+$september_iwcost+$october_iwcost+$november_iwcost+$december_iwcost+$january_iwcost+$february_iwcost+$march_iwcost,2); ?></div>
<div style="float:left; width:100px; margin:5px;">&pound; <?php echo number_format($april_vat+$may_vat+$june_vat+$july_vat+$august_vat+$september_vat+$october_vat+$november_vat+$december_vat+$january_vat+$february_vat+$march_vat,2); ?></div>
<div style="float:left; width:100px; margin:5px;">&pound; <?php echo number_format($april_profit+$may_profit+$june_profit+$july_profit+$august_profit+$september_profit+$october_profit+$november_profit+$december_profit+$january_profit+$february_profit+$march_profit,2); ?></div>
<div style="clear:left;"></div>

<?
$get_template->bottomHTML();
$sql_command->close();


?>