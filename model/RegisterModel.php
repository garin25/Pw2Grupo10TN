<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\ErrorCorrectionLevel;

class RegisterModel
{
    private $conexion;
    private $config;

    public function __construct($conexion)
    {
        $this->conexion = $conexion;
        $this->config = parse_ini_file("config/config.ini");
    }

    public function crearUsuario($nombreCompleto, $email, $passwordHash, $nombre_usuario, $sexo, $anio, $pais, $ciudad, $token)
    {
        // 1. INSERTAR EL USUARIO INICIALMENTE
        $sql = "INSERT INTO usuario (nombre_completo, anio_nacimiento, sexo, pais, ciudad, email, password, nombre_usuario, id_rol, token, img_qr) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        // Columna 'img_qr' se inicializa vacía o con un valor por defecto (ej: '') en el INSERT.
        // Opcionalmente, puedes quitar img_qr de aquí y solo hacer el UPDATE después del QR.
        $img_qr_default = ''; // Valor por defecto o NULL si la columna lo permite

        $tipos = "sissssssiss";
        $params = array($nombreCompleto, $anio, $sexo, $pais, $ciudad, $email, $passwordHash, $nombre_usuario, 1, $token, $img_qr_default);

        $this->conexion->ejecutarConsulta($sql, $tipos, $params);


        // --- Generación y guardado del QR ---

        // 1. Obtener la URL de configuración
        $url_base = $this->config["url_base"];

        // 2. Definir la URL que codificará el QR
        $url_perfil_qr = $url_base . "/perfil/" . $nombre_usuario;

        // 3. Configurar rutas de guardado
        $nombre_archivo_qr = 'qr_' . $nombre_usuario . '.png';
        $ruta_absoluta_guardado = __DIR__ . '/../../imagenes/';
        $ruta_completa_archivo = $ruta_absoluta_guardado . $nombre_archivo_qr;

        // RUTA PÚBLICA que guardaremos en la DB
        $url_qr_publica = "/imagenes/" . $nombre_archivo_qr;

        // 4. Generar y guardar el QR (en el servidor)
        try {
            if (!file_exists($ruta_absoluta_guardado)) {
                mkdir($ruta_absoluta_guardado, 0777, true);
            }

            $qrCode = new QrCode($url_perfil_qr);
            $qrCode->setSize(300);
            $qrCode->setMargin(10);
            $qrCode->setErrorCorrectionLevel(ErrorCorrectionLevel::HIGH());
            $qrCode->setWriterByName('png');

            file_put_contents($ruta_completa_archivo, $qrCode->writeString());

            // 5. ACTUALIZAR LA COLUMNA img_qr EN LA DB
            $sql_update = "UPDATE usuario SET img_qr = ? WHERE nombre_usuario = ?";
            $tipos_update = "ss"; //Para decir que los 2 valores son cadenas de texto
            $params_update = array($url_qr_publica, $nombre_usuario);

            $this->conexion->ejecutarConsulta($sql_update, $tipos_update, $params_update);

        } catch (\Exception $e) {
            error_log("Error al generar o guardar QR: " . $e->getMessage());
        }


        // --- CÓDIGO DE PHPMailer ---

        $mail = new PHPMailer(true);

        try {
            // ---- Configuración del servidor de correo (SMTP) ----
            // ... Tu configuración de SMTP ...
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = $this->config["email"];
            $mail->Password   = $this->config["contrasenia"];
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port       = 465;
            $mail->CharSet    = 'UTF-8';

            // ---- Remitente y Destinatario ----
            $mail->setFrom($this->config["email"], 'Preguntados');
            $mail->addAddress($email, $nombre_usuario);

            // ---- Contenido del Email ----
            $mail->isHTML(true);
            $mail->Subject = '¡Activa tu cuenta!';

            $enlace_activacion = "localhost/register/activacion";

            $mail->Body    = "<h1>¡Gracias por registrarte!</h1>
                    <p>Para completar tu registro, Copia tu token y hacé clic en el siguiente enlace:</p>
                    <p>Token: ".$token."</p>
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

        $sql = "SELECT usuarioId FROM usuario WHERE nombre_usuario = ? OR email = ?";
        $tipos = "ss";
        $params = array($nombre_usuario, $email);

        $resultado = $this->conexion->ejecutarConsulta($sql, $tipos, $params);

        if ($resultado != null){
            return $resultado[0];
        }

        return false;

        /*return $this->conexion->usuarioYaExiste($nombre_usuario, $email);*/
    }

    public function activar($token)
    {
        $exitoso = false;
        $usuario=$this->verificarUsuarioNoVerificado($token);

       if($usuario!=null){
           $exitoso =true;
           $sql = "UPDATE usuario SET cuenta_verificada = true, token = NULL WHERE usuarioId = ?";
           $tipos = "i";
           $params = array($usuario['usuarioId']);

           $this->conexion->ejecutarConsulta($sql, $tipos, $params);

       }
       return $exitoso;
    }

    public function verificarUsuarioNoVerificado($token){
        $sql = "SELECT usuarioId FROM usuario WHERE token = ? AND cuenta_verificada = false LIMIT 1";
        $tipos = "s";
        $params = array($token);

        $resultado = $this->conexion->ejecutarConsulta($sql, $tipos, $params);

        if ($resultado != null){
            return $resultado[0];
        }

        return null;
    }


}