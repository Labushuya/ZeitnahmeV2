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
	
	//	Dummy Formular
	if(isset($_POST['create_tm_dummy'])) {
		unset($_POST['create_tm_dummy']);
		
		/*
			echo "<pre>";
			print_r($_POST);
			echo "</pre>";
		*/
		
		//	Binde Datei zum Anlegen von Dummys ein
		require_once('includes/backend/create_tm_dummy.php');
	}
	
	//	Einzelteilnehmer Formular
	if(isset($_POST['create_tm_single'])) {
		unset($_POST['create_tm_single']);
		
		/*
			echo "<pre>";
			print_r($_POST);
			echo "</pre>";
		*/
		
		//	Binde Datei zum Anlegen von einzelnem Teilnehmer ein
		require_once('includes/backend/create_tm_single.php');
	}
	
	//	Teilnehmerliste Formular
	if(isset($_POST['create_tm_bulk'])) {
		unset($_POST['create_tm_bulk']);
		
		/*
			echo "<pre>";
			print_r($_POST);
			echo "</pre>";
		*/
	}
?>
<!DOCTYPE html>
<html class="no-js">
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
			
			/* Tooltip container */
			.tooltip {
				position: relative;
				display: inline-block;
				// border-bottom: 1px dotted black;
				color: #8e6516;
			}

			.tooltip .tooltiptext {
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
			
			// Base Colors
			$shade-10: #2c3e50 !default;
			$shade-1: #d7dcdf !default;
			$shade-0: #fff !default;
			$teal: #1abc9c !default;

			.range-slider {
			  margin: 60px 0 0 0%;
			}

			// Range Slider
			$range-width: 100% !default;

			$range-handle-color: $shade-10 !default;
			$range-handle-color-hover: $teal !default;
			$range-handle-size: 20px !default;

			$range-track-color: $shade-1 !default;
			$range-track-height: 10px !default;

			$range-label-color: $shade-10 !default;
			$range-label-width: 60px !default;

			.range-slider {
			  width: $range-width;
			}

			.range-slider__range {
				-webkit-appearance: none;
				width: calc(100% - (#{$range-label-width + 13px}));
				height: $range-track-height;
				border-radius: 5px;
				background: $range-track-color;
				outline: none;
				padding: 0;
				margin: 0;

				// Range Handle
				&::-webkit-slider-thumb {
					appearance: none;
					width: $range-handle-size;
					height: $range-handle-size;
					border-radius: 50%;
					background: $range-handle-color;
					cursor: pointer;
					transition: background .15s ease-in-out;

					&:hover {
						background: $range-handle-color-hover;
					}
				}

				&:active::-webkit-slider-thumb {
					background: $range-handle-color-hover;
				}

				&::-moz-range-thumb {
					width: $range-handle-size;
					height: $range-handle-size;
					border: 0;
					border-radius: 50%;
					background: $range-handle-color;
					cursor: pointer;
					transition: background .15s ease-in-out;

					&:hover {
						background: $range-handle-color-hover;
					}
				}

				&:active::-moz-range-thumb {
					background: $range-handle-color-hover;
				}
				  
				// Focus state
				&:focus {
					&::-webkit-slider-thumb {
						box-shadow: 0 0 0 3px $shade-0,
									0 0 0 6px $teal;
					}
				}
			}

			// Range Label
			.range-slider__value {
				display: inline-block;
				position: relative;
				width: $range-label-width;
				color: $shade-0;
				line-height: 20px;
				text-align: center;
				border-radius: 3px;
				background: $range-label-color;
				padding: 5px 10px;
				margin-left: 8px;

				&:after {
					position: absolute;
					top: 8px;
					left: -7px;
					width: 0;
					height: 0;
					border-top: 7px solid transparent;
					border-right: 7px solid $range-label-color;
					border-bottom: 7px solid transparent;
					content: '';
				}
			}

			// Firefox Overrides
			::-moz-range-track {
				background: $range-track-color;
				border: 0;
			}

			input::-moz-focus-inner,
			input::-moz-focus-outer { 
				border: 0; 
			}
			
			.js .inputfile {
				width: 0.1px;
				height: 0.1px;
				opacity: 0;
				overflow: hidden;
				position: absolute;
				z-index: -1;
			}

			.inputfile + label {
				width: 100% !important;
				font-size: 1.25rem;
				/* 20px */
				font-weight: 700;
				text-overflow: ellipsis;
				white-space: nowrap;
				cursor: pointer;
				display: inline-block;
				overflow: hidden;
				padding: 0.625rem 1.25rem;
				/* 10px 20px */
			}

			.no-js .inputfile + label {
				display: none;
			}

			.inputfile:focus + label,
			.inputfile.has-focus + label {
				outline: 1px dotted #000;
				outline: -webkit-focus-ring-color auto 5px;
			}

			.inputfile + label * {
				/* pointer-events: none; */
				/* in case of FastClick lib use */
			}

			.inputfile + label svg {
				width: 1em;
				height: 1em;
				vertical-align: middle;
				fill: currentColor;
				margin-top: -0.25em;
				/* 4px */
				margin-right: 0.25em;
				/* 4px */
			}


			/* style 1 */

			.upload + label {
				color: #f1e5e6;
				background-color: #d3394c;
			}

			.upload:focus + label,
			.upload.has-focus + label,
			.upload + label:hover {
				background-color: #722040;
			}
		</style>
		
		<!-- remove this if you use Modernizr -->
		<script>(function(e,t,n){var r=e.querySelectorAll("html")[0];r.className=r.className.replace(/(^|\s)no-js(\s|$)/,"$1js$2")})(document,window,0);</script>
		
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
					<!-- ADD RACERS -->
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
						
							//	Suche bisherige Anzahl an Teilnehmern
							$select = "SELECT COUNT(*) AS `anzahl` FROM `_tkev_acc_participants` WHERE `eid` = '" . $_SESSION['uid'] . "' AND `finished` = 0";
							$result = mysqli_query($mysqli, $select);
							$getrow = mysqli_fetch_assoc($result);
							
							//	Errechne mögliche Differenz von max. 200 Teilnehmern
							$differ_maximum = 200 - $getrow['anzahl'];
							
							//	Farb Status
							switch($differ_maximum) {
								case $differ_maximum >= 50:
									$status = "green";
								break;
								case ($differ_maximum <= 49 AND $differ_maximum >= 26):
									$status = "#FFFF00";
								break;
								case ($differ_maximum <= 25 AND $differ_maximum >= 0):
									$status = "#FF0000";
								break;
							}
						?>

						<div class="box" style="padding: .5em; border-color: <?php echo $status; ?>; text-align: justify;">
							<h4 style="color: <?php echo $status; ?>;">
								<i class="fas fa-info-circle" style="margin-right: .5em;"></i>Ihrer laufenden Veranstaltung können noch maximal <?php echo $differ_maximum; ?> Teilnehmer hinzugefügt werden!
							</h4>
						</div>
						
						<div class="box" style="border-color: #8e6516; background: rgba(255,255,255,.5);">
							<header class="main">
								<h1 id="make_tm_dummy">Dummy-Teilnehmer erstellen <i id="create_dummy" style="font-size: 0.25em;" class="far fa-plus-square"></i></h1>
								<h4 id="tm_hint_dummy" style="display: none;">
									<div class="box" style="border-color: #8e6516; color: #fff; background: rgb(61,68,73); text-align: justify;">
										Zugangsdaten für Teilnehmer anlegen. Exakte Parameter werden zu einem späteren Zeitpunkt festgelegt.
									</div>
								</h4>
							</header>

							<!-- Form -->
							<form action="<?php echo esc_url($_SERVER['PHP_SELF']); ?>" method="POST" name="make_tmember_form_dummy" id="make_tmember_form_dummy">
								<div class="row uniform make_tm_dummy" id="appending_container" style="display: none;">
									<div class="6u$ 12u$(xsmall) range-slider">
										<input type="range" style="width: 100% !important;" class="range-slider__range" id="dummy_slider" name="dummy_slider" min="0" max="<?php echo $differ_maximum; ?>" value="0" step="1" required="required" />
										<span id="rangeText" class="range-slider__value">0</span>
									</div>
								</div>
								<div class="row uniform make_tm_dummy" style="display: none;">
									<div class="3u 6u(xsmall)">
										<input type="reset" id="reset" value="Löschen" />
									</div>
									<div class="3u$ 6u$(xsmall)" align="right">
										<input type="submit" value="Erstellen" id="create_tm_dummy" name="create_tm_dummy" class="special" />
									</div>
								</div>
							</form>
						</div>
						
						<div class="box" style="border-color: #8e6516; background: rgba(255,255,255,.5);">
							<header class="main">
								<h1 id="make_tm_single">Einzelteilnehmer erstellen <i id="create_single" style="font-size: 0.25em;" class="far fa-plus-square"></i></h1>
								<h4 id="tm_hint_single" style="display: none;">
									<div class="box" style="border-color: #8e6516; color: #fff; background: rgb(61,68,73); text-align: justify;">
										Vollständigen Teilnehmer anlegen. Ready to use mit Zugangsdaten und allem drum und dran.
									</div>
								</h4>
							</header>

							<!-- Form -->
							<form action="<?php echo esc_url($_SERVER['PHP_SELF']); ?>" method="POST" name="make_tmember_form_single" id="make_tmember_form_single">
								<div class="row uniform make_tm_single" style="display: none;">
									<div class="2u 6u(xsmall)">
										<input type="text" class="input not-active" name="desc_startnummer" id="desc_startnummer" value="Startnr. & Kl." disabled />
									</div>
									<div class="2u 3u(xsmall)">
										<input type="text" class="input" name="mt_id[]" id="startnummer" placeholder="#" required />
									</div>
									<div class="2u$ 3u$(xsmall)">
										<input type="text" class="input" name="mt_id[]" id="klasse" placeholder="Kl." required />
									</div>
									<div class="2u 4u(xsmall)">
										<input type="text" class="input not-active" name="desc_fahrzeug" id="desc_fahrzeug" value="Fahrzeug" disabled />
									</div>
									<div class="2u 4u(xsmall)">
										<input type="text" class="input" name="mt_id[]" id="baujahr" placeholder="Baujahr" required />
									</div>
									<div class="2u$ 4u$(xsmall)">
										<input type="text" class="input" name="mt_id[]" id="fabrikat" placeholder="Fabrikat" required />
									</div>
									<div class="6u$ 12u$(xsmall)">
										<input type="text" class="input" name="mt_id[]" id="modell" placeholder="Modell" required />
									</div>
									<div class="2u 6u(xsmall)">
										<input type="text" class="input not-active" name="desc_fahrer" id="desc_fahrer" value="Fahrer" disabled />
									</div>
									<div class="2u 3u(xsmall)">
										<input type="text" class="input" name="mt_id[]" id="fahrer_vorname" placeholder="Vorname" required />
									</div>
									<div class="2u$ 3u$(xsmall)">
										<input type="text" class="input" name="mt_id[]" id="fahrer_nachname" placeholder="Nachname" required />
									</div>
									<div class="2u 6u(xsmall)">
										<input type="text" class="input not-active" name="desc_beifahrer" id="desc_beifahrer" value="Beifahrer" disabled />
									</div>
									<div class="2u 3u(xsmall)">
										<input type="text" class="input" name="mt_id[]" id="beifahrer_vorname" placeholder="Vorname" required />
									</div>
									<div class="2u$ 3u$(xsmall)">
										<input type="text" class="input" name="mt_id[]" id="beifahrer_nachname" placeholder="Nachname" required />
									</div>
								</div>
								<div class="row uniform make_tm_single" style="display: none;">
									<div class="3u 6u(xsmall)">
										<input type="reset" value="Löschen" />
									</div>
									<div class="3u$ 6u$(xsmall)" align="right">
										<input type="submit" value="Erstellen" id="create_tm_single" name="create_tm_single" class="special" />
									</div>
								</div>
							</form>
						</div>
						
						<div class="box" style="border-color: #8e6516; background: rgba(255,255,255,.5);">
							<header class="main">
								<h1 id="make_tm_bulk">Teilnehmerliste hochladen <i id="create_bulk" style="font-size: 0.25em;" class="far fa-plus-square"></i></h1>
								<h4 id="tm_hint_bulk" style="display: none;">
									<div class="box" style="border-color: #8e6516; color: #fff; background: rgb(61,68,73); text-align: justify;">
										Teilnehmerliste hochladen. Max. 200 Teilnehmer. Ready to use. Mit Zugangsdaten und allem drum und dran.
									</div>	
								</h4>
							</header>

							<!-- Form -->
							<form action="<?php echo esc_url($_SERVER['PHP_SELF']); ?>" method="POST" name="make_tmember_form_bulk" id="make_tmember_form_bulk">
								<div class="row uniform make_tm_bulk" style="display: none;">
									<div class="6u 12u(xsmall)">
										<input type="file" name="file" id="upload" style="width: 100% !important;" class="inputfile upload" data-multiple-caption="{count} files selected" multiple />
										<label for="upload"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17"><path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"/></svg> <span id="upload_span">Keine Datei gewählt</span></label>
									</div>
								</div>
								<div class="row uniform make_tm_bulk" style="display: none;">
									<div class="3u 6u(xsmall)">
										<input type="reset" id="bulk_reset" value="Löschen" />
									</div>
									<div class="3u$ 6u$(xsmall)" align="right">
										<input type="submit" value="Erstellen" id="create_tm_bulk" name="create_tm_bulk" class="special" />
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
			var rangeValues =
			{
				"0" : "0",
				"1" : "1",
				"2" : "2",
				"3" : "3",
				"4" : "4",
				"5" : "5",
				"6" : "6",
				"7" : "7",
				"8" : "8",
				"9" : "9",
				"10" : "10",
				"11" : "11",
				"12" : "12",
				"13" : "13",
				"14" : "14",
				"15" : "15",
				"16" : "16",
				"17" : "17",
				"18" : "18",
				"19" : "19",
				"20" : "20",
				"21" : "21",
				"22" : "22",
				"23" : "23",
				"24" : "24",
				"25" : "25",
				"26" : "26",
				"27" : "27",
				"28" : "28",
				"29" : "29",
				"30" : "30",
				"31" : "31",
				"32" : "32",
				"33" : "33",
				"34" : "34",
				"35" : "35",
				"36" : "36",
				"37" : "37",
				"38" : "38",
				"39" : "39",
				"40" : "40",
				"41" : "41",
				"42" : "42",
				"43" : "43",
				"44" : "44",
				"45" : "45",
				"46" : "46",
				"47" : "47",
				"48" : "48",
				"49" : "49",
				"50" : "50",
				"51" : "51",
				"52" : "52",
				"53" : "53",
				"54" : "54",
				"55" : "55",
				"56" : "56",
				"57" : "57",
				"58" : "58",
				"59" : "59",
				"60" : "60",
				"61" : "61",
				"62" : "62",
				"63" : "63",
				"64" : "64",
				"65" : "65",
				"66" : "66",
				"67" : "67",
				"68" : "68",
				"69" : "69",
				"70" : "70",
				"71" : "71",
				"72" : "72",
				"73" : "73",
				"74" : "74",
				"75" : "75",
				"76" : "76",
				"77" : "77",
				"78" : "78",
				"79" : "79",
				"80" : "80",
				"81" : "81",
				"82" : "82",
				"83" : "83",
				"84" : "84",
				"85" : "85",
				"86" : "86",
				"87" : "87",
				"88" : "88",
				"89" : "89",
				"90" : "90",
				"91" : "91",
				"92" : "92",
				"93" : "93",
				"94" : "94",
				"95" : "95",
				"96" : "96",
				"97" : "97",
				"98" : "98",
				"99" : "99",
				"100" : "100",
				"101" : "101",
				"102" : "102",
				"103" : "103",
				"104" : "104",
				"105" : "105",
				"106" : "106",
				"107" : "107",
				"108" : "108",
				"109" : "109",
				"110" : "110",
				"111" : "111",
				"112" : "112",
				"113" : "113",
				"114" : "114",
				"115" : "115",
				"116" : "116",
				"117" : "117",
				"118" : "118",
				"119" : "119",
				"120" : "120",
				"121" : "121",
				"122" : "122",
				"123" : "123",
				"124" : "124",
				"125" : "125",
				"126" : "126",
				"127" : "127",
				"128" : "128",
				"129" : "129",
				"130" : "130",
				"131" : "131",
				"132" : "132",
				"133" : "133",
				"134" : "134",
				"135" : "135",
				"136" : "136",
				"137" : "137",
				"138" : "138",
				"139" : "139",
				"140" : "140",
				"141" : "141",
				"142" : "142",
				"143" : "143",
				"144" : "144",
				"145" : "145",
				"146" : "146",
				"147" : "147",
				"148" : "148",
				"149" : "149",
				"150" : "150",
				"151" : "151",
				"152" : "152",
				"153" : "153",
				"154" : "154",
				"155" : "155",
				"156" : "156",
				"157" : "157",
				"158" : "158",
				"159" : "159",
				"160" : "160",
				"161" : "161",
				"162" : "162",
				"163" : "163",
				"164" : "164",
				"165" : "165",
				"166" : "166",
				"167" : "167",
				"168" : "168",
				"169" : "169",
				"170" : "170",
				"171" : "171",
				"172" : "172",
				"173" : "173",
				"174" : "174",
				"175" : "175",
				"176" : "176",
				"177" : "177",
				"178" : "178",
				"179" : "179",
				"180" : "180",
				"181" : "181",
				"182" : "182",
				"183" : "183",
				"184" : "184",
				"185" : "185",
				"186" : "186",
				"187" : "187",
				"188" : "188",
				"189" : "189",
				"190" : "190",
				"191" : "191",
				"192" : "192",
				"193" : "193",
				"194" : "194",
				"195" : "195",
				"196" : "196",
				"197" : "197",
				"198" : "198",
				"199" : "199",
				"200" : "200"
			};
			
			var inputs = document.querySelectorAll('.inputfile');
			Array.prototype.forEach.call(inputs, function(input) {
				var label	 = input.nextElementSibling,
					labelVal = label.innerHTML;

				input.addEventListener('change', function(e) {
					var fileName = '';
					
					if(this.files && this.files.length > 1) {
						fileName = (this.getAttribute('data-multiple-caption') || '').replace('{count}', this.files.length);
					} else {
						fileName = e.target.value.split("\\").pop();
					}
					
					if(fileName) {
						label.querySelector('span').innerHTML = fileName;
					} else {
						label.innerHTML = labelVal;
					}
				});
			});
		
			$(document).ready(function() {
				// on page load, set the text of the label based the value of the range
				$('#rangeText').text(rangeValues[$('#dummy_slider').val()]);

				// setup an event handler to set the text when the range value is dragged (see event for input) or changed (see event for change)
				$('#dummy_slider').on('input change', function () {
					if($('#dummy_slider').val() < <?php echo $differ_maximum; ?>) {
						$('#rangeText').text(rangeValues[$(this).val()]);
					} else if($('#dummy_slider').val() == <?php echo $differ_maximum; ?>) {
						$('#rangeText').text(rangeValues[$(this).val()] + " max.");
					} else if($('#dummy_slider').val() > <?php echo $differ_maximum; ?>) {
						$('#rangeText').text("200 max.");
					}	

					$('#dummy_slider').val() == <?php echo $differ_maximum; ?>;
				});
				
				$("#create_tm_dummy").prop("disabled", true);
				
				$("#dummy_slider").change(function() {
					if($("#dummy_slider").val() == 0) {
						$("#create_tm_dummy").prop("disabled", true);
					} else {
						$("#create_tm_dummy").prop("disabled", false);
					}
				});
				
				$("#make_tm_dummy").click(function() {
					if($(".make_tm_dummy").is(":visible")) {
						$("#tm_hint_dummy").slideUp(500);
						$("#tm_hint_single").slideDown(500);
						$("#tm_hint_bulk").slideUp(500);
						
						$(".make_tm_dummy").slideUp(500);
						$(".make_tm_single").slideDown(500);
						$(".make_tm_bulk").slideUp(500);
						
						$("#create_dummy").removeClass("fa-minus-square");
						$("#create_dummy").addClass("fa-plus-square");
						
						$("#create_single").removeClass("fa-plus-square");
						$("#create_single").addClass("fa-minus-square");
						
						$("#create_bulk").removeClass("fa-minus-square");
						$("#create_bulk").addClass("fa-plus-square");
					} else if($(".make_tm_dummy").is(":hidden")) {
						$("#tm_hint_dummy").slideDown(500);
						$("#tm_hint_single").slideUp(500);
						$("#tm_hint_bulk").slideUp(500);
						
						$(".make_tm_dummy").slideDown(500);
						$(".make_tm_single").slideUp(500);
						$(".make_tm_bulk").slideUp(500);
						
						$("#create_dummy").removeClass("fa-plus-square");
						$("#create_dummy").addClass("fa-minus-square");
						
						$("#create_single").removeClass("fa-minus-square");
						$("#create_single").addClass("fa-plus-square");
						
						$("#create_bulk").removeClass("fa-minus-square");
						$("#create_bulk").addClass("fa-plus-square");
					}			
				});
				
				$("#make_tm_single").click(function() {
					if($(".make_tm_single").is(":visible")) {
						$("#tm_hint_dummy").slideUp(500);
						$("#tm_hint_single").slideUp(500);
						$("#tm_hint_bulk").slideDown(500);
						
						$(".make_tm_dummy").slideUp(500);
						$(".make_tm_single").slideUp(500);
						$(".make_tm_bulk").slideDown(500);
						
						$("#create_dummy").removeClass("fa-minus-square");
						$("#create_dummy").addClass("fa-plus-square");
						
						$("#create_single").removeClass("fa-minus-square");
						$("#create_single").addClass("fa-plus-square");
						
						$("#create_bulk").removeClass("fa-plus-square");
						$("#create_bulk").addClass("fa-minus-square");
					} else if($(".make_tm_single").is(":hidden")) {
						$("#tm_hint_dummy").slideUp(500);
						$("#tm_hint_single").slideDown(500);
						$("#tm_hint_bulk").slideUp(500);
						
						$(".make_tm_dummy").slideUp(500);
						$(".make_tm_single").slideDown(500);
						$(".make_tm_bulk").slideUp(500);
						
						$("#create_dummy").removeClass("fa-minus-square");
						$("#create_dummy").addClass("fa-plus-square");
						
						$("#create_single").removeClass("fa-plus-square");
						$("#create_single").addClass("fa-minus-square");
						
						$("#create_bulk").removeClass("fa-minus-square");
						$("#create_bulk").addClass("fa-plus-square");
					}			
				});
				
				$("#make_tm_bulk").click(function() {
					if($(".make_tm_bulk").is(":visible")) {
						$("#tm_hint_dummy").slideUp(500);
						$("#tm_hint_single").slideUp(500);
						$("#tm_hint_bulk").slideUp(500);
						
						$(".make_tm_dummy").slideUp(500);
						$(".make_tm_single").slideUp(500);
						$(".make_tm_bulk").slideUp(500);
						
						$("#create_dummy").removeClass("fa-minus-square");
						$("#create_dummy").addClass("fa-plus-square");
						
						$("#create_single").removeClass("fa-minus-square");
						$("#create_single").addClass("fa-plus-square");
						
						$("#create_bulk").removeClass("fa-minus-square");
						$("#create_bulk").addClass("fa-plus-square");
					} else if($(".make_tm_bulk").is(":hidden")) {
						$("#tm_hint_dummy").slideUp(500);
						$("#tm_hint_single").slideUp(500);
						$("#tm_hint_bulk").slideDown(500);
						
						$(".make_tm_dummy").slideUp(500);
						$(".make_tm_single").slideUp(500);
						$(".make_tm_bulk").slideDown(500);
						
						$("#create_dummy").removeClass("fa-minus-square");
						$("#create_dummy").addClass("fa-plus-square");
						
						$("#create_single").removeClass("fa-minus-square");
						$("#create_single").addClass("fa-plus-square");
						
						$("#create_bulk").removeClass("fa-plus-square");
						$("#create_bulk").addClass("fa-minus-square");
					}			
				});
								
				//	Window-Size prüfen
				var win = $(window).width();
				
				//	Wenn Fenstergröße minimale Breite besitzt, ändere Platzhalter
				if (win < 925) {
					//	Ändere Bezeichnungen und Platzhalter
					$("#desc_startnummer").val("Startnr. & Kl.");
					$("#desc_fahrzeug").val("Fz.");
					
					$("#startnummer").attr("placeholder", "#");
					$("#klasse").attr("placeholder", "Kl.");
					$("#fabrikat").attr("placeholder", "Fbr.");
					$("#baujahr").attr("placeholder", "Bj.");
					$("#fahrer_vorname, #beifahrer_vorname").attr("placeholder", "Vn.");
					$("#fahrer_nachname, #beifahrer_nachname").attr("placeholder", "Nn.");
				} else if (win >= 925) {
					//	Ändere Bezeichnungen und Platzhalter
					$("#desc_startnummer").val("Startnr. & Klasse");
					$("#desc_fahrzeug").val("Fahrzeug");
					
					$("#startnummer").attr("placeholder", "Startnummer");
					$("#klasse").attr("placeholder", "Klasse");
					$("#fabrikat").attr("placeholder", "Fabrikat");
					$("#baujahr").attr("placeholder", "Baujahr");
					$("#fahrer_vorname, #beifahrer_vorname").attr("placeholder", "Vorname");
					$("#fahrer_nachname, #beifahrer_nachname").attr("placeholder", "Nachname");
				}
				
				//	Blende Hinweisfeld von abgesendetem Formular aus
				$("#status_msg_box").click(function() {
					$("#status_msg_box").slideUp(500);
				});
				
				//	Oder blende dieses automatisch nach 5 Sekunden aus
				setTimeout(function() {
					$("#status_msg_box").slideUp(500);
				}, 5000);
			});
			
			//	Teilnehmerliste hochladen Reset Button Workaround
			$("#bulk_reset").click(function() {
				$("#upload").val("");
				$("#upload_span").html = "Keine Datei gewählt";
			});
			
			//	Window-Resize Funktion
			$(window).on('resize', function() {
				var win = $(this);
				
				//	Wenn Fenstergröße minimale Breite besitzt, ändere Platzhalter
				if (win.width() < 925) {
					//	Ändere Bezeichnungen und Platzhalter
					$("#desc_startnummer").val("Startnr. & Kl.");
					$("#desc_fahrzeug").val("Fz.");
					
					$("#startnummer").attr("placeholder", "#");
					$("#klasse").attr("placeholder", "Kl.");
					$("#fabrikat").attr("placeholder", "Fbr.");
					$("#baujahr").attr("placeholder", "Bj.");
					$("#fahrer_vorname, #beifahrer_vorname").attr("placeholder", "Vn.");
					$("#fahrer_nachname, #beifahrer_nachname").attr("placeholder", "Nn.");
				} else if (win.width() >= 925) {
					//	Ändere Bezeichnungen und Platzhalter
					$("#desc_startnummer").val("Startnr. & Klasse");
					$("#desc_fahrzeug").val("Fahrzeug");
					
					$("#startnummer").attr("placeholder", "Startnummer");
					$("#klasse").attr("placeholder", "Klasse");
					$("#fabrikat").attr("placeholder", "Fabrikat");
					$("#baujahr").attr("placeholder", "Baujahr");
					$("#fahrer_vorname, #beifahrer_vorname").attr("placeholder", "Vorname");
					$("#fahrer_nachname, #beifahrer_nachname").attr("placeholder", "Nachname");
				}
			});
		</script>
	</body>
</html>