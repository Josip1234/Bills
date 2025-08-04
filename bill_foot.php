<?php
class Bill_footer
{
    private $bill_number;
    private $date;
    private $ZKI;
    private $JIR;
    private $ref_number;
    private $other;
    private $barcode_image_url;
    private $shop_ssn;

    public function __construct($bill_number,  $date,  $ZKI,  $JIR,  $ref_number,  $other,  $barcode_image_url,  $shop_ssn)
    {
        $this->bill_number = $bill_number;
        $this->date = $date;
        $this->ZKI = $ZKI;
        $this->JIR = $JIR;
        $this->ref_number = $ref_number;
        $this->other = $other;
        $this->barcode_image_url = $barcode_image_url;
        $this->shop_ssn = $shop_ssn;
    }

    public function getBillNumber() {return $this->bill_number;}

	public function getDate() {return $this->date;}

	public function getZKI() {return $this->ZKI;}

	public function getJIR() {return $this->JIR;}

	public function getRefNumber() {return $this->ref_number;}

	public function getOther() {return $this->other;}

	public function getBarcodeImageUrl() {return $this->barcode_image_url;}

	public function getShopSsn() {return $this->shop_ssn;}

	public function setBillNumber( $bill_number): void {$this->bill_number = $bill_number;}

	public function setDate( $date): void {$this->date = $date;}

	public function setZKI( $ZKI): void {$this->ZKI = $ZKI;}

	public function setJIR( $JIR): void {$this->JIR = $JIR;}

	public function setRefNumber( $ref_number): void {$this->ref_number = $ref_number;}

	public function setOther( $other): void {$this->other = $other;}

	public function setBarcodeImageUrl( $barcode_image_url): void {$this->barcode_image_url = $barcode_image_url;}

	public function setShopSsn( $shop_ssn): void {$this->shop_ssn = $shop_ssn;}

	public function printBillNmber(){
        echo "<td>".$this->getBillNumber()."</td>";
    }
}
