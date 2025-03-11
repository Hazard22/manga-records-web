<?php

require_once "../core/Controller.php";
require_once "../app/models/Manga.php";

class MangaController extends Controller{

    public function perfil() {
        require_once "../app/views/manga.php";
    }

    public function getAllMangas(){
        header('Content-Type: application/json');
        http_response_code(400);

        $manga = new Manga();
        $result = $manga->getAllMangas();

        if($result['success']){
            if($result['manga_data']){
                http_response_code(200);
                echo json_encode([
                    'status' => 200,
                    'data' => $result['manga_data'],
                ], JSON_UNESCAPED_SLASHES);
            }
            else{
                http_response_code(404);
                echo json_encode([
                    'status' => 404,
                    'data' => 'No mangas found',
                ]);
            }
        }
        else{
            http_response_code(500);
            echo json_encode([
                'status' => 500,
                'data' => $result
            ]);
        }

    }

    public function createManga() {
        header('Content-Type: application/json');
        http_response_code(400);
        $data = json_decode(file_get_contents('php://input'), true);

        if (!isset($data['title'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Not found params']);
            exit;
        }

        $manga = new Manga();
        $result = $manga->createManga($data);

        if ($result['success']) {
            http_response_code(201);
            echo json_encode([
                'status' => 201,
                'data' => $result
            ]);
        } else {
            http_response_code(500);
            echo json_encode([
                'status' => 500,
                'data' => 'Error interno', 'details' => $result['details']
            ]);
        }
    }    
}
