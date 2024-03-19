<?php 
	//	Bereinige Übergabe-Parameter
	function cleanInput($input) {
		$search = array(
			'@<script[^>]*?>.*?</script>@si',   // Strip out JavaScript
			'@<[\/\!]*?[^<>]*?>@si',            // Strip out HTML tags
			'@<style[^>]*?>.*?</style>@siU',    // Strip style tags properly
			'@<![\s\S]*?--[ \t\n\r]*>@'         // Strip multi-line comments
		);

		$output = preg_replace($search, '', $input);
		
		return $output;
	}
	
	//	SSL-Check mit Redirect
	function checkIsSSL($redirect = false) { 
		if(empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] == "off"){
			$redirect = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
			header('HTTP/1.1 301 Moved Permanently');
			header('Location: ' . $redirect);
			exit();
		} 
	}
	
	//	Bereinige $_SERVER['PHP_SELF']
	function esc_url($url) {
		if('' == $url) {
			return $url;
		}
	 
		$url = preg_replace('|[^a-z0-9-~+_.?#=!&;,/:%@$\|*\'()\\x80-\\xff]|i', '', $url);
	 
		$strip = array('%0d', '%0a', '%0D', '%0A');
		$url = (string) $url;
	 
		$count = 1;
		while ($count) {
			$url = str_replace($strip, '', $url, $count);
		}
	 
		$url = str_replace(';//', '://', $url);
	 
		$url = htmlentities($url);
	 
		$url = str_replace('&amp;', '&#038;', $url);
		$url = str_replace("'", '&#039;', $url);
	 
		if($url[0] !== '/') {
			// 	Wir wollen nur relative Links von $_SERVER['PHP_SELF']
			return '';
		} else {
			return $url;
		}
	}
	
	// SET FUNCTION TITLE CASE CORRECT: EVENT
	function titleCaseEvent($event, $delimiters = array(" ", "-", ".", "'", "O'", "Mc"), $exceptions = array("van", "de", "el", "la", "von", "vom", "der", "und", "zu", "auf", "dem", "dos", "I", "II", "III", "IV", "V", "VI")) {
		/*
		 * EXCEPTIONS IN LOWER CASE ARE WORDS YOU DONT WANT CONVERTED
		 * EXCEPTIONS ALL IN UPPER CASE ARE ANY WORDS YOU DONT WANT TO CONVERTED TO TITLE CASE
		 * BUT SHOULD BE CONVERTED TO UPPER CASE, E. G.:
		 * "king henry viii" OR "king henry Viii" SHOULD BE "King Henry VIII"
		*/
		$event = mb_convert_case($event, MB_CASE_TITLE, "UTF-8");
	
		foreach ($delimiters as $dlnr => $delimiter) {
			$words = explode($delimiter, $event);
			$newwords = array();

			foreach ($words as $wordnr => $word) {
				if (in_array(mb_strtoupper($word, "UTF-8"), $exceptions)) {
					// CHECK EXCEPTIONS LIST FOR ANY WORDS THAT SHOULD BE IN UPPER CASE
					$word = mb_strtoupper($word, "UTF-8");
				} elseif (in_array(mb_strtolower($word, "UTF-8"), $exceptions)) {
					// CHECK EXCEPTIONS LIST FOR ANY WORDS THAT SHOULD BE IN UPPER CASE
					$word = mb_strtolower($word, "UTF-8");
				} elseif (!in_array($word, $exceptions)) {
					// CONVERT TO UPPER CASE (NON-UTF-8 ONLY)
					$word = ucfirst($word);
				}
				array_push($newwords, $word);
			}
			$event = join($delimiter, $newwords);
		} // FOREACH
		return $event;	
	}
			
	// SET FUNCTION TITLE CASE CORRECT: EVENT OWNER
	function titleCaseEventOwner($event_owner, $delimiters = array(" ", "-", ".", "'", "O'", "Mc"), $exceptions = array("van", "de", "el", "la", "von", "vom", "der", "und", "zu", "auf", "dem", "dos", "I", "II", "III", "IV", "V", "VI")) {
	/*
	 * EXCEPTIONS IN LOWER CASE ARE WORDS YOU DONT WANT CONVERTED
	 * EXCEPTIONS ALL IN UPPER CASE ARE ANY WORDS YOU DONT WANT TO CONVERTED TO TITLE CASE
	 * BUT SHOULD BE CONVERTED TO UPPER CASE, E. G.:
	 * "king henry viii" OR "king henry Viii" SHOULD BE "King Henry VIII"
	*/
		$event_owner = mb_convert_case($event_owner, MB_CASE_TITLE, "UTF-8");
		foreach ($delimiters as $dlnr => $delimiter) {
			$words = explode($delimiter, $event_owner);
			$newwords = array();
			foreach ($words as $wordnr => $word) {
				if (in_array(mb_strtoupper($word, "UTF-8"), $exceptions)) {
					// CHECK EXCEPTIONS LIST FOR ANY WORDS THAT SHOULD BE IN UPPER CASE
					$word = mb_strtoupper($word, "UTF-8");
				} elseif (in_array(mb_strtolower($word, "UTF-8"), $exceptions)) {
					// CHECK EXCEPTIONS LIST FOR ANY WORDS THAT SHOULD BE IN UPPER CASE
					$word = mb_strtolower($word, "UTF-8");
				} elseif (!in_array($word, $exceptions)) {
					// CONVERT TO UPPER CASE (NON-UTF-8 ONLY)
					$word = ucfirst($word);
				}
				array_push($newwords, $word);
			}
			$event_owner = join($delimiter, $newwords);
		} // FOREACH
		return $event_owner;	
	}
	
	// CONVERT DATE (FROM DB):
	function convert_from_db($datum) {
		$jahr = substr($datum, 0, 4);
		$mon  = substr($datum, 5, 2);
		$tag  = substr($datum, 8, 2);
		$datneu = $tag . '.' . $mon . '.' . $jahr;
	return $datneu;
	}
	
	// CONVERT DATE (TO DB):
	function convert_to_db($datum) {
		$jahr = substr($datum, 6, 4);
		$mon  = substr($datum, 3, 2);
		$tag  = substr($datum, 0, 2);
		$datneu = $jahr . '-' . $mon . '-' . $tag;
	return $datneu;
	}
	
	function multiexplode($delimiters, $string) {
		$ready = str_replace($delimiters, $delimiters[0], $string);
		$launch = explode($delimiters[0], $ready);
		return $launch;
	}
	
	/*
	function decimal_to_time($seconds) {
		$t = $seconds;
	  
		return sprintf('%02d:%02d:%02d.%02d', ($t / 3600),(($t / 60) % 60), ($t % 60), ($t));
	}
	    
	function timeinsec($ms_total) {
		// EXPLODE STRING
		$ms_total = multiexplode(array(":", "."), $ms_total);
		
		$min = intval($ms_total[0]);
		$sek = intval($ms_total[1]);
		$ms	= intval($ms_total[2]);
		
		$ms_total = (60 * $min + $sek) * 1000 + $ms;
		
		return $ms_total;
	}
	*/

	// PASS TIME AS DECIMAL (E. G. 120.03 => 00:02:00,03)
	function convertTime($decimal_seconds) {
		if($decimal_seconds != 0) {
			// Splitte Ergebnis
			$split = explode('.', $decimal_seconds);
			
			// Ermittle Sekunden
			$seconds = (int)$split[0];
			
			// Ermittle Millisekunden (t/100)
			$milliseconds = (int)$split[1];
			
			if($milliseconds <= 9) {
				$milliseconds = "0" . $milliseconds;
			} else {
				$milliseconds = $milliseconds;
			}
			
			// Wandle in lesbares Format um
			$converted = gmdate('H:i:s', $seconds) . "," . $milliseconds;
		} else {
			$converted = "00:00:00,00";
		}
		
		// Gebe Rückgabewert aus
		return $converted;
	}
	  
	// PASS TIME AS DECIMAL (E. G. 120.03 => 00:02:00,03)
	function convertTimeRacer($decimal_seconds) {
		if($decimal_seconds != 0) {
			// Splitte Ergebnis
			$split = explode('.', $decimal_seconds);
			
			// Ermittle Sekunden
			$seconds = (int)$split[0];
			
			// Ermittle Millisekunden (t/100)
			$milliseconds = (int)$split[1];
			
			if($milliseconds <= 9) {
				$milliseconds = "0" . $milliseconds;
			} else {
				$milliseconds = $milliseconds;
			}
			
			// Wandle in lesbares Format um
			$converted = gmdate('i:s', $seconds) . "," . $milliseconds;
		} else {
			$converted = "00:00,00";
		}
		
		// Gebe Rückgabewert aus
		return $converted;
	}
	    
	function resize($width, $height) {
		// GET ORIGINAL IMAGE X AND Y
		list($w, $h) = getimagesize($_FILES['logo']['tmp_name']);
 
		// CALCULATE NEW IMAGE SIZE WITH RATIO
		$ratio = max($width / $w, $height / $h);
		$h = ceil($height / $ratio);
		$x = ($w - $width / $ratio) / 2;
		$w = ceil($width / $ratio);
  
		// NEW FILE NAME
		$path = 'uploads/' . $width . 'x' . $height . '_' . $_FILES['logo']['name'];
  
		// READ BINARY DATA FROM IMAGE FILE
		$imgString = file_get_contents($_FILES['logo']['tmp_name']);
 
		// CREATE IMAGE FROM STRING
		$image = imagecreatefromstring($imgString);
		$tmp = imagecreatetruecolor($width, $height);
  
		imagecopyresampled($tmp, $image, 0, 0, $x, 0, $width, $height, $w, $h);
  
		// SAVE IMAGE
		switch ($_FILES['logo']['type']) {
			case 'image/jpeg':
				imagejpeg($tmp, $path, 100);
			break;
			case 'image/png':
				imagepng($tmp, $path, 0);
			break;
			case 'image/gif':
				imagegif($tmp, $path);
			break;
			default:
				exit;
			break;
		}
  
		return $path;
  
		// CLEAN UP MEMORY
		imagedestroy($image);
		imagedestroy($tmp);
	}
	
	// Funktion zum Sortieren basierend auf der Gesamtabweichung als Dezimale
	/*
	function build_sorter($key) {
		return function ($a, $b) use ($key) {
			return strnatcmp($a[$key], $b[$key]);
		};
	}
	*/	
	
	// Funktion zum Sortieren basierend auf der Gesamtabweichung als Dezimale [v2]
	function array_orderby() {
		$args = func_get_args();
		$data = array_shift($args);
		foreach ($args as $n => $field) {
			if (is_string($field)) {
				$tmp = array();
				foreach ($data as $key => $row)
					$tmp[$key] = $row[$field];
				$args[$n] = $tmp;
				}
		}
		$args[] = &$data;
		call_user_func_array('array_multisort', $args);
		return array_pop($args);
	}
	
	//////////////////////////////////////////////////////////////////////
	//	PARA: Date Should In YYYY-MM-DD Format
	//	RESULT FORMAT:
	// '%y Year %m Month %d Day %h Hours %i Minute %s Seconds'      =>  1 Year 3 Month 14 Day 11 Hours 49 Minute 36 Seconds
	// '%y Year %m Month %d Day'                                    =>  1 Year 3 Month 14 Days
	// '%m Month %d Day'                                            =>  3 Month 14 Day
	// '%d Day %h Hours'                                            =>  14 Day 11 Hours
	// '%d Day'                                                     =>  14 Days
	// '%h Hours %i Minute %s Seconds'                              =>  11 Hours 49 Minute 36 Seconds
	// '%i Minute %s Seconds'                                       =>  49 Minute 36 Seconds
	// '%h Hours                                                    =>  11 Hours
	// '%a Days                                                     =>  468 Days
	//////////////////////////////////////////////////////////////////////
	function dateDifference($date_1, $date_2, $differenceFormat = '%a') {
		//	Datum größer als Datetime2
		$datetime1 = date_create($date_1);
		
		//	Datum kleiner als Datetime1
		$datetime2 = date_create($date_2);
	   
		$interval = date_diff($datetime1, $datetime2);
	   
		return $interval->format($differenceFormat);	   
	}
	
	function datePosition($today, $other) {
		$datetime1 = strtotime($today);
		$datetime2 = strtotime($other);
	   
		//	Heute ist größer als Other
		if($datetime1 > $datetime2) {
		   $interval = 1;
		//	Heute ist kleiner gleich als Other
		} elseif($datetime1 <= $datetime2) {
		   $interval = 0;
		}
	   
		return $interval;	   
	}
?>