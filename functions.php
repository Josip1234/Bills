<?php 
//function to print all shops from database
function print_all_available_shops(){
    include("dbconn.php");
    $connection = new DatabaseConnection("localhost","root","","bills","utf8");
    $dbc=$connection->connectToDatabase();
    $sql="SELECT shop_name FROM shop;";
    $query=mysqli_query($dbc,$sql);
    while($res=mysqli_fetch_array($query)){
		echo $res['shop_name']."<br>";
	}
    $dbc=mysqli_close($dbc);

}


?>

