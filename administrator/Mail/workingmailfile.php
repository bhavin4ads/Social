<?php
/**
* Simple example script using PHPMailer with exceptions enabled
* @package phpmailer
* @version $Id$
*/
require 'class.phpmailer.php';
try {
	$mail = new PHPMailer(true); //New instance, with exceptions enabled

	/*$body             = file_get_contents('contents.html');
	$body             = preg_replace('/\\\\/','', $body); //Strip backslashes*/
        $body="hello";

	$mail->IsSMTP();                           // tell the class to use SMTP
	$mail->SMTPAuth   = true;                  // enable SMTP authentication
	$mail->Port       = 465;                    // set the SMTP server port
	$mail->Host       = "ssl://smtp.gmail.com"; // SMTP server
	//$mail->Username   = "admin@sabsyp.com";     // SMTP server username
        $mail->Username   = "sumitjoshi@themacrosoft.com";     // SMTP server username
	$mail->Password   = "myisland";            // SMTP server password

	//$mail->IsSendmail();  // tell the class to use Sendmail

	$mail->AddReplyTo("sumitjoshi@themacrosoft.com","First Last");
        $mail->AddAttachment('javaapplet.gif');
	$mail->From       = "sumitjoshi@themacrosoft.com";
	$mail->FromName   = "First Last";

	$to = "itproffesionalwork@yahoo.co.in";

	$mail->AddAddress($to);
        
	$mail->Subject  = "First PHPMailer Message";

	$mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test
	$mail->WordWrap   = 80; // set word wrap

	$mail->MsgHTML($body);

	$mail->IsHTML(true); // send as HTML

	$mail->Send();
	echo 'Message has been sent.';
} catch (phpmailerException $e) {
	echo $e->errorMessage();
}
?>