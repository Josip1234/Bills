<?php 
//function to print all shops from database
function print_all_available_shops(){
    include("dbconn.php");
    include("shop.php");
    $connection = new DatabaseConnection("localhost","root","","bills","utf8");
    $dbc=$connection->connectToDatabase();
    $sql="SELECT shop_name FROM shop;";
    $query=mysqli_query($dbc,$sql);
    $id=0;
    echo "<h2>Lista upisanih trgovina</h2>";
    echo "<table class='table table-striped'>";
    echo "<thead><tr><th scope='col'>Redni broj</th><th scope='col'>Naziv trgovine</th></tr></thead>";
    echo "<tbody>";
    while($res=mysqli_fetch_array($query)){
        echo "<tr>";
        $id++;
        $shop=new Shop($res['shop_name']);
        echo "<td>".$id."</td>";
		echo "<td>".$shop->get_shop_name()."</td>";
        echo "</tr>";
	}
    echo "<tbody>";
    echo "</table>";
    $dbc=mysqli_close($dbc);

}


?>
