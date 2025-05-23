<?php
class PrincipalModel extends Query{
    public function __construct()
    {
        parent::__construct();
    }

    public function validateUser($user)
    {
        return $this->GET("SELECT * FROM usuarios WHERE usuario = '$user'");
    }

    public function postUser($nombre, $usuario, $correo, $clave)
    {
        $sql = "INSERT INTO usuarios (nombre, usuario, correo, clave) VALUES (?,?,?,?)";
        $datos = array($nombre, $usuario, $correo, $clave);
        return $this->POST($sql, $datos);
    }

    public function validate($item, $value)
    {
        $sql = "SELECT * FROM usuarios WHERE $item = '$value'";
        return $this->GET($sql);
    }

}

?>