<?php 
include("dbconn.php");
class Shop{
    public $shop_name;

    function __construct($shop_name)
    {
        $this->shop_name=$shop_name;
    }

    function set_shop_name($shop_name){
        $this->shop_name=$shop_name;
    }

    function get_shop_name(){
        return $this->shop_name;
    }

    function __destruct()
    {
        $this->shop_name="";
       
    }
    
}


?>