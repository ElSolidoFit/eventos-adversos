<?php 
include 'conexion.php'; 
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Lista de Eventos</title>

    <link rel="stylesheet" href="./css/normalize.css" />
    <link rel="stylesheet" href="./css/bootstrap.min.css" />
    <link rel="stylesheet" href="./css/bootstrap-material-design.min.css" />
    <link rel="stylesheet" href="./css/all.css" />
    <link rel="stylesheet" href="./css/jquery.mCustomScrollbar.css" />
    <link rel="stylesheet" href="./css/style.css" />
</head>
<body>
<main class="full-box main-container">
    <section class="full-box nav-lateral">
        <div class="full-box nav-lateral-bg show-nav-lateral"></div>
        <div class="full-box nav-lateral-content">
            <figure class="full-box nav-lateral-avatar">
                <i class="far fa-times-circle show-nav-lateral"></i>
                <img src="./assets/avatar/Avatar.png" class="img-fluid" alt="Avatar" />
                <figcaption class="roboto-medium text-center">
                    Carlos Alfaro <br />
                    <small class="roboto-condensed-light">Web Eventos</small>
                </figcaption>
            </figure>
            <div class="full-box nav-lateral-bar"></div>
            <?php include 'menu-lateral.php'; ?>
        </div>
    </section>

    <section class="full-box page-content">
        <nav class="full-box navbar-info">
            <a href="#" class="float-left show-nav-lateral"><i class="fas fa-exchange-alt"></i></a>
            <a href="user-update.html"><i class="fas fa-user-cog"></i></a>
            <a href="#" class="btn-exit-system"><i class="fas fa-power-off"></i></a>
        </nav>

        <div class="full-box page-header">
            <h3 class="text-left">
                <i class="fas fa-clipboard-list fa-fw"></i> &nbsp; LISTA DE EVENTOS
            </h3>
            <p class="text-justify">
                A continuación se muestra la lista de eventos adversos registrados en el sistema.
            </p>
        </div>

        <div class="container-fluid">
            <ul class="full-box list-unstyled page-nav-tabs">
                <li><a href="client-new.php"><i class="fas fa-plus fa-fw"></i> &nbsp; AGREGAR EVENTO</a></li>
                <li><a class="active" href="client-list.php"><i class="fas fa-clipboard-list fa-fw"></i> &nbsp; LISTA DE EVENTOS</a></li>
                <li><a href="client-search.php"><i class="fas fa-search fa-fw"></i> &nbsp; BUSCAR EVENTO</a></li>
            </ul>
        </div>

        <div class="container-fluid">
            <div class="table-responsive">
                <table class="table table-dark table-sm">
                    <thead>
                        <tr class="text-center roboto-medium">
                            <th>#</th>
                            <th>PACIENTE</th>
                            <th>DESCRIPCIÓN</th>
                            <th>TIPO</th>
                            <th>RESPONSABLE</th>
                            <th>ACTUALIZAR</th>
                            <th>ELIMINAR</th>
                        </tr>
                    </thead>
                    <tbody id="tabla-eventos">
                        <?php
                        $sql = "SELECT * FROM eventos ORDER BY id DESC";
                        $resultado = $conn->query($sql);
                        $contador = 1;

                        if ($resultado && $resultado->num_rows > 0) {
                            while ($row = $resultado->fetch_assoc()) {
                                echo '<tr class="text-center" data-id="' . $row["id"] . '">';
                                echo '<td>' . $contador++ . '</td>';
                                echo '<td>' . htmlspecialchars($row["paciente"]) . '</td>';
                                echo '<td>' . htmlspecialchars($row["descripcion"]) . '</td>';
                                echo '<td>' . htmlspecialchars($row["tipo"]) . '</td>';
                                echo '<td>' . htmlspecialchars($row["responsable"]) . '</td>';
                                echo '<td><a href="client-update.php?id=' . $row["id"] . '" class="btn btn-success"><i class="fas fa-sync-alt"></i></a></td>';
                                echo '<td><button class="btn btn-warning btn-eliminar" data-id="' . $row["id"] . '"><i class="far fa-trash-alt"></i></button></td>';
                                echo '</tr>';
                            }
                        } else {
                            echo '<tr><td colspan="7" class="text-center">No hay eventos registrados.</td></tr>';
                        }
                        $conn->close();
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</main>

<!-- Scripts -->
<script src="./js/jquery-3.4.1.min.js"></script>
<script src="./js/popper.min.js"></script>
<script src="./js/bootstrap.min.js"></script>
<script src="./js/jquery.mCustomScrollbar.concat.min.js"></script>
<script src="./js/bootstrap-material-design.min.js"></script>
<script>
    $(document).ready(function () {
        $('body').bootstrapMaterialDesign();
    });
</script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const tabla = document.getElementById('tabla-eventos');

    tabla.addEventListener('click', function (e) {
        if (e.target.closest('.btn-eliminar')) {
            const boton = e.target.closest('.btn-eliminar');
            const id = boton.getAttribute('data-id');
            const fila = boton.closest('tr');

            if (confirm('¿Eliminar evento? Esta acción no se puede deshacer.')) {
                console.log('Confirmado eliminar, enviando fetch con id:', id);

                fetch('client-delete.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: 'id=' + encodeURIComponent(id)
                })
                .then(res => res.text())
                .then(data => {
                    console.log('Respuesta del servidor:', data);
                    if (data.trim() === 'ok') {
                        alert('¡Eliminado! El evento fue eliminado.');
                        location.reload();
                    } else {
                        alert('Error: No se pudo eliminar el evento. ' + data);
                    }
                })
                .catch(() => {
                    alert('Error en la solicitud.');
                });
            }
        }
    });
});
</script>

</body>
</html>
