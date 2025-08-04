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
    <link rel="stylesheet" href="bills.css">
</head>
<body>
<div class="container text-center">
<div class="row">
    <div class="col">
    <div class="input-group flex-nowrap">
  <span class="input-group-text" id="addon-wrapping">Search</span>
  <input type="text" id="search" class="form-control" placeholder="Search" aria-label="Search" aria-describedby="addon-wrapping">
</div>
    </div>
  </div>
  <div class="row">
    <div class="col">
      <a href="shops.php?current_url=10&page_number=0" target="_blank" rel="noopener noreferrer" class="text-decoration-none text_primary">Back to list of shops</a>
      
    </div>
  </div>

<div class="row">
<div class="col">
    <?php 
include("functions.php");
if(isset($_GET['shop_name'])){
 print_shop_details($_GET['shop_name']);
}else{
  print_navigation();
}
?>
</div>
</div>
</div>
</body>
</html>