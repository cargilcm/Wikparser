<?php
/**
**/
	$dbHost = 'localhost'; // e.g. localhost
	$dbUser = 'root';
	$dbPass = 'admin';
	$dbName = 'frwiktionary3';
	
	
/***********************************************************************************/
	$conn = new mysqli($dbHost, $dbUser, $dbPass, $dbName);
	
	if ($conn->connect_errno > 0) {
		die("Unable to connect to database [".$conn->connect_error."].");
	}
	else {
		//$conn = mysql_connect("localhost","root","admin"); //(host, username, password)
		//echo $conn->host_info . "<BR>";
		//var_dump($conn);
		
	}
	mysqli_set_charset($conn, 'utf8');
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
	
	$time_end = microtime(true);
	$time = $time_end - $time_start;
	print_r("".$text[1]);
	$j=2;
	if(isset($i))
		while($j<$i){
			$word = $argv[$j];//'accueillir';
			$word = utf8_decode($word);
			$text = sqlquery($conn,$word);//$word);
			print_r(" ".$text[1]);
			$j++;
		}
			
	//print_r("\n<BR>time to translate mysql:  <span style='position:absolute;left:220px;'>" . $time . " sec.</span><BR>");
	
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