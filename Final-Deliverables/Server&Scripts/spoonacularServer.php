#!/usr/bin/php
<?php
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');

require_once "connect.php";

function doLogin($email, $password)
{

    $db = $GLOBALS['db'];

    $stt = $db->prepare('SELECT * FROM users WHERE email=?');
    $stt->execute([$email]);
    if($stt->rowCount()==1){
        $row = $stt->fetch(PDO::FETCH_ASSOC);
        if($row['password']==$password){
            return 1;
        }else{
            return 0;
        }
    }else{
        return 0;
    }

}

//registers users
function doRegister($username, $password, $email)
{
    require_once "functions.php";

    //$hpass = md5($password);
    $db = $GLOBALS['db'];

    $stt=$db->prepare("SELECT * FROM users WHERE email=?");
    $stt->execute([$email]);
    if($stt->rowCount()==0){
        $st = $db->prepare("INSERT INTO users(id,username,email,password) VALUES(?,?,?,?)");
        if($st->execute([NULL, $username, $email, $password])){

            return 1;

        }else{

            return 0;

        }

    }else{

        return 0;

    }

}


function requestProcessor($request)
{
    echo "received request" . PHP_EOL;
    var_dump($request);
    if (!isset($request['type'])) {
        return "ERROR: unsupported message type";
    }
    switch ($request['type']) {
        case "login":
            return doLogin($request['username'], $request['password']);
        case "validate_session":
            return doValidate($request['sessionId']);
        case "register":
            return doRegister($request['username'], $request['password'], $request['email']);

    }
    return array("returnCode" => '0', 'message' => "Server received request and processed");
}

$server = new rabbitMQServer("testRabbitMQ.ini", "testServer");

echo "testRabbitMQServer BEGIN" . PHP_EOL;
$server->process_requests('requestProcessor');
echo "testRabbitMQServer END" . PHP_EOL;
exit();
?>

