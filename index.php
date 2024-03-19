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
				<div class="scrollbar-macosx inner">
					<!-- Header -->
					<header id="header">
						<a href="/" class="logo"><span style="font-weight: 800;">zeitnah|me</span> &ndash; Die Datenbank im Motorsport!</a>
						<!-- SOCIAL MEDIA -->
						<?php // include_once('includes/frontend/build/social_media.html'); ?>
					</header>
					
					<!-- CONTENT SECTIONS -->
					<!-- BANNER -->
					<section id="banner">
						<div class="content">
							<header>
								<h1>Willkommen!</h1>
								<p style="color: #b68c2f; letter-spacing: 0.05em;">zeitnah|me - Wer wir sind und was wir tun</p>
							</header>
							<p align="justify"><font color="#8e6516">zeitnah|me</font> vereinfacht die Art und Weise, Ihre Motorsport relevanten Daten während der Veranstaltung online zu verwalten und Ihren Teilnehmern zur Verfügung zu stellen. So sind schnellere und vor allem reibungslosere Abläufe während der gesamten Veranstaltung und darüber hinaus möglich. Mit <font color="#8e6516">zeitnah|me</font> haben Sie Ihre Zeiten stets griffbereit - zentral an einem Punkt!</p>
							<ul class="actions">
								<li><a href="#" class="button big" id="intro" style="color: #c0c0c0 !important;">mehr erfahren</a></li>
							</ul>
						</div>
						<span class="image object">
							<!-- <img src="images/pic10.jpg" alt="" /> -->
							<!-- <img src="images/subway.jpg" alt="" style="border: 1px solid #8E6515;" />	 -->
							<img src="images/subway.jpg" alt="" style="border: 1px solid #8E6515;" />
						</span>
					</section>

					<!-- INFOGRAPHICS -->
					<section>
						<header class="major" id="ad">
							<h2>Unser System</h2>
						</header>
						<div class="posts">
							<article>
								<h3>Was</h3>
								<p align="justify">Ihre Veranstaltung läuft wie gewohnt ab. Der Unterschied besteht darin, dass Ihr(e) Zeitnehmer die bereits bekannten Zeiten der Teilnehmer in unser System einträgt. Die exakte Berechnung - basierend auf den von Ihnen im Vorfeld festgelegten Einstellungen - erfolgt augenblicklich und ist jederzeit abrufbar - <span style="color: #8e6516;">auch nach der Veranstaltung!</span></p>
							</article>
							<article>
								<h3>Wie</h3>
								<p align="justify">Sie erstellen eine Veranstaltung und nehmen entsprechende Einstellungen vor. Basierend hierauf errechnet unser System die von Ihren Zeitnehmern übermittelten Zeiten. Darüber hinaus haben Sie die Möglichkeit, bereits vorhandene Zeiten für weitere Arbeiten Ihrerseits zu exportieren. Oder Sie lassen uns Ihre Auswertung erstellen - <span style="color: #8e6516;">ganz egal wie umfangreich!</span></p>
							</article>
							<article>
								<h3>Wo</h3>
								<p align="justify">Sie können jederzeit und von überall aus auf Ihre Zeiten zugreifen. Sie benötigen lediglich eine aktive Internetverbindung. Um die Übermittlung der prüfungsrelevanten Zeiten Ihrer Zeitnehmer zu gewährleisten, schaltet unser System automatisch in den Offline-Modus, sollte eine aktive Internetverbindung derzeit nicht möglich sein - <span style="color: #8e6516;">Ihre Zeiten bleiben erhalten!</span></p>
							</article>
						</div>
					</section> 
					
					<!-- ADVERTISE -->
					<section>
						<header class="major">
							<h2>Wir haben Sie noch nicht überzeugt?</h2>
						</header>
						<div class="features">
							<article>
								<span class="icon fa-user"></span>
								<div class="content">
									<h3>Benutzerfreundlichkeit</h3>
									<p>Denn lange Einarbeitungszeiten gehören nicht zu unserem Leitbild. Eine intuitive Benutzeroberfläche und kinderleichte Handhabung sind da eher unser Ding!</p>
								</div>
							</article>
							<article>
								<span class="icon fa-code"></span>
								<div class="content">
									<h3>Webbasierend</h3>
									<p>Mit stetiger Zunahme von Webanwendungen ist auch unser Dienst gänzlich webbasierend und erfordert keinerlei Downloaden oder Installation!</p>
								</div>
							</article>
							<article>
								<span class="icon fa-rocket"></span>
								<div class="content">
									<h3>Autonomes Design</h3>
									<p>Nerviges Heranzoomen oder Hin- und Herwischen ade! Diese Webseite versteht etwas vom guten Ton und passt sich Ihrem Endgerät an - nicht umgekehrt!</p>
								</div>
							</article>
							<article>
								<span class="icon fa-signal"></span>
								<div class="content">
									<h3>Barrierefreier Zugriff</h3>
									<p>Greifen Sie überall und jederzeit auf Ihre Zeiten zu. Mehr als eine Internetverbindung werden Sie nicht benötigen!</p>
								</div>
							</article>
							<article>
								<span class="icon fa-lock"></span>
								<div class="content">
									<h3>Sicherheit</h3>
									<p>Manipulationen von Außen sind ausgeschlossen. Sie autorisieren den Zugriff für Funktionäre und Teilnehmer per Zugang und Kennung!</p>
								</div>
							</article>
							<article>
								<span class="icon fa-exclamation"></span>
								<div class="content">
									<h3>Und ..</h3>
									<p>Anpassung an Ihre Bedürftnisse wären durch ständige Weiterentwicklung möglich!</p>
								</div>
							</article>
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
								<!-- LOGIN -->
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
	</body>
</html>