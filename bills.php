<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bills</title>
       <?php 
     include("css_js_includes.php");
     $styles=new Styles();
     echo $styles->getBootstrapInclude();
?>
<script src="bills.js"></script>
<script src="shop.js"></script>
</head>
<body>
    <div class="container text-center">
     <?php  
 include("functions.php");
print_search_form();
print_checkboxes();
print_navigation();
print_bill_numbers_without_pagination();
?>
    
        <div class="row">
        <div class="col">
          <p id="results"><?php
          
          if(isset($_COOKIE["result"])&&(isset($_COOKIE["search"]))){
            print_search_data_from_table($_COOKIE["result"],$_COOKIE["search"]);
            delete_cookies();

          }
?>
          </p>
        </div>
  </div>
      </div>
</body>
</html>