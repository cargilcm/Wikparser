<?php
/**
**/
	
	include('../conc.php');

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
		
		$tradPattern = "(trad\+\|en\|([A-z]* [A-z]* [A-z]*))";  //(\{\{([trad+|en|])\??\}\})"; 
		$trad3 = preg_match_all($tradPattern,$text,$matchesTrad3);
		if($trad3)
			return $matchesTrad3;
		$tradPattern = "(trad\+\|en\|([A-z]* [A-z]*))";  //(\{\{([trad+|en|])\??\}\})"; 
		$trad2 = preg_match_all($tradPattern,$text,$matchesTrad2);
		if($trad2)
			return $matchesTrad2;
		$tradPattern = "(trad\+\|en\|([A-z]*))";  //(\{\{([trad+|en|])\??\}\})"; 
		$trad = preg_match_all($tradPattern,$text,$matchesTrad);
		if($trad)
			return $matchesTrad;
		return ["/////"];
	}
	//echo utf8_decode('drôle'); // outputs drôle in html

	//isset() determines if var is set and not null
	// check for an empty string and display a message.
	$i=0;
	
	if(isset($_GET)){
		$pieces = Array();
		foreach($_GET as $key=>$value)
			$pieces[$i++]=$value;
		//print_r($pieces);
	}
	$j = count($_GET);
	/*
	if(isset($_GET)){
		$var = $_GET;
		foreach($var as $key=>$value)
			$pieces = explode(" ",$value);
		//print_r($pieces);
	}*/
	$i=0;
	$j=count($pieces);
	if(isset($pieces[$i]))
		$trimmed = trim($pieces[0]); //trim whitespace from the stored variable
	else
		$trimmed = " ";
	//echo $trimmed;
	
	$word = $trimmed;//'accueillir';
	$word = utf8_decode($word);
			
	$time_start = microtime(true);

	/*$text = sqlquery($conn,$word);
	if(isset($text) && count($text)>=1)
		print_r("$word=".$text[1]."\t");
	else
		print_r("no such word translation |");*/ 
	
	while($i<$j){
			$word = trim($pieces[$i++]);
			$word = utf8_decode($word);
			//print_r($word);
			$text = sqlquery($conn,$word);//$word);
			if(isset($text) && count($text)>=2){
				 echo $word . "=";
				 if(count($text[1])>=1){
					$text[1] = array_unique($text[1]);
					for($ii=0;$ii<=count($text[1]);$ii++){	
						if(!empty($text[1][$ii]))
							print_r("".$text[1][$ii]." &nbsp;, &nbsp;"); //change this to arrive at synsets
					
					}
				}
				echo "<br>";
				//print_r($text[1] . " ");
			}
			else
				print_r(" ////");
			
		}
	$time_end = microtime(true);
	$time = $time_end - $time_start;
	
	if(isset($pieces)){
		$i=$i-1;
		//print_r("\n<BR>time to translate using mysql $i words:  <span style='position:absolute;left:220px;'>" . $time . " sec.</span><BR>");
		//print_r("\ntime to translate using mysql $i words:" . $time . " sec.");
		}
	else
		print_r("");
		//print_r("\ntime to translate using mysql 1 words:" . $time . " sec.");
		
	/*
	$genderPattern = "(\{\{([mf]|mf)\??\}\})"; // {{m}}
	$posPattern = "(\{\{\S\|[\d\w\s]+\|fr(\|num=[0-9])?\}\})";  // {{S|nom|fr}}
	{{trad+|en|Tuesday}}  
	
	$gen = preg_match($genderPattern,$text,$matchesGen);
	$pos = preg_match($posPattern,$text,$matchesPos);
	*/

	?>