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
	$query = "set names utf8";
	query($conn,$query);
	query($conn2,$query);
	
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
		
		if (!$queryResult = $conn->query($query)) {
			die("Error: Couldn't query word.");
		}
		
		$i =0;
		if ($queryResult->num_rows > 0) {
			while ($row = $queryResult->fetch_assoc()){
				$page_title = $row['page_title'];//$row['old_text'];
				$wikid = $row['page_id'];
				$tablename = 'page2';
				/***************/
				$query = "SELECT * FROM  `revision` WHERE  `rev_id` = ".$row['page_latest']." limit 1";
				$row_revision = query($conn,$query);
				$rev_text_id = $row_revision['rev_text_id'];
				
				$query = "SELECT * FROM  `text` WHERE  `old_id` = ".$row_revision['rev_text_id']." limit 1";
				$row_text = query($conn,$query);
				$old_text = $row_text['old_text'];
				$entry[$i++] = [$wikid,$page_title,$old_text];
				$old_text='';
			}
		}
		else {
			echo "No such query as $query possible.\n";
			$bad_query=TRUE;
		}
		if(!$bad_query){
			$ct= count($entry);
			$i=0;
			while($i<=$ct){
				//echo $i . "\n".$c;
				if(!empty($entry[$i])){
					$a = $entry[$i][0]; // page_id
					$b = $entry[$i][1]; // page_title
					$c = $entry[$i][2]; // old_text
					
					$t4 = "(trad\+\|en\|([A-z]* [A-z]* [A-z]* [A-z]*))";//(\{\{([trad+|en|])\??\}\})"; //   {{trad+|en|Tuesday Wedn Thurs Fri}}  
					$t3 = "(trad\+\|en\|([A-z]* [A-z]* [A-z]*))";//(\{\{([trad+|en|])\??\}\})"; //   {{trad+|en|Tuesday Wedn Thurs}}  
					$t2 = "(trad\+\|en\|([A-z]* [A-z]*))";//(\{\{([trad+|en|])\??\}\})"; //   {{trad+|en|Tuesday Wedn}}  
					$t1 = "(trad\+\|en\|([A-z]*))";//(\{\{([trad+|en|])\??\}\})"; //   {{trad+|en|Tuesday}}  
					
					$m4 = preg_match($t4,$c,$matchesTrad4);
					$m3 = preg_match($t3,$c,$matchesTrad3);
					$m2 = preg_match($t2,$c,$matchesTrad2);
					$m1 = preg_match($t1,$c,$matchesTrad1);
					$selection=5;
					
					if($m4)
						$selection = 4;
					if(!empty($matchesTrad3)&& !$m4)
						$selection = 3;
					if(!empty($matchesTrad2)&& !$selection<5)
						$selection = 2;
					//if(!empty($matchesTrad1)&& !$selection<5)
					if($m1 && !$selection<5)
						$selection = 1;
					//if(count($matchesTrad)>=2)
						//	$matchesTrad = array_shift($matchesTrad);
					$var_name = "$" . "matchesTrad".$selection; // = '$matchesTrad#1-4'
					if($selection!==5)
						if($selection!==1)
							$replacement = implode(",", $var_name); // $matchesTrad[1]; // = translation #1
						else
							$replacement = $matchesTrad1[1];
					//echo $b . "=" . $replacement . "\n";
				
					if(empty($replacement))
						$c = '';//$entry[$i][1];
					else
						$c = $replacement;	
					$query2 = "INSERT INTO $tablename(page_id,page_title,replacement) VALUES ";
					$query2.= "('$a','$b','$c')";
					$conn2->query($query2);
		//			echo $query2 . "\n";
					$a='';
					$b='';
					$c='';
					$replacement = '';
				}
				$i++;
			}
			echo "last word processed is $page_title\n";
		}
		if(!empty($entry)){
			if(count($entry[$ct-1])>0)
				$last = implode(",",$entry[$ct-1]);
			else
				$last = $entry[$ct-1][1];
			echo $ct . ":" . "$page_title" . ",$replacement\n";
		}
		$entry=NULL;
		$ct=0;
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