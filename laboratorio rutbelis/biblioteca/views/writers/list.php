<?php
// Vista que muestra la lista de todos los escritores/autores.
// Proporciona enlaces para crear editar y eliminar escritores (solo para administradores)
?>

<p><a href="index.php?controller=Book&action=list">Volver a libros</a></p>

<h1>Escritores</h1>

<?php // Comprueba si el array $writers esta vacío ?>
<?php if(!empty($writers)): ?>
    <table>
        <tr>
            <th>Nombre</th>
            <th>Acciones</th> </tr>

        <?php // Itera sobre la lista de escritores  para construir las filas de la tabla ?>
        <?php foreach($writers as $w): ?>
            <tr>
                <td><?= htmlspecialchars($w['name']) ?></td>
                <td>
                    <a href="index.php?controller=Writer&action=form&id=<?= $w['id'] ?>">Editar</a>
                    <a href="index.php?controller=Writer&action=delete&id=<?= $w['id'] ?>"
                       onclick="return confirm('¿Eliminar escritor?')">Eliminar</a>
                </td>
            </tr>
        <?php endforeach; ?>

    </table>
<?php else: ?>
    <p>No hay escritores registrados.</p>
<?php endif; ?>

<p><a href="index.php?controller=Writer&action=form">Agregar escritor</a></p>