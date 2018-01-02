<?php
	require_once('SmsApi.php');
	header('Content-Type: text/plain;charset=utf-8');
	
	$smsapi = new SmsApi("[username]", "[password]");
	
	/* Cancel previously submitted short message */
	$response = $smsapi->cancel(9191600);
	
	if($response->status){
		if($response->payload->Status->Code == 200){		
			echo "Message is canceled";
		}
		else{
			echo "No client error but server responded with error: "
			. $response->payload->Status->Code . "-" . $response->payload->Status->Description;
		}
	}
	else{
		echo "Client error: $response->error";	
	}
	
	/* Get balance */
	$response = $smsapi->getBalance();
	
	if($response->status){
		if($response->payload->Status->Code == 200){	
			echo "\r\n";	
			echo "Main balance: " . $response->payload->Balance->Main . "\r\n";
			echo "Amount of credit that user can use in advance (postpaid): " . $response->payload->Balance->Limit . "\r\n";
		}
		else{
			echo "No client error but server responded with error: "
			. $response->payload->Status->Code . "-" . $response->payload->Status->Description;
		}
	}
	else{
		echo "Client error: $response->error";	
	}
	
	/* Get account settings/information */
	$response = $smsapi->getSettings();
	
	if($response->status){
		if($response->payload->Status->Code == 200){		
			
			echo "\r\n";
			echo "Balance:\r\n";
			echo "Main balance: " . $response->payload->Settings->Balance->Main . "\r\n";
			echo "Amount of credit that user can use in advance (postpaid): " . $response->payload->Settings->Balance->Limit . "\r\n";
			
			echo "\r\n";
			echo "Senders:\r\n";
			foreach ($response->payload->Settings->Senders->Sender as $item) {
    			echo "Sender Value:" . $item->Value . "\t Is Default:" . $item->Default . "\r\n";
			}
			
			echo "\r\n";
			echo "Keywords:\r\n";
			foreach ($response->payload->Settings->Keywords->Keyword as $item) {
    			echo "Service Number:" . $item->ServiceNumber . "\t Value:" . $item->Value . "\r\n";
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