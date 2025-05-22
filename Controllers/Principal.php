<?php
class Principal extends Controller
{
    public function __construct() {
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
        $usuario= $_POST['usuario_l'];
        $clave = $_POST['contraseña_l'];

        $data = $this->model->getUsuario($usuario);
        if(!empty($data)) {
            if(password_verify($clave, $data['contraseña'])){
                $_SESSION['id'] = $data['id'];
                $_SESSION['nombre'] = $data['nombre'];
                $_SESSION['usuario'] = $data['usuario'];
                $_SESSION['correo'] = $data['correo'];
                $res = array('tipo'=>'success','mensaje'=> 'BIENVENIDO');
            }else{
                $res = array('tipo'=>'warning','mensaje'=> 'LA CONTRAEÑA ES INCORRECTA');
            }
        }else {
            $res = array('tipo'=>'warning','mensaje'=> 'EL CORREO / USUARIO INGRESADO NO EXISTE');
        }
        echo json_encode($res,JSON_UNESCAPED_UNICODE);
        die();
    }

    public function logout()
    {
        session_destroy();
        header('Location: ' . BASE_URL);
    }

}
