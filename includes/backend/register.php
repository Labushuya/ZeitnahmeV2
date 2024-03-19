<?php
	//	Setze Fehlerlevel
	error_reporting(E_ALL);
	
	//	Binde Functions ein
	include_once('functions.php');
	
	//	Deklariere Fehlervariable
	/*
		[0] =>	Kein Fehler
		[1] =>	Unterschiedliche Passwörter
		[2] =>	
		[0] =>	
		[0] =>	
		[0] =>		
	*/
	$error = "";

	if(isset($_POST['register'])) {		
		//	Bereinige Übergabeparameter
		$utype 	= cleanInput($_POST['utype']);
		
		$upass 	= cleanInput($_POST['upass']);
		$upass2	= cleanInput($_POST['upass2']);
		$umail 	= cleanInput($_POST['umail']);
		$whois	= cleanInput($_POST['anrede']);
		
		//	Optionaler Titel
		if(isset($_POST['title'])) {
			$title 	= cleanInput($_POST['title']);
		} else {
			$title = "";
		}
		
		$vname	= cleanInput($_POST['vname']);
		$nname	= cleanInput($_POST['nname']);
		$str	= cleanInput($_POST['str']);
		$nr 	= cleanInput($_POST['nr']);
		$ort 	= cleanInput($_POST['ort']);
		$plz 	= cleanInput($_POST['plz']);
		$agb 	= cleanInput($_POST['agb']);
		
		//	Starte Session
		session_start();
		
		//	Überführe in globale Übergabeparameter
		$_SESSION['utype'] = $utype;
		$_SESSION['upass'] = $upass;
		$_SESSION['upass2'] = $upass2;
		$_SESSION['umail'] = $umail;
		$_SESSION['anrede'] = $whois;
		$_SESSION['title'] = $title;
		$_SESSION['vname'] = $vname;
		$_SESSION['nname'] = $nname;
		$_SESSION['str'] = $str;
		$_SESSION['nr'] = $nr;
		$_SESSION['ort'] = $ort;
		$_SESSION['plz'] = $plz;
		$_SESSION['agb'] = $agb;
				
		//	Prüfe, ob Passwörter identisch sind
		if($upass == $upass2) {
			//	Prüfe, ob Passwort sicher genug
			//	Passwortlänge mind. 6 Stellen lang?
			if(mb_strlen($upass) >= 6) {
				//	Passwort beinhaltet Großbuchstaben, Zahlen und Sonderzeichen
				if(preg_match('/[A-Z]{1,}/', $upass) AND preg_match('/[0-9]{1,}/', $upass) AND preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $upass)) {
					//	Generiere Hash aus Passwort
					$upass = password_hash($upass, PASSWORD_DEFAULT);
					
					require_once('dbc.php');
					
					//	Generiere Bestätigungscode
					$confirmationcode = bin2hex(random_bytes(32));
					
					//	Prüfe, ob generierter Bestätigungscode bereits vorhanden ist
					$select_cc = "SELECT * FROM `_tkev_sys_accounts` WHERE `confirmationcode` = '" . $confirmationcode . "'";
					$result_cc = mysqli_query($mysqli, $select_cc);
					$numrow_cc = mysqli_num_rows($result_cc);
					
					//	Generiere solange neuen Bestätigungscode bis nicht in DB vorhanden
					if($numrow_cc > 0) {
						while($numrow_cc > 0) {
							//	Generiere neuen Bestätigungscode
							$confirmationcode = bin2hex(random_bytes(32));
							
							//	Prüfe, ob neu generierter Bestätigungscode bereits vorhanden ist
							$select_cc = "SELECT * FROM `_tkev_sys_accounts` WHERE `confirmationcode` = '" . $confirmationcode . "'";
							$result_cc = mysqli_query($mysqli, $select_cc);
							$numrow_cc = mysqli_num_rows($result_cc);
							
							if($numrow_cc == 0) {
								break;
							} else {
								continue;
							}
						}
					}
					
					//	Prüfe, ob Benutzer mit E-Mail Adresse bereits vorhanden ist
					$select = "SELECT * FROM `_tkev_sys_accounts` WHERE `umail` = '" . $umail . "'";
					$result = mysqli_query($mysqli, $select);
					$numrow = mysqli_num_rows($result);
					
					//	Benutzer nicht vorhanden
					if($numrow == 0) {
						//	Lege Benutzer an
						$insert =	"
									INSERT INTO
										`_tkev_sys_accounts`(
											`uid`,
											`umail`,
											`upass`,
											`class`,
											`confirmationcode`,
											`confirmed`,
											`flagged`,
											`banned`,
											`deleted`
										)
									VALUES (
										NULL,
										'" . $umail . "',
										'" . $upass . "',
										'" . $utype . "',
										'" . $confirmationcode . "',
										'1',
										'0',
										'0',
										'0'
									)
									";
						//	Füge Datensatz ein
						mysqli_query($mysqli, $insert);
						
						//	Suche nach eingefügtem Datensatz für Zusatzinformationen
						$select_ins = "SELECT * FROM `_tkev_sys_accounts` WHERE `umail` = '" . $umail . "'";
						$result_ins = mysqli_query($mysqli, $select_ins);
						$numrow_ins = mysqli_num_rows($result_ins);
						
						if($numrow_ins > 0) {
							$getrow_ins = mysqli_fetch_assoc($result_ins);
							$id = $getrow_ins['uid'];
							
							//	Suche nach Zusatzinformationen für diesen Benutzer (pro forma)
							$select_zi = "SELECT * FROM `_tkev_sys_userdata` WHERE `uid` = '" . $uid . "'";
							$result_zi = mysqli_query($mysqli, $result_zi);
							$numrow_zi = mysqli_num_rows($result_zi);
							
							//	Keine DB-Leiche(n) für diesen Benutzer vorhanden
							if($numrow_zi == 0) {
								//	Lege Zusatzinformationen für diesen Benutzer an
								$insert_ud =	"
												INSERT INTO
													`_tkev_sys_userdata`(
														`id`,
														`uid`,
														`title`,
														`salutation`,
														`vname`,
														`nname`,
														`country`,
														`postcode`,
														`city`,
														`state`,
														`street`,
														`number`,
														`tac`
													)
												VALUES (
													NULL,
													'" . $uid . "',
													'" . $title . "',
													'" . $whois . "',
													'" . $vname . "',
													'" . $nname . "',
													'DE',
													'" . $plz . "',
													'" . $ort . "',
													'',
													'" . $str . "',
													'" . $nr . "',
													'" . $agb . "'
												)
												";
								//	Füge Datensatz ein
								mysqli_query($mysqli, $insert_ud);
								
								//	Prüfe, ob Zusatzinformationen für diesen Benutzer angelegt wurden
								if(mysqli_affected_rows == 0) {
									//	Fehler: Zusatzinformationen konnten nicht angelegt werden
									$error = "0x9003";
									
									$empfaenger = 'mindsourcesdotnet@web.de';
									$betreff = $error . ' - Zusatzinformationen konnten nicht angelegt werden!';
									$nachricht =	"
													Beim Erstellen des Benutzers mit der E-Mail Adresse <strong>" . $umail . "</strong> ist ein Fehler aufgetreten.
													<br />
													<br />
													Fehlercode: " . $error . " - Zusatzinformationen konnten nicht angelegt werden!
													<br />
													Übermittelte Daten:
													<br />
													UID: " . $uid . "
													<br />
													Titel: " . $title . "
													<br />
													Anrede: " . $whois . "
													<br />
													Vorname: " . $vname . "
													<br />
													Nachname: " . $nname . "
													<br />
													Straße: " . $str . "
													<br />
													Nummer: " . $nr . "
													<br />
													PLZ: " . $plz . "
													<br />
													Ort: " . $ort . "
													<br />
													AGB: " . $agb . "
													<br />
													";
									$header =	'From: error_handler@zeitnah.me' . "\r\n" .
												'Reply-To: ' . $umail . "\r\n" .
												'X-Mailer: PHP/' . phpversion();

									mail($empfaenger, $betreff, $nachricht, $header);
								}
							} else {
								//	Wenn Leiche(n) vorhanden sind, lösche zugehörige Datensätze
								$delete_del = "DELETE FROM `_tkev_sys_userdata` WHERE `uid` = '" . $uid . "'";
								$result_del = mysqli_query($mysqli, $delete_del);
								
								//	Prüfe, ob erfolgreich gelöscht
								if($mysqli_affected_rows == 0) {
									//	Fehler: Datenleichen konnten nicht gelöscht werden
									$error = "0x9002";
									
									$empfaenger = 'mindsourcesdotnet@web.de';
									$betreff = $error . ' - Datenleichen konnten nicht gelöscht werden!';
									$nachricht =	"
													Beim Erstellen des Benutzers mit der E-Mail Adresse <strong>" . $umail . "</strong> ist ein Fehler aufgetreten.
													<br />
													<br />
													Fehlercode: " . $error . " - Datenleichen konnten nicht gelöscht werden!
													<br />
													Übermittelte Daten:
													<br />
													UID: " . $uid . "
													<br />
													Titel: " . $title . "
													<br />
													Anrede: " . $whois . "
													<br />
													Vorname: " . $vname . "
													<br />
													Nachname: " . $nname . "
													<br />
													Straße: " . $str . "
													<br />
													Nummer: " . $nr . "
													<br />
													PLZ: " . $plz . "
													<br />
													Ort: " . $ort . "
													<br />
													AGB: " . $agb . "
													<br />
													";
									$header =	'From: error_handler@zeitnah.me' . "\r\n" .
												'Reply-To: ' . $umail . "\r\n" .
												'X-Mailer: PHP/' . phpversion();

									mail($empfaenger, $betreff, $nachricht, $header);
								}
							}
						} else {
							//	Fehler: Benutzer konnte nicht angelegt werden
							$error = "0x9001";
							
							$empfaenger = 'mindsourcesdotnet@web.de';
							$betreff = $error . ' - Benutzer konnte nicht angelegt werden!';
							$nachricht =	"
											Beim Erstellen des Benutzers mit der E-Mail Adresse <strong>" . $umail . "</strong> ist ein Fehler aufgetreten.
											<br />
											<br />
											Fehlercode: " . $error . " - Benutzer konnte nicht angelegt werden!
											<br />
											Übermittelte Daten:
											<br />
											UID: " . $uid . "
											<br />
											Pass: " . $upass . "
											<br />
											Confirmation: " . $confirmationcode . "
											<br />
											Type: " . $utype . "
											<br />
											Confirmed: 1
											<br />
											Flagged: 0
											<br />
											Banned: 0
											<br />
											Deleted: 0
											<br />
											Titel: " . $title . "
											<br />
											Anrede: " . $whois . "
											<br />
											Vorname: " . $vname . "
											<br />
											Nachname: " . $nname . "
											<br />
											Straße: " . $str . "
											<br />
											Nummer: " . $nr . "
											<br />
											PLZ: " . $plz . "
											<br />
											Ort: " . $ort . "
											<br />
											AGB: " . $agb . "
											<br />
											";
							$header =	'From: error_handler@zeitnah.me' . "\r\n" .
										'Reply-To: ' . $umail . "\r\n" .
										'X-Mailer: PHP/' . phpversion();
							mail($empfaenger, $betreff, $nachricht, $header);
						}
					} else {
						//	Fehler: E-Mail Adresse bereits vorhanden
						$error = "0x1004";
					}
				} else {
					//	Fehler: Passwort enthält keine Großbuchstaben, Zahlen oder Sonderzeichen
					$error = "0x1003";
				}
			} else {
				//	Fehler: Passwort hat weniger als 6 Stellen
				$error = "0x1002";
			}			
		} else {
			//	Fehler: Unterschiedliche Passwörter
			$error = "0x1001";
		}
		
		//	Gebe Fehlerstatus als Callback aus (0 => Alles okay)
		if($error == "") {
			header("Location: ../../success.php");
		} else {
			header("Location: ../../fail.php?ec=" . $error);
		}
	} else {
		header("Location: ../../index.php");
	}
?>