<?php error_reporting(E_ALL);
	//	Binde Functions ein
	include_once 'functions.php';
	
	//	Binde DB Connect ein
	include_once 'dbc.php';
	
	//	Starte Session
	session_start();
	
	//	Lege Leervariablen fest
	$primary = 0;
	$secondary = 0;
	 
	if(isset($_POST["rd"]) && !empty($_POST["rd"])) {
		// 	Bereinige Übergabeparameter
		$rid = mysqli_real_escape_string($mysqli, $_POST['rd']);
		
		//	Suche nach Anzahl der Prüfungen für diese Veranstaltung, um Count zu ermitteln
		$select_wpt = "SELECT * FROM `_tkev_nfo_exam` WHERE `eid` = '" . $_SESSION['uid'] . "' AND `active` = '1'";
		$result_wpt = mysqli_query($mysqli, $select_wpt);
		$numrow_wpt = mysqli_num_rows($result_wpt);
		
		$select_wpt_sz = "SELECT * FROM `_tkev_nfo_exam_sz` WHERE `eid` = '" . $_SESSION['uid'] . "' AND `active` = '1'";
		$result_wpt_sz = mysqli_query($mysqli, $select_wpt_sz);
		$numrow_wpt_sz = mysqli_num_rows($result_wpt_sz);
		
		//	Lösche Prüfungen, die noch aktiv sind (inaktive gelten als archiviert)
        $delete_wpt = "DELETE FROM `_tkev_nfo_exam` WHERE `rid` = '" . $rid . "' AND `eid` = '" . $_SESSION['uid'] . "' AND `active` = '1'";
        mysqli_query($mysqli, $delete_wpt);
		
		//	Prüfe, ob alle Datensätze gelöscht wurden
		if(mysqli_affected_rows($mysqli) == $numrow_wpt) {
			$primary = 1;
		}
		
		//	Lösche zugehörige Sollzeiten der einzelnen, aktiven Prüfungen
        $delete_wptsz = "DELETE FROM `_tkev_nfo_exam_sz` WHERE `rid` = '" . $rid . "' AND `eid` = '" . $_SESSION['uid'] . "' AND `active` = '1'";
        mysqli_query($mysqli, $delete_wptsz);
		
		//	Prüfe, ob zugehörige Sollzeiten vollständig gelöscht wurden
		if(mysqli_affected_rows($mysqli) == $numrow_wpt_sz) {
			$secondary = 1;
		}
		
		if($primary == $secondary) {
			echo 'Prüfung wurde <strong>vollständig</strong> gelöscht!';
		} elseif($primary > $secondary) {
			echo '<strong>Primäre</strong> Prüfungsdaten wurden gelöscht!';
		} elseif($primary < $secondary) {
			echo '<strong>Sekundäre</strong> Prüfungsdaten wurden gelöscht!';
		}
	}
?>