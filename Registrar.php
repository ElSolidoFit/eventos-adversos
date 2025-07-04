<?php
/* ===========================================================
   registrar.php – Alta de nuevos usuarios
   =========================================================== */

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    /* 1) Recoger datos del formulario */
    $usuario = trim($_POST['usuario'] ?? '');
    $clave   = $_POST['clave']        ?? '';
    $nombre  = trim($_POST['nombre']  ?? '');
    $email   = trim($_POST['email']   ?? '');

    if ($usuario === '' || $clave === '' || $nombre === '') {
        exit('⚠️ Debes completar todos los campos obligatorios.');
    }

    /* 2) Encriptar la contraseña */
    $claveHash = password_hash($clave, PASSWORD_DEFAULT);

    try {
        /* 3) Conexión PDO */
        $pdo = new PDO(
            'mysql:host=localhost;dbname=eventos_adversos;charset=utf8',
            'root',
            'ste2012STE',
            [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
        );

        /* 4) Insertar usuario con estado 'Activo' */
        $sql = 'INSERT INTO usuarios
                   (usuario, clave, nombre_completo, email, estado)
                VALUES
                   (:usuario, :clave, :nombre, :email, :estado)';
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':usuario' => $usuario,
            ':clave'   => $claveHash,
            ':nombre'  => $nombre,
            ':email'   => $email ?: null,
            ':estado'  => 'Activo'
        ]);

        echo "
        <div style='
            text-align: center; 
            font-size: 24px; 
            font-weight: bold; 
            color: white; 
            background-color: #28a745; 
            padding: 20px; 
            border-radius: 10px; 
            width: 50%; 
            margin: 50px auto;
            box-shadow: 0px 0px 10px rgba(0,0,0,0.2);
        '>
            ✅ Usuario registrado correctamente.
            <a href='login.html'>Iniciar sesión</a>";
    

    } catch (PDOException $e) {
        /* 23000 = violación de clave única (usuario repetido) */
        if ($e->getCode() === '23000') {
            echo '⚠️ El usuario ya existe.';
        } else {
            echo '❌ Error de base de datos: ' . $e->getMessage();
        }
    }

} else {
    echo 'Acceso no permitido.';
}
?>