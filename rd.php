<?php
	//	SET ERROR LEVEL
	error_reporting(E_ALL);

	//	Binde Functions ein
	include_once('includes/backend/functions.php');
	
	//	EXECUTE CHECKSSL
	checkIsSSL(true);
	
	//	Europäische Zeitzone (Berlin)
	date_default_timezone_set("Europe/Berlin");
	
	//	Starte Session
	session_start();
	
	//	Setze Leervariable für spätere Nutzung
	$error = "modal.style.display = \"none\";";
	
	if(!isset($_SESSION['uid']) OR empty($_SESSION['uid']) OR $_SESSION['uid'] == "") {
		header("Location: process_logout.php");
	} else {
		//	Binde DB Connect ein
		require_once('includes/backend/dbc.php');
		
		//	Suche nach letzter Prüfungsnummer
		$select_pn = "SELECT `eid`, `rid` FROM `_tkev_nfo_exam` WHERE `eid` = '" . $_SESSION['uid'] . "' ORDER BY `rid` DESC LIMIT 0, 1";
		$result_pn = mysqli_query($mysqli, $select_pn);
		$numrow_pn = mysqli_num_rows($result_pn);
		
		if($numrow_pn > 0) {
			$getrow_pn = mysqli_fetch_assoc($result_pn);
			$neue_pruefungsnummer = $getrow_pn['rid'] + 1;
		} else {
			$neue_pruefungsnummer = 1;
		}
		
		//	Suche nach Start und Enddatum für Stichtag der Prüfung
		$select_stichtag = "SELECT `eid`, `start`, `finish` FROM `_tkev_nfo_event` WHERE `eid` = '" . $_SESSION['uid'] . "' AND `active` = '1'";
		$result_stichtag = mysqli_query($mysqli, $select_stichtag);
		$numrow_stichtag = mysqli_num_rows($result_stichtag);
		$getrow_stichtag = mysqli_fetch_assoc($result_stichtag);
		
		$start = $getrow_stichtag['start'];
		$started = explode("-", $start);
		
		$end = $getrow_stichtag['finish'];
		$ended = explode("-", $end);
	}
	
	//	Verarbeite Formulardaten
	if(isset($_POST['create_rd'])) {
		//	Zählervariable für erfolgreiches Anlegen
		$pts = 0;
		
		$select_rdtype = "SELECT `eid`, `type` FROM `_tkev_nfo_event` WHERE `eid` = '" . $_SESSION['uid'] . "' AND `active` = '1'";
		$result_rdtype = mysqli_query($mysqli, $select_rdtype);
		$numrow_rdtype = mysqli_num_rows($result_rdtype);
		$getrow_rdtype = mysqli_fetch_assoc($result_rdtype);
		
		$rundentyp			= $getrow_rdtype['type'];
		$zeiteneingabe		= mysqli_real_escape_string($mysqli, $_POST['zeiteneingabe']);
		$pruefungsnummer	= mysqli_real_escape_string($mysqli, $_POST['pruefungsnummer']);
		$datum_edp			= mysqli_real_escape_string($mysqli, $_POST['datum_ende_der_pruefung']);
		
		if(isset($_POST['zwischenzeit_anzahl'])) {
			$zwischenzeit_anzahl	= mysqli_real_escape_string($mysqli, utf8_encode($_POST['zwischenzeit_anzahl']));
		} else {
			$zwischenzeit_anzahl	= 0;
		}
		
		$_POST['sollzeit'] = array_map(array($mysqli, 'real_escape_string'), $_POST['sollzeit']);
			
		for($i = 0; $i < count($_POST['sollzeit']); $i++) {
			$sollzeit[$i] = $_POST['sollzeit'][$i];
		}
		
		//	Konvertiere Datum zu Zeit und verbinde mit Zeit Parameter
		$datum_edp = convert_to_db($datum_edp);
		
		//	Setze POST Parameter zurück
		unset($_POST['create_rd']);
		unset($_POST['zeiteneingabe']);
		unset($_POST['pruefungsnummer']);
		unset($_POST['datum_ende_der_pruefung']);
		unset($_POST['sollzeit']);
		
		//	Prüfe zuerst, ob übergebene Runden-ID bereits verwendet wurde und führe Auto-Zuweisung durch, wenn nötig
		$select_round_number = "SELECT `eid`, `rid` FROM `_tkev_nfo_exam` WHERE `eid` = '" . $_SESSION['uid'] . "' AND `rid` = '" . $pruefungsnummer . "'";
		$result_round_number = mysqli_query($mysqli, $select_round_number);
		$numrow_round_number = mysqli_num_rows($result_round_number);
							
		//	Runden-ID wurde bereits verwendet
		if($numrow_round_number > 0) {
			//	Weise neuen Wert durch Prüfen der Gesamtanzahl an Runden + 1 zu
			$select_round_number_new = "SELECT `eid`, `rid` FROM `_tkev_nfo_exam` WHERE `eid` = '" . $_SESSION['uid'] . "'";
			$result_round_number_new = mysqli_query($mysqli, $select_round_number_new);
			$numrow_round_number_new = mysqli_num_rows($result_round_number_new);
			$pruefungsnummer = $numrow_round_number_new + 1;
		}
		
		if($zeiteneingabe == 1) {
			$gesamtpositionen = intval($zwischenzeit_anzahl) + 2;
		} elseif($zeiteneingabe == 2) {
			$gesamtpositionen = 1;
		}
		
		
		$insert_rd	= 	"
						INSERT INTO
							`_tkev_nfo_exam`(
								`id`,
								`eid`,
								`rid`,
								`type`,
								`execute`,
								`positions`,
								`reference`,
								`mode`,
								`abort`,
								`finished`,
								`active`
							)
						VALUES(
							NULL,
							'" . $_SESSION['uid'] . "',
							'" . $pruefungsnummer . "',
							'" . $rundentyp . "',
							'" . $datum_edp . "',
							'" . $gesamtpositionen . "',
							'0',
							'" . $zeiteneingabe . "',
							'0',
							'0',
							'1'
						)
						";			 
		mysqli_query($mysqli, $insert_rd);
		
		if(mysqli_affected_rows($mysqli) > 0) {
			$pts++;
		}
		
		//	Prüfe, ob mehr als ein Element in Array vorhanden
		if(count($sollzeit) > 1) {
			// LOOP THROUGH SZ POST
			for($i = 0; $i < count($sollzeit); $i++) {
				//	Initiativzähler für Zuweisung
				$j = $i + 1;
										
				$insert_sz	= 	"
								INSERT INTO
									`_tkev_nfo_exam_sz`(
										`id`,
										`eid`,
										`rid`,
										`sid`,
										`sollzeit`,
										`active`
									)
								VALUES(
									NULL,
									'" . $_SESSION['uid'] . "',
									'" . $pruefungsnummer . "',
									'" . $j . "',
									'00:" . $sollzeit[$i] . "',
									'1'
								)";			 
				mysqli_query($mysqli, $insert_sz);
										
				if(mysqli_affected_rows($mysqli) > 0) {
					$pts++;
				}
			}
		} elseif(count($sollzeit) == 1) {
			$insert_sz	= 	"INSERT INTO
									`_tkev_nfo_exam_sz`(
										`id`,
										`eid`,
										`rid`,
										`sid`,
										`sollzeit`,
										`active`
									)
								VALUES(
									NULL,
									'" . $_SESSION['uid'] . "',
									'" . $pruefungsnummer . "',
									'1',
									'00:" . $sollzeit[0] . "',
									'1'
								)";		 
			mysqli_query($mysqli, $insert_sz);
									
			if(mysqli_affected_rows($mysqli) > 0) {
				$pts++;
			}
		}
		
		//	Prüfe abhängig von Anzahl der Sollzeit-Elemente, ob INSERT erfolgreich war
		if($pts < count($sollzeit)) {
			$error = "modal.style.display = \"block\";";
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
		<style>
			.not-active {
				pointer-events: none;
				cursor: default;
				text-decoration: none;
				color: black;
				background: transparent !important;
				border: none;
				color: #8e6516 !important;
			}
			
			/* The Modal (background) */
			.modal {
				display: none; /* Hidden by default */
				position: fixed; /* Stay in place */
				z-index: 1; /* Sit on top */
				left: 0;
				top: 0;
				width: 100%; /* Full width */
				height: 100%; /* Full height */
				overflow: auto; /* Enable scroll if needed */
				background-color: rgb(0,0,0); /* Fallback color */
				background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
			}

			/* Modal Content/Box */
			.modal-content {
				background-color: #fefefe;
				margin: 15% auto; /* 15% from the top and centered */
				padding: 20px;
				border: 1px solid #888;
				width: 80%; /* Could be more or less, depending on screen size */
			}

			/* The Close Button */
			.close {
				color: #aaa;
				float: right;
				font-size: 28px;
				font-weight: bold;
			}

			.close:hover,
			.close:focus {
				color: black;
				text-decoration: none;
				cursor: pointer;
			} 
			
			/* Tooltip container */
			.tooltip {
				position: relative;
				display: inline-block;
				// border-bottom: 1px dotted black;
				color: #8e6516;
			}

			.tooltip .tooltiptext {
				visibility: hidden;
				width: 120px;
				background-color: black;
				color: #fff;
				text-align: center;
				border-radius: 6px;
				padding: 5px 0;
				position: absolute;
				z-index: 1;
				top: 150%;
				left: 50%;
				margin-left: -60px;
				
				opacity: 0;
				transition: opacity 1s;
			}

			.tooltip .tooltiptext::after {
				content: "";
				position: absolute;
				bottom: 100%;
				left: 50%;
				margin-left: -5px;
				border-width: 5px;
				border-style: solid;
				border-color: transparent transparent black transparent;
			}

			.tooltip:hover .tooltiptext {
				visibility: visible;
				opacity: 1;
			}
		</style>	
		
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
		
		<!-- The Modal -->
		<div id="myModal" class="modal">

		  <!-- Modal content -->
		  <div class="modal-content">
			<span class="close">&times;</span>
			<p>Some text in the Modal..</p>
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
							$select_rdtype = "SELECT `eid`, `type` FROM `_tkev_nfo_event` WHERE `eid` = '" . $_SESSION['uid'] . "' AND `active` = '1'";
							$result_rdtype = mysqli_query($mysqli, $select_rdtype);
							$numrow_rdtype = mysqli_num_rows($result_rdtype);
							$getrow_rdtype = mysqli_fetch_assoc($result_rdtype);
						
							//	Suche nach bereits erstellten Prüfungen und liste diese auf
							$select_rd = "SELECT `id`, `eid`, `rid`, `execute`, `positions`, `reference`, `mode`, `abort`, `finished`, `active` FROM `_tkev_nfo_exam` WHERE `eid` = '" . $_SESSION['uid'] . "' AND `active` = '1' ORDER BY `rid` ASC";
							$result_rd = mysqli_query($mysqli, $select_rd);
							$numrow_rd = mysqli_num_rows($result_rd);
							
							if($numrow_rd > 0) {
								echo	'
										<header class="main">
											<h1>Prüfungen</h1>
										</header>
								
										<div class="12u$">
											<div class="table-wrapper">
												<table>
													<thead>
														<tr>
															<th>P. Nr.</th>
															<th>Prüfungsdatum</th>
															<th>Positionen<div class="tooltip"><sup>[?]</sup><span class="tooltiptext">+ Start und Ziel</span></div></th> 
															<th>Referenzlauf</th>
															<th>Zeiteneingabe</th>
															<th>Status</th>
														</tr>
													</thead>
													<tbody>
										';
								
								while($getrow_rd = mysqli_fetch_assoc($result_rd)) {
									$raw_date = explode("-", $getrow_rd['execute']);
									$beginn = $raw_date[2] . "." . $raw_date[1] . "." . $raw_date[0];
									
									if($getrow_rd['reference'] == 0) {
										$reference = "Nein";
									} else if($getrow_rd['reference'] == 1) {
										$reference = "Ja";
									}
									
									if($getrow_rd['mode'] == 1) {
										$mode = "Regulär";
									} else if($getrow_rd['mode'] == 2) {
										$mode = "Fahrtzeit";
									}
									
									if($getrow_rd['abort'] == 0) {
										if(date("Y-m-d", time()) < $getrow_rd['execute'] OR $getrow_rd['finished'] == 1) {
											$aktiv = "<i class=\"fas fa-check\" style=\"color: green;\"> laufend</i>";
										} elseif(date("Y-m-d", time()) >= $getrow_rd['execute'] OR $getrow_rd['finished'] == 0) {
											$aktiv = "<i class=\"fas fa-flag-checkered\" style=\"color: black;\"> beendet</i>";
										}
									} elseif($getrow_rd['abort'] == 1) {
										$aktiv = "<i class=\"fas fa-ban\" style=\"color: red;\"> neutralisiert</i>";
									}
									
									
									if($getrow_rd['positions'] > 2) {
										$positions = ($getrow_rd['positions'] - 2) . " [ +2 ]";
									} else {
										$positions = $getrow_rd['positions'];
									}
									
									echo	'
														<tr id="row_' . $getrow_rd['rid'] . '">
															<td><span class="rd_type">' . $getrow_rdtype['type'] . "</span>" . $getrow_rd['rid'] . '</td>
															<td>' . $beginn . '</td>
															<td>' . $positions . '</td>
															<td>' . $reference . '</td>
															<td>' . $mode . '</td>
															<td id="state_' . $getrow_rd['rid'] . '">' . $aktiv . '</td>
														</tr>
											';
								}
								
								mysqli_free_result($result_rd);
								
								echo				'
													</tbody>
												</table>	
											</div>	
										</div>	
													';
							}
						?>
					
						<div class="box" style="border-color: #8e6516; background: rgba(255,255,255,.5);">
							<header class="main">
								<h1 id="make_rd">Prüfungen erstellen <i id="create" style="font-size: 0.25em;" class="far fa-plus-square"></i></h1>
								<h4 id="make_rd_hint" style="display: none;">
									<div class="box" style="border-color: #8e6516; color: #fff; background: rgb(61,68,73); text-align: justify;">
										Prüfungen erstellen und Veranstaltungsrelevante Parameter festlegen.
									</div>
								</h4>
							</header>

							<!-- Form -->
							<form action="<?php echo esc_url($_SERVER['PHP_SELF']); ?>" method="POST" name="make_stichtag_form">
								<div class="row uniform make_rd" id="appending_container" style="display: none;">
									<div class="6u$ 12u$(xsmall)">
										<div class="select-wrapper">
											<select name="zeiteneingabe" id="zeiteneingabe" required>
												<option value="" selected="selected" disabled="disabled">Zeiteneingabe</option>
												<option value="1">Regulär</option>
												<option value="2">Fahrtzeit</option>
											</select>
										</div>
									</div>
									<div class="5u 10u(xsmall)"><input type="text" class="input not-active" name="desc_pruefungsnummer" id="desc_pruefungsnummer" value="Aktuelle Prüfungsnummer" disabled /></div>
									<div class="1u$ 2u$(xsmall)">
										<input type="text" class="input" name="pruefungsnummer" id="pruefungsnummer" value="<?php if(isset($pruefungsnummer)) { echo $pruefungsnummer + 1; } else { echo $neue_pruefungsnummer; } ?>" placeholder="<?php if(isset($pruefungsnummer)) { echo $pruefungsnummer + 1; } else { echo $neue_pruefungsnummer; } ?>" required />
									</div>
									<div class="3u 6u(xsmall)"><input type="text" class="input not-active" name="desc_ende_der_pruefung" id="desc_ende_der_pruefung" value="Beginn" disabled /></div>
									<div class="3u$ 6u$(xsmall)">
										<input type="text" class="input" name="datum_ende_der_pruefung" id="datum_ende_der_pruefung" placeholder="TT.MM.JJJJ" pattern="^((0[1-9]|[1-2][0-9]|3[0-1]).(0[1-9]|1[0-2]).([1-9]{1}[0-9]{3}))$" required />
									</div>
									<div class="3u 6u(xsmall) container_zeiteneingabe">
										<div class="select-wrapper">
											<select name="zwischenzeit" id="zwischenzeit" required>
												<option value="" selected="selected" disabled="disabled">Zwischenzeit?</option>
												<option value="1">Nein</option>
												<option value="2">Ja</option>
											</select>
										</div>
									</div>
									<div class="3u$ 6u$(xsmall) container_zeiteneingabe">
										<div class="select-wrapper">
											<select name="zwischenzeit_anzahl" id="zwischenzeit_anzahl" class="not-active" required disabled>
												<option value="" selected="selected" disabled="disabled"></option>
												<option value="1">1</option>
												<option value="2">2</option>
												<option value="3">3</option>
												<option value="4">4</option>
												<option value="5">5</option>
											</select>
										</div>
									</div>
									<div class="4u 8u(xsmall) basic_element"><input type="text" class="input not-active sollzeit_basic_desc" name="sollzeit[]" value="Sollzeit Start / Ziel" disabled /></div>
									<div class="2u$ 4u$(xsmall) basic_element">
										<input type="text" class="input sollzeit_basic" name="sollzeit[]" placeholder="MM:SS,00" required />
									</div>
								</div>
								<div class="row uniform make_rd" style="display: none;">
									<div class="3u 6u(xsmall)">
										<input type="reset" value="Zurücksetzen" />
									</div>
									<div class="3u$ 6u$(xsmall)" align="right">
										<input type="submit" value="Erstellen" id="create_rd" name="create_rd" class="special" />
									</div>
								</div>
							</form>
						</div>
						
						<div class="box" style="border-color: #8e6516; background: rgba(255,255,255,.5);">
							<header class="main">
								<h1 id="edit_rd">Prüfungen verwalten <i id="manage" style="font-size: 0.25em;" class="far fa-plus-square"></i></h1>
								<h4 id="edit_rd_hint" style="display: none;">
									<div class="box" style="border-color: #8e6516; color: #fff; background: rgb(61,68,73); text-align: justify;">
										Allgemeine Prüfungsbezeichnung ändern oder bestehende Prüfungen löschen.
									</div>
								</h4>
							</header>

							<!-- Form -->
							<form action="process_editrd.php" method="POST" name="edit_stichtag_form">
								<div class="row uniform edit_rd" style="display: none;">
									<div class="6u$ 12u$(xsmall)">
										<h3>Prüfungsbezeichnung ändern</h3>
										<div class="select-wrapper">
											<select name="edit_bezeichnung" id="edit_bezeichnung" required>
												<?php
													//	Suche nach Rundenbezeichnung für Änderung
													$select_rdtype = "SELECT `eid`, `type` FROM `_tkev_nfo_event` WHERE `eid` = '" . $_SESSION['uid'] . "' AND `active` = '1'";
													$result_rdtype = mysqli_query($mysqli, $select_rdtype);
													$numrow_rdtype = mysqli_num_rows($result_rdtype);
													$getrow_rdtype = mysqli_fetch_assoc($result_rdtype);
													
													if($numrow_rdtype > 0) {
														echo '<option value="' . $getrow_rdtype['type'] . '" selected="selected" disabled="disabled">Ändern auf ..</option>';
														
														if($getrow_rdtype['type'] == "GP") {
															echo '<option value="SP">SP</option>';
															echo '<option value="WP">WP</option>';
														} elseif($getrow_rdtype['type'] == "SP") {
															echo '<option value="GP">GP</option>';
															echo '<option value="WP">WP</option>';
														} elseif($getrow_rdtype['type'] == "WP") {
															echo '<option value="GP">GP</option>';
															echo '<option value="SP">SP</option>';
														}													
													} else {
														echo '<option value="" selected="selected" disabled="disabled">Prüfung anlegen!</option>';
													}
												?>
											</select>
										</div>
									</div>
									<div class="6u$ 12u$(xsmall)">
										<h3>Prüfung(en) löschen</h3>
										<div class="select-wrapper">
											<select name="delete_bezeichnung" id="delete_bezeichnung" required>
												<?php
													//	Suche nach Runden für Änderung
													$select_rds = "SELECT * FROM `_tkev_nfo_exam` WHERE `eid` = '" . $_SESSION['uid'] . "' AND `active` = '1' ORDER BY `rid` ASC";
													$result_rds = mysqli_query($mysqli, $select_rds);
													$numrow_rds = mysqli_num_rows($result_rds);
													
													if($numrow_rds > 0) {
														echo '<option value="" selected="selected" disabled="disabled">Bitte wählen</option>';
														
														while($getrow_rds = mysqli_fetch_assoc($result_rds)) {
															echo '<option value="' . $getrow_rds['rid'] . '">' . $getrow_rdtype['type'] . $getrow_rds['rid'] . '</option>';
														}												
													} else {
														echo '<option value="" selected="selected" disabled="disabled">Prüfung anlegen!</option>';
													}
												?>
											</select>
										</div>
									</div>
								</div>
								<div class="row uniform edit_rd" style="display: none;">
									<div id="status_msg" class="6u$ 12u$(xsmall)" style="display: none; text-align: center;"></div>
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
			// Get the modal
			var modal = document.getElementById('myModal');

			// Get the button that opens the modal
			var btn = document.getElementById("myBtn");

			// Get the <span> element that closes the modal
			var span = document.getElementsByClassName("close")[0];

			// When the user clicks on the button, open the modal
			<?php echo $error; ?>

			// When the user clicks on <span> (x), close the modal
			span.onclick = function() {
				modal.style.display = "none";
			}

			// When the user clicks anywhere outside of the modal, close it
			window.onclick = function(event) {
				if (event.target == modal) {
					modal.style.display = "none";
				}
			} 
		
			$(document).ready(function() {	
				$("#edit_bezeichnung").change(function() {
					var bezeichnung = $("#edit_bezeichnung").val();
					
					$.ajax({
						type: 'POST',
						url: 'includes/backend/change_rdtype.php',
						data: 'bezeichnung=' + bezeichnung,
						success: function(html){
							$('#status_msg').fadeIn(500).delay(2500).fadeOut(500).html(html);
							var rd_type = $("#edit_bezeichnung").find("option:selected").val();
							
							$(".rd_type").html(rd_type);
							
							$.ajax({
								type: 'POST',
								url: 'includes/backend/refresh_rdselect.php',
								data: 'bezeichnung=' + bezeichnung,
								success: function(data) {
									$("#edit_bezeichnung").html(data);
									$("#edit_bezeichnung").selectmenu('refresh');
								}
							});
						}
					}); 
				});
				
				$("#delete_bezeichnung").change(function() {
					var round = $("#delete_bezeichnung").val();
					
					$.ajax({
						type: 'POST',
						url: 'includes/backend/delete_rd.php',
						data: 'rd=' + round,
						success: function(html){
							$('#status_msg').fadeIn(500).delay(2500).fadeOut(500).html(html);
							var rd_type = $("#delete_bezeichnung").find("option:selected").val();
							
							$("#row_" + round).slideUp(500);
							$("#row_" + round).html("");
							
							$.ajax({
								type: 'POST',
								url: 'includes/backend/refresh_rdselect.php',
								data: 'bezeichnung=' + round,
								success: function(data) {
									$("#delete_bezeichnung").html(data);
									$("#delete_bezeichnung").selectmenu('refresh', true);
								}
							});
						}
					}); 
				});
			
				$("#make_rd").click(function() {
					if($(".make_rd").is(":visible")) {
						$(".make_rd").slideUp(500);
						$("#make_rd_hint").slideUp(500);
						$(".edit_rd").slideDown(500);
						$("#edit_rd_hint").slideDown(500);
						$("#create").removeClass("fa-minus-square");
						$("#create").addClass("fa-plus-square");
						$("#manage").removeClass("fa-plus-square");
						$("#manage").addClass("fa-minus-square");
					} else if($(".make_rd").is(":hidden")) {
						$(".make_rd").slideDown(500);
						$("#make_rd_hint").slideDown(500);
						$(".edit_rd").slideUp(500);
						$("#edit_rd_hint").slideUp(500);
						$("#manage").removeClass("fa-minus-square");
						$("#manage").addClass("fa-plus-square");
						$("#create").removeClass("fa-plus-square");
						$("#create").addClass("fa-minus-square");
					}			
				});
				
				$("#edit_rd").click(function() {
					if($(".edit_rd").is(":visible")) {
						$(".edit_rd").slideUp(500);
						$("#edit_rd_hint").slideUp(500);
						$(".make_rd").slideDown(500);
						$("#make_rd_hint").slideDown(500);
						$("#manage").removeClass("fa-minus-square");
						$("#manage").addClass("fa-plus-square");
						$("#create").removeClass("fa-plus-square");
						$("#create").addClass("fa-minus-square");
					} else if($(".edit_rd").is(":hidden")) {
						$(".edit_rd").slideDown(500);
						$("#edit_rd_hint").slideDown(500);
						$(".make_rd").slideUp(500);
						$("#make_rd_hint").slideUp(500);
						$("#create").removeClass("fa-minus-square");
						$("#create").addClass("fa-plus-square");
						$("#manage").removeClass("fa-plus-square");
						$("#manage").addClass("fa-minus-square");
					}
				});
			
				$(function($){
					$("#datum_ende_der_pruefung").mask("99.99.9999",{placeholder:"TT:MM.JJJJ"});
					$(".sollzeit_basic").mask("99:99,99",{placeholder:"MM:SS,00"});
				});
				
				$.datepicker.regional['de'] = {
					showWeek: true,
					showButtonPanel: true,
					closeText: 'Fertig',
					prevText: '<<',
					nextText: '>>',
					currentText: 'heute',
					monthNames: [
						'Januar',
						'Februar',
						'März',
						'April',
						'Mai',
						'Juni',
						'Juli',
						'August',
						'September',
						'Oktober',
						'November',
						'Dezember'
					],
					monthNamesShort: [
						'Jan',
						'Feb',
						'Mär',
						'Apr',
						'Mai',
						'Jun',
						'Jul',
						'Aug',
						'Sep',
						'Okt',
						'Nov',
						'Dez'
					],
					dayNames: [
						'Sonntag',
						'Montag',
						'Dienstag',
						'Mittwoch',
						'Donnerstag',
						'Freitag',
						'Samstag'
					],
					dayNamesShort: [
						'So',
						'Mo',
						'Di',
						'Mi',
						'Do',
						'Fr',
						'Sa'
					],
					dayNamesMin: [
						'So',
						'Mo',
						'Di',
						'Mi',
						'Do',
						'Fr',
						'Sa'
					],
					weekHeader: 'KW',
					dateFormat: 'dd.mm.yy',
					firstDay: 0,
					isRTL: false,
					showMonthAfterYear: false,
					yearSuffix: ''
				};
				
				$.datepicker.setDefaults(
					$.datepicker.regional["de"], 
					$('#datum_ende_der_pruefung').datepicker('option', 'dateFormat', 'dd/mm/yy')
				);				
				
				$("#datum_ende_der_pruefung").datepicker({
					minDate: new Date(<? echo $started[0]; ?>, <? echo $started[1]; ?>, <? echo $started[2]; ?>),
					maxDate: new Date(<? echo $ended[0]; ?>, <? echo $ended[1]; ?>, <? echo $ended[2]; ?>)
				});
				
				$("#zeiteneingabe").change(function() {
					var zwischenzeit = $("#zeiteneingabe").val();
					
					if(zwischenzeit == "2") {
						$(".container_zeiteneingabe").hide();
						$("#zwischenzeit").removeAttr("required");
						
						$(".appended_element").remove();						
						$(".basic_element").remove();
						
						var htmlString = "";
						
						htmlString += '<div class="4u 8u(xsmall) basic_element"><input type="text" class="input not-active sollzeit_basic_desc" name="sollzeit[]" value="Sollzeit Start / Ziel" disabled /></div><div class="2u$ 4u$(xsmall) basic_element"><input type="text" class="input sollzeit_basic" name="sollzeit[]" placeholder="MM:SS,00" required /></div>';
						
						$('#zwischenzeit_anzahl').val('');
						$('#zwischenzeit_anzahl option:first').text('Keine Zwischenzeit');
						
						$("#appending_container").append(htmlString);
						$(".sollzeit_basic").mask("99:99,99",{placeholder:"MM:SS,00"});
					} else {
						$(".container_zeiteneingabe").show();
						$("#zwischenzeit").prop("required", true);
					}
				});
				
				$("#zwischenzeit").change(function() {
					var zwischenzeit = $("#zwischenzeit").val();
					
					if(zwischenzeit == "1") {
						$('#zwischenzeit_anzahl option:first').text('Keine Zwischenzeit');
						$("#zwischenzeit_anzahl").attr('disabled', 'disabled');
						$("#zwischenzeit_anzahl").addClass('not-active');						
						
						$(".appended_element").remove();						
						$(".basic_element").remove();
						
						var htmlString = "";
						
						htmlString += '<div class="4u 8u(xsmall) basic_element"><input type="text" class="input not-active sollzeit_basic_desc" name="sollzeit[]" value="Sollzeit Start / Ziel" disabled /></div><div class="2u$ 4u$(xsmall) basic_element"><input type="text" class="input sollzeit_basic" name="sollzeit[]" placeholder="MM:SS,00" required /></div>';
						
						$("#appending_container").append(htmlString);
						$(".sollzeit_basic").mask("99:99,99",{placeholder:"MM:SS,00"});
						
						$('#zwischenzeit_anzahl').val('');
						$('#zwischenzeit_anzahl option:first').text('Keine Zwischenzeit');
					} else if(zwischenzeit == "2") {
						$("#zwischenzeit_anzahl").removeAttr('disabled');
						$("#zwischenzeit_anzahl").removeClass('not-active');
						$('#zwischenzeit_anzahl option:first').text('Anzahl Zwischenzeit');
						
						$("#zwischenzeit_anzahl").change(function() {
							$(".appended_element").remove();						
							$(".basic_element").remove();						
							
							var htmlString = "";
							var len = $("#zwischenzeit_anzahl").find("option:selected").val();
						
							if(len == 0) {
								var array = ['Sollzeit Start / Ziel'];
							} else if(len == 1) {
								var array = ['Sollzeit Start / ZZ1', 'Sollzeit ZZ1 / Ziel'];
							} else if(len == 2) {
								var array = ['Sollzeit Start / ZZ1', 'Sollzeit ZZ1 / ZZ2', 'Sollzeit ZZ2 / Ziel'];
							} else if(len == 3) {
								var array = ['Sollzeit Start / ZZ1', 'Sollzeit ZZ1 / ZZ2', 'Sollzeit ZZ2 / ZZ3', 'Sollzeit ZZ3 / Ziel'];
							} else if(len == 4) {
								var array = ['Sollzeit Start / ZZ1', 'Sollzeit ZZ1 / ZZ2', 'Sollzeit ZZ2 / ZZ3', 'Sollzeit ZZ3 / ZZ4', 'Sollzeit ZZ4 / Ziel'];
							} else if(len == 5) {
								var array = ['Sollzeit Start / ZZ1', 'Sollzeit ZZ1 / ZZ2', 'Sollzeit ZZ2 / ZZ3', 'Sollzeit ZZ3 / ZZ4', 'Sollzeit ZZ4 / ZZ5', 'Sollzeit ZZ5 / Ziel'];
							}
							
							$.each(array, function(i, val) {
								htmlString += '<div class="4u 8u(xsmall) appended_element"><input type="text" class="input not-active sollzeit_appended_desc" name="sollzeit[]" value="' + val + '" disabled /></div><div class="2u$ 4u$(xsmall) appended_element"><input type="text" class="input sollzeit_appended" name="sollzeit[]" placeholder="MM:SS,00" required /></div>';
							});
							$("#appending_container").append(htmlString);
							$(".sollzeit_appended").mask("99:99,99",{placeholder:"MM:SS,00"});
						});
					}
				});
			});
		</script>
	</body>
</html>