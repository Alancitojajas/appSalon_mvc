<?php

namespace Classes;

use PHPMailer\PHPMailer\PHPMailer;

class Email
{

    public $email;
    public $nombre;
    public $token;

    public function __construct($email, $nombre, $token)
    {
        $this->email = $email;
        $this->nombre = $nombre;
        $this->token = $token;
    }

    public function enviarConfirmacion()
    {
        //Crear el objeto de email
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = 'smtp.mailtrap.io';
        $mail->SMTPAuth = true;
        $mail->Port = 2525;
        $mail->Username = '2718d784446ae9';
        $mail->Password = 'f7c19095c91898';

        $mail->setFrom("cuentas@appsalon.com");
        $mail->addAddress("cuentas@appsalon.com", "AppSalon.com");
        $mail->Subject = "Confirma tu cuenta ";

        $mail->isHTML(TRUE);
        $mail->CharSet = "UTF-8";

        //Cuerpo del mensaje
        $contenido =
        "<html>
            <p><strong>Hola ". $this->nombre ."</strong> Has creado tu cuenta 
            en AppSalon, preciona en el siguiente enlace: </p>
            <p>Preciona aqui: <a href= 'http://localhost:3000/confirmar-cuenta?token=" . $this->token ."'>
            Confirmar cuenta</a ></p>
            <p>En caso de no solicitar esta cuenta, ignorar el mensaje</p>
        </html>";

        $mail->Body = $contenido;

        //Enviar el email
        $mail->send();
    }

    public function enviarInstrucciones(){
                //Crear el objeto de email
                $mail = new PHPMailer();
                $mail->isSMTP();
                $mail->Host = 'smtp.mailtrap.io';
                $mail->SMTPAuth = true;
                $mail->Port = 2525;
                $mail->Username = '2718d784446ae9';
                $mail->Password = 'f7c19095c91898';
        
                $mail->setFrom("cuentas@appsalon.com");
                $mail->addAddress("cuentas@appsalon.com", "AppSalon.com");
                $mail->Subject = "Reestablece tu contraseña";
        
                $mail->isHTML(TRUE);
                $mail->CharSet = "UTF-8";
        
                //Cuerpo del mensaje
                $contenido =
                "<html>
                    <p><strong>Hola ". $this->nombre ."</strong> Has solicitado reestablecer
                    tu contraseña </p>
                    <p>Preciona aqui: 
                    <a href= 'http://localhost:3000/recuperar?token=" . $this->token ."'>
                    Reestablecer contraseña</a ></p>
                    <p>En caso de no solicitar esta cambio, ignorar el mensaje</p>
                </html>";
        
                $mail->Body = $contenido;
        
                //Enviar el email
                $mail->send();
    }
}
