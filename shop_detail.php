<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insert new shop</title>
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.min.js" integrity="sha384-RuyvpeZCxMJCqVUGFI0Do1mQrods/hhxYlcVfGPOfQtPJh0JCw12tUAZ/Mv10S7D" crossorigin="anonymous"></script>
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