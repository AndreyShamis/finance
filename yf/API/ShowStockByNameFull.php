<?php
/**
 * Created by PhpStorm.
 * User: werd
 * Date: 8/3/14
 * Time: 10:21 PM
 */

require_once "../ApiClient.php";
require_once "../HttpClient.php";

include "DB.php";
$client = new  YahooFinanceApi\ApiClient();
$stock_name = isset($_POST['StockName'])?$_POST['StockName']: (isset($_GET['StockName']) ? $_GET['StockName']:"");

//$stock_name
$data = $client->getQuotes(array("YHOO", "GOOGL","FB","INTC","ATML","MCHP","AMD","TXN","ARMH","EBAY","MSFT","QCOM","RVLT")); //Single stock
//$data = $client->getQuotesList($stock_name );



echo "Searching " . $stock_name  . " .Found " . $data['query']['count'] . "<br/>";
echo "<pre>";
print_r($data);
/*
$stock = $data['query']['results']['quote'];

$stock_date_all = explode("T",$data['query']['created']);
$stock_date = $stock_date_all[0];  // $stock['LastTradeDate']
$stock_time = $stock_date_all[1];  // $stock['LastTradeTime']
$stock_time = str_replace("Z","",$stock_time);
$sql = "INSERT INTO tbl_data (id_symbol,id_LastTradePriceOnly,id_company,id_LastTradeDate,id_LastTradeTime,id_Open,id_DaysHigh,id_DaysLow,id_Volume)
VALUES
('".$stock['symbol']."','".$stock['LastTradePriceOnly']."','".$stock['Name']."','".$stock_date."',
'".$stock_time."','".$stock['Open']."','".$stock['DaysHigh']."','".$stock['DaysLow']."','".$stock['Volume']."')";
$db->query($sql);
*/
//$sql = "INSERT INTO tbl_company (id_name,id_symbol)VALUES('".$stock['Name']."','".$stock['symbol']."')";
//$db->query($sql);

echo $sql;
echo "</pre>";