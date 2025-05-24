<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

class Principal extends Controller
{
    public function __construct()
    {
        parent::__construct();
        session_start();
    }
    public function index()
    {
        $data['title'] = 'Iniciar sesión';
        $this->views->getView('principal', 'index', $data);
    }
    public function validateUser()
    {
        $usuario = $_POST['usuario_l'];
        $clave = $_POST['contraseña_l'];

        $data = $this->model->validateUser($usuario);
        if (!empty($data)) {
            if (password_verify($clave, $data['clave'])) {
                $_SESSION['id'] = $data['id'];
                $_SESSION['nombre'] = $data['nombre'];
                $_SESSION['usuario'] = $data['usuario'];
                $_SESSION['correo'] = $data['correo'];
                $res = array('tipo' => 'success', 'mensaje' => 'BIENVENIDO');
            } else {
                $res = array('tipo' => 'warning', 'mensaje' => 'LA CONTRAEÑA ES INCORRECTA');
            }
        } else {
            $res = array('tipo' => 'warning', 'mensaje' => 'EL CORREO / USUARIO INGRESADO NO EXISTE');
        }
        echo json_encode($res, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function postUser()
    {
        $secretKey = "6Lc4yUYrAAAAAG_9hhMJIkBMx8Rzwvt66ATvGj0I";
        $captcha = $_POST['g-recaptcha-response'];

        $verify = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret={$secretKey}&response={$captcha}");
        $response = json_decode($verify);

        if (!$response->success) {
            $res = array('tipo' => 'error', 'mensaje' => 'Verificación CAPTCHA fallida. Intenta de nuevo.');
            echo json_encode($res, JSON_UNESCAPED_UNICODE);
            die();
        }
        $nombre = $_POST['nombre_r'];
        $usuario = $_POST['usuario_r'];
        $correo = $_POST['correo_r'];
        $contraseña = $_POST['contraseña_r'];

        //verifica que no se repitan datos importantes en los registros
        $checkUser = $this->model->validate('usuario', $usuario);

        if (empty($checkUser)) {
            $checkMail = $this->model->validate('correo', $correo);
            if (empty($checkMail)) {
                $hash = password_hash($contraseña, PASSWORD_DEFAULT);
                $data = $this->model->postUser($nombre, $usuario, $correo, $hash);
                if ($data > 0) {
                    $res = array('tipo' => 'success', 'mensaje' => 'USUARIO CREADO CORRECTAMENTE');
                } else {
                    $res = array('tipo' => 'error', 'mensaje' => 'ERROR AL CREAR TU CUENTA INTENTA DE NUEVO');
                }
            } else {
                $res = array('tipo' => 'warning', 'mensaje' => 'ESTE CORREO YA FUE REGISTRADO');
            }
        } else {
            $res = array('tipo' => 'warning', 'mensaje' => 'ESTE NOMBRE DE USUARIO YA EXISTE ');
        }
        echo json_encode($res, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function sendPassword()
    {
        $usuario = $_POST['usuario_f'];
        $correo = $_POST['correo_f'];

        $user = $this->model->validateRecovery($usuario, $correo);

        if (!empty($user)) {
            $nuevaClave = bin2hex(random_bytes(4)); // Contraseña temporal (8 caracteres)
            $claveHash = password_hash($nuevaClave, PASSWORD_DEFAULT);
            $this->model->updatePassword($claveHash, $user['id']);

            // Preparar el correo
            $mail = new PHPMailer(true);

            try {
                // Configurar servidor SMTP
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com'; // Cambia esto si usas otro proveedor
                $mail->SMTPAuth = true;
                $mail->Username = 'kevinriper68@gmail.com';
                $mail->Password = 'saxa bitw ajso ttke'; // No tu contraseña real, usa contraseña de aplicación
                $mail->SMTPSecure = 'tls';
                $mail->Port = 587;

                // Datos del correo
                $mail->setFrom('noreply@innovatube.com', 'InnovaTube');
                $mail->addAddress($correo, $user['nombre']);

                $mail->isHTML(true);
                $mail->CharSet = 'UTF-8';
                $mail->Encoding = 'base64';
                $mail->Subject = 'Recuperación de contraseña - InnovaTube';
                $mail->Body = "
                <p>Hola <strong>{$user['nombre']}</strong>,</p>
                <p>Tu nueva contraseña temporal es: <strong>{$nuevaClave}</strong></p>
                <p>Por seguridad, cámbiala al iniciar sesión.</p>
            ";

                $mail->send();
                $res = ['tipo' => 'success', 'mensaje' => 'Hemos enviado una nueva contraseña a tu correo.'];
            } catch (Exception $e) {
                $res = ['tipo' => 'error', 'mensaje' => 'Error al enviar el correo: ' . $mail->ErrorInfo];
            }
        } else {
            $res = ['tipo' => 'warning', 'mensaje' => 'Usuario y correo no coinciden.'];
        }

        echo json_encode($res, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function logout()
    {
        session_destroy();
        header('Location: ' . BASE_URL);
    }

}
