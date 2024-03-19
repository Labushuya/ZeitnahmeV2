<?php
	//	Debugging
	//	error_reporting(E_ALL);

	//	Binde UUID ein
	require_once 'includes/backend/uuid/uuid.php';

	//	Binde QR Code Generierung ein
	require_once 'includes/backend/phpqrcode/qrlib.php';

	//	Zählervariable für erfolgreiches Anlegen pro Durchlauf
	$success_update = 0;
	$success_insert = 0;

	//	Prüfe, ob zwischenzeitlich eine Änderung des max. Teilnehmerstandes erfolgt ist
	$select_max_tmember = "SELECT COUNT(*) AS `anzahl` FROM `_tkev_acc_participants` WHERE `eid` = '" . $_SESSION['uid'] . "' AND `finished` = 0";
	$result_max_tmember = mysqli_query($mysqli, $select_max_tmember);
	$getrow_max_tmember = mysqli_fetch_assoc($result_max_tmember);

	$tmember_count = $getrow_max_tmember['anzahl'];

	//	Prüfe, ob zulässige Grenze nicht überschritten wurde
	if((count($_POST['mt_id']) / 9) <= (200 - $tmember_count)) {
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
		
		for($i = 0; $i < count($_POST['mt_id']); $i++) {
			$sid   = mysqli_real_escape_string($mysqli, $_POST['mt_id'][$i]);
			$i++;
			$class   = mysqli_real_escape_string($mysqli, $_POST['mt_id'][$i]);
			$i++;
			$baujahr   = mysqli_real_escape_string($mysqli, $_POST['mt_id'][$i]);
			$i++;
			$fabrikat   = mysqli_real_escape_string($mysqli, $_POST['mt_id'][$i]);
			$i++;
			$typ   = mysqli_real_escape_string($mysqli, $_POST['mt_id'][$i]);
			$i++;
			$vname1    = mysqli_real_escape_string($mysqli, $_POST['mt_id'][$i]);
			$i++;
			$nname1    = mysqli_real_escape_string($mysqli, $_POST['mt_id'][$i]);
			$i++;
			$vname2    = mysqli_real_escape_string($mysqli, $_POST['mt_id'][$i]);
			$i++;
			$nname2    = mysqli_real_escape_string($mysqli, $_POST['mt_id'][$i]);
			
			//	Suche nach bestehender aktiver Startnummer
			$select_current_startnumber = "SELECT `eid`, `sid` FROM `_tkev_acc_participants` WHERE `eid` = '" . $_SESSION['uid'] . "' AND `sid` = '" . $_SESSION['uid'] . "' AND `finished` = 0 LIMIT 1";
			$result_current_startnumber = mysqli_query($mysqli, $select_current_startnumber);
			$numrow_current_startnumber = mysqli_num_rows($result_current_startnumber);
			
			//	Prüfvariable für Update oder Insert
			$query_type = "";
			
			//	Startnummer gefunden
			if($numrow_current_startnumber == 1) {
				$getrow_current_startnumber = mysqli_fetch_assoc($result_current_startnumber);
				
				//	Abfrage ist Update
				$query_type = "Update";
				
				//	Aktualisiere bestehende Teilnehmerdaten
				$query	= 	"
							UPDATE
								`_tkev_acc_participants`
							SET
								`class` = '" . $class . "',
								`model` = '" . $fabrikat . "',
								`type` = '" . $typ . "',
								`vintage` = '" . $baujahr . "',
								`vname1` = '" . $vname1 . "',
								`nname1` = '" . $nname1 . "',
								`vname2` = '" . $vname2 . "',
								`nname2` = '" . $nname2 . "'
							WHERE
								`eid` = '" . $_SESSION['uid'] . "'
							AND
								`sid` = '" . $sid . "'
							AND
								`finished` = 0
							";
				$result_query = mysqli_query($mysqli, $query);
										
				if(mysqli_affected_rows($mysqli) == 1) {
					$success_update++;
				}
			//	Kein aktiver Teilnehmer mit dieser Startnummer gefunden
			} else {
				//	Teilnehmer wird neu angelegt
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
				
				//	Abfrage ist Update
				$query_type = "Insert";
				
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
								'" . $class . "',
								'" . $fabrikat . "',
								'" . $typ . "',
								'" . $baujahr . "',
								'" . $vname1 . "',
								'" . $nname1 . "',
								'" . $vname2 . "',
								'" . $nname2 . "',
								'1',
								'0'
							)
							";
				$result_query = mysqli_query($mysqli, $query);
										
				if(mysqli_affected_rows($mysqli) == 1) {
					$success_insert++;
				}
			}
		}
		
		if($query_type == "Update") {
			if($success_update == (count($_POST['mt_id']) / 9)) {
				$status_msg = 'Teilnehmerdaten aktualisiert!';
				$status_color = "green";
			} elseif($success_update != (count($_POST['mt_id']) / 9)) {
				if($success_update == 0) {
					$status_msg = 'Teilnehmerdaten bereits aktualisiert!';
					$status_color = "#FFFF00";
				} elseif($success_update > 0) {
					$status_msg = 'Teilnehmerdaten unvollständig aktualisiert!';
					$status_color = "#FF0000";
				}
			} elseif($success_update != (count($_POST['mt_id']) / 9) AND $success_update == 0) {
				$status_msg = 'Teilnehmerdaten konnten nicht aktualisiert werden!';
				$status_color = "#FF0000";
			}
		} elseif($query_type == "Insert") {
			if($success_insert == (count($_POST['mt_id']) / 9)) {
				$status_msg = 'Teilnehmerdaten angelegt!';
				$status_color = "green";
			} elseif($success_insert != (count($_POST['mt_id']) / 9)) {
				if($success_insert == 0) {
					$status_msg = 'Teilnehmerdaten bereits angelegt!';
					$status_color = "green";
				} elseif($success_insert > 0) {
					$status_msg = 'Teilnehmerdaten unvollständig angelegt!';
					$status_color = "#FF0000";
				}
			} elseif($success_insert != (count($_POST['mt_id']) / 9) AND $success_insert == 0) {
				$status_msg = 'Teilnehmerdaten konnten nicht angelegt werden!';
				$status_color = "#FF0000";
			}
		}
	} else {
		$status_msg = 'Sie haben das Maximum um ' . abs($tmember_count - $dummy_amount) . ' Teilnehmer überschritten';
		$status_color = "#FF0000";
	}
?>