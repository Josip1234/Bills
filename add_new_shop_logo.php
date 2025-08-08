<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bills- add new shop logo</title>
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
$sn=$_GET['shop_name'];
echo "<a href='shop_detail.php?shop_name=".$sn."' target='_blank' rel='noopener noreferrer'>Back to shop detail</a>";
print_shop_logo_form();
?>

    </div>
</body>
</html>