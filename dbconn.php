<?php 
class DatabaseConnection{
    private $host;
    private $user;
    private $pass;
    private $db;
    private $charset;


    function __construct($host,$user,$pass,$db,$charset)
    {
        $this->host=$host;
        $this->user=$user;
        $this->$pass=$pass;
        $this->db=$db;
        $this->charset=$charset;
    }


    function connectToDatabase(){
           $dbconn=mysqli_connect($this->host,$this->user,$this->pass,$this->db);
           mysqli_set_charset($dbconn,$this->charset);
           return $dbconn;
    }

}



?>