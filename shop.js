function showShopDetails(id) {
    //alert(id);
    var shop_name = id;
    window.open("http://localhost/Bills/shop_detail.php?shop_name=" + shop_name);
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

function countClick(){
    var count=0;
    var btn=document.getElementById("next");
    var display=document.getElementById("display");

    btn.onclick=function(){
        count++;
        display.innerHTML=count;
    }
}