<?php
	//	Debugging
	//	error_reporting(E_ALL);

	//	Binde UUID ein
	require_once 'includes/backend/uuid/uuid.php';

	//	Binde QR Code Generierung ein
	require_once 'includes/backend/phpqrcode/qrlib.php';

	//	Zählervariable für erfolgreiches Anlegen pro Durchlauf
	$success_dummy = 0;

	//	Hole Anzahl der zu erstellenden Dummy-Teilnehmer
	$dummy_amount = mysqli_real_escape_string($mysqli, $_POST["dummy_slider"]);

	//	Prüfe, ob zwischenzeitlich eine Änderung des max. Teilnehmerstandes erfolgt ist
	$select_max_tmember = "SELECT COUNT(*) AS `anzahl` FROM `_tkev_acc_participants` WHERE `eid` = '" . $_SESSION['uid'] . "' AND `finished` = 0";
	$result_max_tmember = mysqli_query($mysqli, $select_max_tmember);
	$getrow_max_tmember = mysqli_fetch_assoc($result_max_tmember);

	$tmember_count = $getrow_max_tmember['anzahl'];

	//	Prüfe, ob zulässige Grenze nicht überschritten wurde
	if($dummy_amount <= (200 - $tmember_count)) {
		//	Suche Kennungsdaten aller aktiven Teilnehmer
		$select_all_participants = "SELECT `eid`, `uname`, `upass`, `qr_validation` FROM `_tkev_acc_participants` WHERE `eid` = '" . $_SESSION['uid'] . "' AND `finished` = 0";
		$result_all_participants = mysqli_query($mysqli, $select_all_participants);
		$numrow_all_participants = mysqli_num_rows($result_all_participants);
		
		//	Erstelle Arrays mit bereits bestehenden Kennungsdaten
		$uname_pool = array();
		$upass_pool = array();
		$qrval_pool = array();
		
		//	Keine aktiven Teilnehmer gefunden
		if($numrow_all_participants == 0) {
			//	Speichere je einen Leerwert in Pool-Arrays
			$uname_pool[] = "";
			$upass_pool[] = "";
			$qrval_pool[] = "";
		} else {
			//	Speichere Kennungsdaten für späteren Abgleich aus DB in Arrays
			while($getrow_all_participants = mysqli_fetch_assoc($result_all_participants)) {
				$uname_pool[] = $getrow_all_participants['uname'];
				$upass_pool[] = $getrow_all_participants['upass'];
				$qrval_pool[] = $getrow_all_participants['qr_validation'];
			}
		}
		
		//	Suche nach höchster aktiver Startnummer
		$select_highest_startnumber = "SELECT `eid`, MAX(`sid`) AS `highest_sid` FROM `_tkev_acc_participants` WHERE `eid` = '" . $_SESSION['uid'] . "' AND `finished` = 0 LIMIT 1";
		$result_highest_startnumber = mysqli_query($mysqli, $select_highest_startnumber);
		$numrow_highest_startnumber = mysqli_num_rows($result_highest_startnumber);
		
		//	Mindestens ein aktiver Teilnehmer für höchste Startnummer gefunden
		if($numrow_highest_startnumber > 0) {
			$getrow_highest_startnumber = mysqli_fetch_assoc($result_highest_startnumber);
			
			$highest_sid = $getrow_highest_startnumber['highest_sid'];
		//	Kein aktiver Teilnehmer gefunden; höchste Startnummer is 1
		} else {
			$highest_sid = 1;
		}		
				
		//	Lege für die festgelegte Anzahl Dummy-Teilnehmer an
		for($i = $highest_sid; $i < ($highest_sid + $dummy_amount); $i++) {
			//	Lege nächste freie Startnummer fest
			$sid = $i + 1;
			
			//	Erstelle zufällige Benutzerkennung
			$uname = rand(100, 999) . rand(100, 999);
					
			//	Erstelle zufälliges Passwort
			$upass = rand(18273645, 51486237);
			
			//	Erstelle QRID und prüfe, ob bereits vorhanden
			$qr_validation = UUID::v4();
			
			//	Prüfe auf Einmaligkeit
			while(in_array($uname, $uname_pool)) {
				//	Erstelle zufällige Benutzerkennung
				$uname = rand(100, 999) . rand(100, 999);
			}
			
			//	Prüfe auf Einmaligkeit
			while(in_array($upass, $upass_pool)) {
				//	Erstelle zufälliges Passwort
				$upass = rand(18273645, 51486237);
			}
			
			//	Prüfe auf Einmaligkeit
			while(in_array($qr_validation, $qrval_pool)) {
				//	Erstelle QRID und prüfe, ob bereits vorhanden
				$qr_validation = UUID::v4();
			}
			
			$tempDir = getcwd() . "/images/qr/";

			$codeContents = 'https://meine.zeitnah.me/qr_login.php?sso=' . $qr_validation;
						
			//	Generiere Dateiname aus Event-ID und Startnummer mit führender Null
			if(strlen($_SESSION['uid']) == 1) {
				$file_eid = "00" . $_SESSION['uid'];
			} elseif(strlen($_SESSION['uid']) == 2) {
				$file_eid = "0" . $_SESSION['uid'];
			} elseif(strlen($_SESSION['uid']) == 3) {
				$file_eid = $_SESSION['uid'];
			}
						
			$fileName = $file_eid . '_' . rand(100, 999) . rand(100, 999) . '_' . md5($codeContents) . '.png';																
			$pngAbsoluteFilePath = $tempDir . $fileName;																
			QRcode::png($codeContents, $pngAbsoluteFilePath);
			
			$query	= 	"INSERT INTO
							`_tkev_acc_participants`(
								`uid`, 
								`eid`, 
								`sid`, 
								`uname`, 
								`upass`,
								`qr_validation`, 
								`image_path`,
								`class`,
								`model`,
								`type`,
								`vintage`,
								`vname1`,
								`nname1`,
								`vname2`,
								`nname2`,
								`ready`,
								`finished`
							)
						VALUES(
							NULL,
							'" . $_SESSION['uid'] . "',
							'" . $sid . "',
							'" . $uname . "', 
							'" . $upass . "', 
							'" . $qr_validation . "', 
							'images/qr/" . $fileName . "', 
							'',
							'',
							'',
							'',
							'',
							'',
							'',
							'',
							'1',
							'0'
						)
						";
	 
			mysqli_query($mysqli, $query);
			
			if(mysqli_affected_rows($mysqli) == 1) {
				$success_dummy++;
			}
		}
		
		if($dummy_amount == $success_dummy AND $dummy_amount > 0) {
			$status_msg = 'Dummy-Teilnehmer wurden vollständig angelegt!';
			$status_color = "green";
		} elseif($dummy_amount == $success_dummy AND $dummy_amount == 0) {
			$status_msg = 'Es wurden keine Dummy-Teilnehmer zum Anlegen gewählt!';
			$status_color = "#FF0000";
		} elseif($dummy_amount != $success_dummy AND $dummy_amount > 0) {
			$status_msg = 'Dummy-Teilnehmer wurden unvollständig angelegt';
			$status_color = "#FFFF00";
		}
	} else {
		$status_msg = 'Sie haben das Maximum um ' . abs($tmember_count - $dummy_amount) . ' Teilnehmer überschritten';
	}
?>