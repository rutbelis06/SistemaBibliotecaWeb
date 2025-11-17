<?php
// Vista que muestra la lista de préstamosLa información mostrada varía
// dependiendo del rol del usuario logueado (admin o normal)
?>

<p><a href="index.php?controller=Book&action=list">Volver a lista de libros</a></p>

<h2><?= ($_SESSION['user']['role'] === 'admin') ? 'Todos los Préstamos' : 'Mis Préstamos' ?></h2>

<?php 
// Bloque condicional que Muestra un mensaje de error si se ha guardado en la sesión
?>
<?php if(isset($_SESSION['error'])): ?>
    <p style="color:red; font-weight:bold;">
        <?= $_SESSION['error'] ?>
    </p>
    <?php unset($_SESSION['error']); // Elimina el error de la sesión para que no se muestre de nuevo ?>
<?php endif; ?>

<?php // Comprueba si hay prestamos para mostrar ?>
<?php if(!empty($borrowings)): ?>
    <table>
        <tr>
            <?php // Muestra la columna usuario solo si el usuario es administrador ?>
            <?php if($_SESSION['user']['role'] === 'admin'): ?>
                <th>Usuario</th>
            <?php endif; ?>
            <th>Libro</th>
            <th>Fecha</th>
            <?php // Muestra la columna acciones  solo si el usuario es administrador?>
            <?php if ($_SESSION['user']['role'] === 'admin'): ?>
                <th>acciones</th>
            <?php endif; ?>
        </tr>

        <?php // Itera sobre la lista de préstamos ?>
        <?php foreach($borrowings as $b): ?>
            <tr>
                <?php // Muestra el nombre del usuario (columna adicional) solo para el administrador?>
                <?php if($_SESSION['user']['role'] === 'admin'): ?>
                    <td><?= htmlspecialchars($b['user_name']) ?></td>
                <?php endif; ?>

                <td><?= htmlspecialchars($b['book_title']) ?></td>
                <td><?= htmlspecialchars($b['borrow_date']) ?></td>
                
                <td>
                    <?php // Muestra el enlace para "eliminar prestamo" solo si el usuario es administrador?>
                    <?php if ($_SESSION['user']['role'] === 'admin'): ?>
                    <a href="index.php?controller=Borrowing&action=cancel&id=<?= $b['id'] ?>"
                       onclick="return confirm('¿Cancelar préstamo?')">
                        eliminar prestamo
                    </a>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>

    </table>
<?php else: ?>
    <p>No hay prestamos registrados.</p>
<?php endif; ?>