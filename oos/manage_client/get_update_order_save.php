<?

if(!$_POST["exchange_rate"]) { $error .= "Missing exchange rate<br>"; }
if($_POST["exchange_rate"] <= 0) { $error .= "Please enter an exchange rate greater than 0<br>"; }

if($error) {
$get_template->topHTML();
$get_template->errorHTML("Manage Client","Oops!","$error","Link","oos/manage-client.php?a=edit-order&id=".$_POST["client_id"]."&invoice_id=".$_POST["invoice_id"]);
$get_template->bottomHTML();
$sql_command->close();
}


$package_info_result = $sql_command->select($database_order_history,"id,name,cost,iw_cost,currency,d_value,d_type,status,d_","WHERE order_id='".addslashes($_GET["invoice_id"])."' and item_type='Package'");
$package_info_record = $sql_command->result($package_info_result);

$gross_package_cost = ($_POST['gross_package_cost']>0) ? $_POST['gross_package_cost'] : $package_info_record[1];

$sql_command->update($database_order_history,"iw_cost='".addslashes($gross_package_cost)."'","order_id='".addslashes($_GET["invoice_id"])."' and item_type='Package'");
$sql_command->update($database_order_details,"package_iw_cost='".addslashes($gross_package_cost)."'","id='".addslashes($_GET["invoice_id"])."'");


$invoice_cols = "order_id,supplier_id,name,qty,cost,iw_cost,currency,status,exchange_rate,timestamp,code,invoice_id";
$cols = "order_id,type_id,name,qty,cost,iw_cost,local_tax_percent,discount_at,discount_percent,currency,item_type,type,status,exchange_rate,timestamp,d_value,d_type,d_,code,invoice_id";

$sql_command->update($database_order_details,"exchange_rate='".addslashes($_POST["exchange_rate"])."'","id='".addslashes($_POST["invoice_id"])."'");
$sql_command->update($database_order_details,"reception_id='".addslashes($_POST["venue_id"])."'","id='".addslashes($_POST["invoice_id"])."'");
$sql_command->update($database_order_details,"ceremony_id='".addslashes($_POST["ceremony_id"])."'","id='".addslashes($_POST["invoice_id"])."'");

if($_POST["package_d_value"] and $_POST["package_d_type"]) {
$sql_command->update($database_order_history,"d_value='".addslashes($_POST["package_d_value"])."'","order_id='".addslashes($_POST["invoice_id"])."' and item_type='Package'");
$sql_command->update($database_order_history,"d_type='".addslashes($_POST["package_d_type"])."'","order_id='".addslashes($_POST["invoice_id"])."' and item_type='Package'");
$sql_command->update($database_order_history,"d_='".addslashes($_POST["package_d"])."'","order_id='".addslashes($_POST["invoice_id"])."' and item_type='Package'");
}


$package_info_result = $sql_command->select($database_order_history,"id,name,cost,iw_cost,currency,d_value,d_type,d_,status","WHERE order_id='".addslashes($_GET["invoice_id"])."' and item_type='Package'");
$package_info_record = $sql_command->result($package_info_result);

$sql_command->delete($database_order_history,"order_id='".addslashes($_POST["invoice_id"])."' and item_type='Menu' and status='Outstanding'");
$sql_command->delete($database_order_history,"order_id='".addslashes($_POST["invoice_id"])."' and item_type='Extra' and status='Outstanding'");
$sql_command->delete($database_order_history,"order_id='".addslashes($_POST["invoice_id"])."' and item_type='Service Fee' and status='Outstanding'");



$maxid = $_POST["invoice_id"];






$current_row = 1;
$end_value = $_POST["theValue"] + 1;

while($current_row < $end_value) {
$bespoke_qty = "bespoke_extra_qty_".$current_row;
$bespoke_name = "bespoke_extra_name_".$current_row;
$bespoke_currency = "bespoke_extra_currency_".$current_row;
$bespoke_cost = "bespoke_extra_cost_".$current_row;
$bespoke_iwcost = "bespoke_extra_iw_cost_".$current_row;
$bespoke_supplier = "bespoke_extra_supplier_".$current_row;

if($_POST[$bespoke_name]) { 
$colsadd = "supplier_id,category_id,island_id,product_name,currency,cost,iw_cost,type,notes,timestamp,code,deleted";

$valuesadd = "'".addslashes($_POST[$bespoke_supplier])."',
'58',
'".addslashes($_POST["island_id"])."',
'".addslashes($_POST[$bespoke_name])."',
'".addslashes($_POST[$bespoke_currency])."',
'".addslashes($_POST[$bespoke_cost])."',
'".addslashes($_POST[$bespoke_iwcost])."',
'Extra',
'',
'$time',
'',
'No'";

$sql_command->insert($database_package_extras,$colsadd,$valuesadd);
$maxidadd = $sql_command->maxid($database_package_extras,"id");

$_POST[$bespoke_name] = str_replace("<p>", "", $_POST[$bespoke_name]);
$_POST[$bespoke_name] = str_replace("</p>", "", $_POST[$bespoke_name]);

$totalcharacters = strlen($_POST[$bespoke_name]);
$middleend = $totalcharacters / 2;

$first = $_POST[$bespoke_name][0];
$middle = $_POST[$bespoke_name][$middleend];
$last = $_POST[$bespoke_name][$totalcharacters-1];

$codeadd =  $maxidadd . strtoupper($first) . strtoupper($middle) . strtoupper($last) . "B";

$sql_command->update($database_package_extras,"code='".addslashes($codeadd)."'","id='".$maxidadd."'");

$cols = "order_id,type_id,name,qty,cost,iw_cost,local_tax_percent,discount_at,discount_percent,currency,item_type,type,status,exchange_rate,timestamp,d_value,d_type,d_,code,invoice_id";


$values = "'$maxid',
'".addslashes($maxidadd)."',
'".addslashes($_POST[$bespoke_name])."',
'".addslashes($_POST[$bespoke_qty])."',
'".addslashes($_POST[$bespoke_cost])."',
'".addslashes($_POST[$bespoke_iwcost])."',
'',
'',
'',
'".addslashes($_POST[$bespoke_currency])."',
'Extra',
'Extra',
'Outstanding',
'0',
'$time',
'',
'',
'',
'".addslashes($codeadd)."',
''";
$sql_command->insert($database_order_history,$cols,$values);	


}

$current_row++;
}




if($package_info_record[8] != "Invoice Issued") {



$current_row = 1;
$end_value = $_POST["theValue2"] + 1;

while($current_row < $end_value) {
$bespoke_qty = "bespoke_include_qty_".$current_row;
$bespoke_name = "bespoke_include_name_".$current_row;
$bespoke_currency = "bespoke_include_currency_".$current_row;
$bespoke_cost = "bespoke_include_cost_".$current_row;
$bespoke_iwcost = "bespoke_include_iw_cost_".$current_row;
$bespoke_supplier = "bespoke_include_supplier_".$current_row;

if($_POST[$bespoke_name]) { 
$colsadd = "supplier_id,category_id,island_id,product_name,currency,cost,iw_cost,type,notes,timestamp,code,deleted";

$valuesadd = "'".addslashes($_POST[$bespoke_supplier])."',
'58',
'".addslashes($_POST["island_id"])."',
'".addslashes($_POST[$bespoke_name])."',
'".addslashes($_POST[$bespoke_currency])."',
'".addslashes($_POST[$bespoke_cost])."',
'".addslashes($_POST[$bespoke_iwcost])."',
'Extra',
'',
'$time',
'',
'No'";

$sql_command->insert($database_package_extras,$colsadd,$valuesadd);
$maxidadd = $sql_command->maxid($database_package_extras,"id");

$_POST[$bespoke_name] = str_replace("<p>", "", $_POST[$bespoke_name]);
$_POST[$bespoke_name] = str_replace("</p>", "", $_POST[$bespoke_name]);

$totalcharacters = strlen($_POST[$bespoke_name]);
$middleend = $totalcharacters / 2;

$first = $_POST[$bespoke_name][0];
$middle = $_POST[$bespoke_name][$middleend];
$last = $_POST[$bespoke_name][$totalcharacters-1];

$codeadd =  $maxidadd . strtoupper($first) . strtoupper($middle) . strtoupper($last) . "B";

$sql_command->update($database_package_extras,"code='".addslashes($codeadd)."'","id='".$maxidadd."'");

$cols = "order_id,type_id,name,qty,cost,iw_cost,local_tax_percent,discount_at,discount_percent,currency,item_type,type,status,exchange_rate,timestamp,d_value,d_type,d_,code,invoice_id";


$values = "'$maxid',
'".addslashes($maxidadd)."',
'".addslashes($_POST[$bespoke_name])."',
'".addslashes($_POST[$bespoke_qty])."',
'".addslashes($_POST[$bespoke_cost])."',
'".addslashes($_POST[$bespoke_iwcost])."',
'',
'',
'',
'".addslashes($_POST[$bespoke_currency])."',
'Extra',
'Included',
'Outstanding',
'0',
'$time',
'',
'',
'',
'".addslashes($codeadd)."',
''";
$sql_command->insert($database_order_history,$cols,$values);	


}

$current_row++;
}


}






$menu_option_result = $sql_command->select("$database_menu_options,$database_menus","$database_menu_options.id,
										   $database_menu_options.menu_name,
										   $database_menu_options.cost,
										   $database_menu_options.cost_iw,
										   $database_menu_options.currency,
										   $database_menus.supplier_id,
										   $database_menus.venue_id,
										   $database_menus.island_id,
										   $database_menus.menu_name_iw,
										   $database_menus.local_tax_percent,
										   $database_menus.discount_at,
										   $database_menus.discount_percent,
										   $database_menu_options.code","WHERE $database_menu_options.menu_id=$database_menus.id ");
$menu_option_row = $sql_command->results($menu_option_result);

foreach($menu_option_row as $menu_option_record) {
$add_supplier = "No";

$qty = "menu_included_qty_".$menu_option_record[0];	

if($package_info_record[8] != "Invoice Issued") {
if(abs($_POST[$qty]) != 0) { 
$add_supplier = "Yes";
$values = "'".addslashes($_POST["invoice_id"])."',
'".addslashes($menu_option_record[0])."',
'".addslashes($menu_option_record[8])." > ".addslashes($menu_option_record[1])."',
'".addslashes($_POST[$qty])."',
'".addslashes($menu_option_record[2])."',
'0',
'".addslashes($menu_option_record[9])."',
'".addslashes($menu_option_record[10])."',
'".addslashes($menu_option_record[11])."',
'".addslashes($menu_option_record[4])."',
'Menu',
'Included',
'Outstanding',
'0',
'$time',
'',
'',
'',
'".addslashes($menu_option_record[12])."',
''";
$sql_command->insert($database_order_history,$cols,$values);	
}
}


$qty_extra = "menu_qty_".$menu_option_record[0];
$d_value_extra = "menu_d_value_".$menu_option_record[0];
$d_type_extra = "menu_d_type_".$menu_option_record[0];
$d_extra = "menu_d_".$menu_option_record[0];

if(abs($_POST[$qty_extra]) != 0) {
$add_supplier = "Yes";
$values = "'".addslashes($_POST["invoice_id"])."',
'".addslashes($menu_option_record[0])."',
'".addslashes($menu_option_record[8])." > ".addslashes($menu_option_record[1])."',
'".addslashes($_POST[$qty_extra])."',
'".addslashes($menu_option_record[2])."',
'".addslashes($menu_option_record[3])."',
'".addslashes($menu_option_record[9])."',
'".addslashes($menu_option_record[10])."',
'".addslashes($menu_option_record[11])."',
'".addslashes($menu_option_record[4])."',
'Menu',
'Extra',
'Outstanding',
'0',
'$time',
'".addslashes($_POST[$d_value_extra])."',
'".addslashes($_POST[$d_type_extra])."',
'".addslashes($_POST[$d_extra])."',
'".addslashes($menu_option_record[12])."',
''";
$sql_command->insert($database_order_history,$cols,$values);	
}

$qty_include = "include_qty_".$menu_option_record[0];
$d_value_include = "include_d_value_".$menu_option_record[0];
$d_type_include = "include_d_type_".$menu_option_record[0];
$d_include = "include_d_".$menu_option_record[0];

if($package_info_record[8] != "Invoice Issued") {
if(abs($_POST[$qty_include]) != 0) { 
$add_supplier = "Yes";
$values = "'".addslashes($_POST["invoice_id"])."',
'".addslashes($menu_option_record[0])."',
'".addslashes($menu_option_record[8])." > ".addslashes($menu_option_record[1])."',
'".addslashes($_POST[$qty_extra])."',
'".addslashes($menu_option_record[2])."',
'".addslashes($menu_option_record[3])."',
'".addslashes($menu_option_record[9])."',
'".addslashes($menu_option_record[10])."',
'".addslashes($menu_option_record[11])."',
'".addslashes($menu_option_record[4])."',
'Menu',
'Included',
'Outstanding',
'0',
'$time',
'".addslashes($_POST[$d_value_include])."',
'".addslashes($_POST[$d_type_include])."',
'".addslashes($_POST[$d_include])."',
'".addslashes($menu_option_record[12])."',
''";
$sql_command->insert($database_order_history,$cols,$values);		
}
}
}	
	

	
	
	
$package_extra_result = $sql_command->select("$database_package_extras,$database_category_extras","$database_package_extras.id,
									$database_package_extras.supplier_id,
									$database_package_extras.category_id,
									$database_package_extras.island_id,
									$database_package_extras.product_name,
									$database_package_extras.currency,
									$database_package_extras.cost,
									$database_package_extras.iw_cost,
									$database_package_extras.type,
									$database_package_extras.notes,
									$database_category_extras.category_name,
									$database_package_extras.code
									","WHERE $database_package_extras.category_id=$database_category_extras.id and
									$database_package_extras.type='Extra'");
$package_extra_row = $sql_command->results($package_extra_result);

foreach($package_extra_row as $package_extra_record) {
$add_supplier = "No";

$qty = "extra_included_qty_".$package_extra_record[0];	
			 
if($package_info_record[8] != "Invoice Issued") {
if(abs($_POST[$qty]) != 0) { 
$add_supplier = "Yes";
$values = "'".addslashes($_POST["invoice_id"])."',
'".addslashes($package_extra_record[0])."',
'".addslashes($package_extra_record[4])."',
'".addslashes($_POST[$qty])."',
'".addslashes($package_extra_record[6])."',
'0',
'0',
'0',
'0',
'".addslashes($package_extra_record[5])."',
'Extra',
'Included',
'Outstanding',
'0',
'$time',
'',
'',
'',
'".addslashes($package_extra_record[11])."',
''";
$sql_command->insert($database_order_history,$cols,$values);	
}
}

$qty_extra = "extra_qty_".$package_extra_record[0];
$d_value_extra = "extra_d_value_".$package_extra_record[0];
$d_type_extra = "extra_d_type_".$package_extra_record[0];
$d_extra = "extra_d_".$package_extra_record[0];

if(abs($_POST[$qty_extra]) != 0) { 
$add_supplier = "Yes";
$values = "'".addslashes($_POST["invoice_id"])."',
'".addslashes($package_extra_record[0])."',
'".addslashes($package_extra_record[4])."',
'".addslashes($_POST[$qty_extra])."',
'".addslashes($package_extra_record[6])."',
'".addslashes($package_extra_record[7])."',
'0',
'0',
'0',
'".addslashes($package_extra_record[5])."',
'Extra',
'Extra',
'Outstanding',
'0',
'$time',
'".addslashes($_POST[$d_value_extra])."',
'".addslashes($_POST[$d_type_extra])."',
'".addslashes($_POST[$d_extra])."',
'".addslashes($package_extra_record[11])."',
''";
$sql_command->insert($database_order_history,$cols,$values);		
}


$qty_include = "include_qty_".$package_extra_record[0];
$d_value_include = "include_d_value_".$package_extra_record[0];
$d_type_include = "include_d_type_".$package_extra_record[0];
$d_include = "include_d_".$package_extra_record[0];

if($package_info_record[8] != "Invoice Issued") {
if(abs($_POST[$qty_include]) != 0) { 
$add_supplier = "Yes";
$values = "'".addslashes($_POST["invoice_id"])."',
'".addslashes($package_extra_record[0])."',
'".addslashes($package_extra_record[4])."',
'".addslashes($_POST[$qty_include])."',
'".addslashes($package_extra_record[6])."',
'".addslashes($package_extra_record[7])."',
'0',
'0',
'0',
'".addslashes($package_extra_record[5])."',
'Extra',
'Included',
'Outstanding',
'0',
'$time',
'".addslashes($_POST[$d_value_include])."',
'".addslashes($_POST[$d_type_include])."',
'".addslashes($_POST[$d_include])."',
'".addslashes($package_extra_record[11])."',
''";
$sql_command->insert($database_order_history,$cols,$values);		
}
}
}	
	


	
$package_extra_result = $sql_command->select("$database_package_extras,$database_category_extras","$database_package_extras.id,
									$database_package_extras.supplier_id,
									$database_package_extras.category_id,
									$database_package_extras.island_id,
									$database_package_extras.product_name,
									$database_package_extras.currency,
									$database_package_extras.cost,
									$database_package_extras.iw_cost,
									$database_package_extras.type,
									$database_package_extras.notes,
									$database_category_extras.category_name,
									$database_package_extras.code
									","WHERE $database_package_extras.category_id=$database_category_extras.id and
									$database_package_extras.type='Service'");
$package_extra_row = $sql_command->results($package_extra_result);

foreach($package_extra_row as $package_extra_record) {
$add_supplier = "No";

$qty = "service_included_qty_".$package_extra_record[0];	

if($package_info_record[8] != "Invoice Issued") {
if(abs($_POST[$qty]) != 0) { 
$add_supplier = "Yes";

$values = "'".addslashes($_POST["invoice_id"])."',
'".addslashes($package_extra_record[0])."',
'".addslashes($package_extra_record[4])."',
'".addslashes($_POST[$qty])."',
'".addslashes($package_extra_record[6])."',
'0',
'0',
'0',
'0',
'".addslashes($package_extra_record[5])."',
'Extra',
'Included',
'Outstanding',
'0',
'$time',
'',
'',
'',
'".addslashes($package_extra_record[11])."',
''";
$sql_command->insert($database_order_history,$cols,$values);	
}
}

$qty_extra = "service_qty_".$package_extra_record[0];
$d_value_extra = "service_d_value_".$package_extra_record[0];
$d_type_extra = "service_d_type_".$package_extra_record[0];
$d_extra = "service_d_".$package_extra_record[0];

if(abs($_POST[$qty_extra]) != 0) { 
$add_supplier = "Yes";
$values = "'".addslashes($_POST["invoice_id"])."',
'".addslashes($package_extra_record[0])."',
'".addslashes($package_extra_record[4])."',
'".addslashes($_POST[$qty_extra])."',
'".addslashes($package_extra_record[6])."',
'".addslashes($package_extra_record[7])."',
'0',
'0',
'0',
'".addslashes($package_extra_record[5])."',
'Service Fee',
'Extra',
'Outstanding',
'0',
'$time',
'".addslashes($_POST[$d_value_extra])."',
'".addslashes($_POST[$d_type_extra])."',
'".addslashes($_POST[$d_extra])."',
'".addslashes($package_extra_record[11])."',
''";
$sql_command->insert($database_order_history,$cols,$values);		
}

$qty_include = "include_qty_".$package_extra_record[0];
$d_value_include = "include_d_value_".$package_extra_record[0];
$d_type_include = "include_d_type_".$package_extra_record[0];
$d_include = "include_d_".$package_extra_record[0];

if($package_info_record[8] != "Invoice Issued") {
if(abs($_POST[$qty_include]) != 0) { 
$add_supplier = "Yes";
$values = "'".addslashes($_POST["invoice_id"])."',
'".addslashes($package_extra_record[0])."',
'".addslashes($package_extra_record[4])."',
'".addslashes($_POST[$qty_include])."',
'".addslashes($package_extra_record[6])."',
'".addslashes($package_extra_record[7])."',
'0',
'0',
'0',
'".addslashes($package_extra_record[5])."',
'Extra',
'Included',
'Outstanding',
'0',
'$time',
'".addslashes($_POST[$d_value_include])."',
'".addslashes($_POST[$d_type_include])."',
'".addslashes($_POST[$d_include])."',
'".addslashes($package_extra_record[11])."',
''";
$sql_command->insert($database_order_history,$cols,$values);		
}
}	
}

$sql_command->insert($database_client_historyinfo,"client_id,user_id,comment,timestamp","'".addslashes($_POST["client_id"])."','".addslashes($login_record[1])."','Order Updated','".$time."'");


















































$total_pound_cost = 0;
$total_iw_pound_cost = 0;
$total_euro_cost = 0;
$total_iw_euro_cost = 0;
	
$package_info_result = $sql_command->select($database_order_history,"id,name,cost,iw_cost,currency,d_value,d_type,d_","WHERE order_id='".addslashes($_POST["invoice_id"])."' and item_type='Package'");
$package_info_record = $sql_command->result($package_info_result);


$adjustment = $package_info_record[2];
$adjustment_iw = $package_info_record[3];

if($package_info_record[7] == "Gross") { 

if($package_info_record[6] == "Amount" and $package_info_record[5] != 0) {
$adjustment_iw = $package_info_record[3] + $package_info_record[5];
} elseif($package_info_record[6] == "Percent" and $package_info_record[5] != 0) {
$percent_value = ($package_info_record[3] / 100);
$adjustment_iw = $package_info_record[3] + ($percent_value * $package_info_record[5]);
} 

} elseif($package_info_record[7] == "Net") { 

if($package_info_record[6] == "Amount" and $package_info_record[5] != 0) {
$adjustment = $package_info_record[2] + $package_info_record[5];
} elseif($package_info_record[6] == "Percent" and $package_info_record[5] != 0) {
$percent_value = ($package_info_record[2] / 100);
$adjustment = $package_info_record[2] + ($percent_value * $package_info_record[5]);
}

} elseif($package_info_record[7] == "Absolute Gross") { 
$adjustment_iw = $package_info_record[5];
} elseif($package_info_record[7] == "Absolute Net") { 
$adjustment = $package_info_record[5];
}

if($package_info_record[5] == 0 and $package_info_record[7] == "Net") {
$adjustment_iw = $package_info_record[2];
}

$new_package_cost = $adjustment;
$new_package_cost_iw = $adjustment_iw;


if($package_info_record[5] == "Pound") { 
$p_curreny = "&pound;"; 
$total_pound_cost += $new_package_cost;
$total_iw_pound_cost += $new_package_cost_iw;
} else {
$p_curreny = "&euro;"; 
$total_euro_cost += $new_package_cost;
$total_iw_euro_cost += $new_package_cost_iw;
}


$menu_result = $sql_command->select($database_menus,"id,menu_name_iw","ORDER BY menu_name_iw");
$menu_row = $sql_command->results($menu_result);

foreach($menu_row as $menu_record) {
	
	
$total_count = $sql_command->count_rows("$database_order_history,$database_menu_options","$database_order_history.id","$database_order_history.type_id=$database_menu_options.id and 
										   $database_order_history.order_id='".addslashes($_POST["invoice_id"])."' and
										   $database_order_history.item_type='Menu' and $database_menu_options.menu_id='".addslashes($menu_record[0])."'");

if($total_count > 0) {

$menu_option_result = $sql_command->select("$database_order_history,$database_menu_options","$database_order_history.id,
										   $database_order_history.name,
										   $database_order_history.qty,
										   $database_order_history.cost,
										   $database_order_history.iw_cost,
										   $database_order_history.local_tax_percent,
										   $database_order_history.discount_at,
										   $database_order_history.discount_percent,
										   $database_order_history.currency,
										   $database_order_history.item_type,
										   $database_order_history.type,
										   $database_order_history.d_value,
										   $database_order_history.d_type,
										   $database_order_history.d_
										   ","WHERE $database_order_history.type_id=$database_menu_options.id and 
										   $database_order_history.order_id='".addslashes($_POST["invoice_id"])."' and
										   $database_order_history.item_type='Menu' and $database_menu_options.menu_id='".addslashes($menu_record[0])."'");
$menu_option_row = $sql_command->results($menu_option_result);

foreach($menu_option_row as $menu_option_record) {
	
if($menu_option_record[10] == "Included") {
$menu_option_record[3] = 0;
$menu_option_record[4] = 0;
}

$adjustment_iw = $menu_option_record[4];
$adjustment = $menu_option_record[3];


// Work out adjustments
if($menu_option_record[2] > 0) {
	
if($menu_option_record[13] == "Gross") { 

if($menu_option_record[12] == "Amount" and $menu_option_record[11] != 0) {
$adjustment_iw = $menu_option_record[4] + $menu_option_record[11];
} elseif($menu_option_record[12] == "Percent" and $menu_option_record[11] != 0) {
$percent_value = ($menu_option_record[4] / 100);
$adjustment_iw = $menu_option_record[4] + ($percent_value * $menu_option_record[11]);
} 

} elseif($menu_option_record[13] == "Net") { 

if($menu_option_record[12] == "Amount" and $menu_option_record[11] != 0) {
$adjustment = $menu_option_record[3] + $menu_option_record[11];
} elseif($menu_option_record[12] == "Percent" and $menu_option_record[11] != 0) {
$percent_value = ($menu_option_record[3] / 100);
$adjustment = $menu_option_record[3] + ($percent_value * $menu_option_record[11]);
}

} elseif($menu_option_record[13] == "Absolute Gross") { 
$adjustment_iw = $menu_option_record[11];
} elseif($menu_option_record[13] == "Absolute Net") { 
$adjustment = $menu_option_record[11];
}
	
} elseif($menu_option_record[2] < 0) {
	
if($menu_option_record[13] == "Gross") { 

if($menu_option_record[12] == "Amount" and $menu_option_record[11] != 0) {
$adjustment_iw = $menu_option_record[4] - $menu_option_record[11];
} elseif($menu_option_record[12] == "Percent" and $menu_option_record[11] != 0) {
$percent_value = ($menu_option_record[4] / 100);
$adjustment_iw = $menu_option_record[4] - ($percent_value * $menu_option_record[11]);
} 

} elseif($menu_option_record[13] == "Net") { 

if($menu_option_record[12] == "Amount" and $menu_option_record[11] != 0) {
$adjustment = $menu_option_record[3] - $menu_option_record[11];
} elseif($menu_option_record[12] == "Percent" and $menu_option_record[11] != 0) {
$percent_value = ($menu_option_record[3] / 100);
$adjustment = $menu_option_record[3] - ($percent_value * $menu_option_record[11]);
} 

} elseif($menu_option_record[13] == "Absolute Gross") { 
$adjustment_iw = $menu_option_record[11];
} elseif($menu_option_record[13] == "Absolute Net") { 
$adjustment = $menu_option_record[11];
}


}

if($menu_option_record[11] == 0 and $menu_option_record[13] == "Net") {
$adjustment_iw = $menu_option_record[3];
}

$the_cost = $menu_option_record[2] * $adjustment;
$total_iw_cost = $menu_option_record[2] * $adjustment_iw;









if($menu_option_record[8] == "Pound") { 
$curreny = "&pound;"; 
$total_pound_cost += $the_cost;
$total_iw_pound_cost += $total_iw_cost;
} else { 
$curreny = "&euro;"; 
$total_euro_cost += $the_cost;
$total_iw_euro_cost += $total_iw_cost;
}

}
}
}












$extra_cat_result = $sql_command->select($database_category_extras,"id,category_name","ORDER BY category_name");
$extra_cat_row = $sql_command->results($extra_cat_result);

foreach($extra_cat_row as $extra_cat_record) {
	
$total_count = $sql_command->count_rows("$database_order_history,$database_package_extras","$database_order_history.id","$database_order_history.type_id=$database_package_extras.id and 
										   $database_order_history.order_id='".addslashes($_POST["invoice_id"])."' and
										   $database_order_history.item_type='Extra' and $database_package_extras.category_id='".addslashes($extra_cat_record[0])."'");

if($total_count > 0) {
	

$extra_result = $sql_command->select("$database_order_history,$database_package_extras","$database_order_history.id,
										   $database_order_history.name,
										   $database_order_history.qty,
										   $database_order_history.cost,
										   $database_order_history.iw_cost,
										   $database_order_history.local_tax_percent,
										   $database_order_history.discount_at,
										   $database_order_history.discount_percent,
										   $database_order_history.currency,
										   $database_order_history.item_type,
										   $database_order_history.type,
										   $database_order_history.d_value,
										   $database_order_history.d_type,
										   $database_order_history.d_
										   ","WHERE $database_order_history.type_id=$database_package_extras.id and 
										   $database_order_history.order_id='".addslashes($_POST["invoice_id"])."' and
										   $database_order_history.item_type='Extra' and $database_package_extras.category_id='".addslashes($extra_cat_record[0])."'");
$extra_row = $sql_command->results($extra_result);

foreach($extra_row as $extra_record) {
	
if($extra_record[10] == "Included") {
$extra_record[3] = 0;
$extra_record[4] = 0;
}



$adjustment_iw = $extra_record[4];
$adjustment = $extra_record[3];


// Work out adjustments
if($extra_record[2] > 0) {
	
if($extra_record[13] == "Gross") { 

if($extra_record[12] == "Amount" and $extra_record[11] != 0) {
$adjustment_iw = $extra_record[4] + $extra_record[11];
} elseif($extra_record[12] == "Percent" and $extra_record[11] != 0) {
$percent_value = ($extra_record[4] / 100);
$adjustment_iw = $extra_record[4] + ($percent_value * $extra_record[11]);
} 

} elseif($extra_record[13] == "Net") { 

if($extra_record[12] == "Amount" and $extra_record[11] != 0) {
$adjustment = $extra_record[3] + $extra_record[11];
} elseif($extra_record[12] == "Percent" and $extra_record[11] != 0) {
$percent_value = ($extra_record[3] / 100);
$adjustment = $extra_record[3] + ($percent_value * $extra_record[11]);
}

} elseif($extra_record[13] == "Absolute Gross") { 
$adjustment_iw = $extra_record[11];
} elseif($extra_record[13] == "Absolute Net") { 
$adjustment = $extra_record[11];
}
	
} elseif($extra_record[2] < 0) {
	
if($extra_record[13] == "Gross") { 

if($extra_record[12] == "Amount" and $extra_record[11] != 0) {
$adjustment_iw = $extra_record[4] - $extra_record[11];
} elseif($extra_record[12] == "Percent" and $extra_record[11] != 0) {
$percent_value = ($extra_record[4] / 100);
$adjustment_iw = $extra_record[4] - ($percent_value * $extra_record[11]);
} 

} elseif($extra_record[13] == "Net") { 

if($extra_record[12] == "Amount" and $extra_record[11] != 0) {
$adjustment = $extra_record[3] - $extra_record[11];
} elseif($extra_record[12] == "Percent" and $extra_record[11] != 0) {
$percent_value = ($extra_record[3] / 100);
$adjustment = $extra_record[3] - ($percent_value * $extra_record[11]);
} 

} elseif($extra_record[13] == "Absolute Gross") { 
$adjustment_iw = $extra_record[11];
} elseif($extra_record[13] == "Absolute Net") { 
$adjustment = $extra_record[11];
}
	

}

if($extra_record[11] == 0 and $extra_record[13] == "Net") {
$adjustment_iw = $extra_record[3];
}

$the_cost = $extra_record[2] * $adjustment;
$total_iw_cost = $extra_record[2] * $adjustment_iw;



if($extra_record[8] == "Pound") {
$curreny = "&pound;"; 
$total_pound_cost += $the_cost;
$total_iw_pound_cost += $total_iw_cost;
} else { 
$curreny = "&euro;"; 
$total_euro_cost += $the_cost;
$total_iw_euro_cost += $total_iw_cost;
}

}	
}
}



$extra_cat_result = $sql_command->select($database_category_extras,"id,category_name","ORDER BY category_name");
$extra_cat_row = $sql_command->results($extra_cat_result);

foreach($extra_cat_row as $extra_cat_record) {
	
$total_count = $sql_command->count_rows("$database_order_history,$database_package_extras","$database_order_history.id","$database_order_history.type_id=$database_package_extras.id and 
										   $database_order_history.order_id='".addslashes($_POST["invoice_id"])."' and
										   $database_order_history.item_type='Service Fee' and $database_package_extras.category_id='".addslashes($extra_cat_record[0])."'");

if($total_count > 0) {
	

$extra_result = $sql_command->select("$database_order_history,$database_package_extras","$database_order_history.id,
										   $database_order_history.name,
										   $database_order_history.qty,
										   $database_order_history.cost,
										   $database_order_history.iw_cost,
										   $database_order_history.local_tax_percent,
										   $database_order_history.discount_at,
										   $database_order_history.discount_percent,
										   $database_order_history.currency,
										   $database_order_history.item_type,
										   $database_order_history.type,
										   $database_order_history.d_value,
										   $database_order_history.d_type,
										   $database_order_history.d_
										   ","WHERE $database_order_history.type_id=$database_package_extras.id and 
										   $database_order_history.order_id='".addslashes($_POST["invoice_id"])."' and
										   $database_order_history.item_type='Service Fee' and $database_package_extras.category_id='".addslashes($extra_cat_record[0])."'");
$extra_row = $sql_command->results($extra_result);

foreach($extra_row as $extra_record) {
if($extra_record[10] == "Included") {
$extra_record[3] = 0;
$extra_record[4] = 0;
}



$adjustment_iw = $extra_record[4];
$adjustment = $extra_record[3];


// Work out adjustments
if($extra_record[2] > 0) {
	
if($extra_record[13] == "Gross") { 

if($extra_record[12] == "Amount" and $extra_record[11] != 0) {
$adjustment_iw = $extra_record[4] + $extra_record[11];
} elseif($extra_record[12] == "Percent" and $extra_record[11] != 0) {
$percent_value = ($extra_record[4] / 100);
$adjustment_iw = $extra_record[4] + ($percent_value * $extra_record[11]);
} 

} elseif($extra_record[13] == "Net") { 

if($extra_record[12] == "Amount" and $extra_record[11] != 0) {
$adjustment = $extra_record[3] + $extra_record[11];
} elseif($extra_record[12] == "Percent" and $extra_record[11] != 0) {
$percent_value = ($extra_record[3] / 100);
$adjustment = $extra_record[3] + ($percent_value * $extra_record[11]);
}

} elseif($extra_record[13] == "Absolute Gross") { 
$adjustment_iw = $extra_record[11];
} elseif($extra_record[13] == "Absolute Net") { 
$adjustment = $extra_record[11];
}
	
	
} elseif($extra_record[2] < 0) {
	
if($extra_record[13] == "Gross") { 

if($extra_record[12] == "Amount" and $extra_record[11] != 0) {
$adjustment_iw = $extra_record[4] - $extra_record[11];
} elseif($extra_record[12] == "Percent" and $extra_record[11] != 0) {
$percent_value = ($extra_record[4] / 100);
$adjustment_iw = $extra_record[4] - ($percent_value * $extra_record[11]);
} 

} elseif($extra_record[13] == "Net") { 

if($extra_record[12] == "Amount" and $extra_record[11] != 0) {
$adjustment = $extra_record[3] - $extra_record[11];
} elseif($extra_record[12] == "Percent" and $extra_record[11] != 0) {
$percent_value = ($extra_record[3] / 100);
$adjustment = $extra_record[3] - ($percent_value * $extra_record[11]);
} 

} elseif($extra_record[13] == "Absolute Gross") { 
$adjustment_iw = $extra_record[11];
} elseif($extra_record[13] == "Absolute Net") { 
$adjustment = $extra_record[11];
}
	

}

if($extra_record[11] == 0 and $extra_record[13] == "Net") {
$adjustment_iw = $extra_record[3];
}

$the_cost = $extra_record[2] * $adjustment;
$total_iw_cost = $extra_record[2] * $adjustment_iw;



if($extra_record[8] == "Pound") {
$curreny = "&pound;"; 
$total_pound_cost += $the_cost;
$total_iw_pound_cost += $total_iw_cost;
} else { 
$curreny = "&euro;"; 
$total_euro_cost += $the_cost;
$total_iw_euro_cost += $total_iw_cost;
}

}	
}
}


$package_exchange_result = $sql_command->select($database_order_details,"exchange_rate","WHERE id='".addslashes($_POST["invoice_id"])."'");
$package_exchange_record = $sql_command->result($package_exchange_result);

if($package_exchange_record[0] < 1) {
$package_exchange_record[0] = 1;
}

$euro_pound = $total_euro_cost / $package_exchange_record[0]; 
$total_cost_save = $euro_pound + $total_pound_cost;


$euro_pound = $total_iw_euro_cost / $package_exchange_record[0]; 
$total_iw_save = $euro_pound + $total_iw_pound_cost;


$sql_command->update($database_order_details,"total_cost='".$total_cost_save."'","id='".addslashes($_POST["invoice_id"])."'");
$sql_command->update($database_order_details,"total_iw_cost='".$total_iw_save."'","id='".addslashes($_POST["invoice_id"])."'");

	
header("Location: $site_url/oos/manage-client.php?a=history&id=".$_POST["client_id"]);
$sql_command->close();	
	
	
?>