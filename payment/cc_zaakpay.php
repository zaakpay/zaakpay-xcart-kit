<?php
#
#
# Zaakpay - HTML Redirect
#

if((isset($_POST)) && (isset($_POST['orderId'])))
	{
			
	 require('checksum.php');
	 require "./auth.php";
	$s = func_query_first("select param01,param02,testmode from $sql_tbl[ccprocessors] where processor='cc_zaakpay.php'");
	
	
if (!func_is_active_payment("cc_zaakpay.php"))
		exit;
//func_payment_header();

	$order = $_POST['orderId'];
	$res_code = $_POST['responseCode'];
	$res_desc = $_POST['responseDescription'];
	$checksum_recv = $_POST['checksum'];

	#Zaakpay Checksum Part 
	$secret_key = $s["param02"];
	$check = new Checksum();
	$all = ("'". $order ."''". $res_code ."''". $res_desc."'");
	$bool = 0;
	$bool = $check->verifyChecksum($checksum_recv, $all, $secret_key);

	$bill_output["sessid"] = func_query_first_cell("SELECT sessid FROM $sql_tbl[cc_pp3_data] WHERE ref='".$order."'");

	
	if($bool == "1" && $res_code == "100")
	{
		$bill_output["code"] = 1;
		$bill_output["billmes"] = $res_desc;
	}
	else
	{
		$bill_output["code"] = 2;
		$bill_output["billmes"] = "The Transaction is declined.";
	}
	
	if (isset($AVS))
		$bill_output['avsmes'] = 'AVS code: ' . $AVS;

	x_session_id($bill_output["sessid"]);
	x_session_register("is_redirect");
	$weblink = $is_redirect == "Y" ? 1 : 2;

	//echo "<wpdisplay item=banner><br />\n";
	func_payment_footer();
	require($xcart_dir . "/payment/payment_ccend.php");
	}
	else
	{
		require('checksum.php');
	
	if (!defined('XCART_START')) { header("Location: ../"); die("Access denied"); }

	x_session_register("is_redirect");


	$url = "https://api.zaakpay.com/transact";		
		

	$desc="";
	$refr="";


		foreach($cart['products'] as $id){
		if(empty($refr))
			$refr = $id['productcode'];
		else
			$refr = '-'.$id['productcode'];
			
			$desc .= $id['product'].' ';
			}
if (!$duplicate)
	{
		db_query("REPLACE INTO $sql_tbl[cc_pp3_data] (ref,sessid) VALUES ('".addslashes($order_secureid)."','".$XCARTSESSID."')");

}

$s = func_query_first("select param01,param02,testmode from $sql_tbl[ccprocessors] where processor='cc_zaakpay.php'");

	$date = date('Y-m-d');
	$amount = $cart["total_cost"] * 100 ; 	//Should be in paisa
	
	if($module_params["param06"] == "TEST")
	$mode = 0;
	else
	$mode = 1;
	
	$post_variables = array(
		"merchantIdentifier" => $module_params["param01"],
		"orderId" => $order_secureid,
		"returnUrl" => $current_location."/payment/cc_zaakpay.php",
		"buyerEmail" => $userinfo["email"],
		"buyerFirstName" => $bill_firstname,
		"buyerLastName" => $bill_lastname,
		"buyerAddress" => $userinfo["b_address"],
		"buyerCity" => $userinfo["b_city"],
		"buyerState" => $userinfo["b_state"] ? $userinfo["b_state"] : "NA",
		"buyerCountry" => $userinfo["b_country"],
		"buyerPincode" => $userinfo["b_zipcode"],
		"buyerPhoneNumber" => $userinfo["phone"],
		"txnType" => '1',
		"zpPayOption" => '1',
		"mode"	=> $mode,
		"currency" => $module_params["param05"],
		"amount" =>  $amount,
		"merchantIpAddress" => "127.0.0.1", 
		"purpose" => '1',
		"productDescription" => $desc,
		"shipToAddress" => $userinfo["s_address"],
		"shipToCity" => $userinfo["s_city"],
		"shipToState" => $userinfo["s_state"] ? $userinfo["s_state"] : "NA",
		"shipToCountry" => $userinfo["s_country"],
		"shipToPincode" => $userinfo["s_zipcode"],
		"shipToFirstname" => $userinfo["s_firstname"],
		"shipToLastname" => $userinfo["s_lastname"],
		"txnDate" => $date,		
	
	);
	
	$secret_key = $module_params["param02"];
	$sum = new Checksum();
		$all = '';
		foreach($post_variables as $name => $value)	{
			if($name != 'checksum') {
				$all .= "'";
				if ($name == 'returnUrl') {
					$all .= $sum->sanitizedURL($value);
				} else {				
					
					$all .= $sum->sanitizedParam($value);
				}
				$all .= "'";
			}
		}
		
		if($module_params["param04"] == "ON")
		{
		error_log("All Params : ".$all);
		error_log("Secret Key : ".$secret_key);
		}

		$checksum = $sum->calculateChecksum($secret_key,$all);
		
	$fields = array(
		"merchantIdentifier" => $module_params["param01"],
		"orderId" => $sum->sanitizedParam($order_secureid),
		"returnUrl" => $current_location."/payment/cc_zaakpay.php",
		"buyerEmail" => $userinfo["email"],
		"buyerFirstName" => $sum->sanitizedParam($bill_firstname),
		"buyerLastName" => $sum->sanitizedParam($bill_lastname),
		"buyerAddress" => $sum->sanitizedParam($userinfo["b_address"]),
		"buyerCity" => $sum->sanitizedParam($userinfo["b_city"]),
		"buyerState" => $userinfo["b_state"] ? $userinfo["b_state"] : "NA",
		"buyerCountry" => $userinfo["b_country"],
		"buyerPincode" => $userinfo["b_zipcode"],
		"buyerPhoneNumber" => $userinfo["phone"],
		"txnType" => '1',
		"zpPayOption" => '1',
		"mode"	=> $mode,
		"currency" => $module_params["param05"],
		"amount" =>  $sum->sanitizedParam($amount),
		"merchantIpAddress" => "127.0.0.1", 
		"purpose" => '1',
		"productDescription" => $sum->sanitizedParam($desc),
		"shipToAddress" => $sum->sanitizedParam($userinfo["s_address"]),
		"shipToCity" => $userinfo["s_city"],
		"shipToState" => $userinfo["s_state"] ? $userinfo["s_state"] : "NA",
		"shipToCountry" => $userinfo["s_country"],
		"shipToPincode" => $userinfo["s_zipcode"],
		"shipToFirstname" => $sum->sanitizedParam($userinfo["s_firstname"]),
		"shipToLastname" => $sum->sanitizedParam($userinfo["s_lastname"]),
		"txnDate" => $date,		
		"checksum" => $checksum,
		
	);
		
	func_create_payment_form($url, $fields, $module_params["module_name"]);
	}


exit;

?>
