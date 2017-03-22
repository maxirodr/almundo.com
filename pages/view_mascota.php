<?php
if ( !empty($_GET['select']) && is_numeric($_GET['select']) ) {
	// traemos una categoria
	$id=secure_input(trim($_GET['select']));
	$query = "SELECT imagenes,titulo,descripcion,adicionales FROM `articulos_mascotas` WHERE id = '$id' AND categories != 'borrado' LIMIT 1";
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
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="related-search">
					Busquedas relacionadas <a href="<?="//$url_web/"?>buscar?search_query=cachorros#resultados">cachorros,</a>
					 <a href="<?="//$url_web/buscar?search_query=mascotas#resultados"?>">mascotas,</a> 
					 <a href="<?="//$url_web/"?>buscar?search_query=perros#resultados">perros,</a> 
					 <a href="<?="//$url_web/"?>buscar?search_query=gatos#resultados">gatos</a>
				</div>
			</div>
			<div class="col-md-12">
				<div class="cat">
					<a href="<?="//$url_web/"?>">Inicio</a>
					<a href="<?="//$url_web/"?>mascotas">Adopción de mascotas</a>
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
						<div class="sm-desc"><?=unBBcode($row['descripcion'])?></div>
						
						<div style="clear:both"></div>
						

						<div class="sm-actions">
							<div class="row modyp">
								<div class="col-xs-9">
									<a href="#" class="btt br-5" style="background: #ff1744;"> <i class="fa fa-heart"></i> ADOPTAR</a>
								</div>
								<div class="col-xs-3">
									<div href="#" class="btt favorite br-5" data-toggle="tooltip" data-placement="top" data-original-title="Agregar a favoritos"></div>
								</div>
							</div>
						</div>
						
						<div class="sm-shipping">
							<span class="dsc"> <i class="fa fa-truck"></i> El envío se acuerda con el protector</span>
						</div>
				
						

					</div>
					</form>
				</div>
			</div>
		</div>
	</div>

	<div class="testimonials">
		<div class="container">
			<div class="row">
				<div class="col-md-10 col-md-offset-1 col-sm-12 tes-title">¿Qué opinaron <span>otras personas</span>?</div>
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

							<?php echo product_generate_testimonial(true, 'Daniela Rodriguez Daza', 'Buenos Aires', 'https://goo.gl/fnXt2F', 5, '¡Excelente! El perrito estaba muy cuidado y en buena condición.'); ?>

							<?php echo product_generate_testimonial(false, 'Hector Fazio', 'Bahía Blanca', 'http://goo.gl/Z618qa', 4.5, '¡Muy bueno! Super recomendado. Lo comparto con mis amigos.'); ?>

							<?php echo product_generate_testimonial(false, 'Sara Barrientos', 'Buenos Aires', '', 5, 'Excelente protectora, deberían darle un premio; llegó rápido y bañado. ¡Muy bonito! Excelente protectora, deberían darle un premio; llegó rápido y bañado. ¡Muy bonito! Excelente protectora, deberían darle un premio; llegó rápido y bañado. ¡Muy bonito! Excelente protectora, deberían darle un premio; llegó rápido y bañado. ¡Muy bonito! Excelente protectora, deberían darle un premio; llegó rápido y bañado. ¡Muy bonito!'); ?>

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

	<div class="reputation good">
		<div class="container">
			<div class="row">
				<div class="col-md-10 col-md-offset-1 col-sm-12">
					<div class="row">
						<div class="col-md-12 rep-title np">Reputación del protector</div>
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
									<span class="imp">92</span> adopciones concretadas
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
			<div class="col-md-10 col-md-offset-1 col-sm-12 que-title np">Consultas al protector</div>
		</div>
		<div class="row que-panel">
			<div class="col-md-10 col-md-offset-1 col-sm-12 np">

				<?php
				/*echo product_generate_question(
					['name'=>'', 'photo'=>'', 'city'=>'', 'time'=>'', 'question'=>''],
					['name'=>'', 'time'=>'', 'answer'=>'']); */
				?>

				<?php echo product_generate_question(
					['name'=>'Daniela Rodriguez Daza', 'photo'=>'https://goo.gl/fnXt2F', 'city'=>'Buenos Aires', 'time'=>'Hace 10 minutos', 'question'=>'Gracias. Última pregunta: ¿tiene todas las vacunas al día?'],
					[]);
				?>

				<?php echo product_generate_question(
					['name'=>'Sara Barrientos', 'photo'=>'', 'city'=>'Buenos Aires', 'time'=>'1 hora', 'question'=>'Acabo de llamarlos pero no recibí respuesta.'],
					['name'=>'Victoria Fernandez', 'range'=>'protectora', 'time'=>'1 hora', 'answer'=>'Hola Sara. Nuestros horarios de atención teléfonica terminaron por hoy, podés llamar mañana, viernes, a partir de las 9:00 hasta las 18:00; o también el sabado, hasta las 12:00. Nos tomamos los domingos.']);
				?>

				<?php echo product_generate_question(
					['name'=>'Daniela Rodriguez Daza', 'photo'=>'https://goo.gl/fnXt2F', 'city'=>'Buenos Aires', 'time'=>'Hace 3 horas', 'question'=>'Hola, si realizo lo adopto hoy ¿cuánto se demorará en llegar a mi ciudad?'],
					['name'=>'Victoria Fernandez', 'range'=>'protectora', 'time'=>'Hace 2 horas', 'answer'=>'Hola Daniela. Si realizás la adopción hoy el cachorrito estaría llegando dentro de 5 días a tu ciudad por Tarjeta Envíos (recorda que esta opción es gratuita), o dentro de 2 días a través de Tarjeta Envíos Plus, el cuál tiene un costo de $ 120.']);
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
					<div class="sm-t">Más mascotas en adopción del protector</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-10 col-md-offset-1 col-sm-12 np">
					<div class="row mw-basic">
						<div class="col-sm-2 t1">
							Mascotas en general
							<div class="visitor-icons">
								<div class="visitor-item"><b>3</b> en lista <i class="fa fa-heart" aria-hidden="true"></i></div>
								<div class="visitor-item"><b>1</b> adopción realizada <i class="fa fa-shopping-cart" aria-hidden="true"></i></div>
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
					<div class="sm-t">Ellos también quieren una familia</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-10 col-md-offset-1 col-sm-12 np">
					<div class="row mw-basic">
						<div class="col-sm-2 t1">
							Adopción de Mascotas
							<div class="visitor-icons">
								<div class="visitor-item"><b>3</b> en lista <i class="fa fa-heart" aria-hidden="true"></i></div>
								<div class="visitor-item"><b>1</b> adopción realizada <i class="fa fa-shopping-cart" aria-hidden="true"></i></div>
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
<style>
	.sm-shipping {
		margin-top: 5px;
		padding-top: 5px;
		border-top: 1px solid #cecece;
		border-bottom: 1px solid #cecece;
		margin-bottom: 5px;
		padding-bottom: 5px;
	}
	
</style>