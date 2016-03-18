<?php

/**
**/
	$dbHost = 'localhost'; // e.g. localhost
	$dbUser = 'root';
	$dbPass = 'admin';
	$dbName = 'frwiktionary3';
	$db2Name = 'frwiktclone';
	
/***********************************************************************************/
	$conn = new mysqli($dbHost, $dbUser, $dbPass, $dbName);
	$conn2 = new mysqli($dbHost, $dbUser, $dbPass, $db2Name);
	
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

	
	function query($theConn,$theQuery){
		if (!$results_page = $theConn->query($theQuery)) {
			die("Error: Couldn't run query: $theQuery.");
		}
		return $results_page->fetch_assoc();
	}
	/***********************************************************************************/
	$query = "Select max(page_id) from page";
	$res = query($conn,$query);
	$max_id=$res['max(page_id)'];
	
	$query = "Select min(page_id) from page";
	$res = query($conn,$query);
	$min_id=$res['min(page_id)'];
	$min=$min_id-1;
	$offset=50;
	$max = $min_id+$offset;
	
	echo $max_id . "\n";
	$done = FALSE;
	$tablename = 'page';
	while(!$done){
		$query = "SELECT * FROM page where page_id>=$min AND page_id<=$max GROUP BY page_id LIMIT $offset";
		$min_id+=$offset;
		
		if (!$results_page = $conn->query($query)) {
			die("Error: Couldn't query word.");
		}
		
		$i=0;
		
		if ($results_page->num_rows > 0) {
			while ($row_page = $results_page->fetch_assoc()){
				$page_title = $row_page['page_title'];
				$entry[$i][0] = $page_title;
				//echo $i . " " . $page_title . "\n";
				$query = "SELECT * FROM  `revision` WHERE  `rev_id` = ".$row_page['page_latest']." limit 1";
				$row_revision = query($conn,$query);
				$rev_text_id = $row_revision['rev_text_id'];
				
				$query = "SELECT * FROM  `text` WHERE  `old_id` = ".$row_revision['rev_text_id']." limit 1";
				$row_text = query($conn,$query);
				$old_text = $row_text['old_text'];
				//$entry[$i++][1] = $old_text;
				print_r($entry[$i]);// . "\n";			
			}
		}
		else {
			die("No such word as $page_title found.");
		}
		echo "word is:" . $entry[count($entry)-1][0] . "\n";
		echo "size is " . count($entry);
		for($j=0;$j<count($entry);$j++){
			$page_title = $entry[$j][0];
			//$old_text = $entry[$j][1];
			$query2 = "INSERT INTO page(page_id,page_title,replacement) VALUES ";
			$query2.= "('$page_title','$page_title','they')";
			echo $j . " " .$query2 . "\n";
			$conn2->query($query2);
		}
		if($min_id>=($max_id-$offset))
			$done=TRUE;
		$min=$min+$offset;	
		$entry=[];
		echo "processed $min entries\n";
	}
	
	echo $entry[$i][0] . "--length--" . count($entry[$i][1]) . "\n";
	
	//$results_revision = mysql_query($query);
	//$row_revision = mysql_fetch_array($results_revision);

	
	
//	while(count($row_page)
	// Then, page_latest is used to search the revision table for rev_id, and rev_text_id is obtained in the process.
	
	
	
	
	// The value obtained for rev_text_id is used to search for old_id in the text table to retrieve the text.
	//$query = "SELECT * FROM  `text` WHERE  `old_id` = ".$row_revision['rev_text_id']." limit 1";
	//$results_text = mysql_query($query);
	//$row_text = mysql_fetch_array($results_text);

	//echo '<li>'.$row_page['page_title'];
	//echo '<li>'.$row_text['old_text'];

	
	
	
	
	//$query = "SELECT * from page where page_title like \"absc%\"";
	/*
	$query = "SELECT t.old_text FROM text t ";
	$query .= "JOIN revision r ON r.rev_text_id = t.old_id ";
	$query .= "JOIN page p ON r.rev_page = p.page_id ";
	$query .= "WHERE p.page_title = '$word' AND p.page_namespace = 0"; */

	
	/*
	if (!$queryResult = $conn->query($query)) {
		die("Error: Couldn't query word.");
	}
	echo "\n";
	if ($queryResult->num_rows > 0) {
		while ($row = $queryResult->fetch_assoc()){
			$wikitext = $row['page_title'];//$row['old_text'];
			$wikid = $row['page_id'];
			$tablename = 'page';
			$query2 = "INSERT INTO page(page_id,page_title,replacement) VALUES ";
			$query2.= "($wikid,'$wikitext','they')";
			$conn2->query($query2);
			echo $query2 . "\n";
		}
		$text= $wikitext;
	}
	else {
		die("No such word as $word found.");
	}
	$genderPattern = "(\{\{([mf]|mf)\??\}\})"; // {{m}}
	$posPattern = "(\{\{\S\|[\d\w\s]+\|fr(\|num=[0-9])?\}\})";  // {{S|nom|fr}}
	$tradPattern = "(trad\+\|en\|([A-z]*))";//(\{\{([trad+|en|])\??\}\})"; //   {{trad+|en|Tuesday}}  
	
	$text="hey,you,heyyou";
	$tradPattern = "([A-z]*(,))";
	$trad = preg_match($tradPattern,$text,$matchesTrad);
	
	print_r("".$matchesTrad[1][0]);
	*/
	?>