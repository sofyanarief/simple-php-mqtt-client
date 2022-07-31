<?php
require(__DIR__.'/../../vendor/autoload.php');
require('mqtt-server-config.php');

use \PhpMqtt\Client\MqttClient;
// use \PhpMqtt\Client\ConnectionSettings;

include(__DIR__.'/../sqlite/sqlitesvc.php');

$arrtopics = array('heaterlt2','test');

// $connectionSettings  = new ConnectionSettings();
// $connectionSettings
//     ->setUsername($username)
//     ->setPassword($password)
//     ->setLastWillQualityOfService(0);

$mqtt = new MqttClient($server, $port, $clientId);
$mqtt->connect();
// $mqtt->connect($connectionSettings, $clean_session);

foreach ($arrtopics as $substopic) {
    $mqtt->subscribe($substopic, function ($topic, $message) {
        $dbsvc = new Sqlitesvc(__DIR__.'/../sqlite/subs-db.sqlite');
        date_default_timezone_set("Asia/Jakarta");
        $nowdate = Date("d-m-Y H:i:s.v");
        $arrdata = array("topic_subs" => $topic,
                        "value_subs" => $message,
                        "timestamp_subs" => $nowdate);
        $ret = $dbsvc->dbinsert("tbl_subs",$arrdata);
        if($ret == true){
            echo sprintf("Received message on topic [%s]: %s\n", $topic, $message);
        }else{
            echo sprintf($ret);
        }
    }, 0);
}

$mqtt->loop(true);
$mqtt->disconnect();
?>