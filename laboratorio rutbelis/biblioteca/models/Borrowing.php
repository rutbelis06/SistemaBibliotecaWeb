<?php
// Modelo encargado de la gestión de préstamos (borrowings) en la base de datos
// Provee métodos para listar, crear, cancelar y verificar préstamos
class Borrowing extends BaseModel {

    // Nombre de la tabla de la base de datos asociada a este modelo
    public $table = "borrowings";

    // Llama al constructor de BaseModel para inicializar la conexión PDO
    public function __construct() {
        parent::__construct();
    }

    //  Obtiene y retorna todos los registros de préstamos, incluyendo el nombre del usuario y el título del libro, usando JOINs
    public function getAllBorrowings() {
        $sql = "SELECT 
                        br.id,
                        u.name AS user_name,
                        bk.title AS book_title,
                        br.borrow_date
                    FROM borrowings br
                    INNER JOIN users u ON br.user_id = u.id
                    INNER JOIN books bk ON br.book_id = bk.id
                    ORDER BY br.borrow_date DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtiene y retorna los préstamos realizados por un usuario específico
    public function getBorrowingsByUser($userId) {
        $sql = "SELECT 
                        br.id,
                        br.book_id,
                        bk.title AS book_title,
                        br.borrow_date
                    FROM borrowings br
                    INNER JOIN books bk ON br.book_id = bk.id
                    WHERE br.user_id = :uid
                    ORDER BY br.borrow_date DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute(['uid' => $userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    //Registra un nuevo préstamo en la tabla borrowings estableciendo la fecha actual como borrow_d
    public function createBorrowing($userId, $bookId) {
        return $this->insert($this->table, [
            'user_id'   => $userId,
            'book_id'   => $bookId,
            'borrow_date' => date('Y-m-d H:i:s')
        ]);
    }

    //Verifica si ya existe un préstamo activo para un usuario
    public function borrowingExists($userId, $bookId) {
        $sql = "SELECT COUNT(*) FROM borrowings 
                WHERE user_id = :uid AND book_id = :bid";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            'uid' => $userId,
            'bid' => $bookId
        ]);

        // Retorna true si el conteo es mayor a cero.
        return $stmt->fetchColumn() > 0;
    }


    //Elimina un registro de préstamo por su ID, efectivmente cancelando el préstamo. Usa el método deleteById() de BaseModel.
    public function cancelBorrowing($borrowingId) {
        return $this->deleteById($this->table, $borrowingId);
    }
}