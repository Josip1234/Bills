<?php 

class Shop_Logo extends Shop{
    public $logo1_url;
    public $logo2_url;

    public function __construct($shop_name ,$logo1_url,  $logo2_url){
        $this->shop_name=$shop_name;
        $this->logo1_url = $logo1_url;
        $this->logo2_url = $logo2_url;}
	public function getLogo1Url() {return $this->logo1_url;}

	public function getLogo2Url() {return $this->logo2_url;}
public function setLogo1Url( $logo1_url): void {$this->logo1_url = $logo1_url;}

	public function setLogo2Url( $logo2_url): void {$this->logo2_url = $logo2_url;}

	function print_logo(){
       $sn=$this->get_shop_name(); 
        echo "<td><img src='".$this->getLogo1Url()."' alt='".$sn."' class='logo'></td>";
        //ako je logo prazan nemoj nipta ispisivati
        if($this->getLogo2Url()==''){

        }else{
            echo "<td><img src='".$this->getLogo2Url()."' alt='".$sn."' class='logo'></td>";
        }
        
    }
	
}


?>