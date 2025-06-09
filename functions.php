<?php 
 include("shop_details.php");
     $connection = new DatabaseConnection("localhost","root","","bills","utf8");
    
//function to print all shops from database
function print_all_available_shops(){
    global $connection;
    $connection->connectToDatabase();
    $sql="SELECT shop_name FROM shop;";
    $query=mysqli_query($connection->getDbconn(),$sql);
    $id=0;
    echo "<h2>Lista upisanih trgovina</h2>";
    echo "<table class='table table-striped'>";
    echo "<thead><tr><th scope='col'>Redni broj</th><th scope='col'>Naziv trgovine</th><th>#</th></tr></thead>";
    echo "<tbody>";
    while($res=mysqli_fetch_array($query)){
        echo "<tr>";
        $id++;
        $shop=new Shop($res['shop_name']);
        echo "<td>".$id."</td>";
		echo "<td id='".$shop->get_shop_name()."'>".$shop->get_shop_name()."</td>";
        echo "<td><button id='".$shop->get_shop_name()."' type='button' class='btn btn-light' onclick='showShopDetails(this.id)'>Detalji</button></td>";
        echo "</tr>";
	}
    echo "<tbody>";
    echo "</table>";
       $connection->close_database();
}
function print_shop_details($shop_name){
     include("shop_logo.php");
     global $connection;
     $shop=new Shop($shop_name);
    $connection = new DatabaseConnection("localhost","root","","bills","utf8");
    $connection->connectToDatabase();
    $sql="SELECT * FROM shop_detail WHERE shop_name='".$shop->get_shop_name()."'";
    $query=mysqli_query($connection->getDbconn(),$sql);
    //select logo by shop name from table shop_logo
    $sql2="SELECT * FROM shop_logo WHERE shop_name='".$shop->get_shop_name()."'";
    $exe_q=mysqli_query($connection->getDbconn(),$sql2);
    $id=0;
    echo "<h2>Detalji tražene trgovine</h2>";
    echo "<table class='table table-striped'>";
    echo "<thead><tr><th scope='col'>Redni broj</th><th scope='col'>Adresa trgovine</th><th scope='col'>SSN</th><th scope='col'>Broj trgovine</th><th scope='col'>Telefon</th><th scope='col'>Fax</th>
<th scope='col'>Email</th>
<th scope='col'>Adresa sjedišta</th>
<th scope='col'>Web adresa</th>
<th scope='col'>Logotipovi</th>
</tr></thead>";
    echo "<tbody>";
    
    while($res=mysqli_fetch_array($query)){
        echo "<tr>";
        $id++;
     $details=new ShopDetails($id,$shop_name,$res['address'],$res['ssn'],$res['shop number'],$res['telephone'],$res['fax'],$res['email'],$res['hq_address'],$res['web_page']);
     $details->print_table_data();
        //kreiraj objekt shop logo i dohvati i ispiši logotipove
        while($res2=mysqli_fetch_array($exe_q)){
           
            $logo=new Shop_Logo($shop_name,$res2['logo1_url'],$res2['logo2_url']);
            $logo->print_logo();
        }

        echo "</tr>";
        $details->setId($id);
	}
    echo "<tbody>";
    echo "</table>";
     $connection->close_database();
}

function insert_new_shop(){
  global $connection;
  $connection->connectToDatabase();
    echo "<form action='new_shop.php' method='post'>
  <div class='input-group mb-3'>
  <input type='text' class='form-control border border-primary' aria-label='Default' aria-describedby='inputGroup-sizing-default' name='shop_name' id='shop_name' autocomplete='off' size='50' maxlength='255'>
    <div class='input-group-append'>
     <input type='submit' value='Insert new shop' class='btn btn-light' id='ns'>
  </div>
</div>
 
</form>";
$shop=new Shop($_POST['shop_name']);
//INSERT INTO `shop` (`id`, `shop_name`) VALUES (NULL, 'LIDL HRVATSKA d.o.o. k.d.\r\n')
$sn=$shop->get_shop_name();

$query="INSERT INTO `shop` (`shop_name`) VALUES ('$sn')";
mysqli_query($connection->getDbconn(),$query);
 $connection->close_database();
}



?>
