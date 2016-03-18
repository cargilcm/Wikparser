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
	$min_id=0;
	$offset=1000;
	$bad_query=FALSE;
	while(($min_id+$offset)<$max_id){
		$max = $min_id+$offset;
		echo "processing $min_id to $max entries\n";
		
		$query = "SELECT * from page where page_id>=$min_id AND page_id<=$max AND page_namespace=0";// like \"absc%\"";
		$min_id+=$offset;
		/*
		$query = "SELECT t.old_text FROM text t ";
		$query .= "JOIN revision r ON r.rev_text_id = t.old_id ";
		$query .= "JOIN page p ON r.rev_page = p.page_id ";
		$query .= "WHERE p.page_title = '$word' AND p.page_namespace = 0"; */

		if (!$queryResult = $conn->query($query)) {
			die("Error: Couldn't query word.");
		}
		
		$i =0;
		if ($queryResult->num_rows > 0) {
			while ($row = $queryResult->fetch_assoc()){
				$page_title = $row['page_title'];//$row['old_text'];
				$wikid = $row['page_id'];
				$tablename = 'page';
				/***************/
				$query = "SELECT * FROM  `revision` WHERE  `rev_id` = ".$row['page_latest']." limit 1";
				$row_revision = query($conn,$query);
				$rev_text_id = $row_revision['rev_text_id'];
				
				$query = "SELECT * FROM  `text` WHERE  `old_id` = ".$row_revision['rev_text_id']." limit 1";
				$row_text = query($conn,$query);
				$old_text = $row_text['old_text'];
				$entry[$i++] = [$wikid,$page_title,$old_text];
				
			}
			$text= $old_text;
		}
		else {
			echo "No such query as $query possible.\n";
			$bad_query=TRUE;
		}
		if(!$bad_query){
			$ct= count($entry);
			//echo $ct . "\n";// . " " . $entry[$c-1][1] . "\n";
			$i=0;
			//for($i=0;$i<$c;$i++){
			while($i<=$ct){
				//echo $i . "\n".$c;
				if(!empty($entry[$i])){
					$a = $entry[$i][0]; // page_id
					$b = $entry[$i][1]; // page_title
					$c = $entry[$i][2]; // old_text
					
					$tradPattern = "(trad\+\|en\|([A-z]*))";//(\{\{([trad+|en|])\??\}\})"; //   {{trad+|en|Tuesday}}  
					preg_match($tradPattern,$c,$matchesTrad);
					
					if(!empty($matchesTrad[1]))
						$replacement = $matchesTrad[1];
					
					
					if(empty($replacement))
						$c = $entry[$i][1];
					else
						$c = $replacement;	
					//echo $c . "\n";
					$query2 = "INSERT INTO $tablename(page_id,page_title,replacement) VALUES ";
					$query2.= "('$a','$b','$c')";
					$conn2->query($query2);
					//echo $query2 . "\n";
				}
				$i++;
			}
			echo "last word processed is $b\n";
		}
		$entry=[];
		$bad_query=FALSE;
	/*	$genderPattern = "(\{\{([mf]|mf)\??\}\})"; // {{m}}
		$posPattern = "(\{\{\S\|[\d\w\s]+\|fr(\|num=[0-9])?\}\})";  // {{S|nom|fr}}
		$tradPattern = "(trad\+\|en\|([A-z]*))";//(\{\{([trad+|en|])\??\}\})"; //   {{trad+|en|Tuesday}}  
	*/
	}		
	
	
	
	
	
	
	
	$text="hey,you,heyyou";
	$tradPattern = "([A-z]*(,))";
	$trad = preg_match($tradPattern,$text,$matchesTrad);
	
	//print_r("".$matchesTrad[1][0]);
	?>