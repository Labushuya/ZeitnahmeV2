<?php
	//	Hole Zeitstempel des heutigen Tages
	$datetime = time();

	if(isset($_SESSION['uid']) AND $_SESSION['uid'] != "") {
		echo	'
				<ul>
					<li><a href="news.php"><i class="icon fas fa-inbox"></i> Home</a></li>
				';
				
		require_once('includes/backend/dbc.php');
		
		//	Suche in Datenbank nach aktiven Veranstaltung
		$select = "SELECT `eid`, `title`, `organizer`, `type`, `start`, `finish`, `reference`, `calculation`, `active`  FROM `_tkev_nfo_event` WHERE `eid` = '" . $_SESSION['uid'] . "' AND `active` = '1' AND `finish` > '" . $datetime . "'";
		$result = mysqli_query($mysqli, $select);
		$numrow = mysqli_num_rows($result);
		
		//	Wenn aktive Veranstaltung gefunden wurde, ändere Menüansicht
		if($numrow == 1) {
			//	Marker für eindeutiges Event-Ergebnis
			$event = 1;
		//	Deaktiviere alle abgelaufenen Veranstaltungen
		} elseif($numrow > 1) {	
			while($getrow = mysqli_fetch_assoc($result)) {
				if($datetime > $getrow['finish']) {
					//	Deaktiviere Veranstaltung
					$update =	"
								UPDATE
									`_tkev_nfo_event`
								SET
									`active` = '0'
								WHERE
									`eid` = '" . $_SESSION['uid'] . "' 
								AND
									`finish` < '" . $datetime . "'
								AND 
									`active` = '1'
								";
					mysqli_query($mysqli, $update);
					
					//	Suche erneut solange nach aktiver Veranstaltung, bis Ergebnis 1 entspricht
					$select = "SELECT `eid`, `title`, `organizer`, `type`, `start`, `finish`, `reference`, `calculation`, `active`  FROM `_tkev_nfo_event` WHERE `eid` = '" . $_SESSION['uid'] . "' AND `active` = '1' AND `finish` > '" . $datetime . "'";
					$result = mysqli_query($mysqli, $select);
					$numrow = mysqli_num_rows($result);
					
					if($numrow == 1) {
						//	Marker für eindeutiges Event-Ergebnis
						$event = 1;
						
						//	Beende Schleife
						continue;
					}
				}
			}
		} else {
			$event = 0;
		}
		
		if($event == 1) {
			echo	'
					<li>
						<span class="opener"><i class="icon fa-sitemap"></i> Meine Veranstaltung</span>
						<ul>
							<li><a href="landing.php"><i class="fas fa-user-alt"></i> Auswerter</a></li>
					';
					
			//	Suche nach Ergebnissen und füge Menüpunkt hinzu, sofern vorhanden
			$select = "SELECT * FROM `_tkev_nfo_results` WHERE `eid` = '" . $_SESSION['uid'] . "' AND `finished` = '0'";
			$result = mysqli_query($mysqli, $select);
			$numrow = mysqli_num_rows($result);
			
			if($numrow > 0) {
				echo	'
							<li><a href="results.php"><i class="fas fa-history"></i> <strong style="color: #8E6516;">Ergebnisse</strong></a></li>
						';
			}
			
							//	<li><a href="overview.php"><i class="icon far fa-calendar-alt"></i> Veranstalter</a></li>
			echo	'
							<li><a href="rd.php"><i class="icon fa-flag-checkered"></i> Prüfung(en)</a></li>
							<li><a href="zm.php"><i class="fas fa-stopwatch"></i> Zeitnehmer</a></li>
							<li><a href="bp.php"><i class="fas fa-calendar"></i> Bordkarten</a></li>
							<li><a href="tm.php"><i class="icon fa-car"></i> Teilnehmer</a></li>
						</ul>
					</li>
					';
		} elseif($event == 0) {
			echo	'
					<li><a href="create.php"><i class="icon fa-plus-circle"></i> Veranstaltung erstellen</a></li>
					';
		}
		
		//	Suche in Datenbank nach archivierten Veranstaltungen
		$select = "SELECT `eid`, `title`, `organizer`, `type`, `start`, `finish`, `reference`, `calculation`, `active`  FROM `_tkev_nfo_event` WHERE `eid` = '" . $_SESSION['uid'] . "' AND `active` = '0' AND `finish` < '" . $datetime . "'";
		$result = mysqli_query($mysqli, $select);
		$numrow = mysqli_num_rows($result);
		
		if($numrow > 0) {
			echo	'
					<li><a href="create.php"><i class="fas fa-archive"></i></i> Archiv</a></li>
					';
		}
		
		echo	'
					<li>
						<span class="opener"><i class="icon fas fa-question-circle"></i> Hilfe</span>
						<ul>
							<li><a href="#">Nutzung</a></li>
							<li><a href="#">Kundenservice</a></li>
							<li><a href="#">FAQ</a></li>
						</ul>
					</li>
					<li><a href="about.php"><i class="icon fas fa-info-circle"></i> Über uns</a></li>
					<li><a href="impressum.php"><i class="icon fa-book"></i> Impressum</a></li>
					<li><a href="disclaimer.php"><i class="fas fa-university"></i> Disclaimer</a></li>
					<li><a href="datenschutz.php"><i class="fas fa-shield-alt"></i> Datenschutz</a></li>
				</ul>
				';
	} else {
		echo	'
				<ul>
					<li><a href="index.php"><i class="icon fa-home"></i> Home</a></li>
					<li style="color: #b68c2f;"><a href="register.php"><i class="icon fa-user-plus"></i> Registrieren</a></li>
					<li>
						<span class="opener"><i class="icon fas fa-question-circle"></i> Hilfe</span>
						<ul>
							<li><a href="#">Nutzung</a></li>
							<li><a href="#">Kundenservice</a></li>
							<li><a href="#">FAQ</a></li>
						</ul>
					</li>
					<li><a href="#"><i class="icon fas fa-info-circle"></i> Über uns</a></li>
					<li><a href="impressum.php"><i class="icon fa-book"></i> Impressum</a></li>
					<li><a href="#"><i class="fas fa-university"></i> Disclaimer</a></li>
					<li><a href="datenschutz.php"><i class="fas fa-shield-alt"></i> Datenschutz</a></li>
				</ul>
				';
	}
?>
