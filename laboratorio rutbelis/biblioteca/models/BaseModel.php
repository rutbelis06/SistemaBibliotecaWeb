<?php
// Modelo base que provee métodos CRUD (Crear, Leer, Actualizar, Eliminar)
// genéricos para todos los demás modelos de la aplicación.
class BaseModel {
    // Almacena la instancia de la conexión a la base de datos (PDO).
    public $db; 

    // Inicializa la conexión PDO utilizando la clase global Database y asigna la conexión a $this->db.
    protected function __construct() {
        // La clase Database debe estar disponible globalmente.
        $database = new Database(); 
        $this->db = $database->pdo; 
    }

 
    // Obtiene y retorna todos los registros de la tabla especificada ($table) mediante una consulta SELECT *.
    public function getAll($table) {
        $stmt = $this->db->prepare("SELECT * FROM `$table`");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    // Busca y retorna un único registro de la tabla ($table) filtrado por su clave primaria :id.
    public function getById($table, $id) {
        $stmt = $this->db->prepare("SELECT * FROM `$table` WHERE id = :id LIMIT 1");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    // Ejecuta una sentencia DELETE para eliminar el registro con el :id especificado de la tabla ($table).
    public function deleteById($table, $id) {
        $stmt = $this->db->prepare("DELETE FROM `$table` WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }

    // Construye y ejecuta dinámicamente una sentencia INSERT INTO para la tabla ($table)
    public function insert($table, $data) {
        $fields = array_keys($data); // Obtiene los nombres de las columnas.
        // Crea los placeholders (:columna1, :columna2, ...) para la preparación de la consulta.
        $placeholders = array_map(function($f){ return ':' . $f; }, $fields); 
        
        // Ensambla la SQL e inserta los datos usando el array $data para el binding.
        $sql = "INSERT INTO `$table` (`".implode('`,`',$fields)."`) VALUES (".implode(',',$placeholders).")";
        
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($data);
    }

    // Construye y ejecuta dinámicamente una sentencia UPDATE para el registro con :id de la tabla ($table) usando el array $data.
    public function update($table, $id, $data) {
        $parts = [];
        // Itera sobre $data para construir las cláusulas SET (ej: `col` = :col).
        foreach ($data as $k => $v) $parts[] = "`$k` = :$k"; 
        
        // Ensambla la SQL, añade el ID al array de datos para el binding y ejecuta la consulta.
        $sql = "UPDATE `$table` SET ".implode(',',$parts)." WHERE id = :id";
        
        $data['id'] = $id; 
        
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($data);
    }
}