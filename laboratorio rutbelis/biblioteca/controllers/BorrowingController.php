<?php

class BorrowingController {

    private $borrowingModel;
    private $user;

    public function __construct() {
        if (!isset($_SESSION['user'])) {
            header("Location: index.php?controller=User&action=login");
            exit;
        }

        $this->user = $_SESSION['user'];
        $this->borrowingModel = new Borrowing();
        $this->userModel = new User();
    }

    // Mostrar préstamos
    public function list() {

        if ($this->user['role'] === 'admin') {
            $borrowings = $this->borrowingModel->getAllBorrowings();
        } else {
            $borrowings = $this->borrowingModel->getBorrowingsByUser($this->user['id']);
        }

        require __DIR__ . '/../views/borrowing/list.php';
    }

    // Crear un préstamo
public function create() {
    $userId = $_POST['userId'] ?? null;
    $bookId = $_POST['bookId'] ?? null;

    if ($userId && $bookId) {

        // VALIDACIÓN: verificar si ya existe el préstamo
        if ($this->borrowingModel->borrowingExists($userId, $bookId)) {

            // Guardar un error en sesión
            $_SESSION['error'] = "Este usuario ya tiene prestado este libro.";

            // Volver al listado
            header("Location: index.php?controller=Borrowing&action=list");
            exit;
        }

        // Si no existe, crearlo
        $this->borrowingModel->createBorrowing($userId, $bookId);
    }

    header("Location: index.php?controller=Borrowing&action=list");
    exit;
}


    // Eliminar préstamo
    public function cancel() {
        $borrowId = $_GET['id'] ?? null;

        if ($borrowId) {
            $this->borrowingModel->cancelBorrowing($borrowId);
        }

        header("Location: index.php?controller=Borrowing&action=list");
        exit;
    }
}
