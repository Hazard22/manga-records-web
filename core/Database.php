<?php
// Función para establecer la conexión con la base de datos
function getDbConnection() {
    
    try {

        $host = $_ENV['PGHOST'];
        $dbname = $_ENV['PGDATABASE'];
        $user = $_ENV['PGUSER'];
        $password = $_ENV['PGPASSWORD'];

        // Crear una instancia de PDO para conectarse a la base de datos
        $dsn = "pgsql:host=" . $host . ";dbname=" . $dbname;
        $db = new PDO($dsn, $user, $password);
        
        // Configurar PDO para que lance excepciones si hay errores
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return $db;  // Devolver la conexión
    } catch (PDOException $e) {
        // Si ocurre un error, mostrar el mensaje
        echo "Error de conexión: " . $e->getMessage();
        exit;  // Detener la ejecución si la conexión falla
    }
}