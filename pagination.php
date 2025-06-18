<?php 
class Pagination{
//on every page we will milit 10 records
const LIMIT_PER_PAGE=10;
//first we will need a flag variable to see if previous url does have any records
//user could be first time on the page, or pagination number can be less than zero
//this flag will be used to disable previous page, for example, to set disable class 
//same for the next url, if number of records in database has reached maximum disable class will be set and 
//button or url will be disabled
//current variable will not be disabled at any time.
//if number of records is less from 10, pagination could be disabled? need to decide what to to with it
private $disable_previous;
private $disable_next;
private $previous_url;
private $current_url;
private $next_url;
private $page_number;
private $dynamic_limit;

public function __construct( $disable_previous,  $disable_next,  $previous_url,  $current_url,  $next_url,$page_number){$this->disable_previous = $disable_previous;$this->disable_next = $disable_next;$this->previous_url = $previous_url;$this->current_url = $current_url;$this->next_url = $next_url;$this->page_number=$page_number;}
	public function getDisablePrevious() {return $this->disable_previous;}

	public function getDisableNext() {return $this->disable_next;}

	public function getPreviousUrl() {return $this->previous_url;}

	public function getCurrentUrl() {return $this->current_url;}

	public function getNextUrl() {return $this->next_url;}

	public function setDisablePrevious( $disable_previous): void {$this->disable_previous = $disable_previous;}

	public function setDisableNext( $disable_next): void {$this->disable_next = $disable_next;}
    //decrement number of records of database
	public function setPreviousUrl( $previous_url): void {$this->previous_url = $previous_url-Pagination::LIMIT_PER_PAGE;}

	public function setCurrentUrl( $current_url): void {$this->current_url = $current_url;}
    //increment number of records of database
	public function setNextUrl( $next_url): void {$this->next_url = $next_url+Pagination::LIMIT_PER_PAGE;}

	public function getPageNumber() {return $this->page_number;}

	public function setPageNumber( $page_number): void {$this->page_number = $page_number;}

	public function getDynamicLimit() {return $this->dynamic_limit;}

	public function setDynamicLimit( $dynamic_limit): void {$this->dynamic_limit = $dynamic_limit;}

	
	
	

}



?>