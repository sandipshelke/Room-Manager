<?php
    include 'class.phpmailer.php';   
    include 'PHPMailerAutoload.php';

    function SendMyMail($email,$subject,$messageBody)
    {
        $mail = new PHPMailer;
        //Enable SMTP debugging. 
        $mail->SMTPDebug = 0;
        //Set PHPMailer to use SMTP.
        $mail->isSMTP();
        //Set SMTP host name                          
        $mail->Host = "ssl://smtp.gmail.com"; 
        //Set this to true if SMTP host requires authentication to send email
        $mail->SMTPAuth = true;
        //Provide username and password     
        $mail->Username = 'myroommanager@gmail.com';
        $mail->Password = 'Roommanager111@';
        //If SMTP requires TLS encryption then set it
        $mail->SMTPSecure = "ssl";
        //Set TCP port to connect to 
        $mail->Port = 465;
        $mail->From = 'myroommanager@support.com';  
        $mail->FromName = 'support@gadvede.com';
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body=$messageBody;
        $mail->AltBody = "This is the plain text version of the email content";
        $mail->addAddress($email);
        if (!$mail->send()) {
            return false;
        }
        else {
             return true;
        }
    }

?>