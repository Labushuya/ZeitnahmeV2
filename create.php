<?php
	//	SET ERROR LEVEL
	error_reporting(E_ALL);

	//	INCLUDE CHECKSSL
	include_once('includes/backend/functions.php');
	
	//	EXECUTE CHECKSSL
	checkIsSSL(true);
	
	//	Starte Session
	session_start();
	
	//	Prüfe immer auf aktiven Login
	if(!isset($_SESSION['uid']) OR empty($_SESSION['uid']) OR $_SESSION['uid'] == "") {
		header("Location: process_logout.php");
	} else {
		//	Prüfe auf bereits vorhandene, aktive Veranstaltung(en)
		require_once("includes/backend/dbc.php");
		
		$select_active = "SELECT * FROM `_tkev_nfo_event` WHERE `eid` = '" . $_SESSION['uid'] . "' AND `active` = 1";
		$result_active = mysqli_query($mysqli, $select_active);
		$numrow_active = mysqli_num_rows($result_active);
		
		if($numrow_active > 0) {
			header("Location: landing.php");
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
					<!-- REGISTRATION -->
					<section>
						<header class="main">
							<h1>Veranstaltung erstellen</h1>
						</header>

						<!-- Form -->
						<form action="process_create.php" method="POST" name="make_event_form" enctype="multipart/form-data">
							<div class="row uniform">
								<div class="12u$"><h4>Organisatorische Angaben</h4></div>
								<div class="6u$ 12u$(xsmall)">
									<input type="text" class="input" name="eventname" id="eventname" value="" placeholder="Veranstaltung" required />
								</div>
								<div class="6u$ 12u$(xsmall)">
									<input type="text" class="input" name="eventhandler" id="eventhandler" value="" placeholder="Veranstalter" required />
								</div>
								<div class="3u 6u(xsmall)">
									<div class="select-wrapper">
										<select name="zeitenberechnung" id="zeitenberechnung" required>
											<option value="" selected="selected" disabled="disabled">Art der Berechnung</option>
											<option value="1">Ab Start</option>
											<option value="2">Einzeln</option>
											<option value="3" disabled>S|Z ges.</option>
										</select>
									</div>
								</div>
								<div class="2u 4u(xsmall)">
									<div class="select-wrapper">
										<select name="reference" id="reference" required>
											<option value="" selected="selected" disabled="disabled">Referenzlauf?</option>
											<option value="0">Nein</option>
											<option value="1">Ja</option>
										</select>
									</div>
								</div>
								<div class="1u$ 2u$(xsmall)">
									<div class="select-wrapper">
										<select name="bezeichnung" id="bezeichnung" required>
											<option value="" selected="selected" disabled="disabled">Typ</option>
											<option value="GP">GP</option>
											<option value="SP">SP</option>
											<option value="WP">WP</option>
										</select>
									</div>
								</div>
								<div id="0" class="6u$ 12u$(xsmall) t_calc_type">
									&nbsp;
								</div>
								<div id="1" class="6u$ 12u$(xsmall) t_calc_type" style="display: none; text-align: center;">
									Die Fahrtzeit wird immer <strong>ab Start</strong> berechnet
								</div>
								<div id="2" class="6u$ 12u$(xsmall) t_calc_type" style="display: none; text-align: center;">
									Die Fahrtzeit wird immer <strong>einzeln</strong> berechnet
								</div>
								<div id="2" class="6u$ 12u$(xsmall) t_calc_type" style="display: none; border: 1px solid #8E6516; color: #8E6516; text-align: center;">
									Die Fahrtzeit wird immer ausgleichend berechnet
								</div>
								<div class="3u 6u(xsmall)">
									<input type="text" name="karenzzeit" id="karenzzeit" value="" placeholder="HH:MM" pattern="^(([01]?[0-9]|2[0-3]):[0-5][0-9]){1}$" required />
								</div>
								<div class="3u$ 6u$(xsmall)">
									<input type="file" name="logo" id="logo_upload" accept="image/*" style="display: none;" />
									<a id="logo" class="button icon fa-download upload" style="solid 1px rgba(210, 215, 217, 0.75) !important;"> Logo der Veranstaltung</a>
								</div>
								<div class="12u$">
									<hr class="major" />
								</div>
								<div class="12u$"><h4>Dauer der Veranstaltung</h4></div>
								<div class="3u 6u(xsmall)">
									<input type="text" name="start" id="start" value="" placeholder="TT.MM.JJJJ" required="required" pattern="^((0[1-9]|[1-2][0-9]|3[0-1]).(0[1-9]|1[0-2]).([1-9]{1}[0-9]{3}))$" required />
								</div>							
								<div class="3u$ 6u$(xsmall)">
									<input type="text" name="end" id="end" value="" placeholder="TT.MM.JJJJ" required="required" pattern="^((0[1-9]|[1-2][0-9]|3[0-1]).(0[1-9]|1[0-2]).([1-9]{1}[0-9]{3}))$" required />
								</div>
								<div class="12u$">
									<hr class="major" />
								</div>
								<div class="12u$">
									<h4>Veranstaltung erstellen</h4>
								</div>
								<div class="3u 6u(xsmall)">
									<input type="reset" value="Zurücksetzen" />
								</div>
								<div class="3u$ 6u$(xsmall)" align="right">
									<input type="submit" value="Erstellen" id="create" name="create" class="special" />
								</div>
							</div>
						</form>
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
			$(document).ready(function(){
				//	File Upload
				$("#logo").click(function() {
					$("#logo_upload").trigger("click");
				});
				
				$(function($){
					$("#karenzzeit").mask("99:99",{placeholder:"HH:MM"});
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
					$('#start').datepicker('option', 'dateFormat', 'dd/mm/yy')
				);	

				var d = new Date();
				var monthNames = [
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
								];
				today = monthNames[d.getMonth()] + ' ' + d.getDate() + ' ' + d.getFullYear();

				$('#end').attr('disabled', 'disabled');
				$('#start').datepicker({
					defaultDate: "+1d",
					minDate: 1,
					maxDate: "+1y",
					dateFormat: 'dd.mm.yy',
					required: true,
					showOn: "focus",
					numberOfMonths: 1,
				});

				$('#start').change(function () {
					var from = $('#start').datepicker('getDate');
					var date_diff = Math.ceil((from.getTime() - Date.parse(today)) / 86400000);
					var maxDate_d = date_diff + 14 + 'd';
					date_diff = date_diff + 'd';
					$('#end').val('').removeAttr('disabled').removeClass('hasDatepicker').datepicker({
						dateFormat: 'dd.mm.yy',
						minDate: date_diff,
						maxDate: maxDate_d
					});
				});

				$('#end').keyup(function () {
					$(this).val('');
					alert('Please select date from Calendar');
				});
				$('#start').keyup(function () {
					$('#start,#end').val('');
					$('#end').attr('disabled', 'disabled');
					alert('Please select date from Calendar');
				});

				// EVENT HANDLER ON KEYUP
				$(".input").keyup(function() {
					// CALL FUNCTION
					var cp_value = ucwords($(this).val(),true) ;
					$(this).val(cp_value );
				});
			
				// FUNCTION FOR CAPITALIZING AFTER DASHES AND HYPHENS
				function ucwords(str,force) {
					str = force ? str.toLowerCase() : str;
					return str.replace(/(^([a-züöäßA-ZÜÖÄ\p{M}]))|([ -][a-züöäßA-ZÜÖÄ\p{M}])/g,
					function(firstLetter) {
					   return firstLetter.toUpperCase();
					});
				}
				
				// CALCULATION HINT BASED ON SELECT OPTION
				$('#zeitenberechnung').change(function() {
					$('.t_calc_type').hide();
					$('#' + $(this).val()).show();
				});
			});
		</script>
	</body>
</html>