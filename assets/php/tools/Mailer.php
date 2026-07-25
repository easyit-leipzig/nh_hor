<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


class Mailer
{

    private PHPMailer $mail;


    public function __construct()
    {

        $this->mail = new PHPMailer(true);


        $this->mail->isSMTP();


        /*
        SMTP Einstellungen
        später aus config laden
        */

        $this->mail->Host =
            'smtp.example.de';

        $this->mail->SMTPAuth = true;

        $this->mail->Username =
            'mail@example.de';

        $this->mail->Password =
            'PASSWORT';


        $this->mail->SMTPSecure =
            PHPMailer::ENCRYPTION_STARTTLS;


        $this->mail->Port = 587;


        $this->mail->CharSet =
            'UTF-8';


        $this->mail->setFrom(
            'mail@example.de',
            'easyIT Nachhilfe Leipzig'
        );

    }



    public function send(
        string $to,
        string $subject,
        string $body
    ): bool
    {


        $this->mail->clearAddresses();


        $this->mail->addAddress($to);


        $this->mail->Subject =
            $subject;


        $this->mail->Body =
            $body;


        return $this->mail->send();

    }

}
