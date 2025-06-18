<?php 
 include("shop_details.php");
 include("validation_message.php");
 include("pagination.php");
     $connection = new DatabaseConnection("localhost","root","","bills","utf8");
     $pagination = new Pagination("yes","yes",0,0,0,1);
 
    
//function to print all shops from database
function print_all_available_shops(){
    global $pagination;
    global $connection;
    $connection->connectToDatabase();
    //default limit is 10 if we wish to increase it, we could change constant value manually in Pagination class
    //this will be used at the start we need to check if current url is zero
    //if current url is greater than zero set dynamic limit else use constant limit
    $pagination->setCurrentUrl($_GET['current_url']);
    if($pagination->getCurrentUrl()==0){
 $limit=Pagination::LIMIT_PER_PAGE;
    }else{
      $pagination->setDynamicLimit($_GET['current_url']);
      $limit=$pagination->getDynamicLimit();
      echo $limit;
    }
    $sql="SELECT shop_name FROM shop LIMIT $limit";
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
      echo "<tfoot>";
    echo "<tr>";

      //increase pagination values for 10 next url will have number 20
      //in every other case set pagination to 10
      if(isset($_GET['current_url'])){
          $pagination->setNextUrl($_GET['current_url']);
          $pagination->setCurrentUrl($_GET['current_url']);
          $pagination->setPreviousUrl($_GET['current_url']);
      }
    //if previous is less than 0 then user cannot click on him
    //set previous button to disabled
        if($pagination->getPreviousUrl()<0){
     echo "<td><button id='previous' type='button' class='btn btn-light disabled' aria-disabled='true'>Previous</button></td>";
    }else{
    echo "<td><button id='previous' type='button' class='btn btn-light' onclick='set_url_value(".$pagination->getPreviousUrl().")'>Previous</button></td>";
    }
   
      echo "<td>".$pagination->getPageNumber()."</td>";
    
      echo "<td><button id='next' type='button' class='btn btn-light' onclick='set_url_value(".$pagination->getNextUrl().")'>Next</button></td>";
    echo "</tr>";
  echo "</tfoot>";
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
  $shop1=new Shop("");
  //this is a fix for array undefined error
  //after successfull entry do i need to have value from shop name in input field?
  if(!isset($_POST['shop_name'])){
      $_POST['shop_name']="";
  }else{
    $shop1->set_shop_name($_POST['shop_name']);
  }
  global $connection;
  $connection->connectToDatabase();
    echo "<form action='".htmlspecialchars($_SERVER["PHP_SELF"])."' method='post'>
  <div class='input-group mb-3'> 
  <input type='text' class='form-control border border-primary' aria-label='Default' aria-describedby='inputGroup-sizing-default' name='shop_name' id='shop_name' autocomplete='off' size='50' maxlength='255' value='".$shop1->get_shop_name()."'>
    <div class='input-group-append'>
     <input type='submit' value='Insert new shop' class='btn btn-light' id='ns'>
  </div>
</div>
 
</form>";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if(empty($_POST['shop_name'])){
    echo "Error!!! The record you wanted to insert is empty. Please, enter non-empty entry.";
    
  }else{
  $shop=new Shop("");
$shop->set_shop_name($_POST['shop_name']);
$sn=$shop->get_shop_name();
//add shop name to array to use clean data function to clean and trim data as security feature
$shop_array=array();
$shop_array[]=$sn;
//number of data will be known since we will process post data 
//number of post data is equal number of fields in html form written by programmer
$shop_array=clean_data($shop_array);
//we will set new object to recieve clean data
$shop->set_shop_name($shop_array[0]);
//after that validation will be made
$validation=validate_data("shop_name",$shop->get_shop_name());
//if validation has passed insert record into database
//in any other case display error

if($validation==1){
$sn=$shop->get_shop_name();
//$query="INSERT INTO `shop` (`shop_name`) VALUES ('$sn')";
$statement=$connection->getDbconn()->prepare("INSERT INTO shop (shop_name) VALUES (?)");
$statement->bind_param('s',$sn);
$statement->execute();
$statement->close();
 $connection->close_database();
echo "<script type='text/javascript'> document.location = 'new_shop.php?current_url=0';  </script>";
}else if($validation==0){
  echo Validation::SHOP_ALREADY_EXISTS;
  $connection->close_database();
}else{
    echo "Invalid value";
}
  }
}
}
//function for trimming, strip_slashes and htmlspecialchar
//will use array structure since we will use this as multiple cleaning data.
//return values will also be array $_GET['var1], $POST['var2'],$_POST['var_3] array of multiple get and post methods
//reusability
function clean_data($array_of_data){
    $new_array=array();
foreach ($array_of_data as $value) {
  $value = trim($value);
  $value = stripslashes($value);
  $value = htmlspecialchars($value);
  $new_array[]=$value;
}
return $new_array;
}
//validate data for unique values if exists will return error message entry already exists.
//will query database also
//$data is one string or numeric value which will be validated one by one
//function will return true if validation has passed, false if it is not
function validate_data($what_data_to_validate,$data){

    global $connection;
    $connection->connectToDatabase();
    $passed=0;
    if($what_data_to_validate=="shop_name"){
        $sql="SELECT COUNT(*) FROM `shop` WHERE `shop_name`= '$data'";
        $execute_query=mysqli_query($connection->getDbconn(),$sql);
        //need only one result using fetch column
        $result=$execute_query->fetch_column();
       
        if($result>0){
            $passed=0;
          
        }else if($result==0){
            $passed=1;
           
        }else{
            die("Invalid data.");
             $passed=0;
          
        }

    }
  
    return $passed;
}


?>
