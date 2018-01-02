<?php
	require_once('SmsApi.php');
	header('Content-Type: text/plain;charset=utf-8');
	
	$smsapi = new SmsApi("[username]", "[password]");
	
	$response = $smsapi->query_multi(1,'2014-03-03T00:00:00.0000000','2014-05-03T00:00:00.0000000');
	
	if($response->status){
		if($response->payload->Status->Code == 200){		
			foreach ($response->payload->Report->List->ReportItem as $item) {
    			echo $item->Id . "\t|" . $item->Message . "\t|" . $item->State . "\t|" . $item->Count . "\t|" 
    			 	. $item->UndeliveredCount . "\t\r\n";
			}
		}
		else{
			echo "No client error but server responded with error: "
			. $response->payload->Status->Code . "-" . $response->payload->Status->Description;
		}
	}
	else{
		echo "Client error: $response->error";	
	} 
?>