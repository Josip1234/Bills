function showShopDetails(id){
    //alert(id);
    var shop_name=id;
    window.open("http://localhost/Bills/shop_detail.php?shop_name="+shop_name);
}
function set_url_value(value){
    //get current url location
    var loc=window.location;
    //set temp variable do not change original location yet
    var temp=loc.toString();
    //replace single digit
    var location=temp.replace(/[0-9]/g,"");
    //append next value
    var append=location+value;
    //now replace original url with append variable which contains next value
    window.location=append;
  
}