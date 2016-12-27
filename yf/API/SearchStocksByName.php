<?php
/**
 * Created by PhpStorm.
 * User: werd
 * Date: 8/3/14
 * Time: 8:22 PM
 */
require_once "../Exception/ApiException.php";
require_once "../Exception/HttpException.php";
require_once "../ApiClient.php";
require_once "../HttpClient.php";


//require_once "../ApiClient.php";
//require_once "../HttpClient.php";
try{

	$client = new  YahooFinanceApi\ApiClient();
//YahooFinanceApi\ApiClient();

//Fetch basic data
//$data = $client->getQuotesList("INTC"); //Single stock
//$data = $client->getQuotesList(array("YHOO", "GOOG")); //Multiple stocks at once

//Fetch full data set
//$data = $client->getQuotes("INTC"); //Single stock
//$data = $client->getQuotes(array("YHOO", "GOOG")); //Multiple stocks at once

//Get historical data
//$data = $client->getHistoricalData("YHOO");
$stock_name = isset($_REQUEST['StockName']) ? $_REQUEST['StockName'] : "";

//Search stocks
echo "Searching " . $stock_name . "<br/>";
$data = $client->search($stock_name);
echo "Found " . count($data['ResultSet']['Result']) . "<br/>";
echo "<pre>";
print_r($data);
echo "</pre>";

}
catch(Exception $ex){
	echo "<pre>";
	print_r($ex);

}
//exit;
