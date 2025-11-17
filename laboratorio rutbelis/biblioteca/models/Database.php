<?php
/**
 * Maneja la conexión PDO a MySQL
 * Todas las clases modelo heredan esta conexi
 */

class Database {

    /** @var PDO Instancia activa de conexión */
    public $pdo;

    /**
     * Constructor: establece la conexión a MySQL usando PDO
     */
    public function __construct() 
    {
        $dsn = sprintf(
            "mysql:host=%s;dbname=%s;charset=utf8mb4",
            DB_HOST,
            DB_NAME
        );

        try {

            $this->pdo = new PDO($dsn, DB_USER, DB_PASS, [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false
            ]);

        } catch (PDOException $e) {

            die("error " . $e->getMessage());
        }
    }
}
