<?php

require_once '../core/Database.php';

class Manga{

    private $db;

    public function getAllMangas(){
        try {

            $this->db = getDbConnection();
            $stmt = $this->db->prepare("SELECT 
                m.id AS manga_id,
                m.title AS manga_title,
                COUNT(v.id) AS total_volumes,
                SUM(CASE WHEN v.bought THEN 1 ELSE 0 END) AS bought_volumes,
                (SELECT v1.cover_img 
                FROM volume v1 
                WHERE v1.manga_id = m.id 
                ORDER BY v1.vol_no DESC 
                LIMIT 1) AS latest_cover_img
            FROM manga m
            LEFT JOIN volume v ON m.id = v.manga_id
            GROUP BY m.id, m.title
            ORDER BY m.title;
            ");
            $stmt->execute();

            $manga_result = $stmt->fetchAll(PDO::FETCH_ASSOC); 

            if ($manga_result) {
                return [
                    'success' => true,
                    'manga_data' => $manga_result,
                ];
            }
            else{
                return[
                    'success' => true,
                    'manga_data' => null
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

    public function createManga($data){

        $title      = $data['title'];
        $banner_img = $data['banner_img'];

        try {
            $this->db = getDbConnection();
    
            if(!isset($data['banner_img']) || empty($data['banner_img'])){
                $query = "INSERT INTO manga (title) VALUES (:title)";
                $stmt = $this->db->prepare($query);
                $stmt->bindParam(':title', $title);
            }else{
                $query = "INSERT INTO manga (title, banner_img) VALUES (:title, :banner_img)";
                $stmt = $this->db->prepare($query);
                $stmt->bindParam(':title', $title);
                $stmt->bindParam(':banner_img', $banner_img);
            }
            

            if ($stmt->execute()) {
                return [
                    'success' => true,
                    'message' => 'Manga created',
                    'manga_id' => $this->db->lastInsertId()
                ];
            } else {
                $errorInfo = $stmt->errorInfo(); 
                return [
                    'success' => false,
                    'error' => 'Error while registering manga',
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
}