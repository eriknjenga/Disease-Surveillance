<?php

$name = $_POST['name']; // contain name of person
$province = $_POST['province']; // Province of sender 
$district = $_POST['district']; // District
$body = $_POST['msg']; // Your message 
$receiver = "kittemm@gmail.com" ; // hardcorde your email address here - This is the email address that all your feedbacks will be sent to 
if (!empty($name) & !empty($email) && !empty($body)) {
    $body = "Name:{$name}\n\nProvince :{$province}\n\District :{$district}\n\nComments:{$body}";
	$send = mail($receiver, 'Contact Form Submission', $body, "From: {$email}");
    if ($send) {
        echo 'true'; //if everything is ok,always return true , else ajax submission won't work
    }

}

?>