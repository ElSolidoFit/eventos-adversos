<?php
include 'conexion.php';

$buscar = '';
$resultados = [];

if (isset($_GET['buscar'])) {
    $buscar = trim($_GET['buscar']);
    // Prepara consulta con LIKE para buscar en paciente, descripcion y tipo
    $sql = "SELECT * FROM eventos 
            WHERE paciente LIKE ? OR descripcion LIKE ? OR tipo LIKE ?
            ORDER BY id DESC";
    $param = "%{$buscar}%";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $param, $param, $param);
    $stmt->execute();
    $res = $stmt->get_result();

    while ($row = $res->fetch_assoc()) {
        $resultados[] = $row;
    }

    $stmt->close();
} 
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Buscar Eventos</title>

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
                <i class="fas fa-search fa-fw"></i> &nbsp; BUSCAR EVENTOS
            </h3>
            <p class="text-justify">
                Busca eventos adversos por paciente, descripción o tipo.
            </p>
        </div>

        <div class="container-fluid">
            <form method="GET" action="client-search.php" class="form-inline mb-3">
                <input 
                    type="text" 
                    name="buscar" 
                    class="form-control mr-2" 
                    placeholder="Buscar..." 
                    value="<?php echo htmlspecialchars($buscar); ?>" 
                    required
                />
                <button type="submit" class="btn btn-primary">Buscar</button>
                <a href="client-list.php" class="btn btn-secondary ml-2">Volver a la lista</a>
            </form>

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
                    <tbody>
                        <?php
                        if (!empty($resultados)) {
                            $contador = 1;
                            foreach ($resultados as $row) {
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
                        } else if (isset($_GET['buscar'])) {
                            echo '<tr><td colspan="7" class="text-center">No se encontraron eventos que coincidan.</td></tr>';
                        } else {
                            echo '<tr><td colspan="7" class="text-center">Ingrese un término para buscar eventos.</td></tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</main>

<script src="./js/jquery-3.4.1.min.js"></script>
<script src="./js/popper.min.js"></script>
<script src="./js/bootstrap.min.js"></script>
<script src="./js/jquery.mCustomScrollbar.concat.min.js"></script>
<script src="./js/bootstrap-material-design.min.js"></script>
<script>
$(document).ready(function() {
    $('body').bootstrapMaterialDesign();
});
</script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const tabla = document.querySelector('tbody');
    tabla.addEventListener('click', function (e) {
        if (e.target.closest('.btn-eliminar')) {
            const boton = e.target.closest('.btn-eliminar');
            const id = boton.getAttribute('data-id');
            const fila = boton.closest('tr');

            if (confirm('¿Eliminar evento? Esta acción no se puede deshacer.')) {
                fetch('client-delete.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: 'id=' + encodeURIComponent(id)
                })
                .then(res => res.text())
                .then(data => {
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
