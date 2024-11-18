<?php
// Ruta al archivo de usuarios
$archivo = "usuarios.txt";

// Verificar si el formulario fue enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener el nombre de usuario y la contraseña
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Verificar si el archivo existe y se puede abrir para lectura
    if (!file_exists($archivo)) {
        // Si el archivo no existe, lo creamos
        $file = fopen($archivo, "w");
        fclose($file);
    }

    // Abrir el archivo en modo de lectura para comprobar si el usuario ya existe
    $file = fopen($archivo, "r");
    if (!$file) {
        die("No se pudo abrir el archivo de usuarios.");
    }

    // Leer cada línea del archivo para ver si el usuario ya está registrado
    while ($linea = fgets($file)) {
        $linea = trim($linea); // Eliminar saltos de línea
        list($user, $pass) = explode(":", $linea);

        // Si el usuario ya existe, mostrar un mensaje de error
        if ($username === $user) {
            echo "El usuario ya existe. Por favor, elige otro nombre de usuario.";
            fclose($file);
            exit();
        }
    }

    // Si no se encontró el usuario, cerramos el archivo de lectura
    fclose($file);

    // Ahora agregamos el nuevo usuario al archivo
    $file = fopen($archivo, "a"); // Abrir el archivo en modo de escritura (append)
    if (!$file) {
        die("No se pudo abrir el archivo para guardar el usuario.");
    }

    // Escribir el nuevo usuario y la contraseña en el archivo
    fwrite($file, $username . ":" . $password . PHP_EOL);

    // Cerrar el archivo
    fclose($file);

    // Redirigir al usuario a la página de inicio de sesión después de registrarse
    header("Location: login.html");
    exit();
}
?>
