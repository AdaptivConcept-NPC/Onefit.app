<?php
//PHP Mailer code
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

// C:/wamp64_326/www/Onefit/scripts/php/mail.php
require 'C:/wamp64_326/www/Onefit/vendor/phpmailer/phpmailer/src/Exception.php';
require 'C:/wamp64_326/www/Onefit/vendor/phpmailer/phpmailer/src/PHPMailer.php';
require 'C:/wamp64_326/www/Onefit/vendor/phpmailer/phpmailer/src/SMTP.php';

// require '../../vendor/phpmailer/phpmailer/src/Exception.php';
// require '../../vendor/phpmailer/phpmailer/src/PHPMailer.php';
// require '../../vendor/phpmailer/phpmailer/src/SMTP.php';

//require 'PHPMailer/PHPMailerAutoload.php';

//Load Composer's autoloader
//require '../../vendor/autoload.php'; //local
require 'C:/wamp64_326/www/Onefit/vendor/autoload.php'; //local
// require 'https://pantaspa.co.za/custom/application/vendor/autoload.php'; //online

function sendCredentials($general_purpose, $firstname, $lastname, $email, $username, $password)
{
    //Connection Test==============================================>
    // Check connection
    /* if ($dbconn->connect_error) {
            die("<div class='p-4 alert alert-danger'>Connection failed: " . $db->connect_error) . "</div>";
        } else {
            die("Connected successfully");
        } */

    //end of Connection Test============================================>
    //nua - new user account, clntcomm - client communication, pwdrst - password reset, nwsltr - newsletter

    //Initialize Variables
    $link_button = $subject_greetings = $mail_body_content = $alt_mail_body_content = $mail_body = $subject_greetings = "";

    if ($general_purpose == "nua") {
        $admin_username = $admin_password = "";

        $admin_username = $username;
        $admin_password = $password;

        $subject = "Your user account has been created.";
        $subject_greetings = "Your Panta Spa Administration User Account has been created.";

        //generate link button
        $link_button = <<<_END
        <a href="https://pantaspa.co.za/custom/application/"
        style="background:linear-gradient(270deg,#009ba2ff 0%,#00c2cbff 100%);background-color:#00c2cbff;text-decoration:none;padding:15px 0px;color: var(--text-color);border: #fff solid 3px;border-radius:36px;display:inline-block;font-weight:bold;text-transform:uppercase;width:100%;max-width:285px"
        class="m_2317402489703711923full-widthz"
        target="_blank"
        data-saferedirecturl="https://pantaspa.co.za/custom/application/"><span>Login</span></a>
        _END;

        $mail_body_content = <<<_END
        <div style="color:redimportant;">
        Please use the credentials below to log into your account.<br> 
        Access the <a href="https://pantaspa.co.za/custom/application/"
        style="color: var(--text-color)fff;font-weight:normal;text-decoration:underline"
        target="_blank"
        data-saferedirecturl="https://pantaspa.co.za/custom/application/">Administrator Portal</a>.
        <br><br>
        <br>
        <span class="fs-3" style="padding: 20px; background-color: #fff; color: black;"><b>Username:</b> $admin_username</span><br><br>
        <span class="fs-3" style="padding: 20px; background-color: #fff; color: black;"><b>Password:</b> $admin_password</span><br><br>
        These credentials are confidenial and misuse may result in legal action. Do not share your password and do not leave this email open in a shared or exposed public area. We recommend you login ASAP, change your password to a prefared one and deleting this email.
        <hr>
        </div>
        _END;

        $mail_body = <<<_END
        <p style="margin:25px 0;padding:0;color: var(--text-color)fff">
        $subject_greetings
        <br><br>
        $mail_body_content
        </p>
        $link_button
        _END;
    } else if ($general_purpose == "pwdrst") {

        $admin_username = $admin_password = "";

        $admin_username = $username;
        $admin_password = $password;

        $subject = "Your password was reset.";
        $subject_greetings = "Your Panta Spa Administration User Account has been reset.";

        //generate link button
        $link_button = <<<_END
        <a href="https://pantaspa.co.za/custom/application/"
        style="background:linear-gradient(270deg,#009ba2ff 0%,#00c2cbff 100%);background-color:#00c2cbff;text-decoration:none;padding:15px 0px;color: var(--text-color);border: #fff solid 3px;border-radius:36px;display:inline-block;font-weight:bold;text-transform:uppercase;width:100%;max-width:285px"
        class="m_2317402489703711923full-widthz"
        target="_blank"
        data-saferedirecturl="https://pantaspa.co.za/custom/application/"><span>Login</span></a>
        _END;

        $mail_body_content = <<<_END
        <div style="color:redimportant;">
        Please use the credentials below to log into your account.<br> 
        Access the <a href="https://pantaspa.co.za/custom/application/"
        style="color: var(--text-color)fff;font-weight:normal;text-decoration:underline"
        target="_blank"
        data-saferedirecturl="https://pantaspa.co.za/custom/application/">Administrator Portal</a>.
        <br><br>
        <br>
        <span class="fs-3" style="padding: 20px; background-color: #fff; color: black;"><b>Username:</b> $admin_username</span><br><br>
        <span class="fs-3" style="padding: 20px; background-color: #fff; color: black;"><b>Password:</b> $admin_password</span><br><br>
        
        These credentials are confidenial and misuse may result in legal action. Do not share your password and do not leave this email open in a shared or exposed public area. We recommend you login ASAP, change your password to a prefared one and deleting this email.
        <hr>
        </div>
        _END;

        $alt_mail_body_content = <<<_END
        Your user account was created successfully. Please use the credentials below to log into your account.\n 
        Access the Administrator Portal by opening: https://pantaspa.co.za/custom/application/ in your web browser.
        \n\n
        You login credentials are:\n
        Username: $admin_username\n\n
        Password: $admin_password\n\n
        These credentials are confidenial and misuse may result in legal action. Do not share your password and do not leave this email open in a shared or exposed public area. We recommend you login ASAP, change your password to a prefared one and deleting this email.
        _END;

        $mail_body = <<<_END
        <p style="margin:25px 0;padding:0;color: var(--text-color)fff">
        $subject_greetings
        <br><br>
        $mail_body_content
        </p>
        $link_button
        _END;
    } else if ($general_purpose == "clntcomm") {
        $subject = "Client Communication - ";
    } else if ($general_purpose == "nwsltr") {
        $subject = "Newsletter";
    }

    $from = "Panta Spa & Beauty Palace <admin@pantaspa.co.za>";
    $to = "$firstname $lastname <$email>";
    // $subject = "Please rate our service - Client Satisfaction Survey";

    $body = <<<_END
    <html>
    <head>
        <!-- Google Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link
            href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800;900&family=Poppins:wght@400;500;600;700;800;900&display=swap"
            rel="stylesheet">
        <style>
            *::-webkit-scrollbar {
                width: 0px;
            }
            body {
                width: 100% !important;
                height: 100% !important;
                overflow-x: hidden !important;
                overflow-y: auto !important;
                padding: 0 !important;
                margin: 0 !important;
            }
            #main-body {
                margin: 0 !important;
                padding: 0 !important;
                width: 100% !important;
                height: 100% !important;
            }
            .element-hidden {
                display: none !important;
                font-size: 1px;
                color: #ffffff;
                line-height: 1px;
                max-height: 0px;
                max-width: 0px;
                opacity: 0;
                overflow: hidden
            }
            .mail-content-container {
                max-width: 620px;
                width: 100%;
                height: 100vh;
                overflow-y: auto;
                background-color: #fff;
                padding-bottom: 50px;
            }
            .main-mail-body {
                max-width: 620px !important;
                width: 100%;
                background-color: #8e885fff;
                border-radius: 0 0 25px 25px !important;
                overflow: hidden;
            }
        </style>
    </head>
    <body>
        <div id="main-body">
            <!-- style="margin:0!important;padding:0!important" -->
            <div class="element-hidden">
                Panta Spa &amp; Beauty Palace General Mailer </div>
            <!-- <div style="display:none;max-height:0px;overflow:hidden">
            &zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&nbsp;&zwnj;&nbsp;&zwnj;<wbr>&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;<wbr>&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;<wbr>&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;<wbr>&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;<wbr>&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;<wbr>&nbsp;&zwnj;&nbsp;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;<wbr>&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;<wbr>&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;<wbr>&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;<wbr>&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;
        </div> -->
        <table border="0" cellpadding="0" cellspacing="0" role="presentation" width="100%">
            <tbody>
                <tr>
                    <td align="center">
                        <div style="width:100%;height:100%;">
                            <!--#d6d6d5-->
                            <div role="article" aria-label="email name" lang="en"
                                style="background:url('https://adaptivconcept.co.za/public_media/images/logo.png') fixed top center/620px 631px;font-size:18px;line-height:26px;font-family:'Montserrat','Poppins',Arial,Helvetica,sans-serif;color: var(--secondary-color)">
                                <div class="mail-content-container">
                                    <!-- Mail Header -->
                                    <table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation"
                                        width="100%"
                                        style="background:linear-gradient(180deg,#ffffff 0%,#00c2cbff 100%);">
                                        <tbody>
                                            <tr>
                                                <td align="center" style="padding: 0 30px;">
                                                    <table align="center" border="0" cellpadding="0" cellspacing="0"
                                                        role="presentation">
                                                        <tbody>
                                                            <tr>
                                                                <td align="center">
                                                                    <a href="https://pantaspa.co.za/"
                                                                        style="text-decoration:none;border:none"
                                                                        target="_blank"
                                                                        data-saferedirecturl="https://pantaspa.co.za/">
                                                                        <img src="https://adaptivconcept.co.za/public_media/images/PantaSpa_Logo_Color.png"
                                                                            alt="Panta-Spa-Logo"
                                                                            style="background-color: var(--text-color)fff;padding:20px;border-radius:0 0 25px 25px;display:block;max-width:200px;width:100%;text-align:center"
                                                                            width="200">
                                                                    </a>
                                                                    <div style="line-height:90px;height:90px">
                                                                        &nbsp;</div>
                                                                    <div style="display:inline-block">
                                                                    </div>
                                                                    <a href="https://pantaspa.co.za/"
                                                                        style="text-decoration:none" target="_blank"
                                                                        data-saferedirecturl="https://pantaspa.co.za/">
                                                                        <span
                                                                            style="text-transform:uppercase;color: var(--text-color)fff;font-weight:bold;letter-spacing:2px;display:block;font-size:60px;line-height:60px">
                                                                            Panta Spa &amp; Beauty Palace</span>
                                                                        <span
                                                                            style="text-transform:uppercase;color: var(--text-color)fff;font-weight:bold;letter-spacing:2px;display:block;font-size:20px;line-height:30px">
                                                                            $subject
                                                                            </span>
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <!-- ./ Mail Header -->
                                    <!-- Main Mail Body -->
                                    <table border="0" bgcolor="#00c2cbff" cellpadding="0" cellspacing="0"
                                        role="presentation" width="620" class="main-mail-body">
                                        <tbody>
                                            <tr>
                                                <td align="center">
                                                    <table background="https://adaptivconcept.co.za/public_media/images/PantaSpa_Logo_Color.png"
                                                        bgcolor="#3F2F8C" border="0" cellpadding="0" cellspacing="0"
                                                        role="presentation" width="620"
                                                        style="max-width:620px;width:100%;background-size:cover;background-repeat:no-repeat;background:linear-gradient(180deg,#00c2cbff 0%,#009ba2ff 100%);"
                                                        class="g">
                                                        <tbody>
                                                            <tr>
                                                                <td align="center" style="padding:20px">
                                                                    <table border="0" cellpadding="0" cellspacing="0"
                                                                        role="presentation" width="408"
                                                                        style="max-width:408px;width:100%">
                                                                        <tbody>
                                                                            <tr>
                                                                                <td align="center">
                                                                                    $mail_body
                                                                                </td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                    <div style="line-height:60px;height:60px">&nbsp;
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <!-- ./ Main Mail Body -->
                                    <!-- Mail Footer -->
                                    <table bgcolor="#ffffff" border="0" cellpadding="0" cellspacing="0"
                                        role="presentation" width="620"
                                        style="max-width:620px;width:100%;background-color: var(--text-color)fff">
                                        <tbody>
                                            <tr>
                                                <td style="padding:40px 20px 0px">
                                                    <table border="0" cellpadding="0" cellspacing="0"
                                                        role="presentation" width="100%">
                                                        <tbody>
                                                            <tr style="text-align:center;">
                                                                <td align="center" style="padding:20px 0">
                                                                    <span
                                                                        style="margin:20px 0 0 0;padding:0;display:block;color:#757575;font-size:13px;line-height:20px">Go to <a
                                                                            href="https://pantaspa.co.za/custom/application/"
                                                                            style="color:#757575;font-weight:normal;text-decoration:underline"
                                                                            target="_blank"
                                                                            data-saferedirecturl="https://pantaspa.co.za/custom/application/">Administration Portal</a></span>
                                                                    <p style="color:#757575;line-height:20px">Social Media</p>
                                                                    <a href="https://instagram.com/"
                                                                        style="text-decoration:none" target="_blank"
                                                                        data-saferedirecturl="https://instagram.com/">
                                                                        <img src="https://adaptivconcept.co.za/public_media/images/icons/social_media/instagram.png"
                                                                            width="47" style="display:inline-block"
                                                                            alt="Instagram" class="CToWUdz"></a>
                                                                    <i
                                                                        style="letter-spacing:10px;display:inline-block;width:10px">&nbsp;</i>
                                                                    <a href="https://www.tiktok.com/"
                                                                        style="text-decoration:none" target="_blank"
                                                                        data-saferedirecturl="https://www.tiktok.com/">
                                                                        <img src="https://adaptivconcept.co.za/public_media/images/icons/social_media/tiktok.png"
                                                                            width="47" style="display:inline-block"
                                                                            alt="TikTok" class="CToWUdz"></a>
                                                                    <div style="display:inline-block">
                                                                        <i
                                                                            style="letter-spacing:10px;display:inline-block;width:10px">&nbsp;</i>
                                                                        <a href="https://www.facebook.com/"
                                                                            style="text-decoration:none" target="_blank"
                                                                            data-saferedirecturl="https://www.facebook.com/">
                                                                            <img src="https://adaptivconcept.co.za/public_media/images/icons/social_media/facebook.png"
                                                                                width="47" style="display:inline-block"
                                                                                alt="Facebook" class="CToWUdz"></a>
                                                                        <i
                                                                            style="letter-spacing:10px;display:inline-block;width:10px">&nbsp;</i>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td align="center">
                                                                    <span
                                                                        style="margin:0 0 20px 0;padding:0;display:block;color:#757575;font-size:13px;line-height:20px">8605
                                                                        55 Marguerite Crescent, Naturena, Johannesburg,
                                                                        Gauteng, 2095<br>
                                                                        Copyright © 2022 Panta Spa &amp; Beauty Palace.
                                                                        All
                                                                        Rights
                                                                        Reserved. <br><br>
                                                                        <span style="font-size: 10px;">Designed &amp;
                                                                            Developed
                                                                            by <a href="https://adaptivconcept.co.za"
                                                                                style="color: #ff3715!important;">AdaptivConcept&trade;
                                                                                NPC</a></span></span>
                                                                    <hr style="color:#757575">
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                            <!-- <tr>
                                                Latest Promotion
                                                <td align="center" style="padding:20px;cursor: pointer;">
                                                    <p style="color:#757575;line-height:20px">We hope to see you soon.</p>
                                                    <a href="https://pantaspa.co.za/" style="text-decoration:none"
                                                        target="_blank" data-saferedirecturl="https://pantaspa.co.za/">
                                                        <img src="https://adaptivconcept.co.za/public_media/images/promotions/promo-1.jpeg"
                                                            alt="latest prmotion"
                                                            style="max-width: 600px;width: 100%;border-radius: 25px;">
                                                    </a>
                                                </td>
                                            </tr> -->
                                        </tbody>
                                    </table>
                                    <!-- ./ Mail Footer -->
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </body>
    </html>
    _END;

    $host = "mail.pantaspa.co.za";
    $username = "admin@pantaspa.co.za";
    $password = "P@ntaSpa!2022";
    $headers = array(
        'From' => $from,
        'To' => $to,
        'Subject' => $subject
    );

    //Create an instance; passing `true` enables exceptions
    $mail = new PHPMailer(true);

    try {
        //Server settings
        // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
        $mail->isSMTP();                                        // Set mailer to use SMTP
        $mail->Host = $host;                    // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                                 // Enable SMTP authentication
        $mail->Username = $username;                            // SMTP username
        $mail->Password = $password;                            // SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
        $mail->Port = 465;                                      // TCP port to connect to

        // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
        // $mail->isSMTP();                                            //Send using SMTP
        // $mail->Host       = 'smtp.example.com';                     //Set the SMTP server to send through
        // $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        // $mail->Username   = 'user@example.com';                     //SMTP username
        // $mail->Password   = 'secret';                               //SMTP password
        // $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
        // $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients
        $mail->setFrom('admin@pantaspa.co.za', 'Panta Spa & Beauty Palace');
        $mail->addAddress($email, "$firstname $lastname");     // Add a recipient
        $mail->addBCC('admin@adaptivconcept.co.za', "AdaptivConceptNPC");
        //$mail->addAddress('ellen@example.com');               // Name is optional
        $mail->addReplyTo('admin@pantaspa.co.za', 'Panta Spa & Beauty Palace - Admin');
        //$mail->addCC('cc@example.com');
        //$mail->addBCC('bcc@example.com');

        // $mail->setFrom('from@example.com', 'Mailer');
        // $mail->addAddress('joe@example.net', 'Joe User');     //Add a recipient
        // $mail->addAddress('ellen@example.com');               //Name is optional
        // $mail->addReplyTo('info@example.com', 'Information');
        // $mail->addCC('cc@example.com');
        // $mail->addBCC('bcc@example.com');

        //Attachments
        // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
        // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

        //Content
        $mail->isHTML(true);                                  // Set email format to HTML

        $mail->Subject = $subject;
        $mail->Body    = $body;
        $mail->AltBody = $alt_mail_body_content;

        // $mail->isHTML(true);                                  //Set email format to HTML
        // $mail->Subject = 'Here is the subject';
        // $mail->Body    = 'This is the HTML message body <b>in bold!</b>';
        // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        $mail->send();
        return 'Message has been sent';
    } catch (Exception $e) {
        return "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
