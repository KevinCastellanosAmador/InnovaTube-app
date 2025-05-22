<?php
class PrincipalModel extends Query{
    public function __construct()
    {
        parent::__construct();
    }

    public function getUsuario($user)
    {
        return $this->select("SELECT * FROM usuarios WHERE usuario = '$user'");
    }

}

?>