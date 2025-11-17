<?php
//   Punto de entrada del sistema Se encarga de
//     - Cargar automáticamente modelos y controladores
//     - Recibir los parámetros "controller" y "action"
//     - Validar que existan
//     - Ejecutar el controlador correspondiente
// Iniciar sesión
session_start();

// AUTOLOAD BASICO
//   Carga automática de modelos y controladores.
spl_autoload_register(function ($class) {

    // Carpetas donde buscar clases
    $folders = [
        "models",
        "controllers"
    ];
    foreach ($folders as $folder) {
        $path = __DIR__ . "/$folder/$class.php";
        if (file_exists($path)) {
            require_once $path;
            return;
        }
    }
});
// CONFIGURACIÓN DE BASE DE DATOS
//   Constantes usadas por Database.php
define('DB_HOST', '127.0.0.1');
define('DB_NAME', 'biblioteca');
define('DB_USER', 'root');
define('DB_PASS', '');
// OBTENER CONTROLADOR Y ACCION
// Nombre del controlador recibido por GET (ej. "Book", "Writer", "User")
$controllerName = $_GET['controller'] ?? 'User';

// Asegurar primera letra en mayúscula + sufijo "Controller"
$controllerClass = ucfirst($controllerName) . 'Controller';

// AcciOn solicitada /método dentro del controlador
$action = $_GET['action'] ?? 'index';


// VALIDAR QUE EL CONTROLADOR EXISTE
if (!class_exists($controllerClass)) {
    // Si no existe, redirigimos al login
    $controllerClass = "UserController";
}

// Crear instancia del controlador
$controller = new $controllerClass();

// VALIDAR QUE LA ACCIÓN EXISTE
if (!method_exists($controller, $action)) {
    $action = "index"; // método por defecto
}


// EJECUTAR CONTROLADOR Y ACCIÓN
$controller->{$action}();

?>
