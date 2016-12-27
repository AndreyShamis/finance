<?php
/**
 * Created by PhpStorm.
 * User: werd
 * Date: 8/10/14
 * Time: 8:59 PM
 */

require_once "../Exception/ApiException.php";
require_once "../Exception/HttpException.php";
require_once "../ApiClient.php";
require_once "../HttpClient.php";

require_once "DB.php";

function IfLastPriceSame($symbol,$newPrice)
{
    global $db;
    $sql    = "SELECT * FROM tbl_data WHERE id_symbol='".$symbol."' ORDER BY id DESC LIMIT 1";
    $q      = $db->query($sql);
    $count  = $db->count($q);
    //$log = new LogBase("/tmp/updateAllStocksValues.log");
    //$log->AddToLog("Count ". $count);
    if($count == 1)
    {
        $row = $db->fetch_assoc($q);
        //$log->AddToLog("Comparing " . $row['id_LastTradePriceOnly'] . " to " .$newPrice);
        if($row['id_LastTradePriceOnly'] == $newPrice)
        {
            return true;
        }
    }

    return false;
}

function UpdateStocksValue($stock_name)
{
    global $db;
    $client = new  YahooFinanceApi\ApiClient();
    $log = new LogBase("/tmp/updateAllStocksValues.log");
    $ext = new ExecutionTime();
    try{
        $data = $client->getQuotes($stock_name); //Single stock
    }
    catch(Exception $ex)
    {
        $log->AddToLog("ERROR:[UpdateStocksValue]" . $ex->getMessage() . ". " . $ex->getTraceAsString() . " STRING:[" . $stock_name . "]");
    }
    $log->AddToLog("getQuotes in " . $ext->getExecutionTime() . "sec");
    //$data = $client->getQuotesList($stock_name );

    $stock_arr = $data['query']['results']['quote'];
    $inserted = 0;
    $ninserted=0;
	//echo "<pre>";
	//print_r($stock_arr);

    if(is_array($stock_arr)){	
    foreach($stock_arr as $key =>$stock)
    {
        $stock_date_all = explode("T",$data['query']['created']);
        $stock_date = $stock_date_all[0];  // $stock['LastTradeDate']
        $stock_time = $stock_date_all[1];  // $stock['LastTradeTime']
        $stock_time = str_replace("Z","",$stock_time);
        if(IfLastPriceSame($stock['symbol'],$stock['LastTradePriceOnly']) == true)
        {
            $ninserted++;
            //$log->AddToLog(" - Not inserting " . $stock['symbol'] . " previous value like this " . $stock['LastTradePriceOnly']);
        }
        else{
		if($stock['DaysLow'] != "" &&  $stock['Open'] != ""){
			$last_price = 0;
	    		if($stock['LastTradePriceOnly'] > 0){
				$last_price = $stock['LastTradePriceOnly'];
	    		}
            		$inserted++;
            		//$log->AddToLog(" + Inserting " . $stock['symbol'] . " previous value like this " . $stock['LastTradePriceOnly']);
            		$sql = "INSERT INTO tbl_data (id_symbol,id_LastTradePriceOnly,id_LastTradeDate,id_LastTradeTime,id_Open,id_DaysHigh,id_DaysLow,id_Volume)
            		VALUES
            		('".$stock['symbol']."','".$last_price."','".$stock_date."',
            		'".$stock_time."','".$stock['Open']."','".$stock['DaysHigh']."','".$stock['DaysLow']."','".$stock['Volume']."')";
            		//echo $sql . "<br/>";
            		$db->query($sql);
		}
		else{
			echo "SKIP <strong>" . $stock['symbol'] . "</strong><br/>";
		}
        }
    }
    }
    $log->AddToLog("Summary getQuotes in " . $ext->getExecutionTime() . "sec. Inserted " . $ninserted . "/" . $inserted );
}

function UpdateStockValue($stock_name)
{
    global $db;
    $client = new  YahooFinanceApi\ApiClient();

    $data = $client->getQuotes($stock_name); //Single stock
    //$data = $client->getQuotesList($stock_name );

    $stock = $data['query']['results']['quote'];

    $stock_date_all = explode("T",$data['query']['created']);
    $stock_date = $stock_date_all[0];  // $stock['LastTradeDate']
    $stock_time = $stock_date_all[1];  // $stock['LastTradeTime']
    $stock_time = str_replace("Z","",$stock_time);

    $sql = "INSERT INTO tbl_data  (id_symbol,id_LastTradePriceOnly,id_LastTradeDate,id_LastTradeTime,id_Open,id_DaysHigh,id_DaysLow,id_Volume)
    VALUES
    ('".$stock['symbol']."','".$stock['LastTradePriceOnly']."','".$stock_date."',
    '".$stock_time."','".$stock['Open']."','".$stock['DaysHigh']."','".$stock['DaysLow']."','".$stock['Volume']."')";
    $db->query($sql);
}
