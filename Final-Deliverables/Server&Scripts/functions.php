<?php
require_once "connect.php";


function inDb($query,$data){
    $db=$GLOBALS['db'];

    $stt = $db->prepare($query);
    $stt->execute($data);
    if($stt->rowCount()==0){
        return false;
    }else{
        return true;
    }
}

function ExecuteDb($query,$data){
    $db=$GLOBALS['db'];

    $stt = $db->prepare($query);
    if($stt->execute($data)){
        return true;
    }else{
        return false;
    }
}

function fetch($query,$data){
    $db=$GLOBALS['db'];

    $stt = $db->prepare($query);
    $stt->execute($data);
    $rows = [];
    while($row = $stt->fetch(PDO::FETCH_ASSOC)){
        array_push($rows,$row);
    }
    return $rows;
}

