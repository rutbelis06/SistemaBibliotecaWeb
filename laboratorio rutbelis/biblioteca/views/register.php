<?php
//   Vista para registrar un nuevo usuario
//   Muestra formularios de ingreso de datos básicos y errores si existen
?>

<h2>Register</h2>

<?php
// Mostrar mensaje de error si existe la variable $error
// htmlspecialchars() evita que el usuario pueda inyectar HTML
?>
<?php if (!empty($error)): ?>
    <p style="color:red;"><?= htmlspecialchars($error) ?></p>
<?php endif; ?>


<?php
// FORMULARIO DE REGISTRO
//   Envía los datos al método register() del UserController.
?>
<form method="post" action="index.php?controller=User&action=register">

    <!-- Campo para el nombre del usuario -->
    <label>
        nombre:
        <input type="text" name="name" required>
    </label>
    <br>
<label>apellido;
    <input type="text" name="surname" required>
</label><br>

    <!-- Campo para el email -->
    <label>
        correo:
        <input type="email" name="email" required>
    </label>
    <br>

    <!-- Campo para la contraseña -->
    <label>
        contraseña:
        <input type="password" name="password" required>
    </label>
    <br>

    <!-- Botón para enviar formulario -->
    <button type="submit">Register</button>
</form>

<!-- Enlace para volver al formulario de login -->
<p><a href="index.php?controller=User&action=login">Volver al Login</a></p>
