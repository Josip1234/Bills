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
	

}



?>