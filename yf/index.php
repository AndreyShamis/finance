<?php
/**
 * Created by PhpStorm.
 * User: werd
 * Date: 8/3/14
 * Time: 8:22 PM
 */

include "API/DB.php";

require_once "ApiClient.php";
require_once "HttpClient.php";

$client = new  YahooFinanceApi\ApiClient();
//YahooFinanceApi\ApiClient();

//Fetch basic data
//$data = $client->getQuotesList("INTC"); //Single stock
//$data = $client->getQuotesList(array("YHOO", "GOOG")); //Multiple stocks at once

//Fetch full data set
$data = $client->getQuotes("INTC"); //Single stock
//$data = $client->getQuotes(array("YHOO", "GOOG")); //Multiple stocks at once

//Get historical data
//$data = $client->getHistoricalData("YHOO");


//Search stocks
//$data = $client->search("Yahoo");
include "view/header.php";
?>

<table style="width: 100%" border="1">
    <tr>
        <td colspan="2">
            <ul class="css-menu-3">
                <li><a href="/" class="selected">Home</a></li>
                <li><a href="#" onclick="ShowCompanys();">Companys</a></li>
                <li><a href="#">Show Summary</a></li>
            </ul>
        </td>
    </tr>
    <tr>
        <td style="width: 300px;">1</td>
        <td>
            <table>
                <tr>
                    <td>
                        <form id="SearchStocksByName">
                            Search stock by Name <input type="text" name="StockName" id="StockName"/>
                            <input type="button" value="Search" onclick="SearchStocks();" />
                        </form>
                    </td>
                    <td>
                        <form id="ShowStockByName">
                            Show stock by Name <input type="text" name="StockName" id="StockName"/>
                            <input type="button" value="Search" onclick="ShowStockByName();" />
                        </form>
                    </td>
                </tr>
            </table>


        </td>
    </tr>
    <tr>
        <td style="vertical-align: top;">
            <div id="data"></div>
        </td>
        <td style="vertical-align: top;">
            <div id="StockData"></div>

            <div id="SearchByNameOutput">


            <?php
            echo "<pre>";
            print_r($data);
            echo "</pre>";

            ?>
            </div>
        </td>
    </tr>
</table>
<?php
include "view/footer.php";
?>
