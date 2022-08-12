<?php
require('../../vendor/autoload.php');
require('mqtt-server-config.php');

use \PhpMqtt\Client\MqttClient;
use \PhpMqtt\Client\ConnectionSettings;

include('../sqlite/sqlitesvc.php');

$connectionSettings  = new ConnectionSettings();
$connectionSettings
    ->setUsername($username)
    ->setPassword($password)
    ->setLastWillQualityOfService(0);

$mqtt = new MqttClient($server, $port, $clientId);
$mqtt->connect($connectionSettings, $clean_session);

foreach ($arrtopics as $substopic) {
    $mqtt->subscribe($substopic, function ($topic, $message) {
        $dbsvc = new Sqlitesvc($GLOBALS['sqlitefile']);
        date_default_timezone_set($GLOBALS['timezone']);
        $nowdate = Date("d-m-Y H:i:s.v");
        $arrdata = array("topic_subs" => $topic,
                        "value_subs" => $message,
                        "timestamp_subs" => $nowdate);
        $ret = $dbsvc->dbinsert("tbl_subs",$arrdata);
        if($ret == true){
            echo sprintf("%s - Received message on topic [%s]: %s\n", $nowdate, $topic, $message);
        }else{
            echo sprintf($ret);
        }
    }, 0);
}

$mqtt->loop(true);
$mqtt->disconnect();
?>