<?php
// Vista que presenta el formulario para crear un nuevo escritor o editar uno existente
// Depende de las variables $writer (datos del escritor para edicion o null para creación)
// y $error (mensaje de validación)

?>

<h2><?= $writer ? 'Editar Escritor' : 'Agregar Escritor' ?></h2>

<?php // Muestra cualquier mensaje de error de validación que venga del controlador ?>
<?php if(!empty($error)): ?>
    <p style="color:red;"><?= htmlspecialchars($error) ?></p>
<?php endif; ?>

<form method="post" action="index.php?controller=Writer&action=form">

    <?php // Si se está editando un escritor, se incluye un campo oculto con el ID para la actualizacion ?>
    <?php if($writer): ?>
        <input type="hidden" name="id" value="<?= htmlspecialchars($writer['id']) ?>">
    <?php endif; ?>

    <label>
        Nombre:
        <input type="text" name="name"
               value="<?= htmlspecialchars($writer['name'] ?? '') ?>" required>
    </label>
    <br>

    <button type="submit"><?= $writer ? 'Actualizar' : 'Crear' ?></button>
</form>

<p><a href="index.php?controller=Writer&action=list">Volver a escritores</a></p>