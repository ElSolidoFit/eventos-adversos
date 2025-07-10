<?php
include 'conexion.php'; // conexión a la base de datos

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $paciente = $_POST["paciente"];
    $fecha = $_POST["fecha"];
    $descripcion = $_POST["descripcion"];
    $tipo = $_POST["tipo"];
    $responsable = $_POST["responsable"];
    $acciones = $_POST["acciones"];

    $sql = "INSERT INTO eventos (paciente, fecha, descripcion, tipo, responsable, acciones) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssss", $paciente, $fecha, $descripcion, $tipo, $responsable, $acciones);

    if ($stmt->execute()) {
        // Mensaje para AJAX
        echo '<div class="alert alert-success text-center font-weight-bold">✅ Evento adverso registrado correctamente.</div>';
    } else {
        echo '<div class="alert alert-danger text-center font-weight-bold">❌ Error al registrar el evento. Intente nuevamente.</div>';
    }

    $stmt->close();
    $conn->close();
    exit; // Muy importante para que no se imprima el HTML al hacer AJAX
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>Agregar Evento Adverso</title>

	<!-- CSS -->
	<link rel="stylesheet" href="./css/normalize.css" />
	<link rel="stylesheet" href="./css/bootstrap.min.css" />
	<link rel="stylesheet" href="./css/bootstrap-material-design.min.css" />
	<link rel="stylesheet" href="./css/all.css" />
	<link rel="stylesheet" href="./css/sweetalert2.min.css" />
	<link rel="stylesheet" href="./css/jquery.mCustomScrollbar.css" />
	<link rel="stylesheet" href="./css/style.css" />
</head>
<body>
	<main class="full-box main-container">

		<!-- Menú lateral -->
		<section class="full-box nav-lateral">
			<div class="full-box nav-lateral-bg show-nav-lateral"></div>
			<div class="full-box nav-lateral-content">
				<figure class="full-box nav-lateral-avatar">
					<i class="far fa-times-circle show-nav-lateral"></i>
					<img src="./assets/avatar/Avatar.png" class="img-fluid" alt="Avatar" />
					<figcaption class="roboto-medium text-center">
						Carlos Alfaro <br /><small class="roboto-condensed-light">Web Eventos</small>
					</figcaption>
				</figure>
				<div class="full-box nav-lateral-bar"></div>
				<?php include 'menu-lateral.php'; ?>
			</div>
		</section>

		<!-- Contenido de la página -->
		<section class="full-box page-content">
			<nav class="full-box navbar-info">
				<a href="#" class="float-left show-nav-lateral"><i class="fas fa-exchange-alt"></i></a>
				<a href="user-update.html"><i class="fas fa-user-cog"></i></a>
				<a href="#" class="btn-exit-system"><i class="fas fa-power-off"></i></a>
			</nav>

			<div class="full-box page-header">
				<h3 class="text-left"><i class="fas fa-plus fa-fw"></i> &nbsp; AGREGAR EVENTOS ADVERSOS</h3>
				<p class="text-justify">
					Aquí se ingresarán los eventos adversos para su registro y seguimiento, asegurando una gestión eficiente y precisa de cada caso reportado.
				</p>
			</div>

			<div class="container-fluid">
				<ul class="full-box list-unstyled page-nav-tabs">
					<li><a class="active" href="client-new.php"><i class="fas fa-plus fa-fw"></i> &nbsp; AGREGAR EVENTO</a></li>
					<li><a href="client-list.php"><i class="fas fa-clipboard-list fa-fw"></i> &nbsp; LISTA EVENTO</a></li>
					<li><a href="client-search.php"><i class="fas fa-search fa-fw"></i> &nbsp; BUSCAR EVENTO</a></li>
				</ul>	
			</div>
			
			<!-- Aquí se mostrará el mensaje -->
			<div id="mensaje" style="margin-bottom: 20px;"></div>

			<div class="container-fluid">
				<form method="post" class="form-neon" autocomplete="off" id="formEvento">
					<fieldset>
						<legend><i class="fas fa-notes-medical"></i> &nbsp; Ingreso de Evento Adverso</legend>

						<div class="container-fluid">
							<div class="row">
								<div class="col-12 col-md-6">
									<div class="form-group">
										<label for="paciente" class="bmd-label-floating">Nombre del Paciente</label>
										<input type="text" name="paciente" class="form-control" id="paciente" required />
									</div>
								</div>
								<div class="col-12 col-md-6">
									<div class="form-group">
										<label for="fecha" class="bmd-label-floating">Fecha del Evento</label>
										<input type="date" name="fecha" class="form-control" id="fecha" required />
									</div>
								</div>
								<div class="col-12">
									<div class="form-group">
										<label for="descripcion" class="bmd-label-floating">Descripción del Evento</label>
										<textarea name="descripcion" class="form-control" id="descripcion" rows="3" required></textarea>
									</div>
								</div>
								<div class="col-12 col-md-4">
									<div class="form-group">
										<label for="tipo" class="bmd-label-floating">Tipo de Evento</label>
										<input type="text" name="tipo" class="form-control" id="tipo" required />
									</div>
								</div>
								<div class="col-12 col-md-4">
									<div class="form-group">
										<label for="responsable" class="bmd-label-floating">Responsable</label>
										<select name="responsable" class="form-control" id="responsable" required>
	<option value="">Seleccione un responsable</option>
	<?php
		$sqlUsuarios = "SELECT usuario FROM usuarios ORDER BY usuario";
		$resultUsuarios = $conn->query($sqlUsuarios);
		while ($row = $resultUsuarios->fetch_assoc()) {
			echo '<option value="' . htmlspecialchars($row["usuario"]) . '">' . htmlspecialchars($row["usuario"]) . '</option>';
		}
	?>
</select>
									</div>
								</div>
								<div class="col-12 col-md-4">
									<div class="form-group">
										<label for="acciones" class="bmd-label-floating">Acciones Tomadas</label>
										<input type="text" name="acciones" class="form-control" id="acciones" required />
									</div>
								</div>
							</div>
						</div>
					</fieldset>

					<p class="text-center" style="margin-top: 40px;">
						<button type="reset" class="btn btn-raised btn-secondary btn-sm">
							<i class="fas fa-paint-roller"></i> &nbsp; LIMPIAR
						</button>
						&nbsp;&nbsp;
						<button type="submit" class="btn btn-raised btn-info btn-sm">
							<i class="far fa-save"></i> &nbsp; GUARDAR
						</button>
					</p>
				</form>
			</div>

		</section>
	</main>

	<!-- Scripts -->
	<script src="./js/jquery-3.4.1.min.js"></script>
	<script src="./js/popper.min.js"></script>
	<script src="./js/bootstrap.min.js"></script>
	<script src="./js/jquery.mCustomScrollbar.concat.min.js"></script>
	<script src="./js/bootstrap-material-design.min.js"></script>
	<script>$(document).ready(function() { $('body').bootstrapMaterialDesign(); });</script>
	<script src="./js/main.js"></script>

	<script>
	$(document).ready(function() {
		$('#formEvento').submit(function(e) {
			e.preventDefault();
			var form = $(this);
			var data = form.serialize();

			$('#mensaje').html(''); // limpiar mensajes anteriores

			$.post('', data, function(response) {
				$('#mensaje').html(response).hide().fadeIn();

				if(response.includes('✅')) {
					form.trigger('reset');
				}
			}).fail(function() {
				$('#mensaje').html('<div class="alert alert-danger text-center font-weight-bold">❌ Error al guardar, intente nuevamente.</div>').hide().fadeIn();
			});
		});
	});
	</script>
</body>
</html>