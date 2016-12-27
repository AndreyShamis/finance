<?php
/**
 * Created by PhpStorm.
 * User: werd
 * Date: 8/10/14
 * Time: 9:01 PM
 */

require_once "UpdateStockValue.php";
require_once "DB.php";
require_once "class/LogBase.php";
require_once "class/ExecutionTime.php";


$log = new LogBase("/tmp/updateAllStocksValues.log");
$part = isset($_GET['part'])?(int)$_GET['part']:0;
$time_start = microtime(true);
echo "<html><body>";
$limit = 1000;
$sql    = "SELECT * FROM tbl_company WHERE id_exchDisp='NASDAQ' ORDER BY id LIMIT " . $part*$limit . ",". $limit;
$q      = $db->query($sql);
$count  = $db->count($q);

echo "Count " . $count . " entries to proceed.<br/>";
$log->AddToLog("Count " . $count . " entries to proceed. Part:" . $part);
$arr = array();
$MAX_AT_ONCE = 100;
for($i=0;$i<$count;$i++)
{
    $row = $db->fetch_assoc($q);
    //echo $row['id_symbol'] . "<br/>";
    array_push($arr,$row['id_symbol']);

    if(count($arr) == $MAX_AT_ONCE){
        WorkWithArray($arr);
    }
    //UpdateStockValue($row['id_symbol']);
}

if(count($arr) != $MAX_AT_ONCE && count($arr) > 0)
{
    WorkWithArray($arr);
}

function WorkWithArray(&$arr)
{
    global $log;
    global $part;
    //print_r($arr);
    $str = "\"".implode("\",\"",$arr) ."\"";

    $ext = new ExecutionTime();
    echo "<br/>". $str . "<br/>";
    UpdateStocksValue($str);
    $log->AddToLog("Proceed " . count($arr) . " in\t:" . $ext->getExecutionTime() . " sec. Part " . $part);

    reset($arr);
    $arr = array();
    $log->AddToLog("----------------------------------------");
}


$time_end = microtime(true);

//dividing with 60 will give the execution time in minutes other wise seconds
$execution_time = ($time_end - $time_start);

//execution time of the script
$log->AddToLog("Finish in:\t  $execution_time sec. Part " . $part);
echo '<b>Total Execution Time:</b> '.$execution_time.' sec';
echo "<body></html>";
