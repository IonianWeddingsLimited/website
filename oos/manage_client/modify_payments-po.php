<?
$uid = (isset($_POST['cli_id'])) ? "?action=Continue&id=".$_POST['cli_id'] : "";
if (count($_POST['payall'])>=0) {
	if ($_POST['action']==="Approve Payments") {
		$payall = $_POST['payall'];
		
		foreach($payall as $p) {
			$sql_command->update("supplier_transactions","status='Paid'","p_id='".addslashes($p)."'");
			
			$pays = $sql_command->select("supplier_payments",
										 "order_id,invoice_id,main_id",
										 "WHERE pay_no='".addslashes($p)."'");	
			$payr = $sql_command->results($pays);
			$total_prev	=0;
			foreach($payr as $pay) {
				$payval = $sql_command->select("supplier_payments,supplier_transactions",
											   "sum(supplier_payments.p_amount)",
											   "WHERE supplier_transactions.p_id = supplier_payments.pay_no
											   AND supplier_payments.main_id='".addslashes($pay[2])."'
									AND supplier_transactions.status = 'Paid'");
				$payvalr = $sql_command->result($payval);		
				
				
				
				$result = $sql_command->select("$database_supplier_invoices","iw_cost",
											   "WHERE order_id = '".addslashes($pay[0])."'
											   AND supplier_id = '".addslashes($_POST['cli_id'])."'
											   AND invoice_id = '".addslashes($pay[1])."'
											   AND (status != 'Paid' or status != 'Cancelled')");
				$row = $sql_command->result($result);
				
				$totalin = str_replace(",","",number_format($row[0],2));

				if ($payvalr[0]>=$totalin) {
					$sql_command->update($database_supplier_invoices_main,
										 "status='Paid'",
										 "id='".addslashes($pay[2])."'");
					
					$sql_command->update($database_supplier_invoices,
										 "status='Paid'",
										 "order_id='".addslashes($pay[0])."'
										 AND invoice_id = '".addslashes($pay[1])."'
										 AND supplier_id = '".addslashes($_POST['cli_id'])."'");
					
					$sql_command->update("supplier_payments,supplier_transactions",
										 "supplier_payments.status='Cancelled'",
										 "supplier_transactions.p_id = supplier_payments.pay_no
										 AND supplier_transactions.status != 'Paid'
										 AND supplier_payments.status != 'Unpaid'
										 AND supplier_payments.p_amount > 0
										 AND supplier_payments.main_id='".addslashes($pay[2])."'");
			
					$sql_command->update("supplier_payments,supplier_transactions",
										 "supplier_payments.p_amount=0",
										 "supplier_transactions.p_id = supplier_payments.pay_no
										 AND supplier_transactions.status != 'Paid'
										 AND supplier_payments.status != 'Unpaid'
										 AND supplier_payments.p_amount > 0
										 AND supplier_payments.main_id='".addslashes($pay[2])."'");
											   
				}	

			}
			
		}
		header("Location: $site_url/oos/manage-supplier-po.php".$uid);

	}
	elseif ($_POST['action']==="Delete Payments") {
		$payall = $_POST['payall'];
		foreach($payall as $p) {
			
			$pays = $sql_command->select("supplier_payments","main_id,order_id,invoice_id",
								"WHERE pay_no='".addslashes($p)."'");
			$payr = $sql_command->results($pays);

			$sql_command->update("supplier_payments","status='Cancelled'","pay_no='".addslashes($p)."'");
			$sql_command->update("supplier_payments","p_amount=0","pay_no='".addslashes($p)."'");
	

			foreach($payr as $pay) {
				
				$payval = $sql_command->select("supplier_payments,supplier_transactions",
											   "sum(supplier_payments.p_amount)",
											   "WHERE supplier_transactions.p_id = supplier_payments.pay_no
											   AND supplier_payments.main_id='".addslashes($pay[0])."'
											   AND supplier_transactions.status = 'Paid'");
				$payvalr = $sql_command->result($payval);		
				
				
				$result = $sql_command->select("$database_supplier_invoices","SUM(qty*cost)",
										   "WHERE order_id = '".addslashes($pay[1])."'
		   									AND invoice_id='".addslashes($pay[2])."'
											AND supplier_id = '".addslashes($_POST['cli_id'])."'");
				$row = $sql_command->result($result);
				$payval = str_replace(",","",number_format($payvalr[0],2));
				$totalin = str_replace(",","",number_format($row[0],2));

				if ($payval<$totalin) {
					$sql_command->update($database_supplier_invoices_main,
										 "status='Outstanding'",
										 "id='".addslashes($pay[0])."'");
					
					$sql_command->update($database_supplier_invoices,
										 "status='Outstanding'",
										 "order_id='".addslashes($pay[1])."'
										 AND invoice_id = '".addslashes($pay[2])."'
										 AND supplier_id = '".addslashes($_POST['cli_id'])."'");
				}
			}
			$sql_command->update("supplier_transactions","status='Cancelled'","p_id='".addslashes($p)."'");	
			$sql_command->update("supplier_transactions","reason='".$_POST['reason']."'","p_id='".addslashes($p)."'");	
			$debug = "&mid=".$pay[0]."&oid=".$pay[1]."&iid=".$pay[2]."&sid=".$_POST['cli_id']."&pay=".$payval."&total=".$totalin;
			
		}		
		header("Location: $site_url/oos/manage-supplier-po.php".$uid.$debug);
	}

	else {
		header("Location: $site_url/oos/manage-supplier-po.php".$uid.$debug);
	}
}
else {
	header("Location: $site_url/oos/manage-supplier-po.php".$uid.$debug); 
}
?>
