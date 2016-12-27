/**
 * Created by werd on 8/3/14.
 */


function ShowStockByName()
{
    $.post("API/ShowStockByName.php" ,
        $("#ShowStockByName").serializeArray() ,
        function(data) {
            $("#SearchByNameOutput").html(data);
        });
}

function SearchStocks()
{
    $.post("API/SearchStocksByName.php" ,
        $("#SearchStocksByName").serializeArray() ,
        function(data) {
            $("#SearchByNameOutput").html(data);
        });
}

function PostExample()
{
    $.post("API/framework/TestChangeRecovered.php" ,
        $("#TestDetailedInfoForm").serializeArray() ,
        function(data) {
            $("#TestDetailedInfoSaveResult").html(data);
        });
}

function ShowCompanys(){
    $("#StockData").html("");
    $.ajax({
        url: "view/ShowCompanys.php",
        cache:false,
        success: function(html){
            $("#data").html( html);
        }
    });
}
function ShowCompanyStock(compSymbol){
    $.ajax({
        url: "view/ShowCompanyStock.php?comp=" + compSymbol,
        cache:false,
        success: function(html){
            $("#StockData").html( html);
        }
    });
}
    function GetExample(testID){
    $.ajax({
        url: "TestList/TestListInfo.php?testsetid=" + testID,
        cache:false,
        success: function(html){

            $("#data").html( html);
        }
    });
    PrintLog("[ShowTestListInfo]" + "TestList/TestListInfo.php?testsetid=" + testID);
}

function PrintLog(mess)
{
    try{
        console.log(mess);
    }catch (e){
        // handle the unsavoriness if needed
    }
}
