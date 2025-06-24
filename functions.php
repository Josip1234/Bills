<?php
include("shop_details.php");
include("validation_message.php");
include("pagination.php");
$connection = new DatabaseConnection("localhost", "root", "", "bills", "utf8");
$pagination = new Pagination("yes", "yes", 0, 0, 0, 0,0);


//function to print all shops from database
function print_all_available_shops()
{
  global $pagination;
  global $connection;
  $connection->connectToDatabase();
  //get number of records from database
  $record=$connection->get_num_of_records_from_table("shop");
  //default limit is 10 if we wish to increase it, we could change constant value manually in Pagination class
  //this will be used at the start we need to check if current url is zero
  //if current url is greater than zero set dynamic limit else use constant limit
  $pagination->setCurrentUrl($_GET['current_url']);
  $pagination->setPreviousUrl($_GET['current_url']);
  $pagination->setUpperLimit($_GET['current_url']);
//*prevent  Undefined array key "page_number" error
    if (isset($_GET['page_number'])) {
  $pagination->setPageNumber($_GET['page_number']);
  $pagination->setPreviousNumber($_GET['page_number']);
    }

  $downlimit = $pagination->countDownLimit();
  $uplimit = $pagination->getUpperLimit();
  //this should be changed to prepare statements
  //$sql = "SELECT shop_name FROM shop LIMIT $downlimit,$uplimit";
  //$query = mysqli_query($connection->getDbconn(), $sql);
  $sql="SELECT shop_name FROM shop LIMIT ?,?";
  $stat=$connection->getDbconn()->prepare($sql);
  $stat->bind_param("ii",$downlimit,$uplimit);
  $stat->execute();
  $result=$stat->get_result();
  $id = 0;
  echo "<h2>Lista upisanih trgovina</h2>";
  echo "<table class='table table-striped'>";
  echo "<thead><tr><th scope='col'>Redni broj</th><th scope='col'>Naziv trgovine</th><th>#</th></tr></thead>";
  echo "<tbody>";
  while ($res = mysqli_fetch_array($result)) {
    echo "<tr>";
    $id++;
    $shop = new Shop($res['shop_name']);
    echo "<td>" . $id . "</td>";
    echo "<td id='" . $shop->get_shop_name() . "'>" . $shop->get_shop_name() . "</td>";
    echo "<td><button id='" . $shop->get_shop_name() . "' type='button' class='btn btn-light' onclick='showShopDetails(this.id)'>Detalji</button><button id='" . $shop->get_shop_name() . "' type='button' class='btn btn-light' onclick='updateShopName(this.id)'>Ažuriraj</button></td>";
    echo "</tr>";
  }
  echo "<tbody>";
  echo "<tfoot>";
  echo "<tr>";

  //increase pagination values for 10 next url will have number 20
  //in every other case set pagination to 10
  if (isset($_GET['current_url'])) {
    $pagination->setNextUrl($_GET['current_url']);
    $pagination->setCurrentUrl($_GET['current_url']);
    $pagination->setPreviousUrl($_GET['current_url']);
  }
  //if previous is less than 0 then user cannot click on him
  //set previous button to disabled
  if ($pagination->getPreviousUrl() < 10) {
    echo "<td><button id='previous' type='button' class='btn btn-light disabled' aria-disabled='true'>Previous</button></td>";
  } else {
    echo "<td><button id='previous' type='button' class='btn btn-light' onclick='set_url_value(" . $pagination->getPreviousUrl() . ",".$pagination->getPreviousNumber().")'>Previous</button></td>";
  }
   echo "<td id='display'>" . $pagination->getPageNumber(). "</td>";
//we need to query from database how much records does it have to check if current url is greather than maximal data 
//check will be like as previous to disable next if there is no data anymore available
if($pagination->getCurrentUrl()>$record){
  echo "<td><button id='next' type='button' class='btn btn-light disabled' aria-disabled='true'>Next</button></td>";
}else{
  echo "<td><button id='next' type='button' class='btn btn-light'  onclick='set_url_value(" . $pagination->getNextUrl() . ",".$pagination->getPageNumber().")'>Next</button></td>";
}
  echo "</tr>";
  echo "</tfoot>";
  echo "</table>";
  $connection->close_database();
  
}
function print_shop_details($shop_name)
{
  include("shop_logo.php");
  global $connection;
  $shop = new Shop($shop_name);
  $connection = new DatabaseConnection("localhost", "root", "", "bills", "utf8");
  $connection->connectToDatabase();
  $sql = "SELECT * FROM shop_detail WHERE shop_name='" . $shop->get_shop_name() . "'";
  $query = mysqli_query($connection->getDbconn(), $sql);
  //select logo by shop name from table shop_logo
  $sql2 = "SELECT * FROM shop_logo WHERE shop_name='" . $shop->get_shop_name() . "'";
  $exe_q = mysqli_query($connection->getDbconn(), $sql2);
  $id = 0;
  echo "<h2>Detalji tražene trgovine</h2>";
  echo "<table class='table table-striped'>";
  echo "<thead><tr><th scope='col'>Redni broj</th><th scope='col'>Adresa trgovine</th><th scope='col'>SSN</th><th scope='col'>Broj trgovine</th><th scope='col'>Telefon</th><th scope='col'>Fax</th>
    <th scope='col'>Email</th>
    <th scope='col'>Adresa sjedišta</th>
    <th scope='col'>Web adresa</th>
    <th scope='col'>Logotipovi</th>
    </tr></thead>";
  echo "<tbody>";

  while ($res = mysqli_fetch_array($query)) {
    echo "<tr>";
    $id++;
    $details = new ShopDetails($id, $shop_name, $res['address'], $res['ssn'], $res['shop number'], $res['telephone'], $res['fax'], $res['email'], $res['hq_address'], $res['web_page']);
    $details->print_table_data();
    //kreiraj objekt shop logo i dohvati i ispiši logotipove
    while ($res2 = mysqli_fetch_array($exe_q)) {

      $logo = new Shop_Logo($shop_name, $res2['logo1_url'], $res2['logo2_url']);
      $logo->print_logo();
    }

    echo "</tr>";
    $details->setId($id);
  }
  echo "<tbody>";
  echo "</table>";
  $connection->close_database();
}

function insert_new_shop()
{
  $shop1 = new Shop("");
  //this is a fix for array undefined error
  //after successfull entry do i need to have value from shop name in input field?
  if (!isset($_POST['shop_name'])) {
    $_POST['shop_name'] = "";
  } else {
    $shop1->set_shop_name($_POST['shop_name']);
  }
  global $connection;
  $connection->connectToDatabase();
  echo "<form action='" . htmlspecialchars($_SERVER["PHP_SELF"]) . "' method='post'>
  <div class='input-group mb-3'> 
  <input type='text' class='form-control border border-primary' aria-label='Default' aria-describedby='inputGroup-sizing-default' name='shop_name' id='shop_name' autocomplete='off' size='50' maxlength='255' value='" . $shop1->get_shop_name() . "' placeholder='Enter shop name' required>
    <div class='input-group-append'>
     <input type='submit' value='Insert new shop' class='btn btn-light' id='ns'>
  </div>
</div>
</form>";
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST['shop_name'])) {
      echo "Error!!! The record you wanted to insert is empty. Please, enter non-empty entry.";
    } else {
      $shop = new Shop("");
      $shop->set_shop_name($_POST['shop_name']);
      $sn = $shop->get_shop_name();
      //add shop name to array to use clean data function to clean and trim data as security feature
      $shop_array = array();
      $shop_array[] = $sn;
      //number of data will be known since we will process post data 
      //number of post data is equal number of fields in html form written by programmer
      $shop_array = clean_data($shop_array);
      //we will set new object to recieve clean data
      $shop->set_shop_name($shop_array[0]);
      //after that validation will be made
      $validation = validate_data("shop_name", $shop->get_shop_name());
      //if validation has passed insert record into database
      //in any other case display error

      if ($validation == 1) {
        $sn = $shop->get_shop_name();
        //$query="INSERT INTO `shop` (`shop_name`) VALUES ('$sn')";
        $statement = $connection->getDbconn()->prepare("INSERT INTO shop (shop_name) VALUES (?)");
        $statement->bind_param('s', $sn);
        $statement->execute();
        $statement->close();
        $connection->close_database();
          echo "Successfully inserted new record.";
      } else if ($validation == 0) {
        echo Validation::SHOP_ALREADY_EXISTS;
        $connection->close_database();
      } else {
        echo "Invalid value";
      }
    }
  }
}
//function for trimming, strip_slashes and htmlspecialchar
//will use array structure since we will use this as multiple cleaning data.
//return values will also be array $_GET['var1], $POST['var2'],$_POST['var_3] array of multiple get and post methods
//reusability
function clean_data($array_of_data)
{
  $new_array = array();
  foreach ($array_of_data as $value) {
    $value = trim($value);
    $value = stripslashes($value);
    $value = htmlspecialchars($value);
    $new_array[] = $value;
  }
  return $new_array;
}
//validate data for unique values if exists will return error message entry already exists.
//will query database also
//$data is one string or numeric value which will be validated one by one
//function will return true if validation has passed, false if it is not
function validate_data($what_data_to_validate, $data)
{

  global $connection;
  $connection->connectToDatabase();
  $passed = 0;
  if ($what_data_to_validate == "shop_name") {
    $sql = "SELECT COUNT(*) FROM `shop` WHERE `shop_name`= '$data'";
    $execute_query = mysqli_query($connection->getDbconn(), $sql);
    //need only one result using fetch column
    $result = $execute_query->fetch_column();

    if ($result > 0) {
      $passed = 0;
    } else if ($result == 0) {
      $passed = 1;
    } else {
      die("Invalid data.");
      $passed = 0;
    }
  }

  return $passed;
}

function print_search_data_from_table($what_data,$what_table){
  $data=array();
  $cleaned_data="";
  global $connection;
  $connection->connectToDatabase();

  if($what_table=="shop"){
    $data[]=$what_data;
    $data=clean_data($data);
    $cleaned_data=$data[0]."%";
//select everything which is starting from input value
  $sql="SELECT * FROM $what_table WHERE shop_name LIKE ?";
  $stat=$connection->getDbconn()->prepare($sql);
  $stat->bind_param("s",$cleaned_data);
  $stat->execute();
  $result=$stat->get_result();
    echo "<h2>Rezultati pretraživanja</h2>";
  echo "<table class='table table-striped'>";
  echo "<thead><tr><th scope='col'>Naziv trgovine</th><th>#</th></tr></thead>";
  echo "<tbody>";
  while ($res = mysqli_fetch_array($result)) {
    echo "<tr>";
    $shop = new Shop($res['shop_name']);
    echo "<td id='" . $shop->get_shop_name() . "'>" . $shop->get_shop_name() . "</td>";
    echo "<td><button id='" . $shop->get_shop_name() . "' type='button' class='btn btn-light' onclick='showShopDetails(this.id)'>Detalji</button></td>";
    echo "</tr>";
  }
  echo "<tbody>";
  echo "</table>";
   $connection->close_database();
  }else{
     $connection->close_database();
  }
 
}
function print_search_form(){
   echo "<div class='row'>";
  echo  "<div class='col'>";
  echo  "<div class='input-group flex-nowrap'>";
  echo"<span class='input-group-text' id='addon-wrapping'>Search</span>";
  echo"<input type='text' id='search' class='form-control' placeholder='Search' aria-label='Search' aria-describedby='addon-wrapping' onchange='search_values()'>";
echo"</div>";
    echo"</div>";
  echo"</div>";
}

function delete_cookies(){
  $_COOKIE["result"]; setcookie("result", "", time() - 3600);
$_COOKIE["search"]; setcookie("result", "", time() - 3600);
}

function print_checkboxes(){
    echo"<div class='row'>";
     echo" <div class='col'>";
  echo "<div class='form-check form-check-inline'>";
  echo "<input class='form-check-input' type='radio' name='shop' id='shop' value='shop' checked>";
  echo "<label class='form-check-label' for='shop'>Search shops</label>";
echo "</div>";
      echo "</div>";
  echo "</div>";
}

function update_shop_name(){
  $shop2=new Shop("");
  if(isset($_GET["shop_name"])){
    $shop2->set_shop_name($_GET["shop_name"]);
  }
  echo "<form action='" . htmlspecialchars($_SERVER["PHP_SELF"]) . "' method='post'>
  <div class='input-group mb-3'> 
  <input type='text' class='form-control border border-primary' aria-label='Default' aria-describedby='inputGroup-sizing-default' name='shop_name' id='shop_name' autocomplete='off' size='50' maxlength='255' value='" . $shop2->get_shop_name() . "' placeholder='Update shop name' required>
    <div class='input-group-append'>
     <input type='submit' value='Ažuriraj naziv trgovine' class='btn btn-light' id='ns'>
  </div>
</div>
</form>";
}