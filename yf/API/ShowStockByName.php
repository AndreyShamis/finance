<?php
/**
 * Created by PhpStorm.
 * User: werd
 * Date: 8/3/14
 * Time: 10:21 PM
 */
require_once "../Exception/ApiException.php";
require_once "../Exception/HttpException.php";
require_once "../ApiClient.php";
require_once "../HttpClient.php";

require_once "DB.php";
$client = new  YahooFinanceApi\ApiClient();
$stock_name = isset($_REQUEST['StockName'])?$_REQUEST['StockName']:"";

//$data = $client->getQuotes($_POST['StockName']); //Single stock
$data = $client->getQuotesList($stock_name );



echo "<h2>Searching <strong>" . $stock_name  . "</strong> .Found " . $data['query']['count'] . "</h2>";
echo "<pre>";
print_r($data);
$stock = $data['query']['results']['quote'];

$stock_date_all = explode("T",$data['query']['created']);
$stock_date = $stock_date_all[0];  // $stock['LastTradeDate']
$stock_time = $stock_date_all[1];  // $stock['LastTradeTime']
$stock_time = str_replace("Z","",$stock_time);
$sql = "INSERT INTO tbl_data (id_symbol,id_LastTradePriceOnly,id_LastTradeDate,id_LastTradeTime,id_Open,id_DaysHigh,id_DaysLow,id_Volume)
VALUES
('".$stock['symbol']."','".$stock['LastTradePriceOnly']."','".$stock_date."',
'".$stock_time."','".$stock['Open']."','".$stock['DaysHigh']."','".$stock['DaysLow']."','".$stock['Volume']."')";
$db->query($sql);
echo $sql;
echo "</pre>";
