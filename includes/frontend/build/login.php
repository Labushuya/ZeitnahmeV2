<?php
	if(isset($_SESSION['uid']) AND $_SESSION['uid'] != "") {
		echo	'
				<a id="logout_trigger" href="process_logout.php" class="btn" style="background-color: #333; color: #b68c2f; border: 1px solid #c0c0c0;">Ausloggen</a>
				';
	} else {
		//	Prüfe Reminder
		if(isset($_COOKIE['uname']) AND isset($_COOKIE['upass'])) {
			if($_COOKIE['ltype'] == "aw") {
				$pre_select_rmd_aw = "checked='checked'";
				$pre_select_rmd_ft = "";
				$pre_select_rmd_mt = "";
			} elseif($_COOKIE['ltype'] == "ft") {
				$pre_select_rmd_aw = "";
				$pre_select_rmd_ft = "checked='checked'";
				$pre_select_rmd_mt = "";
			} elseif($_COOKIE['ltype'] == "mt") {
				$pre_select_rmd_aw = "";
				$pre_select_rmd_ft = "";
				$pre_select_rmd_mt = "checked='checked'";
			}
		} else {
			$pre_select_rmd_aw = "";
			$pre_select_rmd_ft = "";
			$pre_select_rmd_mt = "";
		}
		
		echo	'
    				<a id="modal_trigger" href="#modal" class="btn" style="background-color: #333; color: #b68c2f; border: 1px solid #c0c0c0;">Einloggen</a>
				
				<div id="modal" class="popupContainer" style="display:none;">
					<header class="popupHeader">
						<span class="header_title">Hallo Gast!</span>
						<span class="modal_close"><i class="fa fa-times"></i></span>
					</header>
							
					<section class="popupBody">
						<!-- Login Typ -->
						<div class="social_login">
							<div class="">
								<!--
								<a href="#" class="social_box fb">
									<span class="icon"><i class="fa fa-facebook"></i></span>
									<span class="icon_title">Connect with Facebook</span>	
								</a>

								<a href="#" class="social_box google">
									<span class="icon"><i class="fa fa-google-plus"></i></span>
									<span class="icon_title">Connect with Google</span>
								</a>
								-->
								
								<a href="#" class="social_box login" id="login_aw">
									<span class="icon"><i class="fa fa-area-chart"></i></span>
									<span class="icon_title">Auswerter Login</span>	
								</a>

								<a href="#" class="social_box login" id="login_ft">
									<span class="icon"><i class="fa fa-clock-o"></i></span>
									<span class="icon_title">Funktionär Login</span>
								</a>
								
								<a href="#" class="social_box login" id="login_mt">
									<span class="icon"><i class="fa fa-car"></i></span>
									<span class="icon_title">Teilnehmer Login</span>
								</a>
							</div>

							<div class="centeredText">
								<span>Oder registrieren Sie sich</span>
							</div>

							<div class="action_btns">
								<!--
								<div class="one_half"><a href="#" id="login_form" class="btn">Login</a></div>
								<div class="one_half last"><a href="#" id="register_form" class="btn">Sign up</a></div>
								<div class="one_half"><a href="#" id="login_form" class="btn">Mehr</a></div>
								<div class="one_half last"><a href="register.php" id="register_form" class="btn">Registrieren</a></div>
								<div class="one_half"><a href="info.php" class="btn">Mehr</a></div>
								<div class="one_half last"><a href="register.php" class="btn">Registrieren</a></div>
								-->
								<div class="one last"><a href="register.php" class="btn">Registrieren</a></div>
							</div>
						</div>
						
						<!-- Login Auswerter -->
						<div id="user_login_aw">
							<form action="process_login.php" method="POST">
								<label>E-Mail Adresse</label>
								<input type="text" name="uname_aw" id="uname_aw" required />
								<br />

								<label>Passwort</label>
								<input type="password" name="upass_aw" id="upass_aw" required />
								<br />

								<div class="checkbox">
									<input style="display: none;" name="remember_aw" id="remember_aw" type="checkbox" ' . $pre_select_rmd_aw . ' />
									<label for="remember_aw">Eingeloggt bleiben</label>
								</div>

								<div class="action_btns">
									<div class="one_half"><a href="#" class="button fit" id="back_btn_aw"><i class="fa fa-angle-double-left"></i> Zurück</a></div>
									<div class="one_half last"><input type="submit" value="Einloggen" name="sbmt_aw" class="button special fit" required /></div>
								</div>
							</form>

							<a href="#" class="forgot_password">Passwort vergessen?</a>
						</div>

						<!-- Login Funktionär -->
						<div id="user_login_ft">
							<form action="process_login.php" method="POST">
								<label>Kennungs-ID</label>
								<input type="text" name="uname_ft" id="uname_ft" required />
								<br />

								<label>Passwort</label>
								<input type="password" name="upass_ft" id="upass_ft" required />
								<br />
								
								<label>Einloggen als</label>
								<select name="ft_type" id="ft_type" required style="background-color: #333; color: #555 !important;">
								    <option style="color: #555 !important;" selected disabled>Bitte auswählen</option>
								    <option style="color: #b68c2f !important;" value="mz">Zeitnehmer</option>
								    <option style="color: #c0c0c0 !important;" value="zk">Zeitkontrolle</option>
								    <option style="color: #c0c0c0 !important;" value="sk">Stempelkontrolle</option>
								    <option style="color: #c0c0c0 !important;" value="bc">Bordkartenkontrolle</option>
								</select>
								<br />

                                <div class="checkbox">
									<input style="display: none;" name="remember_ft" id="remember_ft" type="checkbox" ' . $pre_select_rmd_ft . ' />
									<label for="remember_ft">Eingeloggt bleiben</label>
								</div>

								<div class="action_btns">
									<div class="one_half"><a href="#" class="button fit" id="back_btn_ft"><i class="fa fa-angle-double-left"></i> Zurück</a></div>
									<div class="one_half last"><input type="submit" value="Einloggen" name="sbmt_ft" class="button special fit" required /></div>
								</div>
							</form>

							<a href="#" class="forgot_password">Passwort vergessen?</a>
						</div>
						
						<!-- LOGIN FORM PARTICIPANT -->
						<div id="user_login_mt">
							<form action="process_login.php" method="POST">
								<label>Kennungs-ID</label>
								<input type="text" name="uname_mt" id="uname_mt" required />
								<br />

								<label>Passwort</label>
								<input type="password" name="upass_mt" id="upass_mt" required />
								<br />

								<div class="checkbox">
									<input style="display: none;" name="remember_mt" id="remember_mt" type="checkbox" ' . $pre_select_rmd_mt . ' />
									<label for="remember_mt">Eingeloggt bleiben</label>
								</div>

								<div class="action_btns">
								    <div class="one_half"><a href="#" class="button fit" id="back_btn_mt"><i class="fa fa-angle-double-left"></i> Zurück</a></div>
									<div class="one_half last"><input type="submit" value="Einloggen" name="sbmt_mt" class="button special fit" required /></div>
								</div>
							</form>

							<a href="#" class="forgot_password">Passwort vergessen?</a>
						</div>
					</section>
				</div>
				';
	}
?>