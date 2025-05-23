<?php
class Query extends Conexion
{
    private $pdo, $con, $sql, $datos;
    public function __construct()
    {
        $this->pdo = new Conexion();
        $this->con = $this->pdo->conect();
    }
    public function GET(string $sql)
    {
        $this->sql = $sql;
        $resul = $this->con->prepare($this->sql);
        $resul->execute();
        $data = $resul->fetch(PDO::FETCH_ASSOC);
        return $data;
    }
    public function GETALL(string $sql)
    {
        $this->sql = $sql;
        $resul = $this->con->prepare($this->sql);
        $resul->execute();
        $data = $resul->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }
    public function PUT(string $sql, array $datos)
    {
        $this->sql = $sql;
        $this->datos = $datos;
        $insert = $this->con->prepare($this->sql);
        $data = $insert->execute($this->datos);
        if ($data) {
            $res = 1;
        } else {
            $res = 0;
        }
        return $res;
    }
    public function POST(string $sql, array $datos)
    {
        $this->sql = $sql;
        $this->datos = $datos;
        $insert = $this->con->prepare($this->sql);
        $data = $insert->execute($this->datos);
        if ($data) {
            $res = $this->con->lastInsertId();
        } else {
            $res = 0;
        }
        return $res;
    }

    public function DELETE(string $sql, array $datos)
    {
        $this->sql = $sql;
        $this->datos = $datos;
        $delete = $this->con->prepare($this->sql);
        $data = $delete->execute($this->datos);
        if ($data) {
            $res = 1; // Éxito al eliminar el registro
        } else {
            $res = 0; // Error al eliminar el registro
        }
        return $res;
    }
}

?>