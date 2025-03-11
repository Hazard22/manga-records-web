<?php

require_once "../core/Controller.php";
require_once "../app/models/User.php";

class UserController extends Controller{

    private $user;

    public function __construct() {
        $this->user = new User();
    }

    public function index() {
        
        $content = $this->loadView('login');
        require_once "../app/views/layout/layout.php";
    }

    public function signup() {
        $content = $this->loadView('signup');
        require_once "../app/views/layout/layout.php";
    }

    public function registerUser() {
        header('Content-Type: application/json');
        http_response_code(400);
        // Obtener datos JSON del cuerpo de la solicitud POST
        $data = json_decode(file_get_contents('php://input'), true);

        if (!isset($data['username'], $data['password'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Faltan datos']);
            exit;
        }

        $user = new User();
        $result = $user->createUser($data);

        if ($result['success']) {
            http_response_code(201);
            echo json_encode([
                'status' => 201,
                'data' => $result
            ]);
        } elseif (isset($result) && str_contains($result['details'], 'Unique violation: 7 ERROR')) {
            http_response_code(409);
            echo json_encode([
                'status' => 409,
                'data' => 'Username already in use'
            ]);
        } else {
            http_response_code(500);
            echo json_encode([
                'status' => 500,
                'data' => 'Error interno', 'details' => $result['details']
            ]);
        }
    }    

    public function loginUser() {
        header('Content-Type: application/json');
        http_response_code(400);
        // Obtener datos JSON del cuerpo de la solicitud POST
        $data = json_decode(file_get_contents('php://input'), true);

        if (!isset($data['username'], $data['password'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Faltan datos']);
            exit;
        }

        $user = new User();
        $result = $user->loginUser($data);

        if ($result['success']) {
            //Aqui se creara la sesión de usuario
            session_start();

            $_SESSION['username'] = $result['user_data']['username'];
            $_SESSION['profile_pic'] = $result['user_data']['profile_pic'];
            $_SESSION['loggedin'] = true;

            http_response_code(200);
            echo json_encode([
                'status' => 200,
                'data' => $result,
                'redirect' => 'home'
            ]);
        } else {
            if(isset($result['error'])){
                $error = $result['error'];
                switch($error){
                    case 'User does not exists':
                        http_response_code(404);
                        echo json_encode([
                            'status' => 404,
                            'data' => $result
                        ]);
                        break;
                    case 'Wrong password':
                        http_response_code(401);
                        echo json_encode([
                            'status' => 401,
                            'data' => $result
                        ]);
                        break;
                }
            }
            else{
                http_response_code(500);
                echo json_encode([
                    'status' => 500,
                    'data' => 'Error interno', 'details' => $result['details']
                ]);
            }
        }
    }    

    public function logoutUser(){
         
        try {
            header('Content-Type: application/json');
            http_response_code(400);
            session_start(); 
            session_unset(); 
            session_destroy();
            http_response_code(200);
            echo json_encode([
                'status' => 200,
                'data' => 'Session closed',
            ]);
        } catch (\Throwable $th) {
            http_response_code(500);
            echo json_encode([
                'status' => 500,
                'data' => 'Error interno', 'details' => $th
            ]);
        }
    }
}
