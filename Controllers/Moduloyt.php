<?php
class Moduloyt extends Controller
{
    public function __construct()
    {
        parent::__construct();
        session_start();
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
}
