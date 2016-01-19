<?php
namespace ybourque\Wikparser;
use ybourque\WikParser\Wikparser;


//require dirname(__DIR__) . "/vendor/autoload.php";
$test = new Test();
$test->test2();

class Test{
	public function test2(){
		echo 'hello';
		include '..\..\ybourque\WikParser\Wikparser.php';
		$wik = new WikParser();
		$queries = ['def', 'pos', 'syn', 'hyper', 'gender'];
		$parsed = $wik->getWordDefiniton('bon', $queries, 'fr');
		var_dump($parsed);
	}
}
/*
requires a separate call for each element. modify to make one call and return
all parsed elements?
*/
