<?php
/**
 * Created by PhpStorm.
 * User: werd
 * Date: 8/10/14
 * Time: 7:47 PM
 */

require_once "../ApiClient.php";
require_once "../HttpClient.php";
include "DB.php";
$client = new  YahooFinanceApi\ApiClient();

function generateRandomString($length = 10) {
    $characters = 'abcdefghijklmnopqrstuvwxyz0123456789'; //
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $randomString;
}
$search_str =$_GET['StockName'];
echo "Searching " . $search_str . "<br/>";
$data = $client->search($search_str);
echo "Found " . count($data['ResultSet']['Result']) . "<br/>";
echo "<pre>";
print_r($data);
//print_r($data);
$arr = $data['ResultSet']['Result'];
foreach($arr as $key=>$val)
{
    echo "KRY $key " . $val['symbol'] . "-".  $val['name'] . "<br/>";
    $id = CheckIfSymbolExist($val['symbol']);
    if($id>0)
    {
        $sql = "UPDATE tbl_company SET
        id_exch ='". mysql_real_escape_string($val['exch'])."',
        id_type='". mysql_real_escape_string($val['type'])."',
        id_exchDisp='". mysql_real_escape_string($val['exchDisp'])."',
        id_typeDisp='". mysql_real_escape_string($val['typeDisp'])."'
        WHERE id='".$id."' LIMIT 1";
        echo $sql;
        $db->query($sql);
    }
}


echo "</pre>";
for($i=0;$i<0;$i++)
{
    $search_str = generateRandomString(2);
    echo "Searching " . $search_str . "<br/>";
    $data = $client->search($search_str);
    echo "Found " . count($data['ResultSet']['Result']) . "<br/>";
    echo "<pre>";
    //print_r($data);

    $arr = $data['ResultSet']['Result'];
    foreach($arr as $key=>$val)
    {
        echo "KRY $key " . $val['symbol'] . "-".  $val['name'] . "<br/>";
        $sql = "INSERT INTO tbl_company (id_name,id_symbol,id_exch,id_type,id_exchDisp,id_typeDisp) VALUES
        ('". mysql_real_escape_string($val['name'])."','".mysql_real_escape_string($val['symbol'])."','".mysql_real_escape_string($val['exch'])."','".mysql_real_escape_string($val['type'])."','".mysql_real_escape_string($val['exchDisp'])."','".mysql_real_escape_string($val['typeDisp'])."')";
        $db->query($sql);
    }
    echo "</pre>";
}

function CheckIfSymbolExist($symbol)
{
    global $db;
    $sql = "SELECT * FROM tbl_company WHERE id_symbol='".$symbol."' LIMIT 1";
    $q = $db->query($sql);
    $count = $db->count($q);
    if($count == 1)
    {
        $row = $db->fetch_assoc($q);
        return (int)$row['id'];
    }

    return 0;
}