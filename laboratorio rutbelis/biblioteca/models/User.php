<?php
//modelo que tendra las funciones que hara el usuario
class User extends BaseModel {
    // Nombre de la tabla de la base de datos asociada a este modelo
    public $table = 'users';

    //Llama al constructor padre para inicializar la conexión
    public function __construct() {
        parent::__construct();
    }
    // Busca y retorna un unico registro de usuario de la base de datos utilizando el email como filtro
    public function findByEmail($email) {
        $stmt = $this->db->prepare("SELECT * FROM `users` WHERE email = :email LIMIT 1");
        $stmt->execute(['email' => $email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    

    // Crea un nuevo registro de usuario en la tabla users La contraseña es hasheada antes de la inserción
    public function createUser($name, $surname, $email, $password, $role = 'user') {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        return $this->insert($this->table, [
            'name' => $name,
            'surname' => $surname,
            'email' => $email,
            'password' => $hash, // Se inserta la contraseña hasheada
            'role' => $role
        ]);
    }

    // Verifica las credenciales (email y password) para el proceso de inicio de sesiom
    // Primero busca al usuario por email y luego verifica si la contraseña coincide con el hash almacenado
    public function verifyCredentials($email, $password) {
        $u = $this->findByEmail($email);
        if (!$u) return false; // Retorna false si el usuario no existe
        
        // Compara la contraseña ingresada con el hash usando password_verify
        if (password_verify($password, $u['password'])) return $u; 
        
        return false;
    }
}