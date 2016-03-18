<?php
/**
**/
	include("../conc.php");
/***********************************************************************************/

	function sqlquery($conn,$word){
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
			die("No such word as $word found.");
		}
		$tradPattern = "(trad\+\|en\|([A-z]*))";  //(\{\{([trad+|en|])\??\}\})"; 
		$trad = preg_match($tradPattern,$text,$matchesTrad);
		return $matchesTrad;
	}
	//echo utf8_decode('drôle'); // outputs drôle in html

	//isset() determines if var is set and not null
	if(isset($argv)){
		$var = $argv[1];
		if(count($argv)>2)
			$i = count($argv);
	}
	// check for an empty string and display a message.
	if(isset($_GET['q']))
		$var = trim($_GET['q']); //trim whitespace from the stored variable

	if(isset($var))
		$trimmed = trim($var); //trim whitespace from the stored variable
	else
		$trimmed = " ";
	//echo $trimmed;
	
	$word = $trimmed;//'accueillir';
	$word = utf8_decode($word);
		
			
	$time_start = microtime(true);

	$text = sqlquery($conn,$word);
	if(isset($text) && count($text)>=1)
		print_r("$word=".$text[1]."\t");
	else
		print_r("no such word translation |");
	$j=2;
	if(isset($i))
		while($j<$i){
			$word = $argv[$j];//'accueillir';
			$word = utf8_decode($word);
			$text = sqlquery($conn,$word);//$word);
			if(isset($text) && count($text)>=1)
				print_r("$word=".$text[1]."\t");
			else
				print_r(" ////");
			$j++;
		}
	$time_end = microtime(true);
	$time = $time_end - $time_start;
	
	if(isset($i)){
		$i=$i-1;
		//print_r("\n<BR>time to translate using mysql $i words:  <span style='position:absolute;left:220px;'>" . $time . " sec.</span><BR>");
		print_r("\ntime to translate using mysql $i words:" . $time . " sec.");
		}
	else
		print_r("\ntime to translate using mysql 1 words:" . $time . " sec.");
		
	/*
	$genderPattern = "(\{\{([mf]|mf)\??\}\})"; // {{m}}
	$posPattern = "(\{\{\S\|[\d\w\s]+\|fr(\|num=[0-9])?\}\})";  // {{S|nom|fr}}
	{{trad+|en|Tuesday}}  
	
	$gen = preg_match($genderPattern,$text,$matchesGen);
	$pos = preg_match($posPattern,$text,$matchesPos);
	
	
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