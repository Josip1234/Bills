<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bills</title>
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.min.js" integrity="sha384-RuyvpeZCxMJCqVUGFI0Do1mQrods/hhxYlcVfGPOfQtPJh0JCw12tUAZ/Mv10S7D" crossorigin="anonymous"></script>
<script src="shop.js"></script>
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
      <a href="bills.php?current_url=10&page_number=0" target="_self" rel="noopener noreferrer" class="btn btn-link">Bills</a>
      
    </div>
    <div class="col">
      <a href="update_bill.php" target="_self" rel="noopener noreferrer" class="btn btn-link disabled"> Update bill</a>
     
    </div>
    <div class="col">
      <a href="delete_bills.php" target="_self" rel="noopener noreferrer" class="btn btn-link disabled">Delete bills</a>
      
    </div>
    <div class="row">
        <div class="col">
                 <a href="new_products.php" target="_self" rel="noopener noreferrer" class="btn btn-link disabled">Insert new products</a>
        </div>
    </div>
    <div class="row">
          <div class="col">
                  <a href="shops.php?current_url=10&page_number=0" target="_self" rel="noopener noreferrer" class="text-decoration-none text_primary">Shops</a>
          </div>
    </div>
    <div class="row">
      <div class="col">
           <a href="insert_new_type_of_bill.php" target="_self" rel="noopener noreferrer" class="btn btn-link disabled">Insert new type of bill</a>
      </div>

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
</div>
</body>
</html>