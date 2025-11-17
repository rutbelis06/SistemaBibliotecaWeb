<?php
// Modelo encargado de la gestión de libros. Extiende BaseModel para las funciones CRUD genericas
class Book extends BaseModel {
    // Nombre de la tabla en la bd
    public $table = 'books';

    // este metodoLlama al constructor padre para inicializar la conexión PDO
    public function __construct() {
        parent::__construct();
    }

    //Obtiene todos los libros, incluyendo el nombre completo del autor mediante un JOIN con la tabla 'authors'
    public function getAllBooks() {
        $sql = "SELECT b.*, a.name as author_name FROM books b JOIN authors a ON b.author_id = a.id ORDER BY b.id DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    //Obtiene un unico libro por su ID, incluyendo el nombre del autor asociado
    public function getBook($id) {
        $sql = "SELECT b.*, a.name as author_name FROM books b JOIN authors a ON b.author_id = a.id WHERE b.id = :id LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Crea un nuevo registro de libro usando el método insert() de BaseModel.
    public function createBook($title, $authorId, $year = null) {
        return $this->insert($this->table, [
            'title' => $title,
            'author_id' => $authorId,
            'year' => $year
        ]);
    }

    // Actualiza los datos de un libro existente identificado por $id, usando el método update() de BaseModel.
    public function updateBook($id, $title, $authorId, $year = null) {
        return $this->update($this->table, $id, [
            'title' => $title,
            'author_id' => $authorId,
            'year' => $year
        ]);
    }

    // deleteBook($id): Elimina un libro de la base de datos por su ID, usando el método deleteById() de BaseModel.
    public function deleteBook($id) {
        return $this->deleteById($this->table, $id);
    }
}