<?php
include "PHPMailerAutoload.php";
function fnMail($emailAdd,$fromAdd,$frmName,$sub,$body,$file_path=null,$file_name=null)
{
	$mail = new PHPMailer();
	$mail->IsSMTP();  
	$mail->Host = "mail.hyperquality.com";        
	$mail->From = $fromAdd;
	$mail->FromName = $frmName;
	$mail->AddAddress($emailAdd);
	$mail->Subject  = $sub;
	$mail->Body  = $body;
	if($file_path!=null && $file_name!=null)
	{
	$mail->AddAttachment( $file_path , $file_name );		
	}
	$mail->IsHTML(true);

	if(!$mail->Send()) 
	{
		$aMsg = 'Message was not sent.';
		$aMsg = 'Mailer error: ' . $mail->ErrorInfo;
	} 
	else 
	{
		$aMsg = "An Email has been sent to $emailAdd";	
	}
	echo "<script>alert('$aMsg');</script>";
}

?>