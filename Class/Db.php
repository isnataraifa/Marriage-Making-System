<?php 
date_default_timezone_set("Asia/Dhaka");
class Db{
	private $con;
	public function __construct($dsn, $u, $p){
		try{
			$this->con=new PDO($dsn, $u, $p);
		}catch(PDOException $e){
			echo "Conection Fail! ".$e->getmessage();
		}
	}
	public function getCon(){
		return $this->con;
	}
}
$zend42Con=new Db("mysql:dbname=ifa;host=127.0.0.1", "root", "");
?>