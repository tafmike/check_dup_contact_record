<?php
$fname = $_POST['fn'];
$lname = $_POST['ln'];
$ipaddr = $_POST['ip'];

if (empty($fname)||empty($lname)||empty($ipaddr)) { 
    echo "<h3>Needed information is missing.</h3>";
    exit;
}

// wait 30 secs first
sleep(30);

$condition = '%5B%7B%22field%22%3A%7B%22field%22%3A%22firstname%22%7D%2C%22op%22%3A%22%3D%22%2C%22value%22%3A%7B%22value%22%3A%22'.$fname.'%22%7D%7D%2C%22AND%22%2C%7B%22field%22%3A%7B%22field%22%3A%22lastname%22%7D%2C%22op%22%3A%22%3D%22%2C%22value%22%3A%7B%22value%22%3A%22'.$lname.'%22%7D%7D%2C%22AND%22%2C%7B%22field%22%3A%7B%22field%22%3A%22ip_addy_display%22%7D%2C%22op%22%3A%22%3D%22%2C%22value%22%3A%7B%22value%22%3A%22'.$ipaddr.'%22%7D%7D%5D';

$request = "https://api.ontraport.com/1/Contacts?condition=".$condition;
$session = curl_init($request);

curl_setopt($session, CURLOPT_HTTPHEADER, array(
    'Api-Appid: xxxx',  // replace xxxx with your API Appid
    'Api-Key: yyyy'  // replace yyyy with your API Key
));

curl_setopt ($session, CURLOPT_POST, false);
curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($session);
$jsonarray = json_decode($response, true);
curl_close($session);

$contacts = $jsonarray["data"];

if (count($contacts)<2) {
	exit;
}

$email_list = '';

foreach ($contacts as $num=>$contact_array) {
	if (empty($contact_array["firstname"])) {
		$fname = '';
	} else {
		$fname = $contact_array["firstname"];
	}	
	if (!empty($contact_array["email"])) {  // skip "subscribers" without an email address
		$email_list .= $contact_array["email"]."\r\n";
	}
}
$email_list .= "\r\n";

// send an email to staff
$sendto = "support@yourdomain.com";   // replace support@yourdomain.com with your email address
$message = 'A contact record was just created for someone who seems to have multiple contact records.';
$message = $message."\r\n\r\nContact Name: ".$fname." ".$lname.".\r\n";
$message = $message."\r\nThe Email Addresses are:\r\n".$email_list."\r\n";
$message = $message.'<a href="https://app.ontraport.com/#!/contact/listAll&search='.$fname.'+'.$lname.'">Check the contact records in Ontraport</a>'."\r\n\r\n";
$msgsubject = "Contact with Multiple Records";
// Send
mail($sendto, $msgsubject, $message);
?>
