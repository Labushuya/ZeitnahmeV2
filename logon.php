<?php
	//	Starte Session und prüfe auf fehlende Angaben
	session_start();
	
	if(isset($_SESSION['uid']) AND $_SESSION['uid'] != "") {
		if($_SESSION['vname'] != "") {
			$greet = "Willkommen zurück, " . $_SESSION['vname'] . "<em>!</em>";
		} else {
			$greet = "Willkommen zurück<em>!</em>";			
		}
		
		if($_SESSION['marker'] == 1) {
			//	Formular zur Vervollständigung der benutzerbezogenen Daten	
			if(isset($_POST['complete'])) {
				//	Prüfe zuerst, ob alle Werte korrekt übergeben wurden
				if($_POST['utype'] == "") {
					header("Location: logon.php");
				}
				
				if($_POST['anrede'] == "") {
					header("Location: logon.php");
				}
				
				if($_POST['vname'] == "") {
					header("Location: logon.php");
				}
				
				if($_POST['nname'] == "") {
					header("Location: logon.php");
				}
				
				if($_POST['str'] == "") {
					header("Location: logon.php");
				}
				
				if($_POST['nr'] == "") {
					header("Location: logon.php");
				}
				
				if($_POST['ort'] == "") {
					header("Location: logon.php");
				}
				
				if($_POST['plz'] == "") {
					header("Location: logon.php");
				}
				
				if($_POST['agb'] == "") {
					header("Location: logon.php");
				}
				
				require_once('includes/backend/dbc.php');
				
				//	Binde Functions ein
				include_once('includes/backend/functions.php');
				
				//	Bereinige Übergabeparameter
				if(isset($_POST['utype'])) {
					$utype 	= cleanInput($_POST['utype']);
					$_SESSION['utype'] = $utype;
				} else {
					$utype 	= cleanInput($_SESSION['utype']);
				}
				
				//	Optionaler Titel
				if(isset($_POST['anrede'])) {
					$whois	= cleanInput($_POST['anrede']);
					
					$_SESSION['anrede'] = $whois;
				} else {
					$whois	= cleanInput($_SESSION['anrede']);
				}
				
				if(isset($_POST['title'])) {
					$title 	= cleanInput($_POST['title']);
					
					$_SESSION['anrede'] = $title;
				} else {
					$title 	= cleanInput($_SESSION['title']);
				}
				
				if(isset($_POST['vname'])) {
					$vname	= cleanInput($_POST['vname']);
					
					$_SESSION['vname'] = $vname;
				} else {
					$vname	= cleanInput($_SESSION['vname']);
				}
				
				if(isset($_POST['nname'])) {
					$nname	= cleanInput($_POST['nname']);
					
					$_SESSION['nname'] = $nname;
				} else {
					$nname	= cleanInput($_SESSION['nname']);
				}
				
				if(isset($_POST['str'])) {
					$str	= cleanInput($_POST['str']);
					
					$_SESSION['str'] = $str;
				} else {
					$str	= cleanInput($_SESSION['str']);
				}
				
				if(isset($_POST['nr'])) {
					$nr 	= cleanInput($_POST['nr']);
					
					$_SESSION['nr'] = $nr;
				} else {
					$nr 	= cleanInput($_SESSION['nr']);
				}
				
				if(isset($_POST['ort'])) {
					$ort 	= cleanInput($_POST['ort']);
					
					$_SESSION['ort'] = $ort;
				} else {
					$ort 	= cleanInput($_SESSION['ort']);
				}
				
				if(isset($_POST['plz'])) {
					$plz 	= cleanInput($_POST['plz']);
					
					$_SESSION['plz'] = $plz;
				} else {
					$plz 	= cleanInput($_SESSION['plz']);
				}
				
				if(isset($_POST['agb'])) {
					$agb 	= cleanInput($_POST['agb']);
					
					$_SESSION['agb'] = $agb;
				} else {
					$agb 	= cleanInput($_SESSION['agb']);
				}
				
				//	Prüfe, ob Benutzer mit E-Mail Adresse bereits vorhanden ist
				$select = "SELECT * FROM `_tkev_sys_accounts` WHERE `uid` = '" . $_SESSION['uid'] . "'";
				$result = mysqli_query($mysqli, $select);
				$numrow = mysqli_num_rows($result);
					
				//	Aktualisiere Benutzer, wenn Eingabe unterschiedlich
				if($utype != $_SESSION['utype']) {
					$update =	"
								UPDATE
									`_tkev_sys_accounts`
								SET
									`utype` = '" . $utype . "'
								WHERE
									`uid` = '" . $_SESSION['uid'] . "'
								";
					//	Aktualisiere Datensatz
					mysqli_query($mysqli, $update);
					
					if(mysqli_affected_rows($mysqli) == 1) {
						$updated_main = 1;
					} elseif(mysqli_affected_rows($mysqli) == 0) {
						$updated_main = 0;
					} 
				} else {
					$updated_main = 1;
				}
				
				//	Aktualisiere Benutzerangaben mit vorherigem Schalter
				$need_update = 0;
				
				if($title != $_SESSION['title']) {
					$need_update = 1;
				}
				
				if($whois != $_SESSION['anrede']) {
					$need_update = 1;
				}
				
				if($vname != $_SESSION['vname']) {
					$need_update = 1;
				}
				
				if($nname != $_SESSION['nname']) {
					$need_update = 1;
				}
				
				if($plz != $_SESSION['plz']) {
					$need_update = 1;
				}
				
				if($str != $_SESSION['str']) {
					$need_update = 1;
				}
				
				if($nr != $_SESSION['nr']) {
					$need_update = 1;
				}
				
				if($agb != $_SESSION['agb']) {
					$need_update = 1;
				}
				
				if($need_update == 1) {
					$update_ud =	"
									UPDATE
										`_tkev_sys_userdata`
									SET
										`title` = '" . $title . "',
										`salutation` = '" . $whois . "',
										`vname` = '" . $vname . "',
										`nname` = '" . $nname . "',
										`country` = 'DE',
										`postcode` = '" . $plz . "',
										`state` = '',
										`street` = '" . $str . "',
										`number` = '" . $nr . "',
										`tac` = '" . $agb . "'
									WHERE
										`uid` = '" . $_SESSION['uid'] . "'
									";
					//	Aktualisiere Datensatz
					mysqli_query($mysqli, $update_ud);
					
					if(mysqli_affected_rows($mysqli) == 1) {
						$updated_opt = 1;
					} elseif(mysqli_affected_rows($mysqli) == 0) {
						$updated_opt = 0;
					}
				} else {
					$updated_opt = 1;
				}
				
				//	Prüfe, ob Daten erfolgreich eingetragen wurden
				if($updated_main == 1 AND $updated_opt == 1) {
					$form =	'
							<div class="row uniform">
								<div class="12u$"><h3>Ihre Daten wurde gespeichert! Login wird fortgesetzt ...</h3><br /></div>
							</div>
							';
					$_SESSION['marker'] = 0;
					echo '<meta http-equiv="refresh" content="3; URL=landing.php">';
				} else {
					$form =	'
							<div class="row uniform">
								<div class="12u$"><h3>Ihre Daten konnten nicht gespeichert werden! Wir werden es später erneut versuchen!</h3><br /></div>
							</div>
							';
					$_SESSION['marker'] = 0;
					echo '<meta http-equiv="refresh" content="3; URL=landing.php">';
				}
			} else {		
				$form =	'
						<form action="' . $_SERVER['PHP_SELF'] . '" method="POST">
							<div class="row uniform">
								<div class="12u$"><h3>Wir haben bemerkt, dass einige Daten nicht ordnungsgemäß übergeben wurden. Bitte vervollständigen Sie Ihre Eingaben, um Ihre Registrierung abzuschließen und den Login fortzusetzen!</h3><br /></div>
								<div class="12u$"><h4>Wahl des Benutzerkontos</h4></div>
								<div class="6u$ 12u$(xsmall)">
									<div class="select-wrapper">
						';
				
				if(isset($_SESSION['utype'])) {
					if($_SESSION['utype'] == "0") {
						$pre_select_aw = "selected";
						$pre_select_va = "";
					} elseif($_SESSION['utype'] == "1") {
						$pre_select_aw = "";
						$pre_select_va = "selected";
					}
					
					$utype_mark = "";
					$utype_read = "readonly";
				} else {
					$pre_select_aw = "";
					$pre_select_va = "";
					
					$utype_mark = "style='border-color: red;'";
					$utype_read = "";
				}
				
				if(isset($_SESSION['vname']) AND $_SESSION['vname'] != "") {
					$vname_mark = "";
					$vname_read = "readonly";
				} elseif(!isset($_SESSION['vname']) OR $_SESSION['vname'] == "") {
					$vname_mark = "style='border-color: red;'";
					$vname_read = "";
				}
				
				if(isset($_SESSION['nname']) AND $_SESSION['nname'] != "") {
					$nname_mark = "";
					$nname_read = "readonly";
				} elseif(!isset($_SESSION['nname']) OR $_SESSION['nname'] == "") {
					$nname_mark = "style='border-color: red;'";
					$nname_read = "";
				}
				
				if(isset($_SESSION['str']) AND $_SESSION['str'] != "") {
					$str_mark = "";
					$str_read = "readonly";
				} elseif(!isset($_SESSION['str']) OR $_SESSION['str'] == "") {
					$str_mark = "style='border-color: red;'";
					$str_read = "";
				}
				
				if(isset($_SESSION['nr']) AND $_SESSION['nr'] != "") {
					$nr_mark = "";
					$nr_read = "readonly";
				} elseif(!isset($_SESSION['nr']) OR $_SESSION['nr'] == "") {
					$nr_mark = "style='border-color: red;'";
					$nr_read = "";
				}
				
				if(isset($_SESSION['ort']) AND $_SESSION['ort'] != "") {
					$ort_mark = "";
					$ort_read = "readonly";
				} elseif(!isset($_SESSION['ort']) OR $_SESSION['ort'] == "") {
					$ort_mark = "style='border-color: red;'";
					$ort_read = "";
				}
				
				if(isset($_SESSION['plz']) AND $_SESSION['plz'] != "") {
					$plz_mark = "";
					$plz_read = "readonly";
				} elseif(!isset($_SESSION['plz']) OR $_SESSION['plz'] == "") {
					$plz_mark = "style='border-color: red;'";
					$plz_read = "";
				}
				
				$form .=	'
										<select name="utype" id="utype" required ' . $utype_mark . ' ' . $utype_read . '>
											<option value="" selected="selected" readonly="readonly">Bitte auswählen</option>
											<option value="0" ' . $pre_select_aw . '>Auswerter</option>
											<option value="1" ' . $pre_select_va . ' readonly="readonly">Veranstalter</option>
										</select>
									</div>
								</div>
								<div class="12u$">
									<hr class="major" />
								</div>
								<div class="12u$"><h4>Benutzerangaben</h4></div>
								<div class="3u 9u(xsmall)">
									<div class="select-wrapper">
							';
				if(isset($_SESSION['anrede'])) {
					if($_SESSION['anrede'] == "Herr") {
						$pre_select_m = "selected";
						$pre_select_f = "";
					} elseif($_SESSION['anrede'] == "Frau") {
						$pre_select_m = "";
						$pre_select_f = "selected";
					}
					
					$anrede_mark = "";
					$anrede_read = "readonly";
				} else {
					$pre_select_m = "";
					$pre_select_f = "";
					
					$anrede_mark = "style='border-color: red;'";
					$anrede_mark = "";
				}
				
				$form .=	'
										<select name="anrede" id="anrede" required ' . $anrede_mark . ' ' . $anrede_read . '>
											<option value="" selected="selected" readonly="readonly">Bitte auswählen</option>
											<option value="Herr" ' . $pre_select_m . '>Herr</option>
											<option value="Frau" ' . $pre_select_f . '>Frau</option>
										</select>
									</div>
								</div>
								<div class="3u$ 3u$(xsmall)">
									<input type="text" name="title" id="title" value="' . $_SESSION['title'] . '" placeholder="Titel" />
								</div>
								<div class="6u$ 12u$(xsmall)">
									<input type="text" name="vname" id="vname" value="' . $_SESSION['vname'] . '"' . $vname_mark . ' ' . $vname_read . ' placeholder="Vorname" required />
								</div>
								<div class="6u$ 12u$(xsmall)">
									<input type="text" name="nname" id="nname" value="' . $_SESSION['nname'] . '" ' . $nname_mark . ' ' . $nname_read . ' placeholder="Nachname" required />
								</div>	
								<div class="4u 8u(xsmall)">
									<input type="text" name="str" id="str" value="' . $_SESSION['str'] . '"' . $str_mark . ' ' . $str_read . '  placeholder="Straße" required />
								</div>
								<div class="2u$ 4u$(xsmall)">
									<input type="text" name="nr" id="nr" value="' . $_SESSION['nr'] . '" ' . $nr_mark . ' ' . $nr_read . ' placeholder="Nr." required />
								</div>	
								<div class="4u 8u(xsmall)">
									<input type="text" name="ort" id="ort" value="' . $_SESSION['ort'] . '" ' . $ort_mark . ' ' . $ort_read . ' placeholder="Ort" required />
								</div>
								<div class="2u$ 4u$(xsmall)">
									<input type="text" name="plz" id="plz" value="' . $_SESSION['plz'] . '" ' . $plz_mark . ' ' . $plz_read . ' placeholder="PLZ" required />
								</div>
							';
				
				if($_SESSION['agb'] == 0) {
					$form .=	'
								<div class="12u$">
									<hr class="major" />
								</div>
								<div class="12u$">
									<h4>Bitte akzeptieren Sie unsere allgemeinen Geschäftsbedinungen</h4>
								</div>
								<div class="6u$ 12u$(xsmall)">
									<div class="pseudo_textarea scrollbar-macosx" id="agb_container">
								';
					
					// $form .=			include_once("includes/frontend/content/agb.html");
					$form .=	'
									</div>
								</div>
								<div class="6u$ 12u$(xsmall)">
								';
					
					if(isset($_SESSION['agb'])) {
						if($_SESSION['agb'] == "1") {
							$pre_select = "checked";
						} elseif($_SESSION['agb'] == "0") {
							$pre_select = "";
						}
						
						$agb_mark = "";
						$agb_read = "readonly";
					} else {
						$pre_select = "";
						
						$agb_mark = "style='border-color: red;'";
						$agb_read = "";
					}
					
					$form .=	'
									<input type="checkbox" id="agb" name="agb" value="1" ' . $pre_select . ' ' . $agb_mark . ' ' . $agb_read . ' required />
									<label for="agb">Ich habe die AGB gelesen und akzeptiere diese</label>
								</div>
								';
				}			
				
				$form .=	'
								<div class="12u$">
									<hr class="major" />
								</div>
								<div class="12u$">
									<h4>Eingaben vervollständigen</h4>
								</div>
								<div class="3u 6u(xsmall)">
									<input type="reset" value="Zurücksetzen" />
								</div>
								<div class="3u$ 6u$(xsmall)" align="right">
									<input type="submit" value="Registrierung abschließen" id="complete" name="complete" class="special" />
								</div>
							</div>
						</form>
						';
			}
		} else {
			echo '<meta http-equiv="refresh" content="3; URL=landing.php">';
		}
	} else {
		header("Location: index.php");
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
					<!-- SUCCESS CONTENT -->
					<section>
						<header class="main">
							<h1><?php echo $greet; ?></h1>
						</header>

						<p>
							<h3><?php echo $form; ?></h3>
							
						</p>

						<hr class="major" />
					</section>
				</div>
			</div>
		</div>
				
		<!--	INCLUDING JSX LIB	-->
		<?php include_once("lib/jsx_library.html"); ?>
	</body>
</html>