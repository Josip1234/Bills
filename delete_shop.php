<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete shop</title>
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
            <?php 
             include("functions.php");
       
                delete_shop();
             
          
            ?>
        </div>
    </div>
</body>
</html>