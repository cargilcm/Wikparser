<?php
/***********************************************************************************/
// Change the values for these variables according to the naming scheme of your own
// SQL copy of Wiktionary.
/***********************************************************************************/
	$dbHost = 'localhost'; // e.g. localhost
	$dbUser = 'root';
	$dbPass = 'admin';
	$dbName = 'wiktionary';
	
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
		
		$word = 'accueillir';
		
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
		}
		else {
			die("No such word found.");
		}
		
	//$res = $conn->query("select * from text where old_id=20826008");// where title like \"accueillir\"";
		/*
 while ($row = $res->fetch_assoc()) {
		echo "<PRE>" . $row['old_text'];
		}
		*/
?>

<!--

  $var = @$_GET['q'] ;
  $trimmed = trim($var); //trim whitespace from the stored variable

// check for an empty string and display a message.
if ($trimmed == "")
  {
  echo "<p>Please enter a search...</p>";
  exit;
  }

// check for a search parameter
if (!isset($var))
  {
  echo "<p>We dont seem to have a search parameter!</p>";
  exit;
  }


// begin to show results set
$count = 1;


// Build SQL Query  
$query = "select * from words where lemma like \"$trimmed\"";
$result = mysql_query($query) or die("Couldn't execute query");

if(mysql_num_rows($result)==0){
echo "$trimmed is not in the dictionary..<a href=\"http://chriscargile.com/dictionary\">try another word</a>?";
}
else
{

 while($row= mysql_fetch_array($result))
{
  $wordid=$row["wordid"];
  $lemma=$row["lemma"];
  echo $lemma;
}-->