<?php
include 'sqlitesvc.php';

$dbsvc = new Sqlitesvc('subs-db.sqlite');

// $nowdate = Date("d-m-Y h:i:s.v");
// $arrdata = array("topic_subs" => "heaterlt2",
//                 "value_subs" => "on",
//                 "timestamp_subs" => $nowdate);

// $ret = $dbsvc->dbinsert("tbl_subs",$arrdata);
// $dbsvc->debugrint($ret);

// $ret = $dbsvc->dbselect($sql);
// $ret = $dbsvc->dbupdate("tbl_subs",$arrdata,"id_subs = 10");
// $dbsvc->debugrint($ret);

// $ret = $dbsvc->dbdelete("tbl_subs","id_subs = 10");
// $dbsvc->debugrint($ret);

// $arrcolname = array("id_subs","topic_subs","value_subs","timestamp_subs");
$ret = $dbsvc->dbselect("tbl_subs",null,null,"timestamp_subs","DESC");
$dbsvc->debugrint($ret);
?>