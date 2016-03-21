<?php
/**
**/
	$dbHost = 'localhost'; // e.g. localhost
	$dbUser = 'root';
	$dbPass = 'admin';
	$dbName = 'frwiktionary3';
	
/***********************************************************************************/
	$conn = new mysqli($dbHost, $dbUser, $dbPass, $dbName);
	$conn2 = new mysqli($dbHost, $dbUser, $dbPass, 'extr');
	
	if ($conn->connect_errno > 0) {
		die("Unable to connect to database [".$conn->connect_error."].");
	}
	else {
		//$conn = mysql_connect("localhost","root","admin"); //(host, username, password)
		//echo $conn->host_info . "<BR>";
		//var_dump($conn);
		
	}
	mysqli_set_charset($conn, 'utf8');
	mysqli_set_charset($conn2, 'utf8');
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
	
	$word = $trimmed;//'accueillir';
	$word = utf8_decode($word);
		
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
		die("No such word as $word found.");
	}

	$genderPattern = "(\{\{([mf]|mf)\??\}\})"; // {{m}}
	$posPattern = "(\{\{\S\|[\d\w\s]+\|fr(\|num=[0-9])?\}\})";  // {{S|nom|fr}}
	$tradPattern = "(trad\+\|en\|([A-z]*))";//(\{\{([trad+|en|])\??\}\})"; //   {{trad+|en|Tuesday}}  
	
	$gen = preg_match($genderPattern,$text,$matchesGen);
	$pos = preg_match($posPattern,$text,$matchesPos);
	$trad = preg_match($tradPattern,$text,$matchesTrad);
	
	print_r("".$matchesTrad[1]);
	
	//$query = "SELECT count(*) from page;";// p where p.page_namespace=0;";

	
	if (!$queryResult = $conn->query($query)) {
		die("Error: Couldn't query word.");
	}
	$i=50;// $queryResult->fetch_assoc()['count(*)'];
	$j=0;
	echo "\n" . $i . "\n";
	
	$query = "SELECT t.old_text, p.page_title,p.pagenamespace from page p ";// p where p.page_namespace=0;";
	$query .= "JOIN text t ON t.old_id=p.page_id ";
	$query .= "JOIN revision r ON r.rev_text_id = t.old_id ";
	//$query .= "JOIN page p ON r.rev_page = p.page_id ";
	$query .= "WHERE p.page_title = '$word' AND p.page_namespace = 0 LIMIT 50";
	
	if (!$queryResult = $conn->query($query)) {
		echo $query;
		die("\nError: Couldn't query word.");
	}
		
	if ($i > 0) {
		while ($row = $queryResult->fetch_assoc() && $j<50){
			//$tradPattern = "(trad\+\|en\|([A-z]*))";//(\{\{([trad+|en|])\??\}\})"; //   {{trad+|en|Tuesday}}  
			//$trad = preg_match($tradPattern,$text,$matchesTrad);
	
			$query = "INSERT INTO extraction values ('null','"; /**null=ID_..ie will autoincrement */
			$query .= $matchesTrad[1] ."','";
			$query .= $row['rev_text_id'] ."', '";
			$query .= $row['rev_page'] ."', '";
			$query .= $row['page_namespace']  ."', '";
			$query .= $row['page_title'] ."')";
			$j++;
		}
	}
	else echo 'didnt find any query result';
	
	if (!$queryResult2 = $conn2->query($query)) {
		//echo $query;
		die("\nError: Couldn't insert.");
		
	}
	else echo $query;
	
	?>