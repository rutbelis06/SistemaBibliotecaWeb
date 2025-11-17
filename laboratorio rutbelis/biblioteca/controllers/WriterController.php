<?php

// Controla el listado, creación, edición y eliminación de autores
class WriterController {
    // Instancia del modelo para interactuar con la tabla de autores
    private $writerModel;
    // Almacena la información del usuario logueado
    private $user;

    // Inicializa el modelo Writer y verifica la autenticacion del usuario
    public function __construct() {
        $this->writerModel = new Writer();

        // Si no hay una sesión de usuario activa redirige a la pgina de login
        if (!isset($_SESSION['user'])) {
            header("Location: index.php?controller=User&action=login");
            exit;
        }

        // Almacena el array de la sesión del usuario para comprobaciones de rol
        $this->user = $_SESSION['user'];
    }

    // Obtiene y muestra la lista de todos los escritores
    public function list() {
        // Recupera la lista completa de escritores llamando al modelo
        $writers = $this->writerModel->getAllWriters();
        // Carga la vista que renderiza el listado
        require __DIR__ . '/../views/writers/list.php';
    }

    //Maneja tanto la visualización del formulario de creación/edición  como el procesamiento de datos
    public function form() {
        // Restricción de acceso Solo el administrador puede acceder a la creación/edición
        if ($this->user['role'] !== 'admin') {
            die("No autorizado.");
        }
        $writer = null;

        // Si se recibe un id por URLrecupera los datos del escritor para editar
        if (isset($_GET['id'])) {
            $writer = $this->writerModel->getWriter((int)$_GET['id']);
        }

        //Procesa el envío del formulario.
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Recolección de nombre del formulario.
            $name = trim($_POST['name'] ?? '');

            // Verifica que el campo de nombre no esté vacío
            if ($name === '') {
                $error = "El nombre es obligatorio."; // Establece un error para mostrar en la vista.
            } else {
                // Si el campoid existe se trata de una actualizacion
                if (!empty($_POST['id'])) {
                    $this->writerModel->updateWriter((int)$_POST['id'], $name);
                } else {
                    // Si no hay id se trata de una nueva creación
                    $this->writerModel->createWriter($name);
                }
                // Redirige al listado después de una operación exitosa
                header("Location: index.php?controller=Writer&action=list");
                exit;
            }
        }

        // Carga la vista que renderiza el formulario
        require __DIR__ . '/../views/writers/form.php';
    }

    // delete(): Elimina un registro de escritor
    public function delete() {
        // Restricción de acceso: Solo el administrador puede eliminar
        if ($this->user['role'] !== 'admin') {
            die("No autorizado.");
        }

        // Si se recibe un 'id' por URL, llama al modelo para eliminar el registro
        if (isset($_GET['id'])) {
            $this->writerModel->deleteWriter((int)$_GET['id']);
        }

        // Redirige al listado después de la eliminación
        header("Location: index.php?controller=Writer&action=list");
        exit;
    }
}