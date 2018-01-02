<?php
	require_once('SmsApi.php');
	header('Content-Type: text/plain;charset=utf-8');
	
	/* 
	 * Tips:
	 * 1) Make sure that $scheduled_delivery_time is in future or message will be sent immediately. 
	 * 2) If account is allowed to use dynamic sender:
	 *    a) When using alphanumeric sender ($from) check whether is smaller or equal to 11 chars - regex: (^[a-zA-Z0-9-\*\.\s]{1,11}$))
	 *    b) When using numeric sender ($from) check whether is smaller or equal to 16 digits - regex: (^[\+]?[0-9]{3,16}$).
	 * 3) When using Default data coding, maximum message length is 160 chars (GSM 3.38) and for long SMS up to 612 (153 * 4 message parts).
	 * 4) When using UCS2 data coding, maximum message length is 70 chars (Unicode) and for long SMS up to 268 (67 * 4 message parts).
	 * */
	
$smsapi = new SmsApi("[username]", "[password]");
	
	/*
	 * Sending one SMS (text) to many cell phone numbers. (1toN)
	 * */
	$to_list = array('905300000001'); // array('00905300000002', '+905360000001');
	$message = 'Test me!';
	
	$from = '';
	$validity_period = 61;
	$data_coding = 'UCS2';
	date_default_timezone_set('UTC');
	$date = mktime(0, 0, 0, 11, 5, 2011); // 5 November 2011
	$scheduled_delivery_time = date(DATE_ATOM, $date); // '2011-11-05T00:00:00+00:00'
	
	/* Send SMS at 2011-11-05 00:00+01:00, valid for 61 minute and with unicode support */
	// $response = $smsapi->submit($to_list, $message, $from, $scheduled_delivery_time, $validity_period, $data_coding);
	
	/* Send SMS immediately, with default sender (from) and  24h validity period, using default GSM 3.38 alphabet */
	// $response = $smsapi->submit($to_list, 'hello world');
	
	/* Send SMS immediately, with default sender (from) and  24h validity period, with unicode support */
	$response = $smsapi->submit($to_list, $message, null, null, null, 'UCS2');
	
	/*
	 * Sending personalized SMS messages. (NtoN)
	 * Send immediately, with default sender (from) and  24h validity period, using default GSM 3.38 alphabet.
	 * */
	$envelop_list = array();
	//$envelop_list[] = new Envelop('38761233976', 'hello bosnia');
	$envelop_list[] = new Envelop('905304012530', 'hello turkey');
	
	// $response = $smsapi->submitMulti($envelop_list, $from, $scheduled_delivery_time);
	$response = $smsapi->submitMulti($envelop_list);
	
	
	/* Check submit response */
	if($response->status){
		if($response->payload->Status->Code == 200){
			echo "Message is sent. Check your reports with SMS ID: " . $response->payload->MessageId;	
		}
		else{
			echo "No client error but server responded with error: "
				 . $response->payload->Status->Code  . "-" . $response->payload->Status->Description;
		}
	}
	else{
		echo "Client error: $response->error";	
	} 

?>