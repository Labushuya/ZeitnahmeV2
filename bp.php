<?php
	//	SET ERROR LEVEL
	error_reporting(E_ALL);

	//	INCLUDE CHECKSSL
	include_once('includes/backend/functions.php');
	
	//	EXECUTE CHECKSSL
	checkIsSSL(true);
	
	//	Europäische Zeitzone (Berlin)
	date_default_timezone_set("Europe/Berlin");
	
	//	Starte Session
	session_start();
	
	//	Marker für Hinweisausgabe, dass Bordkarten Zugänge bereits bestehen
	$already_exists = 0;
	
	if(!isset($_SESSION['uid']) OR empty($_SESSION['uid']) OR $_SESSION['uid'] == "") {
		header("Location: process_logout.php");
	} else {
		//	Binde DB Connect ein
		require_once('includes/backend/dbc.php');
		
		//	Suche nach bereits vorhandenen Zugängen
		$select_bp = "SELECT * FROM `_tkev_acc_boardingpass` WHERE `eid` = '" . $_SESSION['uid'] . "' AND `finished` = 0 ORDER BY `uid` ASC";
		$result_bp = mysqli_query($mysqli, $select_bp);
		$numrow_bp = mysqli_num_rows($result_bp);
		
		//	Es sind bestehende Bordkarten Zugänge vorhanden
		if($numrow_bp > 0) {
			//	Marker für Hinweisausgabe, dass Bordkarten Zugänge bereits bestehen
			$already_exists = 1;
		}
	}
	
	//	Formular
	if(isset($_POST['create_bp'])) {
		//	Prüfvariable, falls Formular abgeschickt wurde (blendet "Bordkarten Zugänge existieren bereits"-Hinweis aus)
		$just_sent = 1;
		
		//	Erstelle Array für spätere Nutzung
		$eventdays = array();
		
		//	Erstelle Zähler für spätere Nutzung
		$insert_count = 0;
		
		unset($_POST['create_bp']);
		
		//	Prüfe auf Anzahl der Veranstaltungstage
		$select_event = "SELECT `eid`, `start`, `finish` FROM `_tkev_nfo_event` WHERE `eid` = '" . $_SESSION['uid'] . "' AND `active` = 1";
		$result_event = mysqli_query($mysqli, $select_event);
		$numrow_event = mysqli_num_rows($result_event);
		
		//	Wenn kein Event gefunden, leite weiter
		if($numrow_event == 0) {
			header("Location: create.php");
		//	Aktive Veranstaltung gefunden
		} else {
			$getrow_event = mysqli_fetch_assoc($result_event);
			
			//	Ermittle Anzahl der Veranstaltungstage
			$event_tage = dateDifference($getrow_event['finish'], $getrow_event['start'], '%a');
			
			//	Suche nach bereits vorhandenen Zugängen
			$select_bp = "SELECT * FROM `_tkev_acc_boardingpass` WHERE `eid` = '" . $_SESSION['uid'] . "' AND `finished` = 0 ORDER BY `uid` ASC";
			$result_bp = mysqli_query($mysqli, $select_bp);
			$numrow_bp = mysqli_num_rows($result_bp);
			
			//	Es sind bestehende Bordkarten Zugänge vorhanden
			if($numrow_bp > 0) {
				//	Lösche unvollständig angelegte Sequenz
				$delete = "DELETE FROM `_tkev_acc_boardingpass` WHERE `eid` = '" . $_SESSION['uid'] . "' AND `finished` = 0";
				$result = mysqli_query($mysqli, $delete);
			}
			
			//	Speichere mögliche Bordkarten Zugang Veranstaltungstage in Array
			for($i = 0; $i < ($event_tage + 1); $i++) {
				//	Beginne mit Start-Datum
				if($i == 0) {
					$eventdays[$i] = $getrow_event['start'];
				//	Beachte mit End-Datum
				} else if($i == $event_tage) {
					$eventdays[$i] = $getrow_event['finish'];
				//	Tage dazwischen
				} else {
					//	Ausgehend von Start-Datum, addiere derzeitige Zählervariable dazu
					$now = date('Y-m-d', strtotime($getrow_event['start'] . ' + ' . $i . ' days'));
					
					$eventdays[$i] = $now;
				}
			}
			
			//	Debugging
			/*
				echo "<pre>";
				print_r($eventdays);
				echo "</pre>";
				exit;
			*/
			
			//	Hole heutiges Datum
			$heute = date("Y-m-d", time());
			
			//	Speichere Bordkarten Zugänge
			for($i = 0; $i < count($eventdays); $i++) {
				//	Suche Kennungsdaten aller aktiven Teilnehmer
				$select_all_boardingpass = "SELECT `eid`, `uname`, `upass` FROM `_tkev_acc_boardingpass` WHERE `eid` = '" . $_SESSION['uid'] . "' AND `finished` = 0";
				$result_all_boardingpass = mysqli_query($mysqli, $select_all_boardingpass);
				$numrow_all_boardingpass = mysqli_num_rows($result_all_boardingpass);
				
				//	Erstelle Arrays mit bereits bestehenden Kennungsdaten
				$uname_pool = array();
				$upass_pool = array();
				
				//	Keine aktiven Teilnehmer gefunden
				if($numrow_all_boardingpass == 0) {
					//	Speichere je einen Leerwert in Pool-Arrays
					$uname_pool[] = "";
					$upass_pool[] = "";
				} else {
					//	Speichere Kennungsdaten für späteren Abgleich aus DB in Arrays
					while($getrow_all_boardingpass = mysqli_fetch_assoc($result_all_boardingpass)) {
						$uname_pool[] = $getrow_all_boardingpass['uname'];
						$upass_pool[] = $getrow_all_boardingpass['upass'];
					}
				}
				
				//	Erstelle zufällige Benutzerkennung
				$uname = rand(100, 999) . rand(100, 999);
						
				//	Erstelle zufälliges Passwort
				$upass = rand(18273645, 51486237);
				
				//	Prüfe auf Einmaligkeit
				while(in_array($uname, $uname_pool)) {
					//	Erstelle zufällige Benutzerkennung
					$uname = rand(100, 999) . rand(100, 999);
				}
				
				//	Prüfe auf Einmaligkeit
				while(in_array($upass, $upass_pool)) {
					//	Erstelle zufälliges Passwort
					$upass = rand(18273645, 51486237);
				}
				
				//	Prüfe, ob derzeitiges Datum noch nicht erreicht wurde, identisch ist, oder überschritten wurde
				$checkPosition = datePosition($heute, $eventdays[$i]);
				
				if($checkPosition == 1) {
					$neutralized = 1;
				} elseif($checkPosition == 0) {
					$neutralized = 0;
				}
				
				//	Passe Format des Datums an
				$raw_date = explode("-", $eventdays[$i]);
				$fin_date = $raw_date[2] . "." . $raw_date[1] . "." . $raw_date[0];
				
				$insert =	"
							INSERT INTO
								`_tkev_acc_boardingpass`(
									`uid`,
									`eid`,
									`uname`,
									`upass`,
									`whois`,
									`neutralized`,
									`eventdate`,
									`finished`,
									`logintime`
								)
							VALUES(
								NULL,
								'" . $_SESSION['uid'] . "',
								'" . $uname . "',
								'" . $upass . "',
								'BK Zugang für " . $fin_date . "',
								'" . $neutralized . "',
								'" . $eventdays[$i] . "',
								'0',
								'0'
							)
							";
				$result = mysqli_query($mysqli, $insert);
				
				//	Prüfe, ob Datensatz gespeichert wurde
				if(mysqli_affected_rows($mysqli) == 1) {
					$insert_count++;
				}
			}
			
			//	Status Ausgabe
			if(count($eventdays) == $insert_count AND count($eventdays) > 0) {
				$status_msg = 'Alle Bordkarten Zugänge wurden erfolgreich angelegt!';
				$status_color = "green";
			} else {
				$status_msg = 'Fehler beim Anlegen der Bordkarten Zugänge! Bitte erneut versuchen. Sollte dieses Problem bestehen, kontaktieren Sie bitte den Kundenservice!';
				$status_color = "#FF0000";
			}
		}
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<!--	SET TITLE		-->
		<title>zeitnah|me</title>
		
		<meta property="og:title" content="mind|sources" />
		<meta property="og:site_name" content="mind|sources" />
		<meta property="og:image" content="images/demo.jpg" />
		<meta property="og:image:type" content="image/jpeg" />
		<meta property="og:image:width" content="400" />
		<meta property="og:image:height" content="300" />
		<meta property="og:image:alt" content="Entwickler für webbasierte Onlinedienste" />
		<meta property="og:description" content="Entwickler für webbasierte Onlinedienste" />
		<meta property="og:url" content="https://mindsources.net" />
		<meta property="og:locale" content="de_DE" />
		<meta property="og:type" content="website" />
		
		<!--	INCLUDING ICO	-->
		<link rel="apple-touch-icon" sizes="57x57" href="images/fav/apple-icon-57x57.png">
		<link rel="apple-touch-icon" sizes="60x60" href="images/fav/apple-icon-60x60.png">
		<link rel="apple-touch-icon" sizes="72x72" href="images/fav/apple-icon-72x72.png">
		<link rel="apple-touch-icon" sizes="76x76" href="images/fav/apple-icon-76x76.png">
		<link rel="apple-touch-icon" sizes="114x114" href="images/fav/apple-icon-114x114.png">
		<link rel="apple-touch-icon" sizes="120x120" href="images/fav/apple-icon-120x120.png">
		<link rel="apple-touch-icon" sizes="144x144" href="images/fav/apple-icon-144x144.png">
		<link rel="apple-touch-icon" sizes="152x152" href="images/fav/apple-icon-152x152.png">
		<link rel="apple-touch-icon" sizes="180x180" href="images/fav/apple-icon-180x180.png">
		<link rel="icon" type="image/png" sizes="192x192"  href="images/fav/android-icon-192x192.png">
		<link rel="icon" type="image/png" sizes="32x32" href="images/fav/favicon-32x32.png">
		<link rel="icon" type="image/png" sizes="96x96" href="images/fav/favicon-96x96.png">
		<link rel="icon" type="image/png" sizes="16x16" href="images/fav/favicon-16x16.png">
		<link rel="manifest" href="images/fav/manifest.json">
		
		<!--	SET META		-->
		<meta name="msapplication-TileImage" content="images/fav/ms-icon-144x144.png">	
		<meta name="theme-color" content="#C0C0C0" />
		<meta name="msapplication-TileColor" content="#C0C0C0">
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<meta name="description" content="zeitnah|me - Das Datenzentrum im Motorsport!" />
		<meta name="author" content="Ultraviolent (www.mindsources.net)" />

		<meta charset="utf-8" />
		
		<meta http-equiv="X-UA-Compatible" content="ie=edge" />
		
		<!--	INCLUDING CSS LIB	-->
		<?php include_once("lib/css_library.html"); ?>
		
		<noscript>
			<div style="z-index: 99998; left: 0; position: fixed; text-align: center; width: 100%; height: 100%; background-color: rgba(48, 48, 48, 0.75);">
				<h2 style="line-height: 100%; padding-top: 25%; color: #fff;"><span style="border: 1px dotted #fff; padding: 25px 50px 25px 50px; background-color: rgba(255, 0, 0, 0.25)">Bitte aktivieren Sie JavaScript!</span></h2>
			</div>
		</noscript>
	</head>
	<body>
		<div id="preloader">
			<div id="status">
				<svg class="lds-curve-bars" width="200px" height="200px" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid" style="background: rgba(0, 0, 0, 0) none repeat scroll 0% 0%;">
					<g transform="translate(50,50)">
						<circle cx="0" cy="0" r="8.333333333333334" fill="none" stroke="#ffd700" stroke-width="4" stroke-dasharray="26.179938779914945 26.179938779914945">
							<animateTransform attributeName="transform" type="rotate" values="0 0 0;360 0 0" times="0;1" dur="1s" calcMode="spline" keySplines="0.2 0 0.8 1" begin="0" repeatCount="indefinite"/>
						</circle>
						<circle cx="0" cy="0" r="16.666666666666668" fill="none" stroke="#ffffff" stroke-width="4" stroke-dasharray="52.35987755982989 52.35987755982989">
							<animateTransform attributeName="transform" type="rotate" values="0 0 0;360 0 0" times="0;1" dur="1s" calcMode="spline" keySplines="0.2 0 0.8 1" begin="-0.2" repeatCount="indefinite"/>
						</circle>
						<circle cx="0" cy="0" r="25" fill="none" stroke="#c0c0c0" stroke-width="4" stroke-dasharray="78.53981633974483 78.53981633974483">
							<animateTransform attributeName="transform" type="rotate" values="0 0 0;360 0 0" times="0;1" dur="1s" calcMode="spline" keySplines="0.2 0 0.8 1" begin="-0.4" repeatCount="indefinite"/>
						</circle>
						<circle cx="0" cy="0" r="33.333333333333336" fill="none" stroke="#a09a8e" stroke-width="4" stroke-dasharray="104.71975511965978 104.71975511965978">
							<animateTransform attributeName="transform" type="rotate" values="0 0 0;360 0 0" times="0;1" dur="1s" calcMode="spline" keySplines="0.2 0 0.8 1" begin="-0.6" repeatCount="indefinite"/>
						</circle>
						<circle cx="0" cy="0" r="41.666666666666664" fill="none" stroke="#8e6516" stroke-width="4" stroke-dasharray="130.89969389957471 130.89969389957471">
							<animateTransform attributeName="transform" type="rotate" values="0 0 0;360 0 0" times="0;1" dur="1s" calcMode="spline" keySplines="0.2 0 0.8 1" begin="-0.8" repeatCount="indefinite"/>
						</circle>
					</g>
				</svg>
			</div>
		</div>
	
		<!-- Wrapper -->
		<div id="wrapper">
			<!-- Main -->
			<div id="main">
				<div class="inner">
					<!-- Header -->
					<header id="header">
						<a href="/" class="logo"><span style="font-weight: 800;">zeitnah|me</span> &ndash; Die Datenbank im Motorsport!</a>
		
						<!-- SOCIAL MEDIA -->
						<?php // include_once('includes/frontend/build/social_media.html'); ?>
					</header>
							
					<!-- CONTENT SECTIONS -->
					<section>
						<?php
							//	Hinweismeldung für abgesendetes Formular
							if(isset($status_msg) AND $status_msg != "") {
								echo	'
										<div id="status_msg_box" class="box" style="padding: .5em; border-color: ' . $status_color . '; text-align: justify;">
											<h4 style="color: ' . $status_color . '">
												<i class="fas fa-info-circle" style="margin-right: .5em;"></i>' . $status_msg . '
											</h4>
										</div>
										';
							}
							
							//	Marker für Hinweisausgabe, dass Bordkarten Zugänge bereits bestehen
							if($already_exists == 1 AND !isset($just_sent)) {
								echo	'
										<div id="status_msg_box_already_exists" class="box" style="padding: .5em; border-color: #8E6516; text-align: justify;">
											<h4 style="color: #8E6516">
												<i class="fas fa-info-circle" style="margin-right: .5em;"></i>Bordkarten Zugänge bereits erstellt. Erneutes Erstellen löscht alle bestehenden Bordkarten Zugänge und generiert diese vollständig neu.
											</h4>
										</div>
										';
							}
						?>
					
						<div class="box" style="border-color: #8e6516; background: rgba(255,255,255,.5);">
							<header class="main">
								<h1>Bordkarten Zugang erstellen</h1>
								<h4>
									<div class="box" style="border-color: #8e6516; color: #fff; background: rgb(61,68,73); text-align: justify;">
										Ein Zugang für jeden Tag der Veranstaltung. Dient der Erfassung von Strafsekunden zur Verrechnung der Ergebnisse.
									</div>
								</h4>
							</header>

							<!-- Form -->
							<form action="<?php echo esc_url($_SERVER['PHP_SELF']); ?>" method="POST" name="make_bp_form">
								<div>
									<div class="6u$ 12u$(xsmall)">
										<input type="submit" value="<?php if($already_exists == 1 AND !isset($just_sent)) { echo "Erneuern"; } else { echo "Erstellen"; } ?>" name="create_bp" class="special" />
									</div>
								</div>
							</form>
						</div>
					</section>
					
					<!-- PREMIUM ADDONS -->
					<!-- FLOATING BUTTON -->
					<?php // include_once('includes/frontend/addons/shortcuts.html'); ?>
				</div>
			</div>

			<!-- SIDEBAR -->
			<div id="sidebar">
				<div class="inner">					
					<!-- SEARCH -->
					<?php // include_once('includes/frontend/build/search.html'); ?>
						
					<!-- Menu -->
					<nav id="menu">
						<header class="major">
							<h2>Menu</h2>
						</header>
								
						<!-- MENU -->
						<?php include_once('includes/frontend/build/menu.php'); ?>
								
						<p>
							<!-- INCLUDE LOGIN SECTION -->
							<div class="container">
								<!-- MODAL LOGIN -->
								<?php include_once('includes/frontend/build/login.php'); ?>
							</div>
						</p>
					</nav>
							
					<!-- MISC SECTIONS -->
					<!-- PICTURE SECTION -->
					<?php // include_once('includes/frontend/build/picture.html'); ?>
					
					<!-- CONTACT SECTION -->
					<?php include_once('includes/frontend/build/contact.html'); ?>

					<!-- FOOTER SECTION -->
					<?php include_once('includes/frontend/build/footer.php'); ?>
				</div>
			</div>
		</div>
				
		<!--	INCLUDING JSX LIB	-->
		<?php include_once("lib/jsx_library.html"); ?>
		<script>
			$(document).ready(function() {
				//	Blende Hinweisfeld von abgesendetem Formular aus
				$("#status_msg_box").click(function() {
					$("#status_msg_box").slideUp(500);
				});
				
				//	Oder blende dieses automatisch nach 5 Sekunden aus
				setTimeout(function() {
					$("#status_msg_box").slideUp(500);
				}, 5000);
				
				//	Blende Hinweisfeld von abgesendetem Formular aus
				$("#status_msg_box_already_exists").click(function() {
					$("#status_msg_box_already_exists").slideUp(500);
				});
				
				//	Oder blende dieses automatisch nach 5 Sekunden aus
				setTimeout(function() {
					$("#status_msg_box_already_exists").slideUp(500);
				}, 10000);
			});
		</script>
	</body>
</html>