<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bill details</title>
       <?php 
     include("css_js_includes.php");
     $styles=new Styles();
     echo $styles->getBootstrapInclude();
?>
<script src="shop.js"></script>
<link rel="stylesheet" href="bills.css">
</head>
<body>
  <div class="container text-center">
    <?php 
 include("functions.php");
 print_search_form();
 print_checkboxes();
 print_navigation();
 

?>
<div class="row">
    <div class="col">
         <?php 
           print_bill_details();
         ?>
    </div>
</div>
  </div>
</body>
</html>