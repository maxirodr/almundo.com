<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
	<meta name="theme-color" content="#ff1744"/>

	<title>almundo - Tu tienda online</title>

	<!--[if lt IE 9]>
	  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->

	<link rel="icon" type="image/png" href="img/favicon.png">

	<link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/themes/ui-lightness/jquery-ui.min.css" />
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/font-awesome.min.css">
	<link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" href="css/homepage.css">
</head>
<body>

	<div class="fixed">
		<header>
			<div class="container">
				<div class="row">
					<div class="col-xs-4">
						<a href="full" class="logo-header">
							<!-- <img src="img/toldo.png" style="max-width:30px;max-height:30px;" onerror="this.onerror=null; this.src='toldo.png'">
							<img src="img/logo.svg" style="max-width:90%;" onerror="this.onerror=null; this.src='logo.png'">!-->
							<img src="img/logo_av.png">
						</a>
					</div>
					
					<div class="col-xs-8 pull-right">
						<div class="row">
							<div class="col-md-12 hidden-xs">
								<ul class="icons ns">
									<li data-toggle="tooltip" data-placement="bottom" title="Cuenta">
										<a href="#"><i class="fa fa-user" aria-hidden="true"></i> Ingresar</a>
									</li>
									
									<li class="separator"></li>

									<li data-toggle="tooltip" data-placement="bottom" title="Beneficios">
										<a href="#">
											clubalmundo
										</a>
									</li>
		
									<li class="separator"></li>

									<li data-toggle="tooltip" data-placement="bottom" title="Dónde comprar">
										<a href="#">
											Sucursales
										</a>
									</li>

									<li class="separator"></li>

									<li data-toggle="tooltip" data-placement="bottom" title="Asistencia">
										<a href="#">Llamanos</a>
									</li>

									<li class="separator"></li>

									<li data-toggle="tooltip" data-placement="bottom" title="Asistencia online">
										<a href="#">
											Ayuda
										</a>
									</li>
								</ul>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12 hidden-lg hidden-md hidden-sm">
								<div class="navbar-header header ns">
									<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#categories">
										<i class="fa fa-bars" aria-hidden="true"></i>
									</button>
									
									<button type="button" class="navbar-toggle" data-toggle="collapse">
										<i class="fa fa-search" aria-hidden="true"></i>
									</button>
									
									<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#user">
										<i class="fa fa-user" aria-hidden="true"></i>
									</button>
								</div>
							</div>
						</div>
						
					</div>
				</div>
			</div>
		</header>
		<nav class="navbar home" role="navigation">
			<div class="container np navbar-home">
				<div class="collapse navbar-collapse" id="categories">
					<ul class="nav navbar-nav home ns">
						
						<li><a href="#">Hoteles</a></li>
						
						<li><a href="#">Vuelos</a></li>
						
						<li><a href="#">Vuelos + Hotel</a></li>
						
						<li><a href="#">Paquetes</a></li>
						
						<li><a href="#">Disney</a></li>
						
						<li><a href="#">Escapadas</a></li>
						
						<li><a href="#">Seguros</a></li>
						
						<li><a href="#">Autos</a></li>
						
						<li><a href="#">Cruceros</a></li>
						
						<li><a href="#">OFERTAS</a></li>					
						
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">Mas <b class="caret"></b></a>
							<ul class="dropdown-menu">
								<div class="row">
									<div class="col-sm-12">
										<ul class="multi-column-dropdown">
											<li><a href="#">Link</a></li>
											<li><a href="#">Link</a></li>
											<li><a href="#">Link</a></li>
											<li class="divider"></li>
											<li><a href="#">Link</a></li>
											<li><a href="#">Link</a></li>
											<li><a href="#">Link</a></li>
											<li><a href="#">Link</a></li>
											
											<li class="divider"></li>
										</ul>
									</div>
								</div>
							</ul>
						</li>

					</ul>
				</div>

				<div class="collapse navbar-collapse" id="user">
					<ul class="nav navbar-nav home ns">
						<li>algo?</li>
					</ul>
				</div>
			</div>
		</nav>
	</div>

	<div class="header-space"></div>
	
	<section class="search">
		<div class="container">
			<div class="row breadcum">
				Home / 
				<a href="#">Hoteles</a> / 
				madrid
			</div>
			
			<div class="row description">
				
			</div>
			
			<div class="row order-select">select opt full right</div>
			
			<div class="row body">
				<div class="col-md-2">
					filtros
				</div>
				
				<div class="col-md-10">
					
					<div class="col-sm-12">
						<div class="col-sm-4 img">
							<img src="" />
							<div id="over-text">text centrado</div>
						</div>
						
						<div class="col-sm-4 description">
							son 4 rows:
							title, stars, "cama | solo habitación", 6 iconos
						</div>
						
						<div class="col-sm-4 price">
							Precio por noche por habitación<br>
							
							<span id="precio"><span id="smaller">ARS</span>$1.000</span>
							
							impuestos y tasas no incluidos
							<a href="#" id="btn">Ver hotel</a>
							
							<span id="add-txt">Pagá en cuotas</span>
							<span id="add-txt">Pagá en destino</span>
						</div>
					</div>
					
				</div>
			</div>
		</div>
	</section>

	<footer>
		<div class="container">
			<div class="row">
				<div class="col-md-12 social-icons">

					<a href="#" target="_blank">
						<span class="fa-stack fa-lg">
							<i class="fa fa-circle fa-stack-2x"></i>
							<i class="fa fa-facebook fa-stack-1x fa-inverse"></i>
						</span>
					</a>

					<a href="#" target="_blank">
						<span class="fa-stack fa-lg">
							<i class="fa fa-circle fa-stack-2x"></i>
							<i class="fa fa-twitter fa-stack-1x fa-inverse"></i>
						</span>
					</a>

					<a href="#" target="_blank">
						<span class="fa-stack fa-lg">
							<i class="fa fa-circle fa-stack-2x"></i>
							<i class="fa fa-instagram fa-stack-1x fa-inverse"></i>
						</span>
					</a>

				</div>
			</div>
			<div class="row">
				<div class="col-md-11">
					<div class="row">
						<div class="col-md-3 np">
							<ul>
								<li class="title">Footer</li>
								<li><a href="#">Opciones</a></li>
								<li><a href="#">Opciones</a></li>
								<li><a href="#">Opciones</a></li>
								<li><a href="#">Opciones</a></li>
								<li><a href="#">Opciones</a></li>
							</ul>
						</div>
						<div class="col-md-3 np">
							<ul>
								<li class="title">Footer</li>
								<li><a href="#">Opciones</a></li>
								<li><a href="#">Opciones</a></li>
								<li><a href="#">Opciones</a></li>
								<li><a href="#">Opciones</a></li>
								<li><a href="#">Opciones</a></li>
							</ul>
						</div>
						<div class="col-md-3 np">
							<ul>
								<li class="title">Footer</li>
								<li><a href="#">Opciones</a></li>
								<li><a href="#">Opciones</a></li>
								<li><a href="#">Opciones</a></li>
								<li><a href="#">Opciones</a></li>
								<li><a href="#">Opciones</a></li>
							</ul>
						</div>
						<div class="col-md-3 np">
							<ul>
								<li class="title">Footer div</li>
								<li><a href="#">Opciones</a></li>
								<li><a href="#">Opciones</a></li>
							</ul>
							<ul>
								<li class="title">Footer div2</li>
								<li><a href="#">Opciones</a></li>
								<li><a href="#">Opciones</a></li>
								<li><a href="#">Opciones</a></li>
								<li><a href="#">Opciones</a></li>
							</ul>
						</div>
					</div>
				</div>
				<div class="col-md-1 col-xs-6">
					<a href="#" target="_blank">
						<img src="http://placehold.it/84x114" class="img-responsive" alt="">
					</a>
				</div>
			</div>
		</div>
	</footer>

	<div class="copyright">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<ul>
						<li>Copyright © almundo</li>
						<li><a href="#">Términos y condiciones</a></li>
						<li><a href="#">Políticas de privacidad</a></li>
					</ul>
				</div>
			</div>
		</div>
	</div>

	<script src="js/jquery.1.11.3.min.js"></script>
	<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/jquery-ui.min.js"></script>

	<script src="js/bootstrap.min.js"></script>
	<script src="js/functions.js"></script>
	
</body>
</html>