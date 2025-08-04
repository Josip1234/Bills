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

  <div class="row">
    <div class="col">
      <a href="index.php" target="_self" rel="noopener noreferrer" class="text-decoration-none text_primary">Back to main page</a>
      <a href="shops.php?current_url=10&page_number=0" target="_self" rel="noopener noreferrer" class="text-decoration-none text_primary">Show shops</a>
    </div>
  </div>

<div class="row">
<div class="col">
    <?php 
include("functions.php");
insert_new_shop();
?>
</div>
</div>
</div>
</body>
</html>

