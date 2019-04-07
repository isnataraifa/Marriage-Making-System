<?php
require_once('Db.php');
class Crud{
	public $con;
	public function __construct($con){
		$this->con = $con;
	}
	public function insert($table,$request){
		$set=""; $i=0;
		$totalCol=count($request);
		foreach ($request as $key => $value) {
			$i++;
			if($totalCol!=$i){
				$set.=$key."=?,";
			}else{
				$set.=$key."=?";
			}
		}
		$i=0;
		$pdoStmt=$this->con->prepare("INSERT INTO $table SET $set");
		foreach ($request as $key => $value) {
			// $pdoStmt->bindParam(++$i, $value);
			$pdoStmt->bindParam(++$i, $request[$key]);
		}
		return $pdoStmt->execute();
	}
	public function upload($_files){
		// print_r($_files);
		// return;
		$timeStamp=time().".jpg";
		$target_file = "asset/images/" . $timeStamp;
		if (move_uploaded_file($_files["photo"]["tmp_name"], $target_file)){
			return $timeStamp;
		}
	}
	public function selectWhere($table,$request){
		$conditions=""; $i=0;
		$totalCol=count($request);
		foreach ($request as $key => $value) {
			$i++;
			if($totalCol!=$i){
				$conditions.=$key."=? AND ";
			}else{
				$conditions.=$key."=?";
			}
		}
		$pdoStmt=$this->con->prepare("SELECT * FROM $table WHERE $conditions");
		$i=0;
		foreach ($request as $key => $value) {
			$pdoStmt->bindParam(++$i, $request[$key]);
		}
		$pdoStmt->execute();
		return $pdoStmt->fetchAll(PDO::FETCH_ASSOC);
	}
	public function selectAll($table,$cols,$limit=""){
		$pdoStmt=$this->con->prepare("SELECT $cols FROM $table $limit");
		$pdoStmt->execute();
		return $pdoStmt->fetchAll(PDO::FETCH_ASSOC);
	}
	public function update($table,$id,$request){
		$set=""; $i=0;
		$totalCol=count($request);
		foreach ($request as $key => $value) {
			$i++;
			if($totalCol!=$i){
				$set.=$key."=?,";
			}else{
				$set.=$key."=?";
			}
		}
		echo $set;
		$i=0;
		$pdoStmt=$this->con->prepare("UPDATE $table SET $set WHERE id=?");
		foreach ($request as $key => $value) {
			$pdoStmt->bindParam(++$i, $request[$key]);
		}
		$pdoStmt->bindParam(++$i, $id);
		return $pdoStmt->execute();
	}
	public function delete($table,$id){
		$pdoStmt=$this->con->prepare("DELETE FROM $table WHERE id=?");
		$pdoStmt->bindParam(1, $id);
		return $pdoStmt->execute();
	}
}
?>