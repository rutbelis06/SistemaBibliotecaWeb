<?php
// Controlador principal para la gestión de la autenticación de usuarios (Login, Registro, Logout).
class UserController {
    // Instancia del modelo para interactuar con la tabla de usuarios
    private $userModel;

    //Inicializa la sesión si no está activa y crea la instancia del modelo User
    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $this->userModel = new User();
    }

    // Punto de entrada por defecto Redirige a la lista de libros si el usuario ya esta logueado sino llama al método login
    public function index() {
        // Verifica si la variable de sesión user existe
        if (isset($_SESSION['user'])) {
            header("Location: index.php?controller=Book&action=list");
            exit;
        }
        // Si no está logueado procede al inicio de sesio
        $this->login();
    }

    // Maneja la visualización del formulario de login  y el procesamiento de la autenticacion
    public function login() {
        //Procesa el envío del formulario
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Recoleccion de credenciales
            $email = trim($_POST['email'] ?? '');
            $password = trim($_POST['password'] ?? '');

            // Intenta verificar las credenciales llamando al modelo
            $user = $this->userModel->verifyCredentials($email, $password);

            if ($user) {
                // Si la verificación es exitosa guarda los datos esenciales en la sesión
                $_SESSION['user'] = [
                    'id'    => $user['id'],
                    'name'  => $user['name'],
                    'role'  => $user['role']
                ];

                // Redirige al usuario a la lista de libros.
                header("Location: index.php?controller=Book&action=list");
                exit;
            } else {
                // Si falla la verificaciónestablece un mensaje de error para mostrar en la vista
                $error = "Credenciales inválidas.";
            }
        }

        // Carga la vista del formulario de login
        require __DIR__ . '/../views/login.php';
    }

    // register(): Maneja la visualización del formulario de registro y la creación de un nuevo usuario
    public function register() {
        // Procesa el envío del formulario.
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Recolección de datos
            $name = trim($_POST['name'] ?? '');
            $surname = trim($_POST['surname'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $password = trim($_POST['password'] ?? '');

            // Validación de campos obligatorios
            if ($name === '' || $email === '' || $password === '') {
                $error = "Todos los campos son obligatorios.";
            } else {
                // Verifica si el correo electrónico ya existe en la base de datos
                $existing = $this->userModel->findByEmail($email);

                if ($existing) {
                    // Si el correo ya está en uso, establece un error.
                    $error = "Correo no disponible";
                } else {
                    // Si el correo está libre crea el nuevo usuario (con rol por defecto 'user')
                    $this->userModel->createUser($name,$surname, $email, $password);
                    // Redirige al usuario a la página de login
                    header("Location: index.php?controller=User&action=login");
                    exit;
                }
            }
        }

        // Carga la vista del formulario de registro
        require __DIR__ . '/../views/register.php';
    }

    //Cierra la sesión del usuario
    public function logout() {
        // Destruye todos los datos de la sesión actual
        session_destroy();
        // Redirige al usuario a la página de login
        header("Location: index.php?controller=User&action=login");
        exit;
    }
}