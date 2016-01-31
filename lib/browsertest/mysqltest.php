<?php
/**
**/
	include("../conc.php");
/***********************************************************************************/

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
	//echo $trimmed;
	
	$word = $trimmed;//'accueillir"
	$time_start = microtime(true);
	
	$query = "SELECT t.old_text FROM text t ";
	$query .= "JOIN revision r ON r.rev_text_id = t.old_id ";
	$query .= "JOIN page p ON r.rev_page = p.page_id ";
	$query .= "WHERE p.page_title = '$word' AND p.page_namespace = 0";

	if (!$queryResult = $conn->query($query)) {
		die("Error: Couldn't query word.");
	}
	if ($queryResult->num_rows > 0) {
		while ($row = $queryResult->fetch_assoc()){
			$wikitext = $row['old_text'];
		}
		//echo $wikitext;
		$text= $wikitext;
	}
	else {
		die("No such word found.");
	}

	$genderPattern = "(\{\{([mf]|mf)\??\}\})"; // {{m}}
	$posPattern = "(\{\{\S\|[\d\w\s]+\|fr(\|num=[0-9])?\}\})";  // {{S|nom|fr}}
	$tradPattern = "(trad\+\|en\|([A-z]*))";//(\{\{([trad+|en|])\??\}\})"; //   {{trad+|en|Tuesday}}  
	
	$gen = preg_match($genderPattern,$text,$matchesGen);
	$pos = preg_match($posPattern,$text,$matchesPos);
	$trad = preg_match($tradPattern,$text,$matchesTrad);
	
	$time_end = microtime(true);
	$time = $time_end - $time_start;
	print_r("".$matchesTrad[1]);
	//print_r("\n<BR>time to translate mysql:  <span style='position:absolute;left:220px;'>" . $time . " sec.</span><BR>");
	
	/*
	$params = '?action=parse&prop=wikitext&page='.$trimmed.'&format=xml';
	$langCode = 'fr';
	
	$ch = curl_init('http://'.$langCode.'.wiktionary.org/w/api.php'.$params);		
	
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
  
	$data = curl_exec($ch);
	curl_close($ch);
	
	//$xml = file_get_contents("fr.wiktionary.org/w/api.php");
	//echo "data= ". $data;
	$trad = preg_match($tradPattern,$data,$matchesTrad);
	$time_end = microtime(true);
	$time = $time_end - $time_start;
	//print_r("$trimmed=".$matchesTrad[1]);
	//print_r("\n<BR>time to translate via curl:  <span style='position:absolute;left:220px;'>" . $time . " sec.</span><BR>");
	*/
	?>