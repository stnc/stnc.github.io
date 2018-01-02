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
	 * Sending one binary SMS (payload + xser/udh) to many cell phone numbers. (1toN)
	 * */
	$to_list = array('905304012530'); // array('38761233976', '00905304012530', '+905364257920');
	
	$parts = array();
	$parts[] = new DataItem('005400FC0072006B00E70065002000760065007900610020005400FC0072006B0069007900650020005400FC0072006B00E7006500730069002C005500720061006C002D0041006C007400610079002000640069006C002000610069006C006500730069006E0065002000620061011F006C01310020006200690072002000640069006C006400690072002E', '020118');

	/* Send binary SMS immediately, with default sender (from) and  24h validity period */
	//$response = $smsapi->submitData($to_list, $parts, null, null, null);

	/*
	 * Sending personalized binary SMS. (NtoN)
	 * Send immediately, with default sender (from) and  24h validity period.
	 * */
	$envelop_list = array();
	
	// 1. sms
	$parts = array();
	$parts[] = new DataItem('005400FC0072006B00E70065002000760065007900610020005400FC0072006B0069007900650020005400FC0072006B00E7006500730069002C005500720061006C002D0041006C007400610079002000640069006C002000610069006C006500730069006E0065002000620061011F006C01310020006200690072002000640069006C006400690072002E', '020118');
	$envelop_list[] = new Envelop('905304012530', $parts);

	// 2. sms
	// $parts = array();
	// $parts[] = new DataItem('00450076006500200064006F011F00720075002000730131006C00610020015F006100660061006B002000620065011F0065006E00640069006D0020006B006F015F00750079006F0072006C00610072002000790061007A0131006E0020006C0061006D0062006100640061006B00690020007400760020006D006100730061007900610020', '01060500033B0201020108');
	// $parts[] = new DataItem('0064006F011F007200750020006700FC006C0020006100640061006E0061007900610020006D00750074006C00750020006F006C00640075006C0061007200200064006F006D0061007400650073002000620061006C0131006B00680061006E006500790065002E', '01060500033B0202020108');
	// $envelop_list[] = new Envelop('905364257920', $parts);
	
	$response = $smsapi->submitDataMulti($envelop_list);
	
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