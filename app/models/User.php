<?php 

require_once '../core/Database.php';

class User{

    private $db;

    public function createUser($data) {

        $username = $data['username'];
        $password = $data['password'];

        try {
            $this->db = getDbConnection();
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
    
            // Consulta SQL para insertar el usuario
            $query = "INSERT INTO users (username, password) VALUES (:username, :password)";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':password', $hashedPassword);
    
            // Ejecutar la consulta
            if ($stmt->execute()) {
                return [
                    'success' => true,
                    'message' => 'User register correctly',
                    'user_id' => $this->db->lastInsertId()
                ];
            } else {
                $errorInfo = $stmt->errorInfo(); // Obtener detalles del error SQL
                return [
                    'success' => false,
                    'error' => 'Error while registering user',
                    'details' => $errorInfo
                ];
            }
        } catch (PDOException $e) {
            error_log("Error while registering user: " . $e->getMessage());
            return [
                'success' => false,
                'error' => 'Database exception',
                'details' => $e->getMessage()
            ];
        }
    }

    public function loginUser($data) {

        $username = $data['username'];
        $password = $data['password'];

        try {
            $this->db = getDbConnection();
            $stmt = $this->db->prepare("SELECT * FROM users WHERE username = :username");
            $stmt->bindParam(':username', $username);
            $stmt->execute();

            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($result) {
                if(password_verify($password, $result['password'])){
                    return [
                        'success' => true,
                        'user_data' => $result,
                        'details' => 'auth correct'
                    ];
                }
                else{
                    return [
                        'success' => false,
                        'error' => 'Wrong password',
                    ];
                }
            } 
            else{
                return [
                    'success' => false,
                    'error' => 'User does not exists',
                ];
            }
        } catch (PDOException $e) {
            error_log("Error while registering user: " . $e->getMessage());
            return [
                'success' => false,
                'error' => 'Database exception',
                'details' => $e->getMessage()
            ];
        }

    }
}

