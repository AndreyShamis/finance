<?php
/**
 * Created by PhpStorm.
 * User: werd
 * Date: 8/17/14
 * Time: 4:11 PM
 */


require_once    "../Exception/ApiException.php";
require_once    "../Exception/HttpException.php";
require_once    "../ApiClient.php";
require_once    "../HttpClient.php";
require_once    "../API/DB.php";

$time_start = microtime(true);

$sql    = "SELECT * FROM tbl_company WHERE id_exchDisp='NASDAQ' ORDER BY id LIMIT 200";
$q      = $db->query($sql);
$count  = $db->count($q);

echo "Count " . $count . " entries to proceed.<br/>";

?>

<table class="StocksTbl">
    <thead>
    <tr>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
    </tr>
    </thead>

<?php
for($i=0;$i<$count;$i++)
{
    $row = $db->fetch_assoc($q);
    echo "<tr>";
    echo "<td  style='font-size: 10px;' title='".$row['id']."'><a title='".$row['id_symbol']."' onclick=\"ShowCompanyStock('".$row['id_symbol']."');\" href='#'>".$row['id_name']."</a></td>";
    echo "<td style='font-size: 6px;'>".$row['id_exch']."</td>";
    echo "<td style='font-size: 6px;'>".$row['id_type']."</td>";
    echo "<td style='font-size: 6px;'>".$row['id_exchDisp']."</td>";
    echo "<td style='font-size: 6px;'>".$row['id_typeDisp']."</td>";
    echo "</tr>";
//    ShowCompanyStock ShowCompanyStock.php?comp=" . $row['id_symbol']. "

}
?>
</table>