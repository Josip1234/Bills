<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insert new shop</title>
       <?php 
     include("css_js_includes.php");
     $styles=new Styles();
     echo $styles->getBootstrapInclude();
?>
    <script src="shop.js"></script>
    <link rel="stylesheet" href="shop.css">
</head>
<body>
<div class="container text-center">
   <?php 
 include("functions.php");
print_search_form();
print_checkboxes();
?>
  <div class="row">
    <div class="col">
      <a href="index.php" target="_self" rel="noopener noreferrer" class="text-decoration-none text_primary">Back to main page</a>
      <a href="insert_new_shop.php" target="_blank" rel="noopener noreferrer" class="text-decoration-none text_primary">Add new shop</a>
    </div>
  </div>
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

<div class="row">
<div class="col">
    <?php 

print_all_available_shops();
?>
</div>
</div>
</div>
</body>
</html>

