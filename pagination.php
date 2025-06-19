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
private $previous_page_num;
private $upper_limit;
private $down_limit;

public function __construct( $disable_previous,  $disable_next,  $previous_url,  $current_url,  $next_url,$page_number,$previous_page_num){$this->disable_previous = $disable_previous;$this->disable_next = $disable_next;$this->previous_url = $previous_url;$this->current_url = $current_url;$this->next_url = $next_url;$this->page_number=$page_number;$this->previous_page_num=$previous_page_num;}
	public function getDisablePrevious() {return $this->disable_previous;}

	public function getDisableNext() {return $this->disable_next;}

	public function getPreviousUrl() {return $this->previous_url;}

	public function getCurrentUrl() {return $this->current_url;}

	public function getNextUrl() {return $this->next_url;}

	public function setDisablePrevious( $disable_previous){$this->disable_previous = $disable_previous;}

	public function setDisableNext( $disable_next){$this->disable_next = $disable_next;}
    //decrement number of records of database
	public function setPreviousUrl( $previous_url){$this->previous_url = $previous_url-Pagination::LIMIT_PER_PAGE;}

	public function setCurrentUrl( $current_url){$this->current_url = $current_url;}
    //increment number of records of database
	public function setNextUrl( $next_url){$this->next_url = $next_url+Pagination::LIMIT_PER_PAGE;}

	public function getPageNumber() {return $this->page_number;}

	public function setPageNumber( $page_number){$this->page_number = $page_number+1;}

	public function setPreviousNumber( $previous_page_num){$this->previous_page_num = $previous_page_num-1;}

	public function getUpperLimit() {return $this->upper_limit;}

	public function getDownLimit() {return $this->down_limit;}

	public function setUpperLimit( $upper_limit){$this->upper_limit = $upper_limit;}

	public function setDownLimit() {return $this->down_limit;}

	public function getPreviousNumber() {return $this->previous_page_num;}
	
	//limit for pagination will count like this
	//if current url is equal to zero, down limit will be 1
	//query will return data from database between 1 and upper limit
	//in every other case, limit will be counted value of current url minus value from previous url plus 1
	//data will be from for example, if previous url is 10, then down limit will be 11
	public function countDownLimit(){
		$downLimit=0;
		if($this->getCurrentUrl()==0){
			$downLimit=0;
		}else{
			$downLimit=$this->getCurrentUrl()-Pagination::LIMIT_PER_PAGE;
		}
		return $downLimit;
	}
	
	

}



?>