
#!/usr/bin/php
<?php
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');
//include 'database.php';
//$connection=new mysqli("localhost", "aj", "aj123", "rabbitMQ");
function doLogin($username,$password)
{
$connection=new mysqli("192.168.1.7", "karm", "karm123", "rabbitMQ");

    // lookup username in databas
    // check password
$query = "SELECT * FROM `Users` WHERE username='$username' and password='$password'";

$result = mysqli_query($connection, $query) or die(mysqli_error($connection));
$count = mysqli_num_rows($result);
//3.1.2 If the posted values are equal to the database values, then session will be created for the user.
if ($count >= 1){
return 1 ;

}else{
//3.1.3 If the login credentials doesn't match, he will be shown with an error message.

return 0 ;

}



//3.1.2 If the posted values are equal to the database values, then session will be created for the user.


    //return false if not valid
}

//registers users
function doRegister($username,$password,$email)
{
$connection=new mysqli("192.168.1.7", "karm", "karm123", "rabbitMQ");

$query1 = "SELECT * FROM `Users` WHERE username='$username' OR password='$email'";

$result1 = mysqli_query($connection, $query1) or die(mysqli_error($connection));
$count1 = mysqli_num_rows($result1);
//3.1.2 If the posted values are equal to the database values, then session will be created for the user.
if ($count1 >= 1){
return 0 ;
}
else{
//3.1.3 If the login credentials doesn't match, he will be shown with an error message.

$query = "INSERT INTO Users (username, email, password)  VALUES ('$username', '$email', '$password')";

 $result = mysqli_query($connection, $query) or die(mysqli_error($connection));

//3.1.2 If the posted values are equal to the database values, then session will be created for the user.
if ($result){

return 1 ;

}else{
//3.1.3 If the login credentials doesn't match, he will be shown with an error message.

return 0 ;

}

}

}

function requestProcessor($request)
{
  echo "received request".PHP_EOL;
  var_dump($request);
  if(!isset($request['type']))
  {
    return "ERROR: unsupported message type";
  }
  switch ($request['type'])
  {
    case "login":
      return doLogin($request['username'],$request['password']);
    case "validate_session":
      return doValidate($request['sessionId']);
    case "register":
      return doRegister($request['username'],$request['password'],$request['email']);

  }
  return array("returnCode" => '0', 'message'=>"Server received request and processed");
}

$server = new rabbitMQServer("testRabbitMQ.ini","testServer");

echo "testRabbitMQServer BEGIN".PHP_EOL;
$server->process_requests('requestProcessor');
echo "testRabbitMQServer END".PHP_EOL;
exit();
?>

