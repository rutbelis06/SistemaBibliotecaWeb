# Sistema para Biblioteca

## Requerimientos Funcionales

### Inicio de Sesión (Login)

El sistema debe permitir que un usuario registrado acceda utilizando sus credenciales
anque los administradores no tienen un formulario de registro y se les proporciona una cuenta de administrador con
un hash generado por paswordhash e insertado en la base de datos junto con los demas datos por el desarrolador

cuenta de admin:
administrador1@gmail.com
administrador

**Requerimientos específicos:**

* El usuario debe ingresar un **correo electronico** y una **contraseña**.
* El sistema debe validar que:
    * El correo exista en la base de datos
    * La contraseña coincida con el **hash almacenado**
* **Si las credenciales son correctas,** el usuario:
    * Accede al sistema
    * Se le asigna una sesión con sus datos
    * Es redirigido segun su rol (`admin` o `user`)
* **Si la autenticación falla:**
    * Se muestra un mensaje de error.
    * No se genera una sesión.

### Registro de Usuarios

El sistema debe permitir registrar nuevos usuarios aunque esto no aplica con los usuarios con rol de administrador que son proporcionados directamente 

**Requerimientos específicos:**

* Capturar los datos: **Nombre, Apellido, Correo electrónico y Contraseña**
* Validar que el correo **no exista previamente**
* **Hash de contraseña** utilizando `password_hash()`
* Insertar el usuario en la base de datos con **rol predeterminado `user`**
* Mensaje de confirmación después del registro correcto

### Roles del Sistema

El sistema debe diferenciar entre dos tipos de usuarios:

 Rol  Funcionalidades 
 **Administrador**  Registrar, editar y eliminar libros y escritores (CRUD). Registrar y gestionar todos los préstamos del sistema
| **Usuario estandar** | Consultar libros disponibles. Visualizar solo sus préstamos No puede realizar acciones de gestión (CRUD)


## Lógica de Negocio del Sistema

La lógica de negocio está centralizada en los modelos y controladores

Cada operación relevante se gestiona siguiendo las reglas:
* **Validación de datos** en los controladores (Ejemplo: campos obligatorios, rango de números)
* **Inserciones, actualizaciones o consultas** desde los modelos
* **Prevención de duplicados** (usuarios, préstamos, correos) en el lado del modelo
* Manejo seguro de contraseñas con **hashing**.
* **Restricción de acciones** según el rol del usuario (Ej: solo `admin` puede borrar un libro).

Esto garantiza que la aplicación funcione correctamente sin importar desde qué vista se intente operar.



## Flujo de Datos y Comunicación entre los Archivos

El sistema utiliza una arquitectura **MVC (Modelo-Vista-Controlador)** que se comunica de la siguiente manera:

### El Usuario Interactúa con la Vista

* La Vistamuestra la interfaz HTML/PHP
* El usuario envia información mediante formularios o enlaces

### El Router (index.php) procesa la peticion

* el index recibe parámetros como controller y action (Ej: `index.php?controller=User&action=login`)
* Instancia el **Controlador** correspondiente (Ej: UserController y llama al metodo **Acción**)

### El Controlador ejecuta la Lógica

* El Controlador  recibe datos
* Valida la entrada de datos y el rol del usuario
* Llama al método del Modelo para interactuar con la base de datos 
* Redirecciona o carga la **Vista**

### El Modelo interactúa con la Base de Datos

* Los modelos (Ej: User.php, Book.php) **extienden BaseModel**, que maneja la conexión PDO
* Ejecutan las consultas SQL preparadas para buscar usuarios por email, crear préstamos, listar libros, etc
* Retornan el resultado al Controlador.

###  Resultado es Devuelto a la Vista

* El Controlador obtiene los datos del Modelo (Ej: $books = $this->bookModel->getAllBooks()).
* Pasa las variables a la Vista (Ej: require __DIR__ . '/../views/book/list.php';).
* La Vista los muestra en tablas, selectores, mensajes, etc

Este ciclo se repite en todas las operaciones del sistema, garantizando la **separación de responsabilidades** en la arquitectura MVC.



