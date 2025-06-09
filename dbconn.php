<?php 
class DatabaseConnection{
    private $host;
    private $user;
    private $pass;
    private $db;
    private $charset;
    public $dbconn;


    function __construct($host,$user,$pass,$db,$charset)
    {
        $this->host=$host;
        $this->user=$user;
        $this->$pass=$pass;
        $this->db=$db;
        $this->charset=$charset;
    }


    public function setDbconn( $dbconn): void {$this->dbconn = $dbconn;}

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

	public function setHost( $host): void {$this->host = $host;}

	public function setUser( $user): void {$this->user = $user;}

	public function setPass( $pass): void {$this->pass = $pass;}

	public function setDb( $db): void {$this->db = $db;}

	public function setCharset( $charset): void {$this->charset = $charset;}
	
    public function close_database(){
        mysqli_close($this->dbconn);
    }

	

}



?>