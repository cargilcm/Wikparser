<?php
/***********************************************************************************/
// This class is used to parse the wikitionary raw data in order to extract parts
// of speech for a given word.
// See the language.config.php file for setting language specific parameters.
/***********************************************************************************/

class PosParse {
/***********************************************************************************/
// Variables
/***********************************************************************************/
	private $langCode;			// language code (e.g. en, fr, da, etc.)
	
/***********************************************************************************/
// construct
/***********************************************************************************/
	public function __construct($langCode) {
		$this->langCode = $langCode;
	// Set language variables.	
		include './language.config.php';
		if (empty($this->posMatchType) || (empty($this->posPattern) && empty($this->posArray))) {
			die("ERROR: POS parameters are not set correctly for this language in language.config.php.");
		}
	}
/***********************************************************************************/
// public methods; used to retrieve contents of variables
/***********************************************************************************/
	public function get_pos($wikitext, $count) {
		$posArray = $this->extract_pos($wikitext, $count);
		
		include "./classes/class.strip.tags.php";
		$stripTagsObject = new StripTags();
		
		$posArray = $stripTagsObject->strip_tags($posArray, $this->langCode);
		return array_unique($posArray);
	}
/***********************************************************************************/
// private methods
/***********************************************************************************/

/***********************************************************************************/
// Extracts every occurrence of a part of speech.
/***********************************************************************************/
	private function extract_pos($wikitext, $count) {
		$tempPosResults = array();
		
	// If the matches are in an array
		if ($this->posMatchType == "array") {
			foreach ($this->posArray as $value) {
				if (strpos($wikitext, $value)) {
					$tempPosResults[] = str_replace($this->posExtraString, "", $value);
				}
			}		
		}		
	// Else if the matches are part of a regular expression
		else if ($this->posMatchType == "preg") {
			preg_match_all($this->posPattern, $wikitext, $matches);
			if (empty($matches[0]) !== true) {
				foreach ($matches[0] as $value) {
					$tempPosResults[] = str_replace($this->posExtraString, "", $value);
				}
			}
		}
		else {
			die("No POS type (preg or array) specified.");
		}
		
	// Return results if array not empty.	
		if (empty($tempPosResults) !== true) {
			return array_slice($tempPosResults, 0, $count);
		}
		else {
			die("No POS found.");
		}
	}
/***********************************************************************************/
} // End of class