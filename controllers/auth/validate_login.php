<?php

session_start();

require_once '../../config/database.php';

if (
    empty($_POST['email']) ||
    empty($_POST['password'])
) {

    header('Location: ../../index.php');
    exit;
}

$email = trim($_POST['email']);
$password = trim($_POST['password']);

try {

    $sql = "

    SELECT *
    FROM users
    WHERE email = :email

";

$stmt = $conexion->prepare($sql);

$stmt->execute([
    ':email' => $email
]);

$user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (
    !$user ||
    !password_verify(
        $password,
        $user['password']
    )
) {

    $_SESSION['login_error'] =
        'Usuario o contraseña incorrectos';

    header('Location: ../../index.php');
    exit;
}

    session_regenerate_id(true);

    $_SESSION['user_name'] = $user['name'];
    $_SESSION['user_role'] = $user['rol'];
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['user_lastname'] = $user['lastname'];

    header(
        'Location: ../../views/dashboard/dashboard.php'
    );

    exit;

} catch (PDOException $e) {

    error_log($e->getMessage());

    $_SESSION['login_error'] =
        'Error interno del sistema';

    header('Location: ../../index.php');
    exit;
}