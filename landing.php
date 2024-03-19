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
	
	if(!isset($_SESSION['uid']) OR empty($_SESSION['uid']) OR $_SESSION['uid'] == "") {
		header("Location: process_logout.php");
	} else {
		//	Binde DB Connect ein
		require_once('includes/backend/dbc.php');
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
			
			.tooltip_freigabe {
				position: relative;
				display: inline-block;
				// border-bottom: 1px dotted black;
				color: #8e6516;
			}

			.tooltip_freigabe .tooltiptext_freigabe {
				visibility: hidden;
				width: 200px;
				background-color: black;
				color: #fff;
				text-align: center;
				border-radius: 6px;
				padding: 5px 0;
				position: absolute;
				z-index: 1;
				top: 150%;
				left: 50%;
				margin-left: -100px;
				
				opacity: 0;
				transition: opacity 1s;
			}

			.tooltip_freigabe .tooltiptext_freigabe::after {
				content: "";
				position: absolute;
				bottom: 100%;
				left: 50%;
				margin-left: -5px;
				border-width: 5px;
				border-style: solid;
				border-color: transparent transparent black transparent;
			}

			.tooltip_freigabe:hover .tooltiptext_freigabe {
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
	
		<!-- Wrapper -->
		<div id="wrapper">
			<!-- Main -->
			<div id="main">
				<div class="inner">
					<!-- Header -->
					<header id="header">
						<a href="/" class="logo"><span style="font-weight: 800;">zeitnah|me</span> &ndash; Die Datenbank im Motorsport!</a>
						<!-- 
						<ul class="icons">
							<li><a href="#" class="icon fa-twitter"><span class="label">Twitter</span></a></li>
							<li><a href="#" class="icon fa-facebook"><span class="label">Facebook</span></a></li>
							<li><a href="#" class="icon fa-snapchat-ghost"><span class="label">Snapchat</span></a></li>
							<li><a href="#" class="icon fa-instagram"><span class="label">Instagram</span></a></li>
							<li><a href="#" class="icon fa-medium"><span class="label">Medium</span></a></li>
						</ul> 
						-->
					</header>

					<!-- Content -->
					<section>
						<header class="main">
							<h1>Veranstaltungsübersicht</h1>
						</header>
												
						<div class="row uniform">
							<div class="12u$">
								<div id="weather"></div>
							</div>
							
							<div class="12u$">
								<hr class="major" />
							</div>
							
							<div class="12u$">
								<h3>Veranstaltung(en)</h3>
								<div class="table-wrapper">
									<table>
										<?php
											//	Suche nach allen Veranstaltungen des Benutzers
											$select = "SELECT * FROM `_tkev_nfo_event` WHERE `eid` = '" . $_SESSION['uid'] . "'";
											$result = mysqli_query($mysqli, $select);
											$numrow = mysqli_num_rows($result);
											
											if($numrow > 0) {
												echo	"
														<thead>
															<tr>
																<th>Veranstaltung</th>
																<th>Veranstalter</th>
																<th>Berechnungsart</th>
																<th>Referenzlauf</th>
																<th>Karenzzeit</th>
																<th>Beginn</th>
																<th>Ende</th>
																<th>Status</th>
																<th><i class=\"fas fa-archive\"></i></th>
															</tr>
														</thead>
														<tbody>
														";
												
												while($getrow = mysqli_fetch_assoc($result)) {
													//	Ändere etwaige Veranstaltungen auf beendet, falls End-Datum erreicht
													if(date("Y-m-d", time()) > $getrow['finish']) {
														$update =	"
																	UPDATE
																		`_tkev_nfo_event`
																	SET
																		`active` = 0
																	WHERE
																		`eid` = '" . $_SESSION['uid'] . "'
																	AND
																		`active` = 1
																	AND
																		`finish` > '" . date("Y-m-d", time()) . "'
																	AND
																		`id` = '" . $getrow['id'] . "'
																	";
														$result_update = mysqli_query($mysqli, $update);
													}
													
													//	Ändere relevante Daten für Benutzer
													$karenzzeit = date("H:i", $getrow['wperiod']);
													
													$startdatum = convert_from_db($getrow['start']);
													$endetdatum = convert_from_db($getrow['finish']);
													
													if($getrow['reference'] == 0) {
														$referenzlauf = "Nein";
													} elseif($getrow['reference'] == 1) {
														$referenzlauf = "Ja";
													}
													
													if($getrow['calculation'] == 1) {
														$berechnungsart = "Ab Start";
													} elseif($getrow['calculation'] == 2) {
														$berechnungsart = "Einzeln";
													} elseif($getrow['calculation'] == 3) {
														$berechnungsart = "Verrechnung";
													}
													
													if($getrow['active'] == 1) {
														$aktiv = "<i class=\"fas fa-check\" style=\"color: green;\"></i> aktiv";
														$archive = "";
													} elseif($getrow['active'] == 0) {
														$aktiv = "<i class=\"fas fa-times\" style=\"color: red;\"></i> beendet";
														$archive = "<a href=\"#\" class=\"icon fa-download\"></a>";
													}
													
													echo	"
															<tr>
																<td>" . $getrow['title'] . "</td>
																<td>" . $getrow['organizer'] . "</td>
																<td>" . $berechnungsart . "</td>
																<td>" . $referenzlauf . "</td>
																<td>" . $karenzzeit . "</td>
																<td>" . $startdatum . "</td>
																<td>" . $endetdatum . "</td>
																<td>" . $aktiv . "</td>
																<td>" . $archive . "</td>
															</tr>
															";
												}
												
												echo	"
														</tbody>
														";
														
												mysqli_free_result($result);
											} else {
												echo	"
														<tbody>
															<tr>
																<td>Sie haben bisher keine Veranstaltung erstellt. Klicken Sie <a href=\"create.php\">hier</a>, um eine Veranstaltung zu erstellen.</td>
															</tr>
														</tbody>
														";
											}
										?>
									</table>
								</div>	
							</div>
							
							<div class="12u$">
								<h3>Prüfung(en)</h3>
								<div class="table-wrapper">
									<table>
										<?php
											//	Setze Flags für zusätzliche Optionen
											$has_rd = 0;
										
											//	Suche nach allen Veranstaltungen des Benutzers
											$select = "SELECT * FROM `_tkev_nfo_exam` WHERE `eid` = '" . $_SESSION['uid'] . "' AND `active` = 1";
											$result = mysqli_query($mysqli, $select);
											$numrow = mysqli_num_rows($result);
											
											$select_rdtype = "SELECT * FROM `_tkev_nfo_event` WHERE `eid` = '" . $_SESSION['uid'] . "' AND `active` = 1";
											$result_rdtype = mysqli_query($mysqli, $select_rdtype);
											$numrow_rdtype = mysqli_num_rows($result_rdtype);
											$getrow_rdtype = mysqli_fetch_assoc($result_rdtype);
											$rdtype = $getrow_rdtype['type'];
											
											if($numrow > 0) {
												echo	"
														<thead>
															<tr>
																<th>P. Nr.</th>
																<th>Prüfungsdatum</th>
																<th>Positionen<div class=\"tooltip\"><sup>[?]</sup><span class=\"tooltiptext\">+ Start und Ziel</span></div></th> 
																<th>Referenzlauf</th>
																<th>Zeiteneingabe</th>
																<th>Status</th>
															</tr>
														</thead>
														<tbody>
														";
												
												while($getrow = mysqli_fetch_assoc($result)) {
													$raw_date = explode("-", $getrow['execute']);
													$beginn = $raw_date[2] . "." . $raw_date[1] . "." . $raw_date[0];
									
													if($getrow['reference'] == 0) {
														$reference = "Nein";
													} else if($getrow['reference'] == 1) {
														$reference = "Ja";
													}
													
													if($getrow['mode'] == 1) {
														$mode = "Regulär";
													} else if($getrow['mode'] == 2) {
														$mode = "Fahrtzeit";
													}
													
													if($getrow['abort'] == 0) {
														if($getrow['finished'] == 1) {
															$aktiv = "<i class=\"fas fa-flag-checkered\" style=\"color: black;\"></i> beendet";
														} elseif($getrow['finished'] == 0) {
															$aktiv = "<i class=\"fas fa-check\" style=\"color: green;\"></i> laufend";
														}
													} elseif($getrow['abort'] == 1) {
														$aktiv = "<i class=\"fas fa-ban\" style=\"color: red;\"></i> neutralisiert";
													}
													
													
													if($getrow['positions'] > 2) {
														$positions = ($getrow['positions'] - 2) . " [ +2 ]";
													} else {
														$positions = $getrow['positions'];
													}
													
													echo	'
															<tr>
																<td><span class="rd_type">' . $rdtype . "</span>" . $getrow['rid'] . '</td>
																<td>' . $beginn . '</td>
																<td>' . $positions . '</td>
																<td>' . $reference . '</td>
																<td>' . $mode . '</td>
																<td>' . $aktiv . '</td>
															</tr>
															';
												}
												
												echo	"
														</tbody>
														";
														
												//	Setze Flag
												$has_rd = 1;
												
												mysqli_free_result($result);
											} else {
												echo	"
														<tbody>
															<tr>
																<td>Sie haben bisher keine Prüfungen erstellt. Klicken Sie <a href=\"rd.php\">hier</a>, um Prüfungen zu erstellen.</td>
															</tr>
														</tbody>
														";
											}
										?>
									</table>
								</div>	
							</div>
							
							<?php
								if($has_rd == 1) {
									echo	"
											<div class=\"12u$\">
												<h3>Zeitnehmer</h3>
												<div class=\"table-wrapper\">
													<table>
											";
									
									//	Suche nach aktiven Zeitnehmern
									$select = "SELECT * FROM `_tkev_acc_timekeeper` WHERE `eid` = '" . $_SESSION['uid'] . "' AND `finished` = 0";
									$result = mysqli_query($mysqli, $select);
									$numrow = mysqli_num_rows($result);
												
									if($numrow > 0) {
										echo	"
														<thead>
															<tr>
																<th>Runden-ID</th>
																<th>Benutzername</th>
																<th>Kennwort</th>
																<th>Name (opt.)</th>
																<th>Typ</th>
																<th>Flags</th>
																<th>Status</th>
																<th><i class='fas fa-sign-out-alt'></i> Login</th>
															</tr>
														</thead>
														<tbody>
												";
													
										while($getrow = mysqli_fetch_assoc($result)) {
											//	Ändere relevante Daten für Benutzer
											if($getrow['logintime'] > 0) {
												$rd_login = "<i class=\"fas fa-check\" style=\"color: green;\"> " . date("Y-m-d H:i:s", $getrow['logintime']) . "</i>";
												$is_logged = '<a href="#" class="logout" id="' . $datensatz_timee['uid'] . '"><i class="fas fa-sign-out-alt" style="color: green;"></i> ZN ausloggen</a>';
											} elseif($getrow['logintime'] == 0) {
												$rd_login = "<i class=\"fas fa-times\" style=\"color: red;\"></i> ausgeloggt";
												$is_logged = '';
											}
											
											//	Wenn optionaler Name leer, gebe Hinweis aus
											if($getrow['whois'] == "" or empty($getrow['whois'])) {
												$whois = "<a href=\"/zm.php\"><em>ändern</em></a>";
											} else {
												$whois = $getrow['whois'];
											}
													
											echo	"
															<tr>
																<td>" . $getrow['rid'] . "</td>
																<td>" . $getrow['uname'] . "</td>
																<td>" . $getrow['upass'] . "</td>
																<td>" . $whois . "</td>
																<td>" . $getrow['type'] . "</td>
																<td>" . $getrow['flagged'] . "</td>
																<td>" . $rd_login . "</td>
																<td>" . $is_logged . "</td>
															</tr>
													";
										}
													
										echo	"
														</tbody>
												";
													
										mysqli_free_result($result);
									} else {
										echo	"
														<tbody>
															<tr>
																<td>Sie haben bisher keine Zeitnehmer hinzugefügt. Klicken Sie <a href=\"zm.php\">hier</a>, um Zeitnehmer hinzuzufügen.</td>
															</tr>
														</tbody>
												";
									}
								
									echo	"
													</table>
												</div>	
											</div>
											";
								}
								
								if($has_rd == 1) {
									echo	"
											<div class=\"12u$\">
												<h3>Bordkarten Zugang</h3>
												<div class=\"table-wrapper\">
													<table>
											";
									
									//	Prüfe auf Bordkarten Account
									$select = "SELECT * FROM `_tkev_acc_boardingpass` WHERE `eid` = '" . $_SESSION['uid'] . "' AND `finished` = 0";
									$result = mysqli_query($mysqli, $select);
									$numrow = mysqli_num_rows($result);
												
									if($numrow > 0) {
										echo	"
														<thead>
															<tr>
																<th>Benutzername</th>
																<th>Kennwort</th>
																<th>Bezeichnung</th>
																<th>Freigabe<div class=\"tooltip_freigabe\"><sup>[?]</sup><span class=\"tooltiptext_freigabe\">Login Datumgebunden</span></div></th>
																<th>Status</th>
															</tr>
														</thead>
														<tbody>
												";
												
										$heute = date("Y-m-d", time());
													
										while($getrow = mysqli_fetch_assoc($result)) {
											//	Prüfe, ob derzeitiges Zugangsdatum noch nicht erreicht wurde, identisch ist, oder überschritten wurde
											$checkPosition = datePosition($heute, $getrow['eventdate']);
											
											if($checkPosition == 1) {
												$login_possible = "<i class=\"fas fa-check\" style=\"color: green;\"></i>";
											} elseif($checkPosition == 0) {
												$login_possible = "<i class=\"fas fa-times\" style=\"color: red;\"></i>";
											}
											
											//	Ändere relevante Daten für Benutzer
											if($getrow['logintime'] > 0) {
												$rd_login = "<i class=\"fas fa-check\" style=\"color: green;\"> " . date("Y-m-d H:i:s", $getrow['logintime']) . "</i>";
											} elseif($getrow['logintime'] == 0) {
												$rd_login = "<i class=\"fas fa-times\" style=\"color: red;\"></i> ausgeloggt";
											}
											
											echo	"
															<tr>
																<td>" . $getrow['uname'] . "</td>
																<td>" . $getrow['upass'] . "</td>
																<td>" . $getrow['whois'] . "</td>
																<td>" . $login_possible . "</td>
																<td>" . $rd_login . "</td>
															</tr>
													";
										}
													
										echo	"
														</tbody>
												";
													
										mysqli_free_result($result);
									} else {
										echo	"
														<tbody>
															<tr>
																<td>Sie haben bisher keinen Bordkarten Zugang hinzugefügt. Klicken Sie <a href=\"bp.php\">hier</a>, um einen Bordkarten Zugang hinzuzufügen.</td>
															</tr>
														</tbody>
												";
									}
								
									echo	"
													</table>
												</div>	
											</div>
											";
								}
							?>
							
							<?php
								if($has_rd == 1) {
									echo	"
											<div class=\"12u$\">
												<h3>Teilnehmer</h3>
												<div class=\"table-wrapper\">
													<table>
											";
									
									//	Suche nach aktiven Teilnehmern
									$select = "SELECT * FROM `_tkev_acc_participants` WHERE `eid` = '" . $_SESSION['uid'] . "' AND `finished` = 0";
									$result = mysqli_query($mysqli, $select);
									$numrow = mysqli_num_rows($result);
												
									if($numrow > 0) {
										echo	"
														<thead>
															<tr>
																<th>#</th>
																<th>Benutzername</th>
																<th>Kennwort</th>
																<th>Klasse</th>
																<th>Modell</th>
																<th>Typ</th>
																<th>Baujahr</th>
																<th>Fahrer</th>
																<th>Beifahrer</th>
																<th>Status</th>
																<th><i class=\"fas fa-sign-in-alt\"></i> Login</th>
															</tr>
														</thead>
														<tbody>
												";
													
										while($getrow = mysqli_fetch_assoc($result)) {
											//	Ändere relevante Daten für Benutzer
											if($getrow['ready'] == 1) {
												$status = "<i class=\"fas fa-check\" style=\"color: green;\"></i> funktional";
											} elseif($getrow['ready'] == 0) {
												$status = "<i class=\"fas fa-times\" style=\"color: red;\"></i> Ausfall";
											}
													
											echo	"
															<tr>
																<td>" . $getrow['sid'] . "</td>
																<td>" . $getrow['uname'] . "</td>
																<td>" . $getrow['upass'] . "</td>
																<td>" . $getrow['class'] . "</td>
																<td>" . $getrow['model'] . "</td>
																<td>" . $getrow['type'] . "</td>
																<td>" . $getrow['vintage'] . "</td>
																<td>" . $getrow['vname1'] . " " . $getrow['nname1'] . "</td>
																<td>" . $getrow['vname2'] . " " . $getrow['nname2'] . "</td>
																<td>" . $status . "</td>
																<td><a href=\"#\" class=\"tn_login\" id=\"" . $getrow['uid'] . "\">Einloggen</a></td>
															</tr>
													";
										}
													
										echo	"
														</tbody>
												";
													
										mysqli_free_result($result);
									} else {
										echo	"
														<tbody>
															<tr>
																<td>Sie haben bisher keine Teilnehmer hinzugefügt. Klicken Sie <a href=\"tm.php\">hier</a>, um Teilnehmer hinzuzufügen.</td>
															</tr>
														</tbody>
												";
									}
								
									echo	"
													</table>
												</div>	
											</div>
											";
								}
							?>
						</div>
						
						
							
							
						
													
							
						<!--	
						<h2>Interdum sed dapibus</h2>
						<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis dapibus rutrum facilisis. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Etiam tristique libero eu nibh porttitor fermentum. Nullam venenatis erat id vehicula viverra. Nunc ultrices eros ut ultricies condimentum. Mauris risus lacus, blandit sit amet venenatis non, bibendum vitae dolor. Nunc lorem mauris, fringilla in aliquam at, euismod in lectus. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. In non lorem sit amet elit placerat maximus. Pellentesque aliquam maximus risus, vel sed vehicula.</p>
						<p>Interdum et malesuada fames ac ante ipsum primis in faucibus. Pellentesque venenatis dolor imperdiet dolor mattis sagittis. Praesent rutrum sem diam, vitae egestas enim auctor sit amet. Pellentesque leo mauris, consectetur id ipsum sit amet, fersapien risus, commodo eget turpis at, elementum convallis elit. Pellentesque enim turpis, hendrerit tristique lorem ipsum dolor.</p>

						<hr class="major" />						
						
						<h2>Interdum sed dapibus</h2>
						<p>Donec eget ex magna. Interdum et malesuada fames ac ante ipsum primis in faucibus. Pellentesque venenatis dolor imperdiet dolor mattis sagittis. Praesent rutrum sem diam, vitae egestas enim auctor sit amet. Pellentesque leo mauris, consectetur id ipsum sit amet, fergiat. Pellentesque in mi eu massa lacinia malesuada et a elit. Donec urna ex, lacinia in purus ac, pretium pulvinar mauris. Curabitur sapien risus, commodo eget turpis at, elementum convallis elit. Pellentesque enim turpis, hendrerit.</p>
						<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis dapibus rutrum facilisis. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Etiam tristique libero eu nibh porttitor fermentum. Nullam venenatis erat id vehicula viverra. Nunc ultrices eros ut ultricies condimentum. Mauris risus lacus, blandit sit amet venenatis non, bibendum vitae dolor. Nunc lorem mauris, fringilla in aliquam at, euismod in lectus. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. In non lorem sit amet elit placerat maximus. Pellentesque aliquam maximus risus, vel sed vehicula. Interdum et malesuada fames ac ante ipsum primis in faucibus. Pellentesque venenatis dolor imperdiet dolor mattis sagittis. Praesent rutrum sem diam, vitae egestas enim auctor sit amet. Pellentesque leo mauris, consectetur id ipsum sit amet, fersapien risus, commodo eget turpis at, elementum convallis elit. Pellentesque enim turpis, hendrerit tristique lorem ipsum dolor.</p>

						<hr class="major" />

						<h2>Magna etiam veroeros</h2>
						<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis dapibus rutrum facilisis. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Etiam tristique libero eu nibh porttitor fermentum. Nullam venenatis erat id vehicula viverra. Nunc ultrices eros ut ultricies condimentum. Mauris risus lacus, blandit sit amet venenatis non, bibendum vitae dolor. Nunc lorem mauris, fringilla in aliquam at, euismod in lectus. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. In non lorem sit amet elit placerat maximus. Pellentesque aliquam maximus risus, vel sed vehicula.</p>
						<p>Interdum et malesuada fames ac ante ipsum primis in faucibus. Pellentesque venenatis dolor imperdiet dolor mattis sagittis. Praesent rutrum sem diam, vitae egestas enim auctor sit amet. Pellentesque leo mauris, consectetur id ipsum sit amet, fersapien risus, commodo eget turpis at, elementum convallis elit. Pellentesque enim turpis, hendrerit tristique lorem ipsum dolor.</p>

						<hr class="major" />

						<h2>Lorem aliquam bibendum</h2>
						<p>Donec eget ex magna. Interdum et malesuada fames ac ante ipsum primis in faucibus. Pellentesque venenatis dolor imperdiet dolor mattis sagittis. Praesent rutrum sem diam, vitae egestas enim auctor sit amet. Pellentesque leo mauris, consectetur id ipsum sit amet, fergiat. Pellentesque in mi eu massa lacinia malesuada et a elit. Donec urna ex, lacinia in purus ac, pretium pulvinar mauris. Curabitur sapien risus, commodo eget turpis at, elementum convallis elit. Pellentesque enim turpis, hendrerit.</p>
						<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis dapibus rutrum facilisis. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Etiam tristique libero eu nibh porttitor fermentum. Nullam venenatis erat id vehicula viverra. Nunc ultrices eros ut ultricies condimentum. Mauris risus lacus, blandit sit amet venenatis non, bibendum vitae dolor. Nunc lorem mauris, fringilla in aliquam at, euismod in lectus. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. In non lorem sit amet elit placerat maximus. Pellentesque aliquam maximus risus, vel sed vehicula.</p>
						-->
					</section>

					<!-- Section -->
					<!-- 
					<section>
						<header class="major">
							<h2>Ipsum sed dolor</h2>
						</header>
						<div class="posts">
							<article>
								<a href="#" class="image"><img src="images/pic01.jpg" alt="" /></a>
								<h3>Interdum aenean</h3>
								<p>Aenean ornare velit lacus, ac varius enim lorem ullamcorper dolore. Proin aliquam facilisis ante interdum. Sed nulla amet lorem feugiat tempus aliquam.</p>
								<ul class="actions">
									<li><a href="#" class="button">More</a></li>
								</ul>
							</article>
							<article>
								<a href="#" class="image"><img src="images/pic02.jpg" alt="" /></a>
								<h3>Nulla amet dolore</h3>
								<p>Aenean ornare velit lacus, ac varius enim lorem ullamcorper dolore. Proin aliquam facilisis ante interdum. Sed nulla amet lorem feugiat tempus aliquam.</p>
								<ul class="actions">
									<li><a href="#" class="button">More</a></li>
								</ul>
							</article>
							<article>
								<a href="#" class="image"><img src="images/pic03.jpg" alt="" /></a>
								<h3>Tempus ullamcorper</h3>
								<p>Aenean ornare velit lacus, ac varius enim lorem ullamcorper dolore. Proin aliquam facilisis ante interdum. Sed nulla amet lorem feugiat tempus aliquam.</p>
								<ul class="actions">
									<li><a href="#" class="button">More</a></li>
								</ul>
							</article>
							<article>
								<a href="#" class="image"><img src="images/pic04.jpg" alt="" /></a>
								<h3>Sed etiam facilis</h3>
								<p>Aenean ornare velit lacus, ac varius enim lorem ullamcorper dolore. Proin aliquam facilisis ante interdum. Sed nulla amet lorem feugiat tempus aliquam.</p>
								<ul class="actions">
									<li><a href="#" class="button">More</a></li>
								</ul>
							</article>
							<article>
								<a href="#" class="image"><img src="images/pic05.jpg" alt="" /></a>
								<h3>Feugiat lorem aenean</h3>
								<p>Aenean ornare velit lacus, ac varius enim lorem ullamcorper dolore. Proin aliquam facilisis ante interdum. Sed nulla amet lorem feugiat tempus aliquam.</p>
								<ul class="actions">
									<li><a href="#" class="button">More</a></li>
								</ul>
							</article>
							<article>
								<a href="#" class="image"><img src="images/pic06.jpg" alt="" /></a>
								<h3>Amet varius aliquam</h3>
								<p>Aenean ornare velit lacus, ac varius enim lorem ullamcorper dolore. Proin aliquam facilisis ante interdum. Sed nulla amet lorem feugiat tempus aliquam.</p>
								<ul class="actions">
									<li><a href="#" class="button">More</a></li>
								</ul>
							</article>
						</div>
					</section> 
					-->
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
		<?php
			//	$ip = $_SERVER['REMOTE_ADDR'];
			// 	$details = json_decode(file_get_contents("http://ipinfo.io/{$ip}/json"));
		?>
		<script>
			$(document).ready(function() {
				/*
				$.simpleWeather({
					location: '<? echo $details->city; // -> "Mannheim" ?>, <? echo $details->region; // -> "BW" ?>',
					woeid: '',
					unit: 'c',
					success: function(weather) {
						html = '<h2><i class="weather icon-' + weather.code + '"></i> ' + weather.temp + '&deg;' + weather.units.temp + '</h2>';
						html += '<ul><li>' + weather.city + ', ' + weather.region + '</li>';
						html += '<li class="currently">' + weather.currently + '</li>';
						html += '<li>' + weather.wind.direction + ' ' + weather.wind.speed + ' ' + weather.units.speed + '</li></ul>';
			  
						$("#weather").html(html);
					},
					error: function(error) {
						$("#weather").html('<p>'+error+'</p>');
					}
				});
				*/
				
				//	Zeitnehmer ausloggen
				$('.logout').click(function(){
					var zid = $(this).attr('id');		
					
					$.ajax({
						type: 'POST',
						url: "zn_logout.php",
						data: {
								eid: <?php echo $eid; ?>, 
								zid: zid
						},
						success: function(html){
							if(html == "success") {
								$("#td_" + zid).html("<font size=\"2\" color=\"#FF0000\">Ausgeloggt</font>");
								alert("Zeitnehmer wurde ausgeloggt!");
							} else if(html == "multiple") {
								alert("Zeitnehmer mehrfach vorhanden!");
							} else if(html == "nouser") {
								$("#td_" + zid).html("<font size=\"2\" color=\"#FF0000\">Ausgeloggt</font>");
								alert("Zeitnehmer nicht vorhanden!\r\n(zwischenzeitlich gelöscht?)");
							} else if(html == "already") {
								$("#td_" + zid).html("<font size=\"2\" color=\"#FF0000\">Ausgeloggt</font>");
								alert("Zeitnehmer bereits ausgeloggt!\r\n(zwischenzeitlich ausgeloggt?)");
							}							
						}
					});
				});
				
				//	Als Teilnehmer einloggen
				$('.tn_login').click(function(){
					var sid = $(this).attr('id');	
					var eid = <?php echo $_SESSION['uid']; ?>;
					var win = window.open('/msdn/racer.php?eid=' + eid + '&sid=' + sid, '_blank');
                                
                    if(win) {
                        //  Setze Fokus auf neues Tab
                        win.focus();
                    } else {
                        //  Browser lässt keine Popups zu
                        alert('Bitte erlauben Sie Popups in Ihrem Browser!');
                    }
				});
			});
		</script>
	</body>
</html>