<?php
if ( !empty($_GET['select']) && is_numeric($_GET['select']) ) {
	// traemos una categoria
	$id=mysqli_real_escape_string($dbConn, trim($_GET['select']));
	$query = "SELECT id,id_cats,imagenes,link_video,titulo,descripcion,stock,precio,metodo_envio,metodo_pago,tipo_perfil FROM `articulos` WHERE id = '$id' AND categories != 'borrado' LIMIT 1";
	$resultado = mysqli_query($dbConn, $query);
	$row = mysqli_fetch_assoc($resultado); unset($query); mysqli_free_result($resultado);
	
	if(empty($row)) {
		redireccionar($index_web, $url_web);
	}
	
	$imgs=explode(";", $row['imagenes']);
	$imgs_n=count($imgs);
	
	//script para tratar adicionales aun
	$row['adicionales'];
} else {
	redireccionar($index_web, $url_web);
}
?>

<section class="site product" data-site="product">
	<div class="container-fluid e-np" style="margin-bottom: 10px;">
		<div class="row np" style="margin: 0">
			<div class="col-md-12 np">
				<div id="home-highlight" class="carousel slide" data-ride="carousel">
					<!-- Wrapper for slides -->
					<div class="carousel-inner" role="listbox">
						<div class="item active">
							<img src="https://placehold.it/1920x480/2c2c2c?text=1" alt="Publicidad 1">
						</div>
						<div class="item">
							<img src="https://placehold.it/1920x480/2c2c2c?text=2" alt="Publicidad 2">
						</div>
						<div class="item">
							<img src="https://placehold.it/1920x480/2c2c2c?text=3" alt="Publicidad 3">
						</div>
						<div class="item">
							<img src="https://placehold.it/1920x480/2c2c2c?text=4" alt="Publicidad 4">
						</div>
					</div>
					<!-- Left and right controls -->
					<a class="left carousel-control" href="#home-highlight" role="button" data-slide="prev">
						<i class="fa fa-caret-left" aria-hidden="true"></i>
						<span class="sr-only">Anterior</span>
					</a>
					<a class="right carousel-control" href="#home-highlight" role="button" data-slide="next">
						<i class="fa fa-caret-right" aria-hidden="true"></i>
						<span class="sr-only">Siguiente</span>
					</a>
				</div>
			</div>
		</div>
	</div>
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="related-search">
					Busquedas relacionadas <a href="#">remera,</a> <a href="#">chomba,</a> <a href="#">pantalón,</a> <a href="#">camisa</a>
				</div>
			</div>
			<div class="col-md-12">
				<div class="cat">
					<a href="<?="//$url_web/full"?>">Inicio</a>
					<a href="<?="//$url_web/full"?>">Búsqueda de productos</a>
					<!-- <a href="#">Mujer</a> aca filtro si es cachorro adulto o no(PHP) !-->
					<!-- <a href="#">Jeans</a> aca filtro si es castrado o no(PHP) !-->
				</div>
			</div>
			<div class="col-md-10 col-md-offset-1 col-sm-12 sm-info">
				<div class="row">
					<div class="col-sm-7">
						<div class="row np np-exclude-xs np-include-childrens sm-boxes">
							<div class="col-sm-2">
								<div class="row">
									<?php foreach ($imgs as $value) { ?>
									<div class="col-sm-12 col-xs-4">
										<img src="//tarjetealo.com<?=$value?>" alt="" class="product-photo img-responsive">
									</div>
									<?php } ?>
								</div>
							</div>
							<div class="col-sm-10 ppp">
								<img src="" alt="" class="product-principal-photo img-responsive">
							</div>
						</div>
					</div>
					<div class="col-sm-1 hidden-xs">
						<div class="v-sep"></div>
					</div>
					<form action="loquieroya" method="POST">
					<div class="col-md-4 np-right np-right-exclude-xs col-sm-5">
						<h1 class="sm-title"><?=$row['titulo']?></h1>
						<div class="sm-desc"><?=$row['descripcion']?></div>
						<div class="sm-price item-price-alone"><?=$row['precio']?></div>
						<div style="clear:both"></div>
						<div class="sm-desc">Hasta <b>3 cuotas</b>, sin intereses, de $<b><?=round($row['precio']/3,2)?></b></div>

						<div class="sm-actions">
							<div class="row modyp">
								<div class="col-xs-9">
									<a href="<?="//$url_web/"?>loquieroya/<?=$row['id']?>" class="btt buy br-5">Comprar</a>
								</div>
								<div class="col-xs-3">
									<div href="#" class="btt favorite br-5" data-toggle="tooltip" data-placement="top" data-original-title="Agregar a favoritos"></div>
								</div>
							</div>
						</div>
				
						<div class="sm-shipping">
							<span class="free">Envío gratuito</span> con <b>Tarjeta Envíos</b>
							<div style="clear:both"></div>
							<span class="dsc">Llega dentro de <b>5 días</b> a tu dirección en <b>Buenos Aires</b>. <a href="#">Modificar</a></span>
						</div>

						<!-- esto lo agregamos para cuando esté el script para la categoría correspondiente y el panel hecho a medidda
						<div class="sm-select" data-type="clothes">
							<div class="row">
								<div class="col-xs-6">
									<div class="required">Talle</div>

									<select name="size" id="">
										<option value="36">36</option>
										<option value="36">37</option>
										<option value="36">38</option>
										<option value="36">39</option>
									</select>
								</div>
								<div class="col-xs-6">
									<div class="required">Cantidad</div>

									<select name="number" id="">
										<option value="1">1</option>
										<option value="2">2</option>
										<option value="3">3</option>
										<option value="4">4</option>
										<option value="5">5</option>
									</select>
								</div>
								<div class="col-xs-12 sm-colors">
									<div>Colores</div>

									<div class="colors">
										<div class="c1 white br-5" data-color="white" data-toggle="tooltip" data-placement="top" data-original-title="Blanco" data-img="http://placehold.it/400x400/?text=Blanco"></div>
										<div class="c1 green br-5" data-color="green" data-toggle="tooltip" data-placement="top" data-original-title="Verde" data-img="http://placehold.it/400x400/?text=Verde"></div>
										<div class="c1 blue br-5" data-color="blue" data-toggle="tooltip" data-placement="top" data-original-title="Azul" data-img="http://placehold.it/400x400/?text=Azul"></div>
										<div class="c1 red br-5" data-color="red" data-toggle="tooltip" data-placement="top" data-original-title="Rojo" data-img="http://placehold.it/400x400/?text=Rojo"></div>
									</div>
								</div>
							</div>
						</div>
						!-->

					</div>
					</form>
				</div>
			</div>
		</div>
	</div>

	<div class="testimonials">
		<div class="container">
			<div class="row">
				<div class="col-md-10 col-md-offset-1 col-sm-12 tes-title">¿Qué opinaron <span>otros compradores</span>?</div>
			</div>
			<div class="row">

				<div class="col-xs-1">
					<a class="tes-arrow t-left" href="#testimonials" role="button" data-slide="prev">
						<i class="fa fa-chevron-left" aria-hidden="true"></i>
					</a>
				</div>
				<div class="col-sm-10 col-xs-9 np">
					<div id="testimonials" class="carousel slide" data-ride="carousel">
						<div class="carousel-inner" role="listbox">

							<?php echo product_generate_testimonial(true, 'Daniela Rodriguez Daza', 'Buenos Aires', 'https://goo.gl/fnXt2F', 5, '¡Excelente producto! Además llegó enseguida.'); ?>

							<?php echo product_generate_testimonial(false, 'Hector Fazio', 'Bahía Blanca', 'http://goo.gl/Z618qa', 4.5, '¡Muy bueno! Super recomendado. Lo comparto con mis amigos.'); ?>

							<?php echo product_generate_testimonial(false, 'Sara Barrientos', 'Buenos Aires', '', 5, 'El producto es excelente; llegó rápido y en perfectas condiciones. ¡Muy bonito!'); ?>

						</div>
					</div>
				</div>
				<div class="col-xs-1">
					<a class="tes-arrow t-right" href="#testimonials" role="button" data-slide="next">
						<i class="fa fa-chevron-right" aria-hidden="true"></i>
					</a>
				</div>

			</div>
		</div>
	</div>

	<div class="container user-content">
		<div class="row">
			<div class="col-md-10 col-md-offset-1 col-sm-12 np">
				<div class="sm-t">Información del producto</div>
				<div class="sm-i"></div>
			</div>
		</div>
	</div>

	<div class="reputation good">
		<div class="container">
			<div class="row">
				<div class="col-md-10 col-md-offset-1 col-sm-12">
					<div class="row">
						<div class="col-md-12 rep-title np">Reputación del vendedor</div>
						<div class="col-md-12 np">
							<div class="rep-bar br-5">
								<div class="inner-bar" style="width: 98%"></div>
							</div>
						</div>
						<div class="col-md-12 rep-stats np">
							<div class="row">
								<div class="col-xs-8 rep-stats-left">
									<span class="imp">99%</span> positivas
									<div class="break-xs"></div>
									<span class="imp">92</span> ventas concretadas
								</div>
								<div class="col-xs-4">
									<span class="rep-stats-right">
										<i class="fa fa-check" aria-hidden="true"></i> 99%
									</span>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="container questions">
		<div class="row">
			<div class="col-md-10 col-md-offset-1 col-sm-12 que-title np">Consultas al vendedor</div>
		</div>
		<div class="row que-panel">
			<div class="col-md-10 col-md-offset-1 col-sm-12 np">

				<?php
				/*echo product_generate_question(
					['name'=>'', 'photo'=>'', 'city'=>'', 'time'=>'', 'question'=>''],
					['name'=>'', 'time'=>'', 'answer'=>'']); */
				?>

				<?php echo product_generate_question(
					['name'=>'Daniela Rodriguez Daza', 'photo'=>'https://goo.gl/fnXt2F', 'city'=>'Buenos Aires', 'time'=>'Hace 10 minutos', 'question'=>'Gracias. Última pregunta: ¿Aún tienen stock de la de color verde?'],
					[]);
				?>

				<?php echo product_generate_question(
					['name'=>'Sara Barrientos', 'photo'=>'', 'city'=>'Buenos Aires', 'time'=>'1 hora', 'question'=>'Acabo de ofertar e intenté llamarlos para cerrar detalles, pero nadie atendió.'],
					['name'=>'Victoria Fernandez', 'range'=>'vendedora', 'time'=>'1 hora', 'answer'=>'Hola Sara. Nuestros horarios de atención teléfonica terminaron por hoy, podés llamar mañana, viernes, a partir de las 9:00 hasta las 18:00; o también el sabado, hasta las 12:00. Nos tomamos los domingos.']);
				?>

				<?php echo product_generate_question(
					['name'=>'Daniela Rodriguez Daza', 'photo'=>'https://goo.gl/fnXt2F', 'city'=>'Buenos Aires', 'time'=>'Hace 3 horas', 'question'=>'Hola, si realizo la compra hoy ¿cuánto se demorará en llegar a mi ciudad?'],
					['name'=>'Victoria Fernandez', 'range'=>'vendedora', 'time'=>'Hace 2 horas', 'answer'=>'Hola Daniela. Si hacés la compra hoy el producto estaría llegando dentro de 5 días a tu ciudad por Tarjeta Envíos (recorda que esta opción es gratuita), o dentro de 2 días a través de Tarjeta Envíos Plus, el cuál tiene un costo de $ 120.']);
				?>

				<?php echo product_generate_question(
					['name'=>'Hector Fazio', 'photo'=>'http://goo.gl/Z618qa', 'city'=>'Bahía Blanca', 'time'=>'Hace 4 horas', 'question'=>'* Tarjetalo ha eliminado esta pregunta por no cumplir con los Términos y Condiciones del sitio.', 'deleted'=>true],
					['name'=>'Maximiliano Intrevado', 'range'=>'moderador de Tarjetealo', 'time'=>'Hace 4 horas', 'answer'=>'Hola Hector Fazio. Recordá que está prohibido solicitar información de contacto a través del panel de preguntas. Dicha información se obtiene una vez hecho el primer paso de la compra del producto.']);
				?>

			</div>
		</div>
	</div>

	<div class="other-products">
		<div class="container">
			<div class="row">
				<div class="col-md-10 col-md-offset-1 col-sm-12 np">
					<div class="sm-t">Más productos del vendedor</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-10 col-md-offset-1 col-sm-12 np">
					<div class="row mw-basic">
						<div class="col-sm-2 t1">
							Ropa y accesorios
							<div class="visitor-icons">
								<div class="visitor-item"><b>3</b> en lista <i class="fa fa-heart" aria-hidden="true"></i></div>
								<div class="visitor-item"><b>1</b> compra realizada <i class="fa fa-shopping-cart" aria-hidden="true"></i></div>
							</div>
						</div>
						<div class="col-sm-10 t2">
							<div class="row">
								<div class="col-sm-11 intro">
									<div class="row">
										<div id="highlight-items" class="carousel slide highlight" data-ride="carousel" data-interval="10000">									
											<div class="carousel-inner" role="listbox">
												<div class="item active">
													<?php echo generate__item(1,'Calzados Unisex'); ?>
													<?php echo generate__item(2,'Calzados Hombre'); ?>
													<?php echo generate__item(3,'Blusas'); ?>
													<?php echo generate__item(4,'Camisas'); ?>
												</div>
												<div class="item">
													<?php echo generate__item(5,'Pullovers'); ?>
													<?php echo generate__item(6,'Remeras'); ?>
													<?php echo generate__item(7,'Sublimadas'); ?>
													<?php echo generate__item(8,'Lenceria'); ?>
												</div>
												<div class="item">
													<?php echo generate__item(9,'Ropa interior'); ?>
													<?php echo generate__item(10,'Vinilo Textil'); ?>
													<?php echo generate__item(11,'Boxers'); ?>
													<?php echo generate__item(12,'Corpiños'); ?>
												</div>
											</div>
											<!-- Controls -->
											<a class="left carousel-control" href="#highlight-items" role="button" data-slide="prev">
												<i class="fa fa-caret-left" aria-hidden="true"></i>
												<span class="sr-only">Previous</span>
											</a>
											<a class="right carousel-control" href="#highlight-items" role="button" data-slide="next">
												<i class="fa fa-caret-right" aria-hidden="true"></i>
												<span class="sr-only">Next</span>
											</a>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="other-products">
		<div class="container">
			<div class="row">
				<div class="col-md-10 col-md-offset-1 col-sm-12 np">
					<div class="sm-t">Otros usuarios también vieron</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-10 col-md-offset-1 col-sm-12 np">
					<div class="row mw-basic">
						<div class="col-sm-2 t1">
							Ropa y accesorios
							<div class="visitor-icons">
								<div class="visitor-item"><b>3</b> en lista <i class="fa fa-heart" aria-hidden="true"></i></div>
								<div class="visitor-item"><b>1</b> compra realizada <i class="fa fa-shopping-cart" aria-hidden="true"></i></div>
							</div>
						</div>
						<div class="col-sm-10 t2">
							<div class="row">
								<div class="col-sm-11 intro">
									<div class="row">
										<div id="highlight-items" class="carousel slide highlight" data-ride="carousel" data-interval="10000">									
											<div class="carousel-inner" role="listbox">
												<div class="item active">
													<?php echo generate__item(1,'Calzados Unisex'); ?>
													<?php echo generate__item(2,'Calzados Hombre'); ?>
													<?php echo generate__item(3,'Blusas'); ?>
													<?php echo generate__item(4,'Camisas'); ?>
												</div>
												<div class="item">
													<?php echo generate__item(5,'Pullovers'); ?>
													<?php echo generate__item(6,'Remeras'); ?>
													<?php echo generate__item(7,'Sublimadas'); ?>
													<?php echo generate__item(8,'Lenceria'); ?>
												</div>
												<div class="item">
													<?php echo generate__item(9,'Ropa interior'); ?>
													<?php echo generate__item(10,'Vinilo Textil'); ?>
													<?php echo generate__item(11,'Boxers'); ?>
													<?php echo generate__item(12,'Corpiños'); ?>
												</div>
											</div>
											<!-- Controls -->
											<a class="left carousel-control" href="#highlight-items" role="button" data-slide="prev">
												<i class="fa fa-caret-left" aria-hidden="true"></i>
												<span class="sr-only">Previous</span>
											</a>
											<a class="right carousel-control" href="#highlight-items" role="button" data-slide="next">
												<i class="fa fa-caret-right" aria-hidden="true"></i>
												<span class="sr-only">Next</span>
											</a>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

</section>
