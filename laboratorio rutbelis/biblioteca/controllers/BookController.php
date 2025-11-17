<?php
// Controlador encargado de la lógica de gestión de libros
// Controla el listado, creacion, edición y eliminación de libros

class BookController {
    // Instancia del modelo para interactuar con la tabla de libros
    private $bookModel;
    // Instancia del modelo para interactuar con la tabla que contiene a los escritores
    private $writerModel;

    // Inicializa los modelos de Libro y Autor y verifica si hay un usuario logueado
    public function __construct() {
        $this->bookModel = new Book();
        $this->writerModel = new Writer();

        // Redirige al usuario a la pagina de login si no hay una sesión activa
        if (!isset($_SESSION['user'])) {
            header("Location: index.php?controller=User&action=login");
            exit;
        }
    }

    // Obtiene y muestra la lista de todos los libros
    public function list() {
        // Recupera la lista completa de libros con información del autor
        $books = $this->bookModel->getAllBooks();
        // Obtiene la información del usuario logueado para mostrarla o controlar permisos
        $user = $_SESSION['user'];
        // Obtiene la lista completa de usuarios
        $users = (new User())->getAll('users');

        // Carga la vista que renderiza la lista de libros
        require __DIR__ . '/../views/books/list.php';
    }

    //
    public function form() {
        // Obtiene la lista de todos los autores para el menu desplegable (SELECT) del formulario.
        $writers = $this->writerModel->getAllWriters();
        $book = null;
        if (isset($_GET['id'])) {
            $book = $this->bookModel->getBook((int)$_GET['id']);
        }

        // Procesa el envío del formulario para crear o actualizar un libro.
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Recoleccion de datos del formulario
            $title = trim($_POST['title'] ?? '');
            $writerId = (int)($_POST['writer_id'] ?? 0);
            $year = trim($_POST['year']);

            // Verifica que los campos obligatorios no estén vacíos.
            if ($title === '' || $writerId <= 0) {
                $error = "Todos los campos son obligatorios.";
            } else {
                // Si el campo oculto id existe se trata de una actualización
                if (!empty($_POST['id'])) {
                    $this->bookModel->updateBook((int)$_POST['id'], $title, $writerId, $year);
                } else {
                    // Si no hay id se trata de una nueva creación
                    $this->bookModel->createBook($title, $writerId, $year);
                }
                // Redirige al usuario a la lista después de la operación exitosa
                header("Location: index.php?controller=Book&action=list");
                exit;
            }
        }

        // Carga la vista que renderiza el formulario de creacion o edicion
        require __DIR__ . '/../views/books/form.php';
    }

    // Elimina un libro de la base de datos
    public function delete() {
        $user = $_SESSION['user'];

        // Restricción de acceso:Solo el administrador puede eliminar libros
        if ($user['role'] !== 'admin') {
            die("No autorizado.");
        }

        // Si se recibe un id por URL llama al modelo para eliminar el registro
        if (isset($_GET['id'])) {
            $this->bookModel->deleteBook((int)$_GET['id']);
        }

        // Redirige al usuario a la lista después de la eliminación
        header("Location: index.php?controller=Book&action=list");
        exit;
    }
}