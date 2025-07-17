<?php
include("shop_details.php");
include("validation_message.php");
include("pagination.php");
include("cnst_vals.php");

$connection = new DatabaseConnection("localhost", "root", "", "bills", "utf8");
$pagination = new Pagination("yes", "yes", 0, 0, 0, 0, 0);
$op = '"read"';
$op2 = '"update"';
$op3 = '"delete"';
$read_shops = '"shop"';
$create_form = '"New Shop Detail form"';

//function to print all shops from database
function print_all_available_shops()
{
  if (isset($_GET['current_url']) && isset($_GET['page_number'])) {
    global $pagination;
    global $connection;
    global $op;
    global $op2;
    global $op3;
    global $read_shops;

    $connection->connectToDatabase();
    //get number of records from database
    $record = $connection->get_num_of_records_from_table("shop");
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
    $sql = "SELECT shop_name FROM shop LIMIT ?,?";
    $stat = $connection->getDbconn()->prepare($sql);
    $stat->bind_param("ii", $downlimit, $uplimit);
    $stat->execute();
    $result = $stat->get_result();
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
      echo "<td><button id='" . $shop->get_shop_name() . "' type='button' class='btn btn-light' onclick='CRUDoperations(this.id," . $op . "," . $read_shops . ")'>Detalji</button><button id='" . $shop->get_shop_name() . "' type='button' class='btn btn-light' onclick='CRUDoperations(this.id," . $op2 . "," . $read_shops . ")'>Ažuriraj</button><button id='" . $shop->get_shop_name() . "' type='button' class='btn btn-light' onclick='CRUDoperations(this.id," . $op3 . "," . $read_shops . ")'>Izbriši</button></td>";
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
      echo "<td><button id='previous' type='button' class='btn btn-light' onclick='set_url_value(" . $pagination->getPreviousUrl() . "," . $pagination->getPreviousNumber() . ")'>Previous</button></td>";
    }
    echo "<td id='display'>" . $pagination->getPageNumber() . "</td>";
    //we need to query from database how much records does it have to check if current url is greather than maximal data 
    //check will be like as previous to disable next if there is no data anymore available
    if ($pagination->getCurrentUrl() > $record) {
      echo "<td><button id='next' type='button' class='btn btn-light disabled' aria-disabled='true'>Next</button></td>";
    } else {
      echo "<td><button id='next' type='button' class='btn btn-light'  onclick='set_url_value(" . $pagination->getNextUrl() . "," . $pagination->getPageNumber() . ")'>Next</button></td>";
    }
    echo "</tr>";
    echo "</tfoot>";
    echo "</table>";
    $connection->close_database();
  } else {
    print_navigation();
  }
}
function print_shop_details($shop_name)
{
  if (isset($_GET['shop_name'])) {
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
      $details = new ShopDetails($id, $shop_name, $res['address'], $res['ssn'], $res['shop_number'], $res['telephone'], $res['fax'], $res['email'], $res['hq_address'], $res['web_page']);
      $details->print_table_data();
      //kreiraj objekt shop logo i dohvati i ispiši logotipove
      while ($res2 = mysqli_fetch_array($exe_q)) {

        $logo = new Shop_Logo($shop_name, $res2['logo1_url'], $res2['logo2_url']);
        $logo->print_logo();
      }

      echo "</tr>";
      $details->setId($id);
    }
    echo "</tbody>";
    echo "</table>";
    if (isset($_POST['innsd'])) {
      print_details_form();
    }
    echo "<p><form method='post'><button class='btn btn-light' name='innsd'>Unos novog detalja</button></form>";
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      process_form(CNST_VAL::FORM_SHOP_DET_NAME, CNST_VAL::INSERT_NEW_SHOP_DET_OPERATION);
    }

    $connection->close_database();
  } else {
    print_navigation();
  }
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
  process_form(CNST_VAL::FORM_SHOP_NAME, CNST_VAL::INSERT_SHOP_OPERATION);
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
      die(Validation::INVALID);
      $passed = 0;
    }
  } else if ($what_data_to_validate == CNST_VAL::FORM_SHOP_DET_NAME) {
     $passed = 0;
    $vals=array("address", "ssn", "shop_number");
    $cleaned_data=array();
     //get all the data from sql database
     //need only three valuse ssn, address and shop_number
     $sql_data=$connection->getAllData("shop_detail",$vals);
     $cleaned_data=clean_data($sql_data);
     foreach ($cleaned_data as $value) {
       foreach ($data as $val) {
         if($value==$val){
          $passed=0;
          break;
         }else if($value!=$val){
          $passed=1;
         }
       }
     }
                
  }
                                       
  return $passed;
}





function print_search_data_from_table($what_data, $what_table)
{
  global $op;
  global $op2;
  global $op3;
  global $read_shops;

  $data = array();
  $cleaned_data = "";
  global $connection;
  $connection->connectToDatabase();

  if ($what_table == "shop") {
    $data[] = $what_data;
    $data = clean_data($data);
    $cleaned_data = $data[0] . "%";
    //select everything which is starting from input value
    $sql = "SELECT * FROM $what_table WHERE shop_name LIKE ?";
    $stat = $connection->getDbconn()->prepare($sql);
    $stat->bind_param("s", $cleaned_data);
    $stat->execute();
    $result = $stat->get_result();
    echo "<h2>Rezultati pretraživanja</h2>";
    echo "<table class='table table-striped'>";
    echo "<thead><tr><th scope='col'>Naziv trgovine</th><th>#</th></tr></thead>";
    echo "<tbody>";
    while ($res = mysqli_fetch_array($result)) {
      echo "<tr>";
      $shop = new Shop($res['shop_name']);
      echo "<td id='" . $shop->get_shop_name() . "'>" . $shop->get_shop_name() . "</td>";
      echo "<td><button id='" . $shop->get_shop_name() . "' type='button' class='btn btn-light' onclick='CRUDoperations(this.id," . $op . "," . $read_shops . ")'>Detalji</button><button id='" . $shop->get_shop_name() . "' type='button' class='btn btn-light' onclick='CRUDoperations(this.id," . $op2 . "," . $read_shops . ")'>Ažuriraj</button><button id='" . $shop->get_shop_name() . "' type='button' class='btn btn-light' onclick='CRUDoperations(this.id," . $op3 . "," . $read_shops . ")'>Izbriši</button></td>";

      echo "</tr>";
    }
    echo "<tbody>";
    echo "</table>";
    $connection->close_database();
  } else if ($what_table == "bill_footer") {
    delete_cookies();
  } else {
    $connection->close_database();
  }
}
function print_search_form()
{
  echo "<div class='row'>";
  echo  "<div class='col'>";
  echo  "<div class='input-group flex-nowrap'>";
  echo "<span class='input-group-text' id='addon-wrapping'>Search</span>";
  echo "<input type='text' id='search' class='form-control' placeholder='Search' aria-label='Search' aria-describedby='addon-wrapping' onchange='search_values()' disabled>";
  echo "</div>";
  echo "</div>";
  echo "</div>";
}

function delete_cookies()
{
  $_COOKIE["result"];
  setcookie("result", "", time() - 3600);
  $_COOKIE["search"];
  setcookie("result", "", time() - 3600);
}

function print_checkboxes()
{
  echo "<div class='row'>";
  echo " <div class='col'>";
  echo "<div class='form-check form-check-inline'>";
  echo "<input class='form-check-input' type='radio' name='shop' id='shop' value='shop' onclick='enable_search_engine(this.id)'>";
  echo "<label class='form-check-label' for='shop'>Search shops</label>";
  echo "</div>";
  echo "<div class='form-check form-check-inline'>";
  echo "<input class='form-check-input' type='radio' name='bill_footer' id='bill_footer' value='bill_footer' onclick='enable_search_engine(this.id)'>";
  echo "<label class='form-check-label' for='bill_footer'>Search bills</label>";
  echo "</div>";
  echo "</div>";
  echo "</div>";
}

function update_shop_name()
{
  $shop2 = new Shop("");
  if (isset($_GET["shop_name"])) {
    $shop2->set_shop_name($_GET["shop_name"]);
  }
  echo "<form action='" . htmlspecialchars($_SERVER["PHP_SELF"]) . "' method='post'>
  <div class='input-group mb-3'> 
  <input type='text' class='form-control border border-primary' aria-label='Default' aria-describedby='inputGroup-sizing-default' name='shop_name' id='shop_name' autocomplete='off' size='50' maxlength='255' value='" . $shop2->get_shop_name() . "' placeholder='Update shop name' required>
  <input type='hidden' name='previous_shop' value='" . $shop2->get_shop_name() . "'>
    <div class='input-group-append'>
     <input type='submit' value='Ažuriraj naziv trgovine' class='btn btn-light' id='ns'>
  </div>
</div>
</form>";
  process_form(CNST_VAL::FORM_SHOP_NAME, CNST_VAL::UPDATE_SHOP_OPERATION);
}

function process_form($form_name, $operation)
{
  global $connection;
  $connection->connectToDatabase();
  //if form name is shop

  if ($form_name == CNST_VAL::FORM_SHOP_NAME) {
    if ($operation == CNST_VAL::DELETE_SHOP) {
      if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $previous_shop = new Shop($_POST['previous_shop']);
        $query = "DELETE FROM shop WHERE shop_name=?";
        $stat = $connection->getDbconn()->prepare($query);
        $get_shop_name = $previous_shop->get_shop_name();
        $stat->bind_param("s", $get_shop_name);
        if ($stat->execute()) {
          echo CNST_VAL::DELETION_SUCCESSFULL;
          print_navigation();
          $stat->close();
        } else {
          echo CNST_VAL::DELETION_FAIL;
          $stat->close();
        }
      }
    } else {
      if ($_SERVER["REQUEST_METHOD"] == "POST") {

        if (empty($_POST['shop_name'])) {
          echo Validation::EMPTY_RECORD;
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
            //this part will be reusable for shops if operation name is insert new shop then insert new shop 
            //prepare statement and close database.
            if ($operation == CNST_VAL::INSERT_SHOP_OPERATION) {
              $statement = $connection->getDbconn()->prepare("INSERT INTO shop (shop_name) VALUES (?)");
              $statement->bind_param('s', $sn);
              //$statement->execute(); we have an error duplicate entry
              if ($statement->execute()) {
                echo Validation::SUCCESSFULL_INSERT;
                $connection->close_database();
              } else {
                echo Validation::INSERT_FAILED;
                $connection->close_database();
              }
              $statement->close();
            } else if ($operation == CNST_VAL::UPDATE_SHOP_OPERATION) {
              $ps = $_POST['previous_shop'];
              //get shop name from url
              //that shop is being updated
              $query = "UPDATE shop SET shop_name=? WHERE shop_name=?";
              $statement = $connection->getDbconn()->prepare($query);
              $shop_n = $shop->get_shop_name();
              $statement->bind_param('ss', $shop_n, $ps);
              if ($statement->execute()) {
                echo VALIDATION::SUCCESS_UPDATE;
                $statement->close();
              } else {
                echo Validation::UPDATE_FAIL;
                $statement->close();
              }
            }
          } else if ($validation == 0) {
            echo Validation::SHOP_ALREADY_EXISTS;
            $connection->close_database();
          } else {
            echo Validation::INVALID;
          }
        }
      }
    }
  } else if ($form_name == CNST_VAL::FORM_SHOP_DET_NAME) {
    if ($operation == CNST_VAL::INSERT_NEW_SHOP_DET_OPERATION) {
      //if server request is post and has input hidden field value sent because of button unos novog detalja
      if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['insert_detail'])) {
        if (empty($_GET['shop_name']) || empty($_POST['address']) || empty($_POST['ssn']) || empty($_POST['shop_number']) || empty($_POST['telephone'])) {
          echo Validation::EMPTY_RECORD;
        } else {
          $shop_detail = new ShopDetails("", $_GET['shop_name'], $_POST['address'], $_POST['ssn'], $_POST['shop_number'], $_POST['telephone'], $_POST['fax'], $_POST['email'], $_POST['hq_address'], $_POST['web_page']);
          //clean data
          $shop_detail_array=array();
          $shop_detail_array[]=$shop_detail->getId();
          $shop_detail_array[]=$shop_detail->get_shop_name(); 
          $shop_detail_array[]=$shop_detail->getAddress(); 
          $shop_detail_array[]=$shop_detail->getSsn();
          $shop_detail_array[]=$shop_detail->getShopNumber();
          $shop_detail_array[]=$shop_detail->getTelephone();
          $shop_detail_array[]=$shop_detail->getFax(); 
          $shop_detail_array[]=$shop_detail->getHqAddress();
          $shop_detail_array[]=$shop_detail->getWebPage();
          $shop_detail_array=clean_data($shop_detail_array);
          //successfully cleaned data
          //need to validate all unique values data
          $validation=validate_data(CNST_VAL::FORM_SHOP_DET_NAME,$shop_detail_array);
          //if validation has passed record can be inserted
          if($validation==1){
               echo "Now we can insert new data.";
          }else{
            echo Validation::FAILED_VALIDATION;
          }
        }
      }
    }
  }
}

function delete_shop()
{
  //if there is any value in url from get 
  //else print navigation for user to get back to hompage or index
  if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $shop2 = new Shop($_GET['shop_name']);
    echo "<h2>" . CNST_VAL::RECORD_DELETION . "</h2>";
    echo "<form action='" . htmlspecialchars($_SERVER["PHP_SELF"]) . "' method='post'>
  <div class='input-group mb-3'> 
    <input type='hidden' name='previous_shop' value='" . $shop2->get_shop_name() . "'>
    <div class='input-group-append'>
     <input type='submit' value='Izbriši zapis' class='btn btn-light' id='ns'>
  </div>
</div>
</form>";
  } else if ($_SERVER["REQUEST_METHOD"] == "POST") {
    process_form(CNST_VAL::FORM_SHOP_NAME, CNST_VAL::DELETE_SHOP);
  } else {
    print_navigation();
  }
}

function print_navigation()
{
  echo "<div class='row'>
    <div class='col'>
      <a href='index.php' target='_self' rel='noopener noreferrer' class='btn btn-link text-decoration-none text_primary'>Homepage</a>
    </div>
    <div class='col'>
      <a href='shops.php?current_url=10&page_number=0' target='_self' rel='noopener noreferrer' class='btn btn-link text-decoration-none text_primary'>Shops</a>
    </div>
    <div class='col'>
      <a href='bills.php?current_url=10&amp;page_number=0' target='_self' rel='noopener noreferrer' class='btn btn-link text-decoration-none text_primary'>Bills</a>
    </div>
 </div>";
}
function print_details_form()
{
  $self = $_SERVER['PHP_SELF'];
  if (isset($_GET['shop_name'])) {
    $self .= "?shop_name=";
    $self .= $_GET['shop_name'];
  }
  echo "   <form action='" . htmlspecialchars($self) . "' method='post'>
  <div class='row'>
    <div class='col'>
    <input type='text' class='form-control' id='address' name='address' placeholder='Adresa'>
    </div>
  <div class='col'>
    <input type='text' class='form-control' id='ssn' name='ssn' placeholder='Oib'>
  </div>
    <div class='col'>
    <input type='text' class='form-control' id='shop_number' name='shop_number' placeholder='Broj trgovine'>
  </div>
   <div class='col'>
    <input type='text' class='form-control' id='telephone' name='telephone' placeholder='Telefon'>
  </div>
 <div class='col'>
    <input type='text' class='form-control' id='fax' name='fax' placeholder='Fax'>
  </div>
 <div class='col'>
    <input type='email' class='form-control' id='email' name='email' aria-describedby='email' placeholder='Email'>
  </div>
   <div class='col'>
    <input type='text' class='form-control' id='hq_address' name='hq_address' placeholder='Adresa sjedišta'>
  </div>
  <div class='col'>
    <input type='text' class='form-control' id='web_page' name='web_page' placeholder='Web adresa'>
  </div>
  <input type='hidden' name='insert_detail' value='insert_new_detail'>
    <div class='col'>
  <button type='submit' class='btn btn-light'>Pošalji unos</button>
  </div>
</form></div>";
}
