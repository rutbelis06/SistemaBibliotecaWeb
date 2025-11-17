<?php
//   Vista encargada de mostrar el formulario de inicio de sesión.
?>

<h2>iniciar sesion</h2>

<?php
// Mostrar mensaje de error si existe la variable $error
// !empty($error)
//   Verifica que la variable exista y no esté vacía
// htmlspecialchars()
//   Evita inyección de código HTML mostrando texto seguro
?>
<?php if (!empty($error)): ?>
    <p><?= htmlspecialchars($error) ?></p>
<?php endif; ?>


<?php
// FORMULARIO DE LOGIN
//   Envia los datos por al controlador
//   Envía los datos al método login() del UserController
?>
<form method="post" action="index.php?controller=User&action=login">

    <!-- Campo para ingresar el email -->
    <label>
        correo:
        <input type="email" name="email" required>
    </label>
    <br>

    <!-- Campo para ingresar la contraseña -->
    <label>
        contrseña:
        <input type="password" name="password" required>
    </label>
    <br>

    <!-- Botón para enviar el formulario -->
    <button type="submit">iniciar sesion</button>
</form>

<!-- Enlace para ir al formulario de registro -->
<p><a href="index.php?controller=User&action=register">Registrarse</a></p>
