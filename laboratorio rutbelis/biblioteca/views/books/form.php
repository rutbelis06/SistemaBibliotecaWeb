<?php
// Vista que presenta el formulario para crear un nuevo libro o editar uno existente
// Depende de las variables: $book (datos del libro para edicion o null para creación)
?>

<h2><?= $book ? 'Editar Libro' : 'Agregar Libro' ?></h2>

<?php // Muestra cualquier mensaje de error de validación que venga del controlador. ?>
<?php if(!empty($error)): ?>
    <p><?= htmlspecialchars($error) ?></p>
<?php endif; ?>

<form method="post" action="index.php?controller=Book&action=form">

    <?php // Si se está editando un libro se incluye un campo oculto con el ID para la actualización?>
    <?php if($book): ?>
        <input type="hidden" name="id" value="<?= htmlspecialchars($book['id']) ?>">
    <?php endif; ?>


    <label>
        Título:
        <input type="text" name="title" value="<?= htmlspecialchars($book['title'] ?? '') ?>" required>
    </label><br>
    <label>
        <label>año de publicacion:
        <input type="number" name="year" value="<?= htmlspecialchars($book['year'] ??  '')?>" required>
    </label><br>
    <label>
        Escritor:
        <select name="writer_id" required>
            <option value="">-- Seleccione --</option>

            <?php // Itera sobre la lista de escritores para crear las opciones ?>
            <?php foreach($writers as $w): ?>
                <option value="<?= $w['id'] ?>"
                    <?php 
                    // Marca la opción como selected si el ID del autor coincide con del libro que se esta editando
                    ?>
                    <?= isset($book['author_id']) && $book['author_id'] == $w['id'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($w['name']) ?>
                </option>
            <?php endforeach; ?>

        </select>
    </label><br>

    <button type="submit"><?= $book ? 'Actualizar' : 'Crear' ?></button>

</form>

<p><a href="index.php?controller=Book&action=list">Volver a lista de libros</a></p>