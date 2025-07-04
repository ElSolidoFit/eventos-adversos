<?php
session_start();

/* 1) Solo acepta POST desde el formulario */
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: login.html');
    exit;
}

/* 2) Datos recibidos */
$usuario = trim($_POST['usuario'] ?? '');
$clave   = $_POST['clave'] ?? '';

if ($usuario === '' || $clave === '') {
    exit('⚠️ Escribe usuario y contraseña.');
}

/* 3) Conexión PDO */
try {
    $pdo = new PDO(
        'mysql:host=localhost;dbname=eventos_adversos;charset=utf8',
        'root','1234',
        [PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,
         PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC]
    );

    /* 4) Buscar usuario */
    $stmt = $pdo->prepare('SELECT * FROM usuarios WHERE usuario = ? LIMIT 1');
    $stmt->execute([$usuario]);
    $u = $stmt->fetch();

    if (!$u)                           exit('❌ Usuario o contraseña incorrectos.');
    if ($u['estado'] !== 'activo')     exit('🚫 Cuenta inactiva.');
    if (!password_verify($clave,$u['clave']))
                                       exit('❌ Usuario o contraseña incorrectos.');

    /* 5) Todo OK → actualizar última conexión y crear sesión */
    $pdo->prepare('UPDATE usuarios SET ultima_conexion = NOW() WHERE id = ?')
        ->execute([$u['id']]);

    session_regenerate_id(true);
    $_SESSION['usuario']=$u['usuario'];
    $_SESSION['nombre']= $u['nombre_completo'];
    $_SESSION['estado']= $u['estado'];

    header('Location: index.html');
    exit;

} catch (PDOException $e) {
    exit('❌ Error BD: '.$e->getMessage());
}
