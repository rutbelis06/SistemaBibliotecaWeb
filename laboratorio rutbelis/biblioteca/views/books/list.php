<?php
// Vista principal que muestra la lista de todos los libros
// Incluye enlaces de navegacion y gestiona la visibilidad de opciones CRUD y
// el formulario de prestamo basado en el rol del usuario
// $users (lista de todos los usuarios solo si es admin)
?>

<a href="index.php?controller=User&action=logout">Cerrar sesión</a><br>

<?php // Bloque de navegacion específico para el administrador. ?>
<?php if($user['role'] === 'admin'): ?>
    <a href="index.php?controller=Writer&action=list">gestionar escritores</a> <br>
    <a href="index.php?controller=Book&action=form">Agregar libro</a> <br>
    <a href="index.php?controller=Borrowing&action=list">Gestionar prestamos</a><br> 
    
<?php else: ?>
    <a href="index.php?controller=Borrowing&action=list">libros recibidos</a>
<?php endif; ?>

<h1>Lista de libros</h1>

<?php // Comprueba si el array $books está vacio ?>
<?php if(empty($books)): ?>
    <p>No hay libros disponibles</p>
<?php else: ?>
    <table>
        <tr>
            <th>Título</th>
            <th>Escritor</th> 
            <th>año</th>       
            <?php // Muestra la columna Opciones solo si el usuario es administrador?>
            <?php if ($_SESSION['user']['role'] === 'admin'): ?>
                <th>Opciones</th>
            <?php endif; ?> 
        </tr>

        <?php // Itera sobre la lista de libros para construir la tabla ?>
        <?php foreach($books as $b): ?>
            <tr>
                <td><?= htmlspecialchars($b['title']) ?></td>
                <td><?= htmlspecialchars($b['author_name']) ?></td>
                <td><?= htmlspecialchars($b['year']) ?></td>

                <td>
                    <?php // Celdas de opciones (Editar/Eliminar) solo visibles para el administrador?>
                    <?php if($user['role'] === 'admin'): ?>
                        <a href="index.php?controller=Book&action=form&id=<?= $b['id'] ?>">Editar libro</a>
                        <a href="index.php?controller=Book&action=delete&id=<?= $b['id'] ?>"
                            onclick="return confirm('Eliminar libro?')">eliminar</a>
                    <?php endif; ?>
                    
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
    <hr>
    
    <?php //  Muestra el formulario para crear prestamos solo al administrador ?>
    <?php if($_SESSION['user']['role'] === 'admin'): ?>
    
    <h3>Crear nuevo préstamo</h3>

    <form method="post" action="index.php?controller=Borrowing&action=create">
        
        <label>Usuario:</label>
        <select name="userId" required>
            <option value="">Seleccione un usuario</option>
            <?php foreach($users as $u): ?>
                <option value="<?= $u['id'] ?>">
                    <?= htmlspecialchars($u['name'] . ' ' . $u['surname']) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <br><br>

        <label>Libro:</label>
        <select name="bookId" required>
            <option value="">Seleccione un libro</option>
            <?php foreach($books as $bk): ?>
                <option value="<?= $bk['id'] ?>">
                    <?= htmlspecialchars($bk['title']) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <br><br>

        <button type="submit">Registrar préstamo</button>
    </form>


    <?php endif; ?>

<?php endif; ?>