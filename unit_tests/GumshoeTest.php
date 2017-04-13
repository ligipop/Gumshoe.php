<?php
namespace gumshoe\unit_tests;
include '../Gumshoe.php';

use gumshoe;

final class GumshoeTest{
	private $gumshoe;

	function __construct(){		
		$this->gumshoe = new gumshoe\Gumshoe('testTable',['column1','column2']);
	}

	public function testCorrectArgumentsOnGumshoeInitialization(){
		/* 	
		@param string
		@param array 
		//Should return 'true'
		*/
		$gumshoeInstance;
		if($gumshoeInstance = new gumshoe\Gumshoe('testTable',['blah'])){
			echo 'true';
		}
	}

	public function testIncorrectArgumentsOnGumshoeInitialization(){
		/* 
		@param string
		@param string
		//Should throw error: 2nd param must be array
		*/
		$gumshoeInstance = new gumshoe\Gumshoe('testTable','blah');
	}

	public function testIfColumnNamesAssignedToColumnArray(){
		/*
		@param array
		Should print column assoc. array with only column name arrays entered.
		//If no array argument, should throw error*/
		print_r($this->gumshoe->columns(['column1','column2']));

	}

	public function testIfEnteredSearchArgsAssignedToColumnArray(){
		/*
		@param array
		Should print column assoc. array with column name arrays and search values for each array
		//If no array argument, should throw error
		*/
		print_r($this->gumshoe->search(["something","to","search"]));		
	}

	public function testIfGumshoeFinalStatementAndArgsCreated(){
		$this->gumshoe->search(["items","to","search"]);
		 
		//@return String
		//Should echo final prepared statement string
		echo $this->gumshoe->statement();

		//@return array
		//should print array of items to apply to prepared statement
		print_r($this->gumshoe->args());
	}
}


$tester = new GumshoeTest();
//Test methods below:
