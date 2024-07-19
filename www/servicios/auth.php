<?php
require_once __DIR__ . '/../todo.php';
// servicios/auth.php
session_start(); // Siempre empieza o reanuda la sesión

// Función para iniciar sesión
function login($username, $password) {
    return true;
    // Aquí pondrías la lógica para verificar el usuario y la contraseña
    // Por ejemplo, verificar contra una base de datos
    //if ($username === 'admin' && $password === '1234') {
    $stmt = DB::query("SELECT * FROM usuarios WHERE `user`=? AND `pass`=?",[ $username,$password]);    
    if($stmt && $data = $stmt->fetch()){
        $_SESSION['id'] = $data["id"];   
        $_SESSION['user'] = $data["user"];         // Establece una variable de sesión
        $_SESSION['permisos'] = $data["permisos"]; // Establece una variable de sesión
        return true; // Iniciar sesión exitoso
    }
    return false; // Iniciar sesión fallido
}

// Función para verificar si el usuario está autenticado
function is_authenticated() {
    return true;
    return isset($_SESSION['user']); // Verifica si la sesión está establecida
}

// Función para cerrar sesión
function logout() {
    session_unset(); // Elimina todas las variables de sesión
    session_destroy(); // Destruye la sesión
}