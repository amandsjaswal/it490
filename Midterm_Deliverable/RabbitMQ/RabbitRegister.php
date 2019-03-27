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
  $msg = "Register";
}

$user_name = $_POST["username"];
$pass= $_POST["password"];
$email= $_POST["email"];
//$username = "hello";
//$password = "hello";

$request = array();
$request['type'] = "register";
$request['username'] = $user_name;
$request['password'] = $pass;
$request['email']= $email;
$request['message'] = $msg;
$response = $client->send_request($request);
//$response = $client->publish($request);

if ($response = 1) {
	header("location:regsuccess.php");

}else {
	 header("location:registererror.php");

}

?>

