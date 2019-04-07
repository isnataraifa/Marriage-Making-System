<?php 
require_once('Crud.php');
class TableView extends Crud{
	private $table;
	private $isSetPaginate=false;
	private $dbTable,$col,$limit,$perPage,$pageNumber;
	public function getTable($dbTable,$col){
		$this->dbTable=$dbTable;
		$this->col=$col;
		return $this;
	}
	public function generateTable($array,$css_classes=""){
		if(count($array)==count($array,1)){
			$this->table="<table class=\"$css_classes\">";
				foreach($array as $key => $val){
					$this->table.="<tr>";
					
					$this->table.="<th>".ucfirst($key)."</th><td> $val</td>";
						
					$this->table.="</tr>";
				}
			$this->table.="</table>";
		}
		else{
			$this->table="<table class=\"$css_classes\">";
			$this->table.="<tr>";
				foreach($array[0] as $key => $val){
					$this->table.="<th>".ucfirst($key)."</th>";
				}
				$this->table.="</tr>";
				
				foreach($array as $rows){
					$this->table.="<tr>";
						foreach($rows as $cols){
							$this->table.="<td>".ucfirst($cols)."</td>";
						}						
					$this->table.="</tr>";
				}
			$this->table.="</table>";
		}
	}
	/*End getTable()*/
	public function generatePagination(){
		$pdoStmt=$this->con->prepare("SELECT * FROM ".$this->dbTable);
		$pdoStmt->execute();
		$total_row=$pdoStmt->rowCount();
		$total_page=ceil($total_row/$this->perPage);
		$this->table.="<nav aria-label='...'>
			<ul class='pagination'><li><label>PAGE : </label></li>";
			for($i=1;$i<=$total_page;$i++){
				$this->table.="<li class='page-item'><a class='page-link' href='?page=".$i."'>".$i."</a></li>";
			}
			$this->table.="</ul>
		</nav>";
	}
	public function paginate($perPage,$pageNumber=1){
		$this->isSetPaginate=true;
		$this->perPage=$perPage;
		$this->pageNumber=$pageNumber-1;
		$offset=$perPage*$this->pageNumber;
		$this->limit="LIMIT {$this->perPage} OFFSET {$offset}";
		return $this;
	}
	public function show(){
		/*print_r($this->selectAll($this->dbTable,$this->col,$this->limit));
		return;*/
		if($this->isSetPaginate){
			$this->generateTable($this->selectAll($this->dbTable,$this->col,$this->limit));
			$this->generatePagination();
		}else{
			$this->generateTable($this->selectAll($this->dbTable,$this->col));
		}
		return $this->table;
	}
}
?>