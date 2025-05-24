<?php
class ModuloytModel extends Query{
    public function __construct()
    {
        parent::__construct();
    }

    public function agregarFavorito($id_usuario, $video_id, $titulo)
    {
        $sql = "INSERT INTO favoritos (id_usuario, video_id, titulo) VALUES (?, ?, ?)
                ON DUPLICATE KEY UPDATE titulo = VALUES(titulo)";
        $datos = [$id_usuario, $video_id, $titulo];
        return $this->POST($sql, $datos);
    }

    public function eliminarFavorito($id_usuario, $video_id)
    {
        $sql = "DELETE FROM favoritos WHERE id_usuario = ? AND video_id = ?";
        $datos = [$id_usuario, $video_id];
        return $this->DELETE($sql, $datos);
    }

    public function obtenerFavoritos($id_usuario)
    {
        $sql = "SELECT video_id, titulo FROM favoritos WHERE id_usuario = '$id_usuario'";
        return $this->GETALL($sql);
    }

}

?>