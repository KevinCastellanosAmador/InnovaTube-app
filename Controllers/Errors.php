<?php
class Errors extends Controller
{
    private $id_usuario;
    public function __construct() {
        parent::__construct();
    }
    public function index()
    {
        $data['title'] = 'Pagina no encontrada';
        $this->views->getView('principal', 'errors', $data);
    }

}
