<?php
	require_once('SmsApi.php');
	header('Content-Type: text/plain;charset=utf-8');
	
	
	$smsapi = new SmsApi("selmantunc", "123456789");
	
	/* Query SMS messages status by message_id */
	$response = $smsapi->query(325706275);
	
	/* Query SMS message status by message_id and MSISDN (cell phone number) */
	//$response = $smsapi->query(48357370, '905300000001');
	
	/* Check query response */
	if($response->status){
		if($response->payload->Status->Code == 200){	
//print_r($response->payload->ReportDetail->List->ReportDetailItem);		
			foreach ($response->payload->ReportDetail->List->ReportDetailItem as $item) {
    			/* $item->Id . "\t|" . $item->MSISDN . "\t|" . $item->State . "\t|" . $item->ErrorCode . "\t|" 
    			 	. $item->LastUpdated . "\t\r\n";*/
					    			$dizi[]= $item;

			}
		}
		else{
			echo "No client error but server responded with error: ". $response->payload->Status->Code . "-" . $response->payload->Status->Description;
		}
	}
	else{
		echo "Client error: $response->error";	
	} 
	
	print_r($dizi);	
?>