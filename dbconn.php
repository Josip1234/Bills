<?php 
class DatabaseConnection{
    private $host;
    private $user;
    private $pass;
    private $db;
    private $charset;
    public $dbconn;
    private $num_of_records;


    function __construct($host,$user,$pass,$db,$charset)
    {
        $this->host=$host;
        $this->user=$user;
        $this->$pass=$pass;
        $this->db=$db;
        $this->charset=$charset;
    }


    public function setDbconn( $dbconn) {$this->dbconn = $dbconn;}

    function connectToDatabase(){
           $dbconn=mysqli_connect($this->host,$this->user,$this->pass,$this->db);
           mysqli_set_charset($dbconn,$this->charset);
           $this->setDbconn($dbconn);
    }
    public function getHost() {return $this->host;}

	public function getUser() {return $this->user;}

	public function getPass() {return $this->pass;}

	public function getDb() {return $this->db;}

	public function getCharset() {return $this->charset;}

	public function getDbconn() {return $this->dbconn;}

	public function setHost( $host) {$this->host = $host;}

	public function setUser( $user) {$this->user = $user;}

	public function setPass( $pass) {$this->pass = $pass;}

	public function setDb( $db) {$this->db = $db;}

	public function setCharset( $charset) {$this->charset = $charset;}

    public function setNumOfRecords($num_of_records){
        $this->num_of_records=$num_of_records;
    }
    public function getNumOfRecords(){
        return $this->num_of_records;
    }
	
    public function close_database(){
        mysqli_close($this->dbconn);
    }

    public function get_num_of_records_from_table($table){
        $query="SELECT COUNT(*) FROM $table";
        $execute_query=mysqli_query($this->getDbconn(),$query);
        $result=$execute_query->fetch_column();
        $this->setNumOfRecords($result);
        return $this->num_of_records;
    }


        public function get_num_of_records_from_table_where_clause($table,$column,$comp_data){
        $query="SELECT COUNT(*) FROM $table WHERE $column = '$comp_data'";
        $execute_query=mysqli_query($this->getDbconn(),$query);
        $result=$execute_query->fetch_column();
        $this->setNumOfRecords($result);
        return $this->num_of_records;
    }

	
  public function getAllData($table,$values){
    $data=array();
    $sql = 'SELECT ';
     $index=1;
    foreach($values as $val){
        if($index==sizeof($values)){
             $sql .= $val."";
        }else{
            $sql .= $val.",";
        }
        $index++;
        
    }
    $sql .= " FROM ";
    $sql .= $table;
    $sql .= ";";

    
    $statement=mysqli_query($this->getDbconn(),$sql);
    while($res=mysqli_fetch_array($statement)){
        foreach ($values as $value) {
           $data[]=$res[$value];
        }
        
    }

   return $data;
  }


  //we have tried to make a template, 
  //problem to add preparing statement 
  //we will simplyfy function for inserting data 
  //for the specific table.
  public function insert_into_table($what_values,$table, $condition, $values,$generated_query){
    if($generated_query==""){
    if($table==CNST_VAL::FORM_SHOP_DET_NAME){
    $single_value="";
    $multi_value=array();
    $query="INSERT INTO ";
    $query .= "".$table." (";
    if(gettype($what_values)=="string"){
       $single_value=$what_values;
       $query .= "".$single_value.")";
    }else{
        $multi_value=$what_values;
        $index=1;
        foreach ($multi_value as $value) {
            if($index==sizeof($multi_value)){
                $query .= "".$value.")";
            }else{
                $query .= "".$value.",";
            }
           $index++;
        }
    }
     $query .= " VALUES (";

     $index=0;
     //remove extra elements from arrays
     //for example we have shop details we also have additional fields like id and shop name we need to remove this
     $array_slice=array_slice($values,1);
     $index=1;
    foreach ($array_slice as $val) {
        //echo $val; on this place we have found that email is missing 
              if($index==sizeof($array_slice)){
                  $query .= ""."?".")";
              }else{
 $query .= ""."?".",";
              }
             
        
              $index++;
    }
  //this is extra for now but will not remove it maybe it will be needed 
  //later on in development
    if(gettype($condition)=="string"){
        //do nothing if there is array
        //where clause must be in query
        //insert query ba preparing statement overhere
        //echo $query;
        //this will be updated later
    }else{
    $query.=" WHERE ";
    for($index=0;$index<sizeof($condition);$index++){
        if($index+1==sizeof($condition)) break;
        else{
            $query .= $condition[$index];
            $query .= "='";
            $query .= $condition[$index+1]."'";
        }
      
    }
    
}
   //now we are doing prepare statement binding
   $statement=$this->getDbconn()->prepare($query);
    //echo $query;
 
    $shop_name=$array_slice[0];
$address=$array_slice[1];
$ssn=$array_slice[2];
$shop_number=$array_slice[3];
$telephone=$array_slice[4];
$fax=$array_slice[5];
$email=$array_slice[6];
$hq_address=$array_slice[7];
$web_page=$array_slice[8];

   $statement->bind_param('sssssssss',$shop_name,$address,$ssn,$shop_number,$telephone,$fax,$email,$hq_address,$web_page);
  
   $statement->execute();
  }
}else{
    if($table==CNST_VAL::SHOP_LOGO_FORM_NAME){
        $statement=$this->getDbconn()->prepare($generated_query);
        $statement->execute();
    }
   
}
  }




  public function produce_query_string($table,$columns,$data,$operation_name,$where_clause,$what_column,$comp_data){
         $query_string="";
         if($operation_name==CNST_VAL::OPERATION_INSERT_LOGO){
               $query_string .= "INSERT INTO ";
               $query_string .= "$table";
               $query_string .= "(";
               $index=1;
               foreach ($columns as $value) {
                if($index==sizeof($columns)){
                   $query_string .= $value;
                }else{
                   $query_string .= $value.",";
                }
                $index++;
               }
                $query_string .= ") ";
                  $query_string .= "VALUES";
                  $query_string .= ("(");
                  $index=1;
                  foreach ($data as $value) {
                    if($index==sizeof($data)){
                         $query_string .= "'".$value."'";
                    }else{
                       $query_string .= "'".$value."',";
                    }
                    $index++;
                  }
                  $query_string .= ")";
         }else if($operation_name==CNST_VAL::OPERATION_UPDATE_LOGO){
            //UPDATE `articles` SET `serial_num` = '8n54KcU', `article_name` = 'VODA IZV JANA MEN L' WHERE `articles`.`id` = 1
                 $query_string .= "UPDATE ";
                 $query_string .= $table;
                 $query_string .= " SET ";

                 //for easy access, let's create assoc array, since both arrays are equal will save some operations
                 $ass_arr=array();
               
                 $ass_arr=$this->create_ass_array($columns,$data);
                 $index=1;
                 foreach ($ass_arr as $key => $value) {
                    if($index==sizeof($ass_arr)){
                         $query_string .= "".$key."='".$value."'";
                    }else{
$query_string .= "".$key."='".$value."',";
                    } 
                    
                    $index++;
                 }


         }
         if($where_clause=="yes"){
            //what column argument must be a string
            if(gettype($what_column)=="string"){
                 //same as comparison data
                 if(gettype($comp_data)=="string"){
                    $query_string .= " WHERE ";
                    $query_string .= $what_column;
                    $query_string .= "=";
                    $query_string .= "'".$comp_data."'";
                 }
            }
         }
         return $query_string;
  }

  //both needs to be array arguments
  public function create_ass_array($array1,$array2){
       $assoc_array=array();
       if((gettype($array1)=="array") && (gettype($array2)=="array")){
          
         $assoc_array=array_combine($array1,$array2);
            
       }else{
         echo "Wrong array type";
         $assoc_array ="";
       }
       return $assoc_array;
  }

 public function execute_query($query){
    $statement=$this->getDbconn()->prepare($query);
    $statement->execute();
 }



}

?>