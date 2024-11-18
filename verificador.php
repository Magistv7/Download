<?php
session_start(); // Inicia la sesión

// Ruta al archivo de texto que contiene las credenciales
$archivo = "usuarios.txt"; 

// Verificar si el formulario fue enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener el nombre de usuario y la contraseña desde el formulario
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Abrir el archivo en modo de lectura
    $file = fopen($archivo, "r");

    // Variable para verificar si las credenciales son correctas
    $usuario_valido = false;

    // Leer cada línea del archivo
    while ($linea = fgets($file)) {
        // Eliminar posibles saltos de línea al final de la línea
        $linea = trim($linea);

        // Separar el nombre de usuario y la contraseña usando ":"
        list($user, $pass) = explode(":", $linea);

        // Verificar si las credenciales coinciden
        if ($username === $user && $password === $pass) {
            // Si las credenciales son correctas, iniciar sesión
            $_SESSION['loggedin'] = true;
            $_SESSION['username'] = $user;

            // Redirigir al usuario a la página de descarga
            header("Location: descarga.php");  // Redirige a la página de descarga
            exit();
        }
    }

    // Si las credenciales no son válidas, mostrar un mensaje
    echo "Usuario o contraseña incorrectos.";
    fclose($file);
}
?>
