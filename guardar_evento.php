<?php
$conexion = new mysqli("localhost", "root", "ste2012STE", "eventos_adversos");

if ($conexion->connect_error) {
    die('<div class="alert alert-danger text-center font-weight-bold">Error de conexión: ' . $conexion->connect_error . '</div>');
}

function validarFecha($fecha) {
    $fecha_formateada = date_create($fecha);
    if (!$fecha_formateada) return false;
    $timestamp_fecha = strtotime(date_format($fecha_formateada, "Y-m-d"));
    $timestamp_hoy = strtotime(date("Y-m-d"));
    return $timestamp_fecha <= $timestamp_hoy;
}

function validarAnio($fecha) {
    $anio = date("Y", strtotime($fecha));
    $anio_actual = date("Y");
    return (strlen($anio) == 4 && $anio <= $anio_actual);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $paciente = $conexion->real_escape_string($_POST['paciente']);
    $fecha = $conexion->real_escape_string($_POST['fecha']);
    $descripcion = $conexion->real_escape_string($_POST['descripcion']);
    $tipo = $conexion->real_escape_string($_POST['tipo']);
    $responsable = $conexion->real_escape_string($_POST['responsable']);
    $acciones = $conexion->real_escape_string($_POST['acciones']);

    if (!validarFecha($fecha)) {
        die('<div class="alert alert-warning text-center font-weight-bold">⚠️ Error: La fecha ingresada no es válida o es futura.</div>');
    }
    if (!validarAnio($fecha)) {
        die('<div class="alert alert-danger text-center font-weight-bold">❌ Error: El año ingresado no es válido. Debe tener 4 dígitos y no ser mayor que ' . date("Y") . '.</div>');
    }

    $query = "INSERT INTO eventos (paciente, fecha, descripcion, tipo, responsable, acciones) VALUES ('$paciente', '$fecha', '$descripcion', '$tipo', '$responsable', '$acciones')";

    if ($conexion->query($query) === TRUE) {
        echo '<div class="alert alert-success text-center font-weight-bold">✅ ¡Evento adverso registrado correctamente!</div>';
    } else {
        echo '<div class="alert alert-danger text-center font-weight-bold">❌ Error: ' . $conexion->error . '</div>';
    }

    $conexion->close();
} else {
    echo '<div class="alert alert-danger text-center font-weight-bold">Acceso no permitido.</div>';
}
?>
