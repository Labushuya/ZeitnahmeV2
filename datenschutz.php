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
							<h1>Datenschutzerklärung</h1>
						</header>

						<p align="justify">
							Die nachfolgende Datenschutzerklärung gilt für die Nutzung der Webseite [www.zeitnah.me] (nachfolgend „Website“). 
							<br />
							<br />
							Wir messen dem Datenschutz große Bedeutung bei. Die Erhebung und Verarbeitung Ihrer personenbezogenen Daten geschieht unter 
							Beachtung der geltenden datenschutzrechtlichen Vorschriften, insbesondere der EU-Datenschutzgrundverordnung (DSGVO). Wir 
							erheben und verarbeiten Ihre personenbezogenen Daten, um Ihnen das oben genannten Portal anbieten zu können. Diese Erklärung 
							beschreibt, wie und zu welchem Zweck Ihre Daten erfasst und genutzt werden und welche Wahlmöglichkeiten Sie im Zusammenhang 
							mit persönlichen Daten haben. Durch Ihre Verwendung dieser Website stimmen Sie der Erfassung, Nutzung und Übertragung Ihrer 
							Daten gemäß dieser Datenschutzerklärung zu.
						</p>
						<hr class="major" />
						<h3>1. Verantwortliche Stelle</h3>
						<p>
							Verantwortliche Stelle für die Erhebung, Verarbeitung und Nutzung Ihrer personenbezogenen Daten im Sinne der DSGVO ist 
							<br />
							<br />
							<strong><span style="color: #8e6516;">zeitnah|me</span></strong> GbR,
							<br />
							<strong>
							<u>vertreten durch:</u>
							<br />
							Sebastian T. Bott und Christopher H. Bott
							</strong>
							<br />
							Bgm.-Hund-Straße 22
							<br />
							68766 Hockenheim
							<br />
							E-Mail: <a href="mailto:kontakt@zeitnah.me">kontakt@zeitnah.me</a>
							<br />
							Telefon: +49 178 1457 367
							<br />
							<p align="justify">
							Sofern Sie der Erhebung, Verarbeitung oder Nutzung Ihrer Daten durch uns nach Maßgabe dieser Datenschutzbestimmungen 
							insgesamt oder für einzelne Maßnahmen widersprechen wollen, können Sie Ihren Widerspruch an oben genannte verantwortliche 
							Stelle richten. Sie können diese Datenschutzerklärung jederzeit speichern und ausdrucken.
							</p>
						</p>
						<h3>2. Allgemeine Zwecke der Verarbeitung</h3>
						<p align="justify">
							Wir verwenden personenbezogene Daten zum Zweck des Betriebs der Website.
						</p>
						<h3>3. Welche Daten wir verwenden und warum</h3>
						<h3>3.1 Hosting</h3>
						<p align="justify">
							Die von uns in Anspruch genommenen Hosting-Leistungen dienen der Zurverfügungstellung der folgenden Leistungen: Infrastruktur- 
							und Plattformdienstleistungen, Rechenkapazität, Speicherplatz und Datenbankdienste, Sicherheitsleistungen sowie technische 
							Wartungsleistungen, die wir zum Zweck des Betriebs der Website einsetzen.
							<br />
							<br />
							Hierbei verarbeiten wir, bzw. unser Hostinganbieter Bestandsdaten, Kontaktdaten, Inhaltsdaten, Vertragsdaten, Nutzungsdaten, 
							Meta- und Kommunikationsdaten von Kunden, Interessenten und Besuchern dieser Website auf Grundlage unserer berechtigten Interessen 
							an einer effizienten und sicheren Zurverfügungstellung unserer Website gem. Art. 6 Abs. 1 S. 1 f) DSGVO i.V.m. Art. 28 DSGVO.
						</p>
						<h3>3.2 Zugriffsdaten</h3>
						<p align="justify">
							Wir sammeln Informationen über Sie, wenn Sie diese Website nutzen. Wir erfassen automatisch Informationen über Ihr Nutzungsverhalten 
							und Ihre Interaktion mit uns und registrieren Daten zu Ihrem Computer oder Mobilgerät. Wir erheben, speichern und nutzen Daten über 
							jeden Zugriff auf unsere Website (sogenannte Serverlogfiles). Zu den Zugriffsdaten gehören:
							
							<ul class="ul">
								<li>Name und URL der abgerufenen Datei</li>
								<li>Datum und Uhrzeit des Abrufs</li>
								<li>übertragene Datenmenge</li>
								<li>Meldung über erfolgreichen Abruf (HTTP response code)</li>
								<li>Browsertyp und Browserversion</li>
								<li>Betriebssystem</li>
								<li>Referer URL (d.h. die zuvor besuchte Seite)</li>
								<li>Websites, die vom System des Nutzers über unsere Website aufgerufen werden</li>
								<li>Internet-Service-Provider des Nutzers</li>
								<li>IP-Adresse und der anfragende Provider</li>
							</ul>
							
							Wir nutzen diese Protokolldaten ohne Zuordnung zu Ihrer Person oder sonstiger Profilerstellung für statistische Auswertungen zum Zweck 
							des Betriebs, der Sicherheit und der Optimierung unserer Website, aber auch zur anonymen Erfassung der Anzahl der Besucher auf unserer 
							Website (traffic) sowie zum Umfang und zur Art der Nutzung unserer Website und Dienste, ebenso zu Abrechnungszwecken, um die Anzahl der 
							von Kooperationspartnern erhaltenen Clicks zu messen. Aufgrund dieser Informationen können wir personalisierte und standortbezogene 
							Inhalte zur Verfügung stellen und den Datenverkehr analysieren, Fehler suchen und beheben und unsere Dienste verbessern.
							<br />
							<br />
							Hierin liegt auch unser berechtigtes Interesse gemäß Art 6 Abs. 1 S. 1 f) DSGVO.
							<br />
							<br />
							Wir behalten uns vor, die Protokolldaten nachträglich zu überprüfen, wenn aufgrund konkreter Anhaltspunkte der berechtigte Verdacht einer 
							rechtswidrigen Nutzung besteht. IP-Adressen speichern wir für einen begrenzten Zeitraum in den Logfiles, wenn dies für Sicherheitszwecke 
							erforderlich oder für die Leistungserbringung oder die Abrechnung einer Leistung nötig ist, z. B. wenn Sie eines unserer Angebote nutzen. 
							Nach Abbruch des Vorgangs der Bestellung oder nach Zahlungseingang löschen wir die IP-Adresse, wenn diese für Sicherheitszwecke nicht mehr 
							erforderlich ist. IP-Adressen speichern wir auch dann, wenn wir den konkreten Verdacht einer Straftat im Zusammenhang mit der Nutzung unserer 
							Website haben. Außerdem speichern wir als Teil Ihres Accounts das Datum Ihres letzten Besuchs (z.B. bei Registrierung, Login, Klicken von 
							Links etc.).
						</p>
						<h3>3.3 Cookies</h3>
						<p align="justify">
							Wir verwenden sogenannte Session-Cookies, um unsere Website zu optimieren. Ein Session-Cookie ist eine kleine Textdatei, die von den jeweiligen 
							Servern beim Besuch einer Internetseite verschickt und auf Ihrer Festplatte zwischengespeichert wird. Diese Datei als solche enthält eine 
							sogenannte Session-ID, mit welcher sich verschiedene Anfragen Ihres Browsers der gemeinsamen Sitzung zuordnen lassen. Dadurch kann Ihr Rechner 
							wiedererkannt werden, wenn Sie auf unsere Website zurückkehren. Diese Cookies werden gelöscht, nachdem Sie Ihren Browser schließen. Sie dienen 
							z. B. dazu, dass Sie die Warenkorbfunktion über mehrere Seiten hinweg nutzen können.
							<br />
							<br />
							Wir verwenden in geringem Umfang auch persistente Cookies (ebenfalls kleine Textdateien, die auf Ihrem Endgerät abgelegt werden), die auf Ihrem 
							Endgerät verbleiben und es uns ermöglichen, Ihren Browser beim nächsten Besuch wiederzuerkennen. Diese Cookies werden auf Ihrer Festplatte 
							gespeichert und löschen sich nach der vorgegebenen Zeit von allein. Ihre Lebensdauer beträgt 1 Monat bis 10 Jahre. So können wir Ihnen unser 
							Angebot nutzerfreundlicher, effektiver und sicherer präsentieren und Ihnen beispielsweise speziell auf Ihre Interessen abgestimmte Informationen 
							auf der Seite anzeigen.
							<br />
							<br />
							Unser berechtigtes Interesse an der Nutzung der Cookies gemäß Art 6 Abs. 1 S. 1 f) DSGVO liegt darin, unsere Website nutzerfreundlicher, 
							effektiver und sicherer zu machen.
							<br />
							<br />
							In den Cookies werden etwa folgende Daten und Informationen gespeichert:
							
							<ul class="ul">
								<li>Log-In-Informationen</li>
								<li>Spracheinstellungen</li>
								<li>eingegebene Suchbegriffe</li>
								<li>Informationen über die Anzahl der Aufrufe unserer Website sowie Nutzung einzelner Funktionen unseres Internetauftritts</li>
							</ul>
							
							Bei Aktivierung des Cookies wird diesem eine Identifikationsnummer zugewiesen und eine Zuordnung Ihrer personenbezogenen Daten zu dieser 
							Identifikationsnummer wird nicht vorgenommen. Ihr Name, Ihre IP-Adresse oder ähnliche Daten, die eine Zuordnung des Cookies zu Ihnen ermöglichen 
							würden, werden nicht in den Cookie eingelegt. Auf Basis der Cookie-Technologie erhalten wir lediglich pseudonymisierte Informationen, beispielsweise 
							darüber, welche Seiten unseres Shops besucht wurden, welche Produkte angesehen wurden, etc.
							<br />
							<br />
							Sie können Ihren Browser so einstellen, dass Sie über das Setzen von Cookies vorab informiert werden und im Einzelfall entscheiden können, ob 
							Sie die Annahme von Cookies für bestimmte Fälle oder generell ausschließen, oder dass Cookies komplett verhindert werden. Dadurch kann die 
							Funktionalität der Website eingeschränkt werden.
						</p>
						<h3>3.4	Daten zur Erfüllung unserer vertraglichen Pflichten</h3>
						<p align="justify">
							Wir verarbeiten personenbezogene Daten, die wir zur Erfüllung unserer vertraglichen Pflichten benötigen, etwa Name, Adresse, E-Mail-Adresse, 
							bestellte Produkte, Rechnungs- und Zahlungsdaten. Die Erhebung dieser Daten ist für den Vertragsschluss erforderlich. 
							<br />
							<br />
							Die Löschung der Daten erfolgt nach Ablauf der Gewährleistungsfristen und gesetzlicher Aufbewahrungsfristen. Daten, die mit einem Nutzerkonto 
							verknüpft sind (siehe unten), bleiben in jedem Fall für die Zeit der Führung dieses Kontos erhalten.
							<br />
							<br />
							Die Rechtgrundlage für die Verarbeitung dieser Daten ist Art. 6 Abs. 1 S. 1 b) DSGVO, denn diese Daten werden benötigt, damit wir unsere vertraglichen 
							Pflichten Ihnen gegenüber erfüllen können. 
						</p>
						<h3>3.5	E-Mail Kontakt</h3>
						<p align="justify">
							Wenn Sie mit uns in Kontakt treten (z. B. per Kontaktformular oder E-Mail), verarbeiten wir Ihre Angaben zur Bearbeitung der Anfrage sowie für den 
							Fall, dass Anschlussfragen entstehen. 
							<br />
							<br />
							Erfolgt die Datenverarbeitung zur Durchführung vorvertraglicher Maßnahmen, die auf Ihre Anfrage hin erfolgen, bzw., wenn Sie bereits unser Kunde sind, 
							zur Durchführung des Vertrages, ist Rechtsgrundlage für diese Datenverarbeitung Art. 6 Abs. 1 S. 1 b) DSGVO.
							<br />
							<br />
							Weitere personenbezogene Daten verarbeiten wir nur, wenn Sie dazu einwilligen (Art. 6 Abs. 1 S. 1 a) DSGVO) oder wir ein berechtigtes Interesse an der 
							Verarbeitung Ihrer Daten haben (Art. 6 Abs. 1 S. 1 f) DSGVO). Ein berechtigtes Interesse liegt z. B. darin, auf Ihre E-Mail zu antworten.
						</p>
						<h3>4. Google Analytics</h3>
						<p align="justify">
							Wir benutzen Google Analytics, einen Webanalysedienst der Google Inc. („Google“). Google Analytics verwendet sog. „Cookies“, Textdateien, 
							die auf Ihrem Computer gespeichert werden und die eine Analyse der Benutzung der Website durch Sie ermöglichen. Die durch den Cookie erzeugten 
							Informationen über Benutzung dieser Website durch die Seitenbesucher werden in der Regel an einen Server von Google in den USA übertragen und 
							dort gespeichert.
							<br />
							<br />
							Im Falle der Aktivierung der IP-Anonymisierung auf dieser Webseite, wird Ihre IP-Adresse von Google jedoch innerhalb von Mitgliedstaaten der 
							Europäischen Union oder in anderen Vertragsstaaten des Abkommens über den Europäischen Wirtschaftsraum zuvor gekürzt. Nur in Ausnahmefällen wird 
							die volle IP-Adresse an einen Server von Google in den USA übertragen und dort gekürzt. Die IP-Anonymisierung ist auf dieser Website aktiv. In 
							unserem Auftrag wird Google diese Informationen benutzen, um die Nutzung der Website durch Sie auszuwerten, um Reports über die Websiteaktivitäten 
							zusammenzustellen und um weitere mit der Websitenutzung und der Internetnutzung verbundene Dienstleistungen uns gegenüber zu erbringen.
							<br />
							<br />
							Die im Rahmen von Google Analytics von Ihrem Browser übermittelte IP-Adresse wird nicht mit anderen Daten von Google zusammengeführt. Sie können die 
							Speicherung der Cookies durch eine entsprechende Einstellung Ihrer Browser-Software verhindern; wir weisen Sie jedoch darauf hin, dass Sie in diesem 
							Fall gegebenenfalls nicht sämtliche Funktionen dieser Website vollumfänglich werden nutzen können.
							<br />
							<br />
							Sie können darüber hinaus die Erfassung der durch das Cookie erzeugten und auf ihre Nutzung der Website bezogenen Daten (inkl. Ihrer IP-Adresse) an 
							Google sowie die Verarbeitung dieser Daten durch Google verhindern, indem Sie das unter dem folgenden Link verfügbare Browser-Plugin herunterladen und 
							installieren: <a href="http://tools.google.com/dlpage/gaoptout?hl=de" target="_blank">Google Analytics Opt-Out</a>.
							<br />
							<br />
							Alternativ zum Browser-Plugin oder innerhalb von Browsern auf mobilen Geräten können Sie auf den folgenden Link klicken, um ein Opt-Out-Cookie zu setzen, 
							der die Erfassung durch Google Analytics innerhalb dieser Website zukünftig verhindert (dieses Opt-Out-Cookie funktioniert nur in diesem Browser und nur 
							für diese Domain. Löschen Sie die Cookies in Ihrem Browser, müssen Sie diesen Link erneut klicken): <a href=“javascript:gaOptout()“>Google Analytics deaktivieren</a>.
						</p>
						<h3>5. Speicherdauer</h3>
						<p align="justify">
							Sofern nicht spezifisch angegeben speichern wir personenbezogene Daten nur so lange, wie dies zur Erfüllung der verfolgten Zwecke notwendig ist.
							<br />
							<br />
							In einigen Fällen sieht der Gesetzgeber die Aufbewahrung von personenbezogenen Daten vor, etwa im Steuer- oder Handelsrecht. In diesen Fällen werden die Daten 
							von uns lediglich für diese gesetzlichen Zwecke weiter gespeichert, aber nicht anderweitig verarbeitet und nach Ablauf der gesetzlichen Aufbewahrungsfrist gelöscht.  
						</p>
						<h3>6. Ihre Rechte als von der Datenverarbeitung Betroffener</h3>
						<p align="justify">
							Nach den anwendbaren Gesetzen haben Sie verschiedene Rechte bezüglich Ihrer personenbezogenen Daten. Möchten Sie diese Rechte geltend machen, so richten Sie 
							Ihre Anfrage bitte per E-Mail oder per Post unter eindeutiger Identifizierung Ihrer Person an die in Ziffer 1 genannte Adresse.
							<br />
							<br />
							Nachfolgend finden Sie eine Übersicht über Ihre Rechte.
						</p>
						<h3>6.1 Recht auf Bestätigung und Auskunft</h3>
						<p>
							Sie haben das Recht auf eine übersichtliche Auskunft über die Verarbeitung Ihrer personenbezogenen Daten.
							<br />
							<br />
							Im Einzelnen:
							<br />
							<br />
							Sie haben jederzeit das Recht, von uns eine Bestätigung darüber zu erhalten, ob Sie betreffende personenbezogene Daten verarbeitet werden. Ist dies der 
							Fall, so haben Sie das Recht, von uns eine unentgeltliche Auskunft über die zu Ihnen gespeicherten personenbezogenen Daten nebst einer Kopie dieser Daten 
							zu verlangen. Des Weiteren besteht ein Recht auf folgende Informationen: 
							
							<ol class="ol">
								<li>die Verarbeitungszwecke;</li>
								<li>die Kategorien personenbezogener Daten, die verarbeitet werden;</li>
								<li>die Empfänger oder Kategorien von Empfängern, gegenüber denen die personenbezogenen Daten offengelegt worden sind oder noch offengelegt werden, 
								insbesondere bei Empfängern in Drittländern oder bei internationalen Organisationen;</li>
								<li>falls möglich, die geplante Dauer, für die die personenbezogenen Daten gespeichert werden, oder, falls dies nicht möglich ist, die Kriterien 
								für die Festlegung dieser Dauer;</li>
								<li>das Bestehen eines Rechts auf Berichtigung oder Löschung der Sie betreffenden personenbezogenen Daten oder auf Einschränkung der Verarbeitung 
								durch den Verantwortlichen oder eines Widerspruchsrechts gegen diese Verarbeitung;</li>
								<li>das Bestehen eines Beschwerderechts bei einer Aufsichtsbehörde;</li>
								<li>wenn die personenbezogenen Daten nicht bei Ihnen erhoben werden, alle verfügbaren Informationen über die Herkunft der Daten;</li>
								<li>das Bestehen einer automatisierten Entscheidungsfindung einschließlich Profiling gemäß Art. 22 Abs. 1 und 4 DSGVO und – zumindest in diesen 
								Fällen – aussagekräftige Informationen über die involvierte Logik sowie die Tragweite und die angestrebten Auswirkungen einer derartigen Verarbeitung 
								für Sie.</li>
							</ol>
							
							Werden personenbezogene Daten an ein Drittland oder an eine internationale Organisation übermittelt, so haben Sie das Recht, über die geeigneten Garantien 
							gemäß Art. 46 DSGVO im Zusammenhang mit der Übermittlung unterrichtet zu werden.
						</p>
						<h3>6.2 Recht auf Berichtigung</h3>
						<p align="justify">
							Sie haben das Recht, von uns die Berichtigung und ggf. auch Vervollständigung Sie betreffender personenbezogener Daten zu verlangen.
							<br />
							<br />
							Im Einzelnen:
							<br />
							<br />
							Sie haben das Recht, von uns unverzüglich die Berichtigung Sie betreffender unrichtiger personenbezogener Daten zu verlangen. Unter Berücksichtigung der 
							Zwecke der Verarbeitung haben Sie das Recht, die Vervollständigung unvollständiger personenbezogener Daten – auch mittels einer ergänzenden Erklärung – 
							zu verlangen.
						</p>
						<h3>Recht auf Löschung ("Recht auf Vergessenwerden")</h3>
						<p align="justify">
							In einer Reihe von Fällen sind wir verpflichtet, Sie betreffende personenbezogene Daten zu löschen.
							<br />
							<br />
							Im Einzelnen:
							<br />
							<br />
							Sie haben gemäß Art. 17 Abs. 1 DSGVO das Recht, von uns zu verlangen, dass Sie betreffende personenbezogene Daten unverzüglich gelöscht werden, und 
							wir sind verpflichtet, personenbezogene Daten unverzüglich zu löschen, sofern einer der folgenden Gründe zutrifft:
							
							<ol class="ol">
								<li>Die personenbezogenen Daten sind für die Zwecke, für die sie erhoben oder auf sonstige Weise verarbeitet wurden, nicht mehr notwendig.</li>
								<li>Sie widerrufen Ihre Einwilligung, auf die sich die Verarbeitung gemäß Art. 6 Abs. 1 S. 1  a) DSGVO oder Art. 9 Abs. 2 a) DSGVO stützte, und 
								es fehlt an einer anderweitigen Rechtsgrundlage für die Verarbeitung.</li>
								<li>Sie legen gemäß Art. 21 Abs. 1 DSGVO Widerspruch gegen die Verarbeitung ein und es liegen keine vorrangigen berechtigten Gründe für die 
								Verarbeitung vor, oder Sie legen gemäß Art. 21 Abs. 2 DSGVO Widerspruch gegen die Verarbeitung ein.</li>
								<li>Die personenbezogenen Daten wurden unrechtmäßig verarbeitet.</li>
								<li>Die Löschung der personenbezogenen Daten ist zur Erfüllung einer rechtlichen Verpflichtung nach dem Unionsrecht oder dem Recht der 
								Mitgliedstaaten erforderlich, dem wir unterliegen.</li>
								<li>Die personenbezogenen Daten wurden in Bezug auf angebotene Dienste der Informationsgesellschaft gemäß Art. 8 Abs. 1 DSGVO erhoben.</li>
							</ol>
							
							Haben wir die personenbezogenen Daten öffentlich gemacht und sind wir gemäß Art. 17 Abs. 1 DSGVO zu deren Löschung verpflichtet, so treffen wir unter 
							Berücksichtigung der verfügbaren Technologie und der Implementierungskosten angemessene Maßnahmen, auch technischer Art, um für die Datenverarbeitung 
							Verantwortliche, die die personenbezogenen Daten verarbeiten, darüber zu informieren, dass Sie von ihnen die Löschung aller Links zu diesen personenbezogenen 
							Daten oder von Kopien oder Replikationen dieser personenbezogenen Daten verlangt haben.
						</p>
						<h3>6.4 Recht auf Einschränkung der Verarbeitung</h3>
						<p align="justify">
							In einer Reihe von Fällen sind Sie berechtigt, von uns eine Einschränkung der Verarbeitung Ihrer personenbezogenen Daten zu verlangen.
							<br />
							<br />
							Im Einzelnen:
							<br />
							<br />
							Sie haben das Recht, von uns die Einschränkung der Verarbeitung zu verlangen, wenn eine der folgenden Voraussetzungen gegeben ist:
							
							<ol class="ol">
								<li>die Richtigkeit der personenbezogenen Daten wird von Ihnen bestritten, und zwar für eine Dauer, die es uns ermöglicht, die Richtigkeit der 
								personenbezogenen Daten zu überprüfen,</li>
								<li>die Verarbeitung unrechtmäßig ist und Sie die Löschung der personenbezogenen Daten ablehnten und stattdessen die Einschränkung der Nutzung 
								der personenbezogenen Daten verlangt haben;</li>
								<li>wir die personenbezogenen Daten für die Zwecke der Verarbeitung nicht länger benötigen, Sie die Daten jedoch zur Geltendmachung, Ausübung 
								oder Verteidigung von Rechtsansprüchen benötigen, oder</li>
								<li>Sie Widerspruch gegen die Verarbeitung gemäß Art. 21 Abs. 1 DSGVO eingelegt haben, solange noch nicht feststeht, ob die berechtigten Gründe 
								unseres Unternehmens gegenüber den Ihren überwiegen.</li>
							</ol>
						</p>
						<h3>6.5 Recht auf Datenübertragbarkeit</h3>
						<p align="justify">
							Sie haben das Recht, Sie betreffende personenbezogene Daten maschinenlesbar zu erhalten, zu übermitteln, oder von uns übermitteln zu lassen.
							<br />
							<br />
							Im Einzelnen: 
							<br />
							<br />
							Sie haben das Recht, die Sie betreffenden personenbezogenen Daten, die Sie uns bereitgestellt haben, in einem strukturierten, gängigen und 
							maschinenlesbaren Format zu erhalten, und Sie haben das Recht, diese Daten einem anderen Verantwortlichen ohne Behinderung durch uns zu übermitteln, 
							sofern
							
							<ol class="ol">
								<li>die Verarbeitung auf einer Einwilligung gemäß Art. 6 Abs. 1 S. 1 a) DSGVO oder Art. 9 Abs. 2 a) DSGVO oder auf einem Vertrag gemäß Art. 
								6 Abs. 1 S. 1 b) DSGVO beruht und</li>
								<li>die Verarbeitung mithilfe automatisierter Verfahren erfolgt.</li>
							</ol>
							
							Bei der Ausübung Ihres Rechts auf Datenübertragbarkeit gemäß Absatz 1 haben Sie das Recht, zu erwirken, dass die personenbezogenen Daten direkt von uns 
							einem anderen Verantwortlichen übermittelt werden, soweit dies technisch machbar ist.
						</p>
						<h3>6.6 Widerspruchsrecht</h3>
						<p align="justify">
							Sie haben das Recht, aus einer rechtmäßigen Verarbeitung Ihrer personenbezogenen Daten durch uns zu widersprechen, wenn sich dies aus Ihrer besonderen 
							Situation begründet und unsere Interessen an der Verarbeitung nicht überwiegen. 
							<br />
							<br />
							Im Einzelnen: 
							<br />
							<br />
							Sie haben das Recht, aus Gründen, die sich aus Ihrer besonderen Situation ergeben, jederzeit gegen die Verarbeitung Sie betreffender personenbezogener 
							Daten, die aufgrund von Art. 6 Abs. 1 S. 1 e) oder f) DSGVO erfolgt, Widerspruch einzulegen; dies gilt auch für ein auf diese Bestimmungen gestütztes 
							Profiling. Wir verarbeiten die personenbezogenen Daten nicht mehr, es sei denn, wir können zwingende schutzwürdige Gründe für die Verarbeitung nachweisen, 
							die Ihre Interessen, Rechte und Freiheiten überwiegen, oder die Verarbeitung dient der Geltendmachung, Ausübung oder Verteidigung von Rechtsansprüchen.
							<br />
							<br />
							Werden personenbezogene Daten von uns verarbeitet, um Direktwerbung zu betreiben, so haben Sie das Recht, jederzeit Widerspruch gegen die Verarbeitung 
							Sie betreffender personenbezogener Daten zum Zwecke derartiger Werbung einzulegen; dies gilt auch für das Profiling, soweit es mit solcher Direktwerbung 
							in Verbindung steht.
							<br />
							<br />
							Sie haben das Recht, aus Gründen, die sich aus Ihrer besonderen Situation ergeben, gegen die Sie betreffende Verarbeitung Sie betreffender personenbezogener 
							Daten, die zu wissenschaftlichen oder historischen Forschungszwecken oder zu statistischen Zwecken gemäß Art. 89 Abs. 1 DSGVO erfolgt, Widerspruch einzulegen, 
							es sei denn, die Verarbeitung ist zur Erfüllung einer im öffentlichen Interesse liegenden Aufgabe erforderlich.
						</p>
						<h3>6.7	Automatisierte Entscheidungen einschließlich Profiling</h3>
						<p align="justify">
							Sie haben das Recht, nicht einer ausschließlich auf einer automatisierten Verarbeitung – einschließlich Profiling – beruhenden Entscheidung unterworfen zu 
							werden, die Ihnen gegenüber rechtliche Wirkung entfaltet oder Sie in ähnlicher Weise erheblich beeinträchtigt.
							<br />
							<br />
							Eine automatisierte Entscheidungsfindung auf der Grundlage der erhobenen personenbezogenen Daten findet nicht statt.
						</p>
						<h3>6.8	Recht auf Widerruf einer datenschutzrechtlichen Einwilligung</h3>
						<p align="justify">
							Sie haben das Recht, eine Einwilligung zur Verarbeitung personenbezogener Daten jederzeit zu widerrufen.
						</p>
						<h3>6.9	Recht auf Beschwerde bei einer Aufsichtsbehörde</h3>
						<p align="justify">
							Sie haben das Recht auf Beschwerde bei einer Aufsichtsbehörde, insbesondere in dem Mitgliedstaat Ihres Aufenthaltsorts, Ihres Arbeitsplatzes oder des Orts des 
							mutmaßlichen Verstoßes, wenn Sie der Ansicht sind, dass die Verarbeitung der Sie betreffenden personenbezogenen Daten rechtswidrig ist.
						</p>
						<h3>7. Datensicherheit</h3>
						<p align="justify">
							Wir sind um die Sicherheit Ihrer Daten im Rahmen der geltenden Datenschutzgesetze und technischen Möglichkeiten maximal bemüht.
							<br />
							<br />
							Ihre persönlichen Daten werden bei uns verschlüsselt übertragen. Dies gilt für Ihre Bestellungen und auch für das Kundenlogin. Wir nutzen das Codierungssystem 
							SSL (Secure Socket Layer), weisen jedoch darauf hin, dass die Datenübertragung im Internet (z.B. bei der Kommunikation per E-Mail) Sicherheitslücken aufweisen kann. 
							Ein lückenloser Schutz der Daten vor dem Zugriff durch Dritte ist nicht möglich.
							<br />
							<br />
							Zur Sicherung Ihrer Daten unterhalten wir technische und organisatorische Sicherungsmaßnahmen entsprechend Art. 32 DSGVO, die wir immer wieder dem Stand der 
							Technik anpassen. 
							<br />
							<br />
							Wir gewährleisten außerdem nicht, dass unser Angebot zu bestimmten Zeiten zur Verfügung steht; Störungen, Unterbrechungen oder Ausfälle können nicht ausgeschlossen 
							werden. Die von uns verwendeten Server werden regelmäßig sorgfältig gesichert.
						</p>
						<h3>8. Weitergabe von Daten an Dritte, keine Datenübertragung ins Nicht-EU-Ausland</h3>
						<p align="justify">
							Grundsätzlich verwenden wir Ihre personenbezogenen Daten nur innerhalb unseres Unternehmens.
							<br />
							<br />
							Wenn und soweit wir Dritte im Rahmen der Erfüllung von Verträgen einschalten (etwa Logistik-Dienstleister), erhalten diese personenbezogene Daten nur in dem Umfang, 
							in welchem die Übermittlung für die entsprechende Leistung erforderlich ist.
							<br />
							<br />
							Für den Fall, dass wir bestimmte Teile der Datenverarbeitung auslagern („Auftragsverarbeitung“), verpflichten wir Auftragsverarbeiter vertraglich dazu, personenbezogene 
							Daten nur im Einklang mit den Anforderungen der Datenschutzgesetze zu verwenden und den Schutz der Rechte der betroffenen Person zu gewährleisten.
							<br />
							<br />
							Eine Datenübertragung an Stellen oder Personen außerhalb der EU außerhalb des in dieser Erklärung in Ziffer 4 genannten Falls findet nicht statt und ist nicht geplant.
						</p>
						<h3>9. Datenschutzbeauftragter</h3>
						<p align="justify">
							Sollten Sie noch Fragen oder Bedenken zum Datenschutz haben, so wenden Sie sich bitte an unseren Datenschutzbeauftragten:
							<br />
							<br />
							Christopher H. Bott
							<br />
							<br />
							(Siehe Punkt 1)
						</p>
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
				$('.scrollbar-macosx').scrollbar();
			});
		</script>
	</body>
</html>