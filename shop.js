
function CRUDoperations(name,operation,table){
//operations can be create, update read and delete
//alert("Read data from this table: "+table);
//alert("Read values from this shop: "+shop_name);
//alert("Operation of CRUD is: "+operation);
var shop_name = name;
if(table=="shop"){
if(operation=="read"){
       window.open("http://localhost/Bills/shop_detail.php?shop_name=" + shop_name);
    }else if(operation=="update"){
        window.open("http://localhost/Bills/update_shop.php?shop_name=" + shop_name);
    }else if(operation=="delete"){
           window.open("http://localhost/Bills/delete_shop.php?shop_name=" + shop_name);
    }
}
}

function set_url_value(value,page_num) {
    //get current url location
    var loc = window.location;
    //set temp variable do not change original location yet
    var temp = loc.toString();
  
    //remove until page number in php is implemented correct
    var tmp2 = temp.replace(/\Spage_number=\d/g, "");
    //replace single digit
    var location = tmp2.replace(/[0-9]/g, "");
    //append next value
    var append = location + value;
    //now replace original url with append variable which contains next value
    var temp3=temp.replace(/.*\d\d/g,"");
    //should left this value &page_number=1
    //replace 1 with new value number
    var temp4=temp3.replace(/\S\d\d?/g,"="+page_num);
    //add to append
    append=append+temp4;
    //add append as new url
    window.location = append;

}
//need to fix if one checkbox is selected other must be disabled
function search_values(){
    var val=document.getElementById("search").value;
    var radio1=document.getElementById("shop");
    var radio2=document.getElementById("bill_footer");
    var table_to_search="";

    if(radio1.checked==true){
         table_to_search="shop";
    }else if(radio2.checked==true){
        table_to_search="bill_footer";
    }
    if(table_to_search=="shop"){
    var cookie2="search="+table_to_search;
    var cookie="result="+val;
    document.cookie=cookie;
    document.cookie=cookie2;
    $result=val;
    location.reload();
    }else if($table_to_search=="bill_footer"){
    var cookie2="search="+table_to_search;
    var cookie="result="+val;
    document.cookie=cookie;
    document.cookie=cookie2;
    $result=val;
    location.reload();
    }  

    //document.getElementById("results").innerHTML='<p id="results"></p>';
}

function enable_search_engine($what_table_to_search){
    if($what_table_to_search=="shop"){
          changeCheckedValuesToFalse("bill_footer");
          changeCheckedValuesToTrue("shop");
          document.getElementById("search").disabled=false;
       
    }else if($what_table_to_search=="bill_footer"){
          changeCheckedValuesToFalse("shop");
          changeCheckedValuesToTrue("bill_footer");
           document.getElementById("search").disabled=false;
    }
}

  function changeCheckedValuesToTrue(id){
     var radio=document.getElementById(id);
     radio.checked=true;
  }

    function changeCheckedValuesToFalse(id){
      var radio=document.getElementById(id);
     radio.checked=false;
  }

