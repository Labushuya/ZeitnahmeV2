<?php
	//	SET ERROR LEVEL
	error_reporting(E_ALL);

	//	INCLUDE CHECKSSL
	include_once('includes/backend/functions.php');
	
	//	EXECUTE CHECKSSL
	checkIsSSL(true);
	
	//	Starte Session
	session_start();
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
							<h1>Registrieren</h1>
						</header>

						<!-- Form -->
						<form method="post" id="form_registration" action="/includes/backend/register.php">
							<div class="row uniform">
								<div class="12u$"><h4>Wahl des Benutzerkontos</h4></div>
								<div class="6u$ 12u$(xsmall)">
									<div class="select-wrapper">
										<?php
											if(isset($_SESSION['utype'])) {
												if($_SESSION['utype'] == "0") {
													$pre_select_aw = "selected";
													$pre_select_va = "";
												} elseif($_SESSION['utype'] == "1") {
													$pre_select_aw = "";
													$pre_select_va = "selected";
												}
											} else {
												$pre_select_aw = "";
												$pre_select_va = "";
											}
										?>
										<select name="utype" id="utype" required>
											<option value="" selected="selected" disabled="disabled">Bitte auswählen</option>
											<option value="0" <?php echo $pre_select_aw; ?>>Auswerter</option>
											<option value="1" <?php echo $pre_select_va; ?> disabled="disabled">Veranstalter</option>
										</select>
									</div>
								</div>
								<div class="12u$"><h4>Benutzerangaben</h4></div>
								<div class="6u$ 12u$(xsmall)">
									<input type="text" name="umail" id="umail" value="<?php if(isset($_SESSION['umail'])) { echo $_SESSION['umail']; } ?>" placeholder="E-Mail" required />
								</div>
								<div class="3u 6u(xsmall)">
									<input type="password" name="upass" id="upass" value="<?php if(isset($_SESSION['upass'])) { echo $_SESSION['upass']; } ?>" placeholder="Passwort" required />
								</div>							
								<div class="3u$ 6u$(xsmall)">
									<input type="password" name="upass2" id="upass2" value="<?php if(isset($_SESSION['upass2'])) { echo $_SESSION['upass2']; } ?>" placeholder="Passwort wdh." required />
								</div>
								<div class="12u$">
									<hr class="major" />
								</div>
								<div class="12u$"><h4>Personenangaben</h4></div>
								<div class="3u 9u(xsmall)">
									<div class="select-wrapper">
										<?php
											if(isset($_SESSION['anrede'])) {
												if($_SESSION['anrede'] == "Herr") {
													$pre_select_m = "selected";
													$pre_select_f = "";
												} elseif($_SESSION['anrede'] == "Frau") {
													$pre_select_m = "";
													$pre_select_f = "selected";
												}
											} else {
												$pre_select_m = "";
												$pre_select_f = "";
											}
										?>
										<select name="anrede" id="anrede" required>
											<option value="" selected="selected" disabled="disabled">Bitte auswählen</option>
											<option value="Herr" <?php echo $pre_select_m; ?>>Herr</option>
											<option value="Frau" <?php echo $pre_select_f; ?>>Frau</option>
										</select>
									</div>
								</div>
								<div class="3u$ 3u$(xsmall)">
									<input type="text" name="title" id="title" value="<?php if(isset($_SESSION['title'])) { echo $_SESSION['title']; } ?>" placeholder="Titel" />
								</div>
								<div class="6u$ 12u$(xsmall)">
									<input type="text" name="vname" id="vname" value="<?php if(isset($_SESSION['vname'])) { echo $_SESSION['vname']; } ?>" placeholder="Vorname" required />
								</div>
								<div class="6u$ 12u$(xsmall)">
									<input type="text" name="nname" id="nname" value="<?php if(isset($_SESSION['nname'])) { echo $_SESSION['nname']; } ?>" placeholder="Nachname" required />
								</div>	
								<div class="4u 8u(xsmall)">
									<input type="text" name="str" id="str" value="<?php if(isset($_SESSION['str'])) { echo $_SESSION['str']; } ?>" placeholder="Straße" required />
								</div>
								<div class="2u$ 4u$(xsmall)">
									<input type="text" name="nr" id="nr" value="<?php if(isset($_SESSION['nr'])) { echo $_SESSION['nr']; } ?>" placeholder="Nr." required />
								</div>	
								<div class="4u 8u(xsmall)">
									<input type="text" name="ort" id="ort" value="<?php if(isset($_SESSION['ort'])) { echo $_SESSION['ort']; } ?>" placeholder="Ort" required />
								</div>
								<div class="2u$ 4u$(xsmall)">
									<input type="text" name="plz" id="plz" value="<?php if(isset($_SESSION['plz'])) { echo $_SESSION['plz']; } ?>" placeholder="PLZ" required />
								</div>
								<div class="12u$">
									<hr class="major" />
								</div>
								<div class="12u$">
									<h4>Allgemeine Geschäftsbedinungen</h4>
								</div>
								<div class="6u$ 12u$(xsmall)">
									<div class="pseudo_textarea scrollbar-macosx" id="agb_container">
										<?php include_once('includes/frontend/content/agb.html'); ?>
									</div>
								</div>
								<div class="6u$ 12u$(xsmall)">
									<?php
										if(isset($_SESSION['agb'])) {
											if($_SESSION['agb'] == "1") {
												$pre_select = "checked";
											} elseif($_SESSION['agb'] == "0") {
												$pre_select = "";
											}
										} else {
											$pre_select = "";
										}
									?>
									<input type="checkbox" id="agb" name="agb" value="1" <?php echo $pre_select; ?> required />
									<label for="agb">Ich habe die AGB gelesen und akzeptiere diese</label>
								</div>
								<div class="12u$">
									<hr class="major" />
								</div>
								<div class="12u$">
									<h4>Registrierung kostenfrei abschließen</h4>
								</div>
								<div class="3u 6u(xsmall)">
									<input type="reset" value="Zurücksetzen" />
								</div>
								<div class="3u$ 6u$(xsmall)" align="right">
									<input type="submit" value="Registrieren" id="register" name="register" class="special" />
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
		    $(document).ready(function() {
				//	MAC OSSX Navigationsleiste
				$('.scrollbar-macosx').scrollbar();
			});
		</script>
	</body>
</html>