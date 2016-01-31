<?php


	//isset() determines if var is set and not null
	if(isset($argv))
		$var = $argv[1];
	
	// check for an empty string and display a message.
	if(isset($_GET['q']))
		$var = trim($_GET['q']); //trim whitespace from the stored variable

	if(isset($var))
		$trimmed = trim($var); //trim whitespace from the stored variable
	else
		$trimmed = " ";
	$trimmed = lowercase($trimmed);//'accueillir';
	

	function lowercase($word){
		return strtolower($word);
	}
	
	function sql_query($word){
		$params = '?q='.$word;
		$ch = curl_init('https://frwiktionary-cargilcm-1.c9users.io/Wikparser/lib/browsertest/mysqltest.php'.$params);		
		
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		$data = curl_exec($ch);
		curl_close($ch);
		return $data;
	}
	
	function curlWebApi($word){
		$params = '?action=parse&prop=wikitext&page='.$word.'&format=xml';
		$langCode = 'fr';
		$time_start = microtime(true);		
		$ch = curl_init('http://'.$langCode.'.wiktionary.org/w/api.php'.$params);curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		$data = curl_exec($ch);
		curl_close($ch);
		return $data;
	}
	echo "<Table border=1><TR><td>";
	echo $trimmed ."="; // trimmed = STDIN or query parameter
	$time_start = microtime(true);		
	echo sql_query($trimmed) . "</td>";
	$time_end = microtime(true);
	$time = $time_end - $time_start;
	echo '<td>time to translate via mysql: ' . $time; //<span style=';
	//echo 'position:absolute;left:220px;>' . $time;
	echo ' sec.</span></td></tr>';
	
		

	
	$data=curlWebApi($trimmed);
	$genderPattern = "(\{\{([mf]|mf)\??\}\})"; // {{m}}
	$posPattern = "(\{\{\S\|[\d\w\s]+\|fr(\|num=[0-9])?\}\})";  // {{S|nom|fr}}
	$tradPattern = "(trad\+\|en\|([A-z]*))";//(\{\{([trad+|en|])\??\}\})"; //   {{trad+|en|Tuesday}}  
//	$gen = preg_match($genderPattern,$text,$matchesGen);
//	$pos = preg_match($posPattern,$text,$matchesPos);
	$trad = preg_match($tradPattern,$data,$matchesTrad);
	$time_end = microtime(true);
	$time = $time_end - $time_start;
	echo "<tr><td>$trimmed=".$matchesTrad[1]."</td>";
	echo "<td>time to translate via curl:" . $time . " sec.</td></tr>";
	
	
	?>