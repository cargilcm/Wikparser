<?php
namespace ybourque\Wikparser;
use ybourque\WikParser\Wikparser;
use ybourque\WikParser\lib\WikiExtract;


//require dirname(__DIR__) . "/vendor/autoload.php";
$test = new Test();
$test->test2();

class Test{
	public function test2(){
		include '.\lib\WikiExtract.php';
		$languageParams = Array();
		$languageParams['langCode']='en';
		$languageParams['langHeader']='===';
		$languageParams['langSeparator']='=';
		$wikExtr = new WikiExtract($languageParams,'local');
		$parsed = $wikExtr->sqlFetchData('bon');
		var_dump($parsed);
	
		include 'Wikparser.php';
		$wik = new WikParser();
		$queries = ['def'];
		$parsed = $wik->getWordDefiniton('bon', $queries, 'fr');
		//$parsed = $wik->parseQuery('def',$parsed);
		var_dump($parsed);
	
	}
}
/*
requires a separate call for each element. modify to make one call and return
all parsed elements?
*/
