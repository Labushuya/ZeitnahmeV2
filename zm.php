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
		
		//	Suche nach letzter Prüfungsnummer
		$select_pn = "SELECT `eid`, `rid` FROM `_tkev_nfo_exam` WHERE `eid` = '" . $_SESSION['uid'] . "'";
		$result_pn = mysqli_query($mysqli, $select_pn);
		$numrow_pn = mysqli_num_rows($result_pn);
		
		if($numrow_pn == 0) {
			header("Location: landing.php");
		}
	}
	
	if(isset($_POST['create_zm'])) {
		unset($_POST['create_zm']);
		
		//	Lösche alle Übergabeparameter mit Value "allocate_pos"
		for($i = 0; $i < count($_POST['mz_id']); $i++) {
			if($_POST['mz_id'][$i] == "allocate_pos") {
				unset($_POST['mz_id'][$i]);
			}
			
			if(strpos($_POST['mz_id'][$i], "WP") !== false) {
				$split = explode("WP", $_POST['mz_id'][$i]);
				$mz_id_round = $split[1];
				$needle = "WP";
			} elseif(strpos($_POST['mz_id'][$i], "SP") !== false) {
				$split = explode("SP", $_POST['mz_id'][$i]);
				$mz_id_round = $split[1];
				$needle = "SP";
			} elseif(strpos($_POST['mz_id'][$i], "GP") !== false) {
				$split = explode("GP", $_POST['mz_id'][$i]);
				$mz_id_round = $split[1];
				$needle = "GP";
			}
			
			//	Wurde Runden-ID gefunden
			if(strpos($_POST['mz_id'][$i], $needle) !== false) {
				//	Generiere Benutzername
				$uname = rand(100, 999) . rand(100, 999);
						
				//	Generiere Passwort
				$upass = rand(18273645, 51486237);
				
				//	Suche nach Duplikaten von Zugangsdaten
				$select_dupe = "SELECT `uname`, `upass` FROM `_tkev_acc_timekeeper` WHERE `uname` = '" . $uname . "' AND `upass` = '" . $upass . "'";
				$result_dupe = mysqli_query($mysqli, $select_dupe);
				$numrow_dupe = mysqli_num_rows($result_dupe);
				
				//	Prüfe, ob Zugangsdaten bereits existieren
				if($numrow_dupe > 0) {
					while($getrow_dupe = mysqli_fetch_assoc($result_dupe)) {
						//	Wenn bereits existent, generiere neue Zugangsdaten
						$uname = rand(100, 999) . rand(100, 999);
						$upass = rand(18273645, 51486237);
						
						//	Suche erneut nach Zugangsdaten
						$select_dupe2 = "SELECT `uname`, `upass` FROM `_tkev_acc_timekeeper` WHERE `uname` = '" . $uname . "' AND `upass` = '" . $upass . "'";
						$result_dupe2 = mysqli_query($mysqli, $select_dupe2);
						$numrow_dupe2 = mysqli_num_rows($result_dupe2);
						
						//	Verlasse Schleife, wenn Zugangsdaten einzigartig
						if($numrow_dupe2 == 0) {
							break;
						}
					}					
				}
								
				//	Erstelle INSERT
				$query	= 	"INSERT INTO
								`_tkev_acc_timekeeper`(
									`uid`,
									`eid`,
									`uname`,
									`upass`,
									`whois`,
									`rid`,
									`type`,
									`flagged`,
									`finished`,
									`logintime`
								)
							VALUES(
								NULL,
								'" . $_SESSION['uid'] . "', 
								'" . $uname . "',
								'" . $upass . "',
								'',
								'" . $mz_id_round . "',
								'" . $needle . "',
								'0',
								'0',
								'0'
							)";			 
				// EXCECUTE QUERY
				mysqli_query($mysqli, $query);
				
				// FETCH LAST INSERTED ID
				$prev_id = mysqli_insert_id($mysqli);
				
				// DEBUG
				//	echo "<font size='2' color='#FFD700'>" . $query . "</font><br />";
			// ELSE POSITIONS FOUND
			} else {
				// GET POSITION
				$mz_pos = mysqli_real_escape_string($mysqli, utf8_encode($_POST['mz_id'][$i]));
				
				// BUILD INSERT QUERY
				$insert_zmem = "INSERT INTO 
									`_tkev_nfo_timekeeper`(
										`id`, 
										`uid`,
										`rid`,																	
										`position`
									) 
								VALUES(
									NULL, 
									'" . $prev_id . "',
									'" . $mz_id_round . "',
									'" . $mz_pos . "'
								)";											
				// EXECUTE INSERTION
				mysqli_query($mysqli, $insert_zmem);
				
				// DEBUG
				// echo "<font size='2' color='#C0C0C0'>" . $insert_zmem . "</font><br />";
			}							
		}
		
		/*
			echo "<pre>";
			print_r($_POST);
			echo "</pre>";
		*/
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
			
			.extended {
				margin: 0 !important;
			}
			
			select:disabled {
				color: #C0C0C0
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
		
						<!-- SOCIAL MEDIA -->
						<?php // include_once('includes/frontend/build/social_media.html'); ?>
					</header>
							
					<!-- CONTENT SECTIONS -->
					<!-- REGISTRATION -->
					<section>
						<div class="box" style="border-color: #8e6516; background: rgba(255,255,255,.5);">
							<header class="main">
								<h1 id="make_zm">Zeitnehmer erstellen <i id="create" style="font-size: 0.25em;" class="far fa-plus-square"></i></h1>
								<h4 id="make_zm_hint" style="display: none;">
									<div class="box" style="border-color: #8e6516; color: #fff; background: rgb(61,68,73); text-align: justify;">
										Zeitnehmer Prüfungspositionen zuweisen und Zugang erstellen.
									</div>
								</h4>
							</header>

							<!-- Form -->
							<form action="<?php echo esc_url($_SERVER['PHP_SELF']); ?>" method="POST" name="make_zmember_form" id="make_zmember_form">
								<div class="row uniform make_zm" id="appending_container" style="display: none;">
									<div class="6u$ 12u$(xsmall)">
										<div class="select-wrapper">
											<select name="mz_id[]" class="choose_rd" id="zeiteneingabe" required>
												<?php
													//	Suche nach Rundenbezeichnung
													$select_rdtype = "SELECT `eid`, `type` FROM `_tkev_nfo_event` WHERE `eid` = '" . $_SESSION['uid'] . "' AND `active` = '1'";
													$result_rdtype = mysqli_query($mysqli, $select_rdtype);
													$numrow_rdtype = mysqli_num_rows($result_rdtype);
													$getrow_rdtype = mysqli_fetch_assoc($result_rdtype);
													
													$rd_type = $getrow_rdtype['type'];
													
													//	Suche nach Prüfungen
													$select = "SELECT * FROM `_tkev_nfo_exam` WHERE `eid` = '" . $_SESSION['uid'] . "' AND `active` = '1'";
													$result = mysqli_query($mysqli, $select);
													$numrow = mysqli_num_rows($result);
													
													if($numrow > 0) {
														echo '<option value="" selected="selected" disabled="disabled">Bitte wählen</option>';
														
														while($getrow = mysqli_fetch_assoc($result)) {
															if($getrow["mode"] == 2) {
																$what = " &mdash; Sprint";
															} else {
																$what = "";
															}
															
															if($getrow["abort"] == 1) {
																$disabled = "disabled";
															} else {
																$disabled = "";
															}
															
															echo '<option value="' . $rd_type . $getrow['rid'] . '" ' . $disabled . '>' . $rd_type . $getrow['rid'] . $what . '</option>';
														}												
													} else {
														echo '<option value="" selected="selected" disabled="disabled">Prüfung anlegen!</option>';
													}
												?>
											</select>
										</div>
									</div>
								</div>
								<div class="row uniform make_zm" style="display: none;">
									<div class="3u 6u(xsmall)">
										<input type="reset" id="reset" value="Zurücksetzen" />
									</div>
									<div class="3u$ 6u$(xsmall)" align="right">
										<input type="submit" value="Erstellen" id="create_zm" name="create_zm" class="special" />
									</div>
								</div>
							</form>
						</div>
						
						<div class="box" style="border-color: #8e6516; background: rgba(255,255,255,.5);">
							<header class="main">
								<h1 id="edit_zm">Zeitnehmer löschen <i id="manage" style="font-size: 0.25em;" class="far fa-plus-square"></i></h1>
								<h4 id="edit_zm_hint" style="display: none;">
									<div class="box" style="border-color: #8e6516; color: #fff; background: rgb(61,68,73); text-align: justify;">
										Bestehenden Zeitnehmer samt Zugang und hinterlegten Prüfungspositionen löschen.
									</div>
								</h4>
							</header>

							<!-- Form -->
							<form action="process_editrd.php" method="POST" name="edit_delzm_form" id="edit_delzm_form">
								<div class="row uniform edit_zm" style="display: none;">
									<div class="6u$ 12u$(xsmall)">
										<h3>Zeitnehmer löschen</h3>
										<div class="select-wrapper">
											<select name="edit_bezeichnung" id="edit_bezeichnung" required>
												<?php
													//	Suche nach Zeitnehmern, welche aktiv sind (inaktive können nicht gelöscht werden)
													$select_zms = "SELECT * FROM `_tkev_acc_timekeeper` WHERE `eid` = '" . $_SESSION['uid'] . "'";
													$result_zms = mysqli_query($mysqli, $select_zms);
													$numrow_zms = mysqli_num_rows($result_zms);
													
													if($numrow_zms > 0) {
														echo '<option value="" selected="selected" disabled="disabled">Bitte wählen</option>';
														
														while($getrow_zms = mysqli_fetch_assoc($result_zms)) {
															//	Suche nach allen Positionen dieses Zeitnehmers für bessere Übersicht
															$select_zmpos = "SELECT * FROM `_tkev_nfo_timekeeper` WHERE `uid` = '" . $getrow_zms['uid'] . "'";
															$result_zmpos = mysqli_query($mysqli, $select_zmpos);
															$numrow_zmpos = mysqli_num_rows($result_zmpos);
															
															if($getrow_zms['whois'] != "") {
																$whois = $getrow_zms['whois'] . ' &mdash; ';
															} else {
																$whois = "";
															}
															
															//	Zeitnehmer hat keine Prüfungspositionen (löschen und neu anlegen)
															if($numrow_zmpos == 0) {
																echo '<option value="' . $getrow_zms['uid'] . '">' . $getrow_zms['type'] . $getrow_zms['rid'] . ' [ &#9888; ZN löschen und neu anlegen! ]</option>';
															} else {
																echo '<option value="' . $getrow_zms['uid'] . '">' . $whois . $getrow_zms['type'] . $getrow_zms['rid'] . '</option>';
															}
														}												
													} else {
														echo '<option value="" selected="selected" disabled="disabled">Zeitnehmer anlegen!</option>';
													}
												?>
											</select>
										</div>
									</div>
								</div>
								<div class="row uniform edit_zm" style="display: none;">
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
			$(document).ready(function() {
				$("#create_zm").prop("disabled", true);
			
				$("#make_zm").click(function() {
					if($(".make_zm").is(":visible")) {
						$(".make_zm").slideUp(500);
						$("#make_zm_hint").slideUp(500);
						$(".edit_zm").slideDown(500);
						$("#edit_zm_hint").slideDown(500);
						$("#create").removeClass("fa-minus-square");
						$("#create").addClass("fa-plus-square");
						$("#manage").removeClass("fa-plus-square");
						$("#manage").addClass("fa-minus-square");
					} else if($(".make_zm").is(":hidden")) {
						$(".make_zm").slideDown(500);
						$("#make_zm_hint").slideDown(500);
						$(".edit_zm").slideUp(500);
						$("#edit_zm_hint").slideUp(500);
						$("#manage").removeClass("fa-minus-square");
						$("#manage").addClass("fa-plus-square");
						$("#create").removeClass("fa-plus-square");
						$("#create").addClass("fa-minus-square");
					}			
				});
				
				$("#edit_zm").click(function() {
					if($(".edit_zm").is(":visible")) {
						$(".edit_zm_").slideUp(500);
						$("#edit_zm_hint").slideUp(500);
						$(".make_zm").slideDown(500);
						$("#make_zm_hint").slideDown(500);
						$("#manage").removeClass("fa-minus-square");
						$("#manage").addClass("fa-plus-square");
						$("#create").removeClass("fa-plus-square");
						$("#create").addClass("fa-minus-square");
					} else if($(".edit_zm").is(":hidden")) {
						$(".edit_zm").slideDown(500);
						$("#edit_zm_hint").slideDown(500);
						$(".make_zm").slideUp(500);
						$("#make_zm_hint").slideUp(500);
						$("#create").removeClass("fa-minus-square");
						$("#create").addClass("fa-plus-square");
						$("#manage").removeClass("fa-plus-square");
						$("#manage").addClass("fa-minus-square");
					}
				});
				
				$('.choose_rd').on('change',function(){
					//	Setze alle angefügten Container zurück
					$('.appended').remove();
					
					//	Wert von ausgewählter Option
					var ridID = $(this).val();
					
					//	Sende AJAX Request zum Prüfen der Anzahl benötigter Select Felder
					$.ajax({
						type: 'POST',
						url: 'includes/backend/get_max_pos.php',
						data: 'rid=' + ridID,
						success: function(callback){
							//	Füge Container zur Auswahl weiterer Positionen hinzu
							$('#appending_container').append(callback);							
						}
					});
				});
				
				//	Speichere alten Wert für Zuweisung der Positionen
				$(document).on('focusin', 'select[class=rid_pos]', function(){
					$(this).data('val', $(this).val());
				});
				
				//	Bei Zuweisung der Positionen berücksichtige bereits gewählte Optionen
				$(document).on('change', 'select[class=rid_pos]', function(){					
					var prev = $(this).data('val');
					var current = $(this).val();
					
					//	Wenn Position gewählt, wird Option bei anderen gesperrt
					if($(".rid_pos").val() != "allocate_pos") {
						$(".rid_pos").not($(this)).find("option[value='" + current + "']").prop("disabled", true);
						
						$(".rid_pos").not($(this)).find("select[class=rid_pos]").prop("disabled", false);
						
						$("#create_zm").prop("disabled", false);
					//	Setze Position zurück und gebe Option frei
					} else if($(".rid_pos").val() == "allocate_pos") {
						$(".rid_pos").not($(this)).find("option[value='" + prev + "']").prop("disabled", false);
						
						$(".rid_pos").not($(this)).find("select[class=rid_pos]").prop("disabled", true);
						
						$("#create_zm").prop("disabled", true);
					}
					
					$(".allocate_pos").prop("disabled", false);
				});
				
				$("#reset").click(function(){
					//	Setze alle angefügten Container zurück
					$('.appended').remove();
				});
				
				// SELECT OPTION CHECK
		        $('#make_zmember_form').submit(function(e){
                    if ($('.rid_pos').val() == '') {
						// STOP FORM SUBMISSION
                        e.preventDefault();
                    }
                });
				
				// RIGHT BEFORE FORM IS SUBMITTED THEY GET ENABLED FOR
				// SUBMITTING "EMPTY" VALUES (SCRIPT LOOPS EXACT AMOUNT)
				$('#edit_delzm_form').submit(function() {
					$('.rd_id_pos_2').removeAttr('disabled');
					$('.rd_id_pos_3').removeAttr('disabled');
					$('.rd_id_pos_4').removeAttr('disabled');
					$('.rd_id_pos_5').removeAttr('disabled');
				});
			});
		</script>
	</body>
</html>