<?php
class Moduloyt extends Controller
{
    private $id_usuario;
    public function __construct()
    {
        parent::__construct();
        session_start();
        session_start();
        $this->id_usuario = $_SESSION['id'];
        if (empty($_SESSION['id'])) {
            header('Location: ' . BASE_URL);
            exit();
        } 
    }
    public function index()
    {
        $data['title'] = 'InnovaTube';
        $this->views->getView('modules', 'moduloyt', $data);
    }

    public function searchYT()
    {
        header('Content-Type: application/json');
        // Validar parámetro de búsqueda
        if (!isset($_GET['q']) || empty(trim($_GET['q']))) {
            echo json_encode(['error' => 'Falta parámetro de búsqueda']);
            exit;
        }

        $query = urlencode($_GET['q']);
        $apiKey = YOUTUBE_API_KEY;

        // Armar URL de la API de YouTube
        $apiUrl = "https://www.googleapis.com/youtube/v3/search?part=snippet&maxResults=9&q=$query&type=video&key=$apiKey";

        // Hacer la petición
        $response = file_get_contents($apiUrl);

        if ($response === FALSE) {
            echo json_encode(['error' => 'No se pudo conectar con la API de YouTube']);
            exit;
        }

        // Mostrar resultados como JSON
        echo $response;
    }
    public function guardar()
    {
        $json = json_decode(file_get_contents('php://input'), true);

        if (!isset($json['video_id'], $json['titulo'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Datos incompletos']);
            return;
        }

        $id_usuario = $_SESSION['id'];
        $video_id = $json['video_id'];
        $titulo = $json['titulo'];

        $res = $this->model->agregarFavorito($id_usuario, $video_id, $titulo);
        echo json_encode(['success' => $res]);
    }

    public function eliminar()
    {
        $json = json_decode(file_get_contents('php://input'), true);

        if (!isset($json['video_id'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Datos incompletos']);
            return;
        }
        $id_usuario = $_SESSION['id'];
        $video_id = $json['video_id'];

        $res = $this->model->eliminarFavorito($id_usuario, $video_id);
        echo json_encode(['success' => $res]);
    }

    public function obtener()
{
    $id_usuario = $_SESSION['id'];
    $favoritos = $this->model->obtenerFavoritos($id_usuario);
    echo json_encode($favoritos);
}
}
