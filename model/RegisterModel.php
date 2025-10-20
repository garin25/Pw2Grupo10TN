<?php
// Incluir las clases de PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // Carga el autoloader de Composer
class RegisterModel
{

    private $conexion;

    public function __construct($conexion)
    {
        $this->conexion = $conexion;
    }

    public function crearUsuario($nombreCompleto, $email, $passwordHash,$nombre_usuario,$sexo,$año,$pais,$ciudad,$token){

        $sql = "INSERT INTO usuario (nombre_completo, anio_nacimiento, sexo, pais,ciudad,email,password,nombre_usuario,id_rol,token) VALUES (?,?,?,?,?,?,?,?,?,?)";
        $this->conexion->registrarUsuario($sql, $nombreCompleto,$año,$sexo,$pais,$ciudad,$email,$passwordHash,$nombre_usuario,1,$token);


        // Puedo poner el codigo de PHPMAILER aca por que si se ejecuta este metodo significa que se registro correctamente
        // De lo contrario este metodo no se hubiera ejecutado



        $mail = new PHPMailer(true);

        try {
            // ---- Configuración del servidor de correo (SMTP) ----
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com'; // Servidor SMTP (ej. Gmail)
            $mail->SMTPAuth   = true;
            $mail->Username   = 'garinchristian4@gmail.com';
            $mail->Password   = 'rbyw xkfl sbon nbco'; // Contraseña de aplicacion
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port       = 465;
            $mail->CharSet    = 'UTF-8';

            // ---- Remitente y Destinatario ----
            $mail->setFrom('garinchristian4@gmail.com', 'Preguntados');
            $mail->addAddress($email, $nombre); // El correo del usuario que se registró

            // ---- Contenido del Email ----
            $mail->isHTML(true);
            $mail->Subject = '¡Activa tu cuenta!';

            // Construir el enlace de activación
            $enlace_activacion = "localhost/register/activacion?token=" . $token;

            $mail->Body    = "<h1>¡Gracias por registrarte!</h1>
                    <p>Para completar tu registro, por favor hacé clic en el siguiente enlace:</p>
                    <a href='$enlace_activacion' style='padding: 10px 20px; color: white; background-color: #007bff; text-decoration: none;'>Activar mi cuenta</a>";
            $mail->AltBody = 'Para activar tu cuenta, copiá y pegá este enlace en tu navegador: ' . $enlace_activacion;

            $mail->send();
            echo '<h2>¡Registro casi completo!</h2>';
            echo '<p>Te hemos enviado un correo. Por favor, revisá tu bandeja de entrada para activar tu cuenta.</p>';

        } catch (Exception $e) {
            echo "El mensaje no pudo ser enviado. Mailer Error: {$mail->ErrorInfo}";
        }
    }
    public function usuarioYaExiste($nombre_usuario, $email) {
        return $this->conexion->usuarioYaExiste($nombre_usuario, $email);
    }

    public function activar($token)
    {
        $exitoso = false;
       $usuario=$this->verificarUsuarioNoVerificado($token);

       if($usuario!=null){
           $exitoso =true;
           $this->conexion->activar($usuario);
       }
       return $exitoso;
    }

    public function verificarUsuarioNoVerificado($token){
        $sql = "SELECT usuarioId FROM usuario WHERE token = ? AND cuenta_verificada = false LIMIT 1";
        return $this->conexion->verificarUsuarioNoVerificado($sql,$token);
    }


}