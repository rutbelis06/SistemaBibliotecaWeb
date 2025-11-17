<?php
// ARCHIVO: models/Writer.php
// Modelo encargado de la gestión de autores (escritores) Extiende BaseModel para las funciones CRUD genericas
class Writer extends BaseModel {
    // Nombre de la tabla de la base de datos a la que se asocia este modelo
    public $table = 'authors';

    //Llama al constructor padre para inicializar la conexión PDO
    public function __construct() {
        parent::__construct();
    }

    //Obtiene y retorna todos los registros de la tabla 
    public function getAllWriters() {
        return $this->getAll($this->table);
    }

    // Obtiene y retorna un unico registro de autor por su ID usando el método getById de BaseModel
    public function getWriter($id) {
        return $this->getById($this->table, $id);
    }

    // Crea un nuevo registro de autor en la tabla
    public function createWriter($name) {
        return $this->insert($this->table, ['name' => $name]);
    }

    // Actualiza el nombre de un autor existente identificado por $id
    public function updateWriter($id, $name) {
        return $this->update($this->table, $id, ['name' => $name]);
    }

    // deleteWriter($id): Elimina un registro de autor de la base de datos por su id
    public function deleteWriter($id) {
        return $this->deleteById($this->table, $id);
    }
}