<?php
/**
 * Created by PhpStorm.
 * User: werd
 * Date: 8/20/14
 * Time: 10:05 AM
 */

require_once "../Exception/ApiException.php";
require_once "../Exception/HttpException.php";
require_once "../ApiClient.php";
require_once "../HttpClient.php";
require_once "../API/DB.php";

$company = isset($_REQUEST['comp'])?$_REQUEST['comp']:"";

$time_start = microtime(true);


function DeleteDataById($id)
{
    global $db;
    $sql    = "DELETE FROM tbl_data WHERE id='".$id."' LIMIT 1";
    $db->query($sql);

}

$sql    = "SELECT * FROM tbl_data WHERE id_symbol='".$company."' ORDER BY id_LastTradeDate DESC";
$q      = $db->query($sql); //
$count  = $db->count($q);

echo "Count " . $count . " entries to proceed.<br/>";

?>

<table class="StocksTbl">
    <thead>
    <tr>
        <th>ID</th>
        <th>Symbol</th>
        <th>Last Price</th>
        <th>Last Date</th>
        <th>Last Time</th>
        <th>Volume</th>
    </tr>
    </thead>

    <?php
    $prev = -1;
    $prev_price = -1;
    for($i=0;$i<$count;$i++)
    {
        $row = $db->fetch_assoc($q);
        if($prev !=$row['id_Volume'] && $prev_price != $row['id_LastTradePriceOnly'])
        {
            $prev= $row['id_Volume'];
            $prev_price = $row['id_LastTradePriceOnly'];
            $del = 0;
        }
        else{
            $del = $row['id'];
            DeleteDataById($del);
        }
        echo "<tr>";
        echo "<td title='".$row['id']."'>".$row['id']."</td>";
        echo "<td>";
        if($del > 0){
            echo $del . " ";
        }
        echo $row['id_symbol']."</td>";
        echo "<td>".$row['id_LastTradePriceOnly']."</td>";
        echo "<td>".$row['id_LastTradeDate']."</td>";
        echo "<td>".$row['id_LastTradeTime']."</td>";
        echo "<td>".$row['id_Volume']."</td>";
        echo "</tr>";


    }
    ?>

</table>
