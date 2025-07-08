<?php 
include("shop.php");

class ShopDetails extends Shop{
private $id;
 public $address;
 private $ssn;
 public $shop_number;
 public $telephone;
 public $fax;
 public $email;
 public $hq_address;
 public $web_page;

 function __construct($shop_name,$address,$ssn,$shop_number,$telephone,$fax,$email,$hq_address,$web_page)
 {
   
     $this->shop_name=$shop_name;
     $this->address=$address;
     $this->ssn=$ssn;
     $this->shop_number=$shop_number;
     $this->telephone=$telephone;
     $this->fax=$fax;
     $this->email=$email;
     $this->hq_address=$hq_address;
     $this->web_page=$web_page;
 }

 function __destruct()
    {
        $this->shop_name="";
        $this->address="";
        $this->ssn="";
        $this->shop_number="";
        $this->telephone="";
        $this->fax="";
        $this->email="";
        $this->hq_address="";
        $this->web_page="";
       
    }

public function getAddress() {return $this->address;}

	public function getSsn() {return $this->ssn;}

	public function getShopNumber() {return $this->shop_number;}

	public function getTelephone() {return $this->telephone;}

	public function getFax() {return $this->fax;}

	public function getEmail() {return $this->email;}

	public function getHqAddress() {return $this->hq_address;}

	public function getWebPage() {return $this->web_page;}

	public function setAddress( $address): void {$this->address = $address;}

	public function setSsn( $ssn): void {$this->ssn = $ssn;}

	public function setShopNumber( $shop_number): void {$this->shop_number = $shop_number;}

	public function setTelephone( $telephone): void {$this->telephone = $telephone;}

	public function setFax( $fax): void {$this->fax = $fax;}

	public function setEmail( $email): void {$this->email = $email;}

	public function setHqAddress( $hq_address): void {$this->hq_address = $hq_address;}

	public function setWebPage( $web_page): void {$this->web_page = $web_page;}

   public function getId() {return $this->id;}
	
public function setId( $id): void {$this->id = $id++;}

	public function print_table_data(){
        echo "<td>".$this->getId()."</td>";
		echo "<td>".$this->getAddress()."</td>";
        echo "<td>".$this->getSsn()."</td>";
        echo "<td>".$this->getShopNumber()."</td>";
        echo "<td>".$this->getTelephone()."</td>";
        echo "<td>".$this->getFax()."</td>";
        echo "<td>".$this->getEmail()."</td>";
        echo "<td>".$this->getHqAddress()."</td>";
        echo "<td>".$this->getWebPage()."</td>";
    }



}

?>
      
	