<?php

session_start();

require_once '../../config/database.php';

$email = $_POST['email'];  //$_POST recibe datos del formulario
$password = $_POST['password'];

$sql = "SELECT * FROM users
        WHERE email = :email
        AND password = :password";

try{
    $stmt = $conexion->prepare($sql); // prepare() prepara una consulta segura
    $stmt->bindParam(':email', $email); //bindParam inserta valores evitando sql injection
    $stmt->bindParam(':password', $password);
    $stmt->execute(); // ejecuta la consulta

    $user = $stmt->fetch(); // fetch() trae el usuario encontrado

    if($user) {
        $_SESSION['user'] = $user['name']; // Guardamos datos
        $_SESSION['rol'] = $user['rol'];
        $_SESSION['id'] = $user['id'];
        $_SESSION['lastname'] = $user['lastname'];

        header('Location: ../../views/dashboard/dashboard.php'); // Redirigimos
        exit(); // Cotamos ejecucion
    } else {
        echo "LOGIN INCORRECTO";
    }
} catch (PDOException $e) {
    echo "error:" . $e->getMessage($e);
}

?>
