#!/usr/bin/php

<?php
require_once('/home/amandeep/git/rabbitmqphp_example/path.inc');
require_once('/home/amandeep/git/rabbitmqphp_example/get_host_info.inc');
require_once('/home/amandeep/git/rabbitmqphp_example/rabbitMQLib.inc');

$client = new rabbitMQClient("/home/amandeep/git/rabbitmqphp_example/testRabbitMQ.ini","testServer");
if (isset($argv[1]))
{
  $msg = $argv[1];
}
else
{
  $msg = "Hi";
}

$user_name = $_POST["username"];
$pass= $_POST["password"];

//$user_name = "aj";
//$pass = "aj123";

$request = array();
$request['type'] = "login";
$request['username'] = $user_name;
$request['password'] = $pass;
$request['message'] = $msg;
$response = $client->send_request($request);
//$response = $client->publish($request);

if ($response == 1) {
	header("location:account.php");

}else {
	 header("location:loginerror.php");
}

?>

