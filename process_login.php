<?php
	//	Setze Fehlerlevel
	error_reporting(E_ALL);
	
	//	Starte Session
	session_start();
	
	//	Setze Marker als Vergleichswert für fehlende Angaben
	$_SESSION['marker'] = 0;
	
	if(isset($_POST['sbmt_aw'])) {
		//	Binde Functions ein
		include_once('includes/backend/functions.php');
		require_once('includes/backend/dbc.php');
		
		//	Bereinige Übergabeparameter
		$uname = cleanInput($_POST['uname_aw']);
		$upass = cleanInput($_POST['upass_aw']);
		
		//	Prüfe auf Remember me
		if(isset($_POST["remember_aw"]) AND ($_POST["remember_aw"] == '1' || $_POST["remember_aw"] == 'on')) {
			$hour = time() + 3600 * 24 * 30;
			setcookie('uname', $uname, $hour);
			setcookie('upass', $upass, $hour);
			setcookie('ltype', 'aw', $hour);
		}
			
		//	Suche nach Login
		$select = "SELECT * FROM `_tkev_sys_accounts` WHERE `umail` = '" . $uname . "'";
		$result = mysqli_query($mysqli, $select);
		$numrow = mysqli_num_rows($result);
			
		//	Benutzer mit dieser Mail gefunden
		if($numrow > 0) {
			$getrow = mysqli_fetch_assoc($result);
			$stored_hash = $getrow['upass'];
				
			//	Prüfe, ob korrektes Passwort eingegeben wurde
			if(password_verify($upass, $stored_hash)) {
				//	Speichere relevante Informationen in Session
				$_SESSION['uid'] = $getrow['uid'];
				$_SESSION['umail'] = $getrow['umail'];
				$_SESSION['utype'] = $getrow['class'];
				$_SESSION['confirmed'] = $getrow['confirmed'];
				$_SESSION['flagged'] = $getrow['flagged'];
				$_SESSION['banned'] = $getrow['banned'];
				$_SESSION['deleted'] = $getrow['deleted'];
					
				//	Prüfe, ob User gesperrt wurde
				if($getrow['banned'] > 0) {
					//	Zerstöre Session
					session_unset();
					session_destroy();
					session_write_close();
					setcookie(session_name(), '', 0, '/');
					session_regenerate_id(true);
					
					header("Location: fail.php?ec=0x2001");
				}
					
				//	Prüfe, ob User "gelöscht" wurde
				if($getrow['deleted'] == 1) {
					//	Zerstöre Session
					session_unset();
					session_destroy();
					session_write_close();
					setcookie(session_name(), '', 0, '/');
					session_regenerate_id(true);
				
					header("Location: fail.php?ec=0x2002");
				}
					
				//	Suche nach Zusatzinformationen
				$select_uinfo = "SELECT `uid`, `title`, `salutation`, `vname`, `nname`, `country`, `postcode`, `city`, `state`, `street`, `number`, `tac` FROM `_tkev_sys_userdata` WHERE `uid` = '" . $getrow['uid'] . "' LIMIT 1";
				$result_uinfo = mysqli_query($mysqli, $select_uinfo);
				$getrow_uinfo = mysqli_fetch_assoc($result_uinfo);
				$numrow_uinfo = mysqli_num_rows($result_uinfo);
					
				if($numrow == 1) {
					//	Speichere Zusatzinformationen in Session
					//	Optionale Angaben
					if($getrow_uinfo['title'] != "") {
						$_SESSION['title'] = $getrow_uinfo['title'];
					} else {
						$_SESSION['title'] = "";
					}
						
					//	Relevante Angaben
					if($getrow_uinfo['salutation'] != "") {
						$_SESSION['anrede'] = $getrow_uinfo['salutation'];
					} else {
						$_SESSION['anrede'] = "";
						$_SESSION['marker'] = 1;
					}
						
					if($getrow_uinfo['vname'] != "") {
						$_SESSION['vname'] = $getrow_uinfo['vname'];
					} else {
						$_SESSION['vname'] = "";
						$_SESSION['marker'] = 1;
					}
					
					if($getrow_uinfo['nname'] != "") {
						$_SESSION['nname'] = $getrow_uinfo['nname'];
					} else {
						$_SESSION['nname'] = "";
						$_SESSION['marker'] = 1;
					}
						
					if($getrow_uinfo['country'] != "") {
						$_SESSION['land'] = $getrow_uinfo['country'];
					} else {
						$_SESSION['land'] = "";
						$_SESSION['marker'] = 1;
					}
						
					if($getrow_uinfo['postcode'] != "") {
						$_SESSION['plz'] = $getrow_uinfo['postcode'];
					} else {
						$_SESSION['plz'] = "";
						$_SESSION['marker'] = 1;
					}
					
					if($getrow_uinfo['city'] != "") {
						$_SESSION['ort'] = $getrow_uinfo['city'];
					} else {
						$_SESSION['ort'] = "";
						$_SESSION['marker'] = 1;
					}
						
					if($getrow_uinfo['street'] != "") {
						$_SESSION['str'] = $getrow_uinfo['street'];
					} else {
						$_SESSION['str'] = "";
						$_SESSION['marker'] = 1;
					}
						
					if($getrow_uinfo['number'] != "") {
						$_SESSION['nr'] = $getrow_uinfo['number'];
					} else {
						$_SESSION['nr'] = "";
						$_SESSION['marker'] = 1;
					}
						
					if($getrow_uinfo['tac'] != "" OR $getrow['tac'] == 1) {
						$_SESSION['agb'] = $getrow_uinfo['tac'];
					} else {
						$_SESSION['agb'] = 0;
						$_SESSION['marker'] = 1;
					}
				//	Keine Zusatzinformationen vorhanden. Marker für Eingabe nach Login
				} else {
					$_SESSION['marker'] = 1;
				}					
					
				//	Logge User ein
				if(isset($_SESSION['uid']) AND $_SESSION['uid'] != "") {
					header("Location: logon.php");
				} else {
					header("Location: fail.php?ec=0x9004");
				}
			} else {
				//	Falsches Passwort, setze Flag
				$update_flag = "UPDATE `_tkev_sys_accounts` SET `flagged` = `flagged` + 1 WHERE `uid` = '" . $getrow['uid'] . "'";
				$result_flag = mysqli_query($mysqli, $update_flag);
					
				//	Füge Flag in Tabelle hinzu
				$insert_flag = "INSERT INTO `_tkev_sys_logintries`(`id`, `uid`, `dt`) VALUES(NULL, '" . $getrow['uid'] . "', '" . date('Y-m-d H:i:s', time()) . "')";
				$result_flag = mysqli_query($mysqli, $insert_flag);
				
				// 	Falsches Passwort
				header("Location: fail.php?ec=0x2003");
			}
		//	User nicht vorhanden
		} elseif($numrow == 0) {
			header("Location: fail.php?ec=0x2004");
		}
	} else {
		header("Location: index.php");
	}
?>