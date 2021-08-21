<?php

unset($error);
foreach ($_REQUEST as $k => $v) {
	$_REQUEST[$k] = urldecode(trim($v));
}
 //$lib->debug($_REQUEST);

if (isset($_REQUEST)) {
	$firstname = $_REQUEST['firstname'];
	$lastname = $_REQUEST['lastname'];
	$email = $_REQUEST['email'];
	$phone_number = $_REQUEST['phone_number'];
	$password = $_REQUEST['password'];
	$password_confirm = $_REQUEST['password_confirm'];
	


	//  var_dump($profile_user);
	// die;s
	if (empty(trim($firstname))) {
		echo "false||Veuillez renseigner votre prénom";
		exit;
	} elseif (empty(trim($lastname))) {
		echo "false||Veuillez renseigner votre nom";
		exit;
	} elseif (empty(trim($email))) {
		echo "false||Veuillez renseigner votre email";
		exit;
	} elseif (empty(trim($phone_number))) {
		echo "false||Veuillez renseigner votre numéro de téléphone";
		exit;
	} elseif (empty(trim($password))) {
		echo "false||Veuillez renseigner le mot de passe";
		exit;
	} elseif (empty(trim($password_confirm))) {
		echo "false||Veuillez confirmer le mot de passe";
		exit;
	} elseif ($password != $password_confirm) {
		echo "false||Les mots de passe ne correspondent pas";
		exit;
	} elseif (!preg_match('/^[A-Z][\p{L}-]*$/', $lastname)) {
		echo "false||Nom invalide";
		exit;
	} elseif (!preg_match('/^[A-Z][\p{L}-]*$/', $firstname)) {
		echo "false||Prénom invalide";
		exit;
	} elseif (!preg_match('/^[0-9_]+$/', $phone_number)) {
		echo "false||Numéro de téléphone incorrect";
		exit;
	} else {
		//
		//$contact_num = 'D' . substr($zipcode, 0, 2) . substr(strtoupper(normalize($ville)), 0, 3) . substr(strtoupper(normalize($prenom_user)), 0, 2) . rand(1000000, 9000000);
		$verify_user = $sqlData->getUserByEmail($email);
		
		$pass = password_hash($password, PASSWORD_ARGON2I);

		if ($verify_user['rows'] != 0) {
			echo 'false||Vous avez déjà un compte, veuillez réinitialiser votre mot de passe . <a href="'. $iniObj->siteUrl."customer/reset/".$random = $lib->random().'">ici</a>';
			exit;
		} else {
			$register_user = $sqlData->insertNewClient($firstname, $lastname , $email, $phone_number, $pass );//
			if ($register_user == true) {
				$user_exist = $sqlData->getUserByEmail($email);
				// $lib->debug($user_exist);
				if ($user_exist) {
					
					//$register_user_pref = $sqlData->insertNewUserPref($user_exist['data'][0]->contact_num, $pass);

					// die(var_dump($register_user_pref));
					//if ($register_user_pref) {

						/* Locate the email template */
						$mailContent = $sqlData->getTemplate(1);
						$message = '';
						//$subject = '';
						/* Replacing content from template */
						$keywordsContent = array(
							"{LOGIN}" => $user_exist['data'][0]->email,
							"{PASSWORD}" => '****',
							//"{SERVICE}" => $iniObj->serviceName,
							"{SITE_URL}" => $iniObj->siteUrl,
							//"{COMPANY_NAME}" => $iniObj->companyName,
							//"{COMPANY_ADDRESS}" => $iniObj->companyAddress,
							//"{COMPANY_ZIP_CODE}" => $iniObj->companyZipCode,
							//"{COMPANY_CITY}" => $iniObj->companyCity,
							//"{COMPANY_COUNTRY}" => $iniObj->companyCountry,
							//"{COMPANY_PHONE}" => $iniObj->companyPhoneNum,
							//"{COMPANY_FAX}" => $iniObj->companyFaxNum,
							"{SERVICE_EMAIL}" => $iniObj->emailSender,
							//"{STORE_NAME}" => $user_exist['data'][0]->store_name,
							//"{TEMPLATE_IMG}" => $iniObj->customerSite.'/filesLib/template_bg_image/bienvenue.jpg'

						);

						//$keywordsSubject = array(
						//	"{id}" => $val->shipping_id, "{STORE_NAME}" => $user_exist['data'][0]->store_name
						//);

						$message = str_replace(
							array_keys($keywordsContent),
							array_values($keywordsContent),
							$mailContent['data'][0]->body
						);
						//$subject = str_replace(array_keys($keywordsSubject), array_values($keywordsSubject), $mailContent['data'][0]->subject);
						// 				 $lib->sendEmailNoCC($iniObj->emailContact,"jacques.jocelyn@jiscomputing.com",$subject,$message
						// 					$lib->sendEmailNoCC($iniObj->emailContact,"pascal.sylvestre@jiscomputing.com",$subject,$message
						//$sendEmail = $lib->sendConfirmEmailNoCC($iniObj->emailContact, $email, $subject, $message, $cc = $iniObj->emailContact);
						$sendEmail = $lib->sendConfirmEmailNoCC($iniObj->emailContact, $email, $message, $cc = $iniObj->emailContact);
						if ($sendEmail) {
							# code...
							echo "true||" . $lang->trl("You have been registered successfully, check your email to see your credentials.");
							exit;
						} else {
							echo "false||Le serveur de mail ne répond pas";
							exit;
						}
					} else {
						echo "false||Une erreur est survenue lors de l'enregistrement des préférences utilisateurs.";
						exit;
					}
				} else {
					echo "false||Ce utilisateur n'existe pas encore.";
					exit;
				}
			///else {
			//	echo "false||Enregistrement échoué";
			///	exit;
			}
			} 
		}
	

////exit;

function normalize($string)
{
	$table = array(
		'Š' => 'S', 'š' => 's', 'Ð' => 'Dj', 'd' => 'dj', 'Ž' => 'Z', 'ž' => 'z', 'C' => 'C', 'c' => 'c', 'C' => 'C', 'c' => 'c',
		'À' => 'A', 'Á' => 'A', 'Â' => 'A', 'Ã' => 'A', 'Ä' => 'A', 'Å' => 'A', 'Æ' => 'A', 'Ç' => 'C', 'È' => 'E', 'É' => 'E',
		'Ê' => 'E', 'Ë' => 'E', 'Ì' => 'I', 'Í' => 'I', 'Î' => 'I', 'Ï' => 'I', 'Ñ' => 'N', 'Ò' => 'O', 'Ó' => 'O', 'Ô' => 'O',
		'Õ' => 'O', 'Ö' => 'O', 'Ø' => 'O', 'Ù' => 'U', 'Ú' => 'U', 'Û' => 'U', 'Ü' => 'U', 'Ý' => 'Y', 'Þ' => 'B', 'ß' => 'Ss',
		'à' => 'a', 'á' => 'a', 'â' => 'a', 'ã' => 'a', 'ä' => 'a', 'å' => 'a', 'æ' => 'a', 'ç' => 'c', 'è' => 'e', 'é' => 'e',
		'ê' => 'e', 'ë' => 'e', 'ì' => 'i', 'í' => 'i', 'î' => 'i', 'ï' => 'i', 'ð' => 'o', 'ñ' => 'n', 'ò' => 'o', 'ó' => 'o',
		'ô' => 'o', 'õ' => 'o', 'ö' => 'o', 'ø' => 'o', 'ù' => 'u', 'ú' => 'u', 'û' => 'u', 'ý' => 'y', 'ý' => 'y', 'þ' => 'b',
		'ÿ' => 'y', 'R' => 'R', 'r' => 'r',
	);

	return strtr($string, $table);
}
