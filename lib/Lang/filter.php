<?php
/**
**/
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
		
		
	$var = @$_GET['q'] ;
	$trimmed = trim($var); //trim whitespace from the stored variable

// check for an empty string and display a message.
	if (!$trimmed == "")
	{
	echo "<p>".$trimmed."</p>";
	}
  
  $word = $trimmed;//'accueillir';
		
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
  
//$text = "== {{langue|fr}} == === {{S|étymologie}} === : {{cf|ad-|cueillir}}. === {{S|verbe|fr}} === '''accueillir''' {{pron|a.kœ.ji?|fr}} {{t|fr}} {{conjugaison|fr|groupe=3}} # [[action|Action]] de [[faire]] un [[accueil]], de [[recevoir]] en bien ou en mal [[quelqu’un]] qui [[arrive]]. #* ''Et quand elle se sentit définitivement seule et abandonnée, Yasmina se rendit chez ses deux amies qui l’'''accueillirent''' avec joie.'' {{source|[[w:Isabelle Eberhardt|Isabelle Eberhardt]], ''[[s:Yasmina|Yasmina]]'',1902}} #* ''Mais un grand escogriffe en smoking et coiffé d’une casquette à carreaux sortait de la limousine et accourait vers les trois femmes qui l’'''accueillirent''' fraîchement.'' {{source|{{Citation/Francis Carco/Images cachées/1928}}}} #* ''Devant la réprobation presque unanime qui '''accueillit''' mon exposé, je me décourageai et me ralliai à l’interprétation probabiliste de Born, Bohr et Heisenberg […].'' {{source|{{w|Louis de Broglie}}; ''La Physique quantique restera-t-elle indéterministe ?'' Séance de l'Académie des Sciences, du 25 avril 1953}} # {{figuré|fr}} [[surprendre|Surprendre]]. #* ''La tempête, le vent les '''accueillit'''. Le détachement, en approchant du bois, '''fut accueilli''' à coups de fusil.'' ==== {{S|apparentés}} ==== * [[accueil]] *[[accueillable]] * [[accueillant]] ==== {{S|traductions}} ==== {{trad-début|Action de faire un accueil, de recevoir}} * {{T|de}} : {{trad+|de|empfangen}}, {{trad+|de|aufnehmen}} * {{T|en}} : {{trad+|en|welcome}}, {{trad+|en|host}} * {{T|ca|trier}} : {{trad+|ca|acollir}} * {{T|es|trier}} : {{trad+|es|acoger}} * {{T|id}} : {{trad+|id|menyambut}} * {{T|it}} : {{trad+|it|accogliere}} * {{T|swb}} : {{trad--|swb|urenga}} * {{T|nb}} : {{trad+|nb|hilse}}, {{trad-|nb|motta}}, {{trad-|nb|ønske velkommen}}, {{trad+|nb|få}}, {{trad-|nb|godta}} * {{T|nn}} : {{trad+|no|hilse}}, {{trad-|no|motta}}, {{trad-|no|ynskje velkommen}}, {{trad+|no|få}}, {{trad-|no|godtake}} * {{T|oc}} : {{trad-|oc|aculhir}} * {{T|se}} : {{trad--|se|dearvvahit}} * {{T|zdj}} : {{trad--|zdj|ukari?isa}}, {{trad--|zdj|urenga}}, {{trad--|zdj|-lahiki|dif=ulahiki}} * {{T|sv}} : {{trad+|sv|mottaga}}, {{trad+|sv|välkomna}} * {{T|cs}} : {{trad+|cs|vítat}} {{trad-fin}} {{trad-début|Être surpris par un évènement}} * {{T|de}} : {{trad+|de|empfangen}}, {{trad+|de|überraschen}}, {{trad+|de|überkommen}} * {{T|en}} : {{trad+|en|welcome}} {{ironique|nocat=1}} * {{T|nb}} : {{trad+|nb|overraske}} {{trad-fin}} ===== {{S|traductions à trier}} ===== {{trad-début|Traductions à trier suivant le sens}} * {{T|af|trier}} : {{trad-|af|groet}}, {{trad-|af|begroet}}, {{trad-|af|bekom}}, {{trad-|af|kry}}, {{trad-|af|ontvang}}, {{trad-|af|neem}}, {{trad-|af|aanvaar}} * {{T|sq|trier}} : {{trad+|sq|pranoj}} * {{T|ang|trier}} : {{trad-|ang|gretan}}, {{trad-|ang|onfon}} * {{T|da|trier}} : {{trad-|da|hilse}}, {{trad-|da|sige goddag}}, {{trad+|da|få}}, {{trad+|da|modtage}}, {{trad+|da|acceptere}}, {{trad-|da|sige ja tak til}}, {{trad+|da|modtage}} * {{T|eo|trier}} : {{trad+|eo|akcepti}}, {{trad-|eo|saluti}}, {{trad-|eo|ricevi}} * {{T|fo|trier}} : {{trad-|fo|heilsa}}, {{trad-|fo|fáa}}, {{trad-|fo|taka ímóti}}, {{trad-|fo|taka við}}, {{trad-|fo|viðurkenna}} * {{T|fi|trier}} : {{trad+|fi|tervehtiä}}, {{trad+|fi|saada}}, {{trad-|fi|ottaa vastaan}} * {{T|fy|trier}} : {{trad-|fy|begroetsje}}, {{trad-|fy|groetsje}}, {{trad-|fy|krije}}, {{trad-|fy|ûntfange}}, {{trad-|fy|oanfurdigje}}, {{trad-|fy|oannimme}} * {{T|gd|trier}} : {{trad-|gd|faigh}} * {{T|el|trier}} : {{trad+|el|d???µa?}} * {{T|hu|trier}} : {{trad+|hu|akceptál}}, {{trad+|hu|elfogad}} * {{T|io|trier}} : {{trad+|io|aceptar}} * {{T|is|trier}} : {{trad+|is|heilsa}}, {{trad+|is|fá}}, {{trad-|is|samþykkja}}, {{trad+|is|þakka}} * {{T|it|trier}} : {{trad+|it|salutare}}, {{trad+|it|ricevere}}, {{trad+|it|accettare}}, {{trad+|it|accogliere}} * {{T|la|trier}} : {{trad-|la|salutare}}, {{trad-|la|accipere}} * {{T|ms|trier}} : {{trad-|ms|menerima}}, {{trad-|ms|terima}}, {{trad-|ms|menerima}}, {{trad-|ms|terima}} * {{T|yua|trier}} : {{trad--|yua|k’amik}} * {{T|nl|trier}} : {{trad+|nl|groeten}}, {{trad+|nl|begroeten}}, {{trad+|nl|genieten}}, {{trad+|nl|krijgen}}, {{trad+|nl|ontvangen}}, {{trad+|nl|toucheren}}, {{trad+|nl|accepteren}}, {{trad+|nl|aannemen}} * {{T|pap|trier}} : {{trad--|pap|kumindá}}, {{trad--|pap|saludá}}, {{trad--|pap|akohé}}, {{trad--|pap|haña}}, {{trad--|pap|haya}}, {{trad--|pap|akseptá}}, {{trad--|pap|aseptá}} * {{T|pl|trier}} : {{trad+|pl|otrzymac}}, {{trad+|pl|przyjmowac}} * {{T|pt|trier}} : {{trad+|pt|recepcionar}}, {{trad+|pt|cumprimentar}}, {{trad+|pt|saudar}}, {{trad+|pt|haver}}, {{trad+|pt|obter}}, {{trad+|pt|receber}}, {{trad+|pt|aceitar}}, {{trad+|pt|acolher}}, {{trad+|pt|admitir}}, {{trad+|pt|topar}} * {{T|ro|trier}} : {{trad+|ro|primi}}, {{trad+|ro|accepta}}, {{trad+|ro|primi}} * {{T|ru|trier}} : {{trad+|ru|????????}}, {{trad+|ru|????????}}, {{trad+|ru|?????????}} * {{T|srn|trier}} : {{trad--|srn|kisi}} * {{T|sv|trier}} : {{trad+|sv|hälsa}}, {{trad+|sv|anamma}}, {{trad+|sv|bekomma}}, {{trad+|sv|få}}, {{trad+|sv|undfå}}, {{trad-|sv|tacka ja till}} * {{T|sw|trier}} : {{trad+|sw|pokea}} * {{T|tl|trier}} : {{trad-|tl|tanggapín}}, {{trad-|tl|tanggapín}} * {{T|tr|trier}} : {{trad+|tr|almak}}, {{trad+|tr|almak}}, {{trad+|tr|kabul etmek}} * {{T|zu|trier}} : {{trad-|zu|-amukela}} {{trad-fin}} === {{S|prononciation}} === * {{pron|a.kœ.ji?|fr}} * {{écouter|lang=fr|France <!-- précisez svp la ville ou la région -->|a.kœ.ji?|audio=Fr-accueillir.ogg}} === {{S|références}} === * {{Import:DAF8}} [[ca:accueillir]] [[chr:accueillir]] [[cy:accueillir]] [[de:accueillir]] [[el:accueillir]] [[en:accueillir]] [[es:accueillir]] [[et:accueillir]] [[fi:accueillir]] [[hu:accueillir]] [[id:accueillir]] [[io:accueillir]] [[it:accueillir]] [[ko:accueillir]] [[mg:accueillir]] [[pl:accueillir]] [[pt:accueillir]] [[ro:accueillir]] [[scn:accueillir]] [[sv:accueillir]] [[vi:accueillir]] [[zh:accueillir]]";
	
	
	//echo $text;
	$genderPattern = "(\{\{([mf]|mf)\??\}\})"; // {{m}}
	$posPattern = "(\{\{\S\|[\d\w\s]+\|fr(\|num=[0-9])?\}\})";  // {{S|nom|fr}}
	$tradPattern = "(trad\+\|en\|([A-z]*))";//(\{\{([trad+|en|])\??\}\})"; //   {{trad+|en|Tuesday}}  
	
	$gen = preg_match($genderPattern,$text,$matchesGen);
	$pos = preg_match($posPattern,$text,$matchesPos);
	$trad = preg_match($tradPattern,$text,$matchesTrad);
	
	print_r($matchesTrad[1]);
	
	?>