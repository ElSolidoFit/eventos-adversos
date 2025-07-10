<?php
session_start();

// Redirigir si no hay sesión
if (!isset($_SESSION['usuario'])) {
	header('Location: login.html');
	exit;
}

$nombre_usuario = $_SESSION['nombre'] ?? 'Usuario';
$tipo_usuario   = $_SESSION['tipo_usuario'] ?? '';
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Home</title>

	<!-- Estilos -->
	<link rel="stylesheet" href="./css/normalize.css">
	<link rel="stylesheet" href="./css/bootstrap.min.css">
	<link rel="stylesheet" href="./css/bootstrap-material-design.min.css">
	<link rel="stylesheet" href="./css/all.css">
	<link rel="stylesheet" href="./css/sweetalert2.min.css">
	<link rel="stylesheet" href="./css/jquery.mCustomScrollbar.css">
	<link rel="stylesheet" href="./css/style.css">

	<!-- Scripts -->
	<script src="./js/sweetalert2.min.js"></script>
</head>
<body>
	<main class="full-box main-container">
		
		<!-- Nav lateral -->
		<section class="full-box nav-lateral">
			<div class="full-box nav-lateral-bg show-nav-lateral"></div>
			<div class="full-box nav-lateral-content">
				<figure class="full-box nav-lateral-avatar">
					<i class="far fa-times-circle show-nav-lateral"></i>
					<img src="./assets/avatar/Avatar.png" class="img-fluid" alt="Avatar">
					<figcaption class="roboto-medium text-center">
						<?php echo htmlspecialchars($nombre_usuario); ?>
						<br><small class="roboto-condensed-light">Web Eventos</small>
					</figcaption>
				</figure>
				<div class="full-box nav-lateral-bar"></div>
				<?php include 'menu-lateral.php'; ?>
			</div>
		</section>

		<!-- Contenido principal -->
		<section class="full-box page-content">
			<nav class="full-box navbar-info">
				<a href="#" class="float-left show-nav-lateral">
					<i class="fas fa-exchange-alt"></i>
				</a>
				<a href="user-update.php">
					<i class="fas fa-user-cog"></i>
				</a>
				<a href="logout.php" class="btn-exit-system">
					<i class="fas fa-power-off"></i>
				</a>
			</nav>

			<!-- Encabezado -->
			<div class="full-box page-header">
				<h3 class="text-left">
					<i class="fab fa-dashcube fa-fw"></i> &nbsp; DASHBOARD
				</h3>
				<p class="text-justify">
					Bienvenido al sistema de gestión de eventos adversos. Desde aquí puedes acceder a la administración de eventos, usuarios, préstamos e ítems del sistema.
				</p>
			</div>
			
			<!-- Tarjetas -->
			<div class="full-box tile-container">

				<a href="client-new.php" class="tile">
					<div class="tile-tittle">Ingreso de Eventos</div>
					<div class="tile-icon">
						<i class="fas fa-users fa-fw"></i>
						<p>5 Registrados</p>
					</div>
				</a>

				<?php if ($tipo_usuario === '2'): ?>
				
				<!--
				
					<a href="item-list.php" class="tile">
					<div class="tile-tittle">Items</div>
					<div class="tile-icon">
						<i class="fas fa-pallet fa-fw"></i>
						<p>9 Registrados</p>
					</div>
				</a>

				<a href="reservation-list.php" class="tile">
					<div class="tile-tittle">Préstamos</div>
					<div class="tile-icon">
						<i class="fas fa-file-invoice-dollar fa-fw"></i>
						<p>10 Registrados</p>
					</div>
				</a>
              -->
				<a href="user-list.php" class="tile">
					<div class="tile-tittle">Usuarios</div>
					<div class="tile-icon">
						<i class="fas fa-user-secret fa-fw"></i>
						<p>50 Registrados</p>
					</div>
				</a>

				
				<?php endif; ?>
				
			</div>
		</section>
	</main>
	
	<!-- JS -->
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
	<script src="./js/main.js"></script>
</body>
</html>
