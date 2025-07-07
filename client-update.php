<?php
include 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_GET["id"])) {
    $id = $_GET["id"];
    $paciente = $_POST["paciente"];
    $fecha = $_POST["fecha"];
    $descripcion = $_POST["descripcion"];
    $tipo = $_POST["tipo"];
    $responsable = $_POST["responsable"];
    $acciones = $_POST["acciones"];

    $sql = "UPDATE eventos SET paciente=?, fecha=?, descripcion=?, tipo=?, responsable=?, acciones=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssi", $paciente, $fecha, $descripcion, $tipo, $responsable, $acciones, $id);

    if ($stmt->execute()) {
        echo '<div class="alert alert-success text-center font-weight-bold">✅ Evento actualizado correctamente. Redirigiendo...</div>';
    } else {
        echo '<div class="alert alert-danger text-center font-weight-bold">❌ Error al actualizar el evento.</div>';
    }

    $stmt->close();
    $conn->close();
    exit;
}

if (!isset($_GET["id"])) {
    echo "ID de evento no especificado.";
    exit;
}

$id = $_GET["id"];
$sql = "SELECT * FROM eventos WHERE id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$evento = $result->fetch_assoc();
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>Actualizar Evento Adverso</title>
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

	<section class="full-box page-content">
		<nav class="full-box navbar-info">
			<a href="#" class="float-left show-nav-lateral"><i class="fas fa-exchange-alt"></i></a>
			<a href="user-update.html"><i class="fas fa-user-cog"></i></a>
			<a href="#" class="btn-exit-system"><i class="fas fa-power-off"></i></a>
		</nav>

		<div class="full-box page-header">
			<h3 class="text-left"><i class="fas fa-sync-alt fa-fw"></i> &nbsp; ACTUALIZAR EVENTO ADVERSO</h3>
			<p class="text-justify">Actualiza la información del evento adverso reportado para mantener un registro preciso.</p>
		</div>

		<div class="container-fluid">
			<ul class="full-box list-unstyled page-nav-tabs">
				<li><a href="client-new.php"><i class="fas fa-plus fa-fw"></i> &nbsp; AGREGAR EVENTO</a></li>
				<li><a href="client-list.php"><i class="fas fa-clipboard-list fa-fw"></i> &nbsp; LISTA EVENTO</a></li>
				<li><a href="client-search.php"><i class="fas fa-search fa-fw"></i> &nbsp; BUSCAR EVENTO</a></li>
			</ul>
		</div>

		<!-- Mensaje -->
		<div id="mensaje" style="margin-bottom: 20px;"></div>

		<div class="container-fluid">
			<form method="post" class="form-neon" id="formUpdate">
				<fieldset>
					<legend><i class="fas fa-user-edit"></i> &nbsp; Datos del Evento</legend>
					<div class="container-fluid">
						<div class="row">
							<div class="col-12 col-md-6">
								<div class="form-group">
									<label for="paciente" class="bmd-label-floating">Nombre del Paciente</label>
									<input type="text" name="paciente" class="form-control" value="<?php echo $evento['paciente']; ?>" required />
								</div>
							</div>
							<div class="col-12 col-md-6">
								<div class="form-group">
									<label for="fecha" class="bmd-label-floating">Fecha del Evento</label>
									<input type="date" name="fecha" class="form-control" value="<?php echo date('Y-m-d', strtotime($evento['fecha'])); ?>" required />
								</div>
							</div>
							<div class="col-12">
								<div class="form-group">
									<label for="descripcion" class="bmd-label-floating">Descripción</label>
									<textarea name="descripcion" class="form-control" rows="3" required><?php echo $evento['descripcion']; ?></textarea>
								</div>
							</div>
							<div class="col-12 col-md-4">
								<div class="form-group">
									<label for="tipo" class="bmd-label-floating">Tipo</label>
									<input type="text" name="tipo" class="form-control" value="<?php echo $evento['tipo']; ?>" required />
								</div>
							</div>
							<div class="col-12 col-md-4">
								<div class="form-group">
									<label for="responsable" class="bmd-label-floating">Responsable</label>
									<input type="text" name="responsable" class="form-control" value="<?php echo $evento['responsable']; ?>" required />
								</div>
							</div>
							<div class="col-12 col-md-4">
								<div class="form-group">
									<label for="acciones" class="bmd-label-floating">Acciones</label>
									<input type="text" name="acciones" class="form-control" value="<?php echo $evento['acciones']; ?>" required />
								</div>
							</div>
						</div>
					</div>
				</fieldset>

				<p class="text-center" style="margin-top: 40px;">
					<button type="submit" class="btn btn-raised btn-success btn-sm">
						<i class="fas fa-sync-alt"></i> &nbsp; ACTUALIZAR
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
<script>
	$(document).ready(function () {
		$('body').bootstrapMaterialDesign();

		$('#formUpdate').submit(function (e) {
			e.preventDefault();
			var form = $(this);
			var data = form.serialize();

			$('#mensaje').html('');

			$.post('client-update.php?id=<?php echo $evento['id']; ?>', data, function (response) {
				$('#mensaje').html(response).hide().fadeIn();

				if (response.includes('✅')) {
					setTimeout(function () {
						window.location.href = 'client-list.php';
					}, 2000);
				}
			}).fail(function () {
				$('#mensaje').html('<div class="alert alert-danger text-center font-weight-bold">❌ Error al actualizar. Intente nuevamente.</div>').hide().fadeIn();
			});
		});
	});
</script>
</body>
</html>
