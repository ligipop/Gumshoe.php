<?php
/*
Copyright 2017, Li George
www.liligi.com
MIT License
*/

namespace gumshoe;

final class Gumshoe{
	private $tableName;
	private $dbColNames = [];
	private $columnArray = [];
	private $searchArguments;
	private $stmt;
	private $arg;

	function __construct($tableName, $columnNames=NULL){
		$this->tableName = $tableName;
		if($columnNames !== NULL){
			if(is_array($columnNames)){
				$this->dbColNames = $columnNames;
				$this->columns($this->dbColNames);
			}else{
				throw new \Exception('Second argument must be an array!');
			}	
		}
	}

	final public function columns($columnNames){
		if(is_array($columnNames)){
			$this->dbColNames = $columnNames;
			foreach($this->dbColNames as $args){	
				$this->columnArray[$args] = [];
			}	
			return $this->columnArray;
		}else{
			throw new \Exception('Argument must be an array!');
		}	
	}

	final public function search($args){
		if(is_array($args)){
			$this->searchArguments = $args;
			foreach($this->columnArray as $columnName => $value){
				foreach($this->searchArguments as $searches){
					array_push($this->columnArray[$columnName], $searches);
				}		
			}

			$this->statementMaker($this->columnArray);
			return $this->columnArray;
		}else{
			throw new \Exception('Arguments must be an array!');
		}
		
	}

	final private function statementMaker($columnArray){
		foreach($columnArray as $columnName => $terms){
			foreach($terms as $searchTerms => $searchItems){
				$this->stmt .= $columnName." LIKE %".$searchItems."% OR ";
			}
		}
		
		$this->stmt = 'SELECT * FROM '.$this->tableName.' WHERE '.substr($this->stmt, 0, -3);
		$this->separator($this->stmt);
		return $this->stmt;
	}

	final private function separator($stmt){
		$extractArgs = preg_match_all('/%.*?%/',$this->stmt, $matches); 
		foreach($matches as $match){
			$this->arg = $match;
		} 

		$this->stmt = preg_replace('/%.*?%/',"?",$this->stmt);
	}

	final public function statement(){
		return $this->stmt;
	}

	final public function args(){
		return $this->arg;
	}
}
