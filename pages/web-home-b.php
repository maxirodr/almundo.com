<?php
$slider = array();
$query = "SELECT id,image FROM `slider` WHERE categories!='borrado' ORDER BY id DESC LIMIT 10";
$resultado = mysqli_query($dbConn, $query);
while ( $row = mysqli_fetch_assoc($resultado)) {
	array_push( $slider,$row );
} 


$cant_count=count($slider);
?>
<section class="site home" data-site="homeAdvanced">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div id="home-highlight" class="carousel slide" data-ride="carousel">
					<!-- Indicators -->
					<ol class="carousel-indicators">
					<?php for ($i=0; $i < $cant_count; $i++) { 
					if($i==0) { ?>
						<li data-target="#home-highlight" data-slide-to="0" class="active"></li>
					<?php  } else { ?>
						<li data-target="#home-highlight" data-slide-to="<?=$i?>" class="active"></li>
					<?php } } ?>
					</ol>
					<!-- Wrapper for slides -->
					<div class="carousel-inner" role="listbox">
						<?php foreach ($slider as $key => $value) { ?>
						<div class="item<?=($key==0) ? " active":"";?>" alt="<?=$value['id']?>">
							<img src="<?=$value['image']?>">
						</div>
						<?php } ?>
					</div>
					<!-- Left and right controls -->
					<a class="left carousel-control" href="#home-highlight" role="button" data-slide="prev">
						<i class="fa fa-caret-left" aria-hidden="true"></i>
						<span class="sr-only">Previous</span>
					</a>
					<a class="right carousel-control" href="#home-highlight" role="button" data-slide="next">
						<i class="fa fa-caret-right" aria-hidden="true"></i>
						<span class="sr-only">Next</span>
					</a>
				</div>
			</div>
		</div>
		<div class="row search-bar" style="margin-top:20px;">
			<div class="col-md-12 search-bar">
				<form action="buscar#resultados" method="POST">
					<div class="group" id="adv-search">
						<input type="search" placeholder="Jean mujer"/>
						<div class="submit">
							<div role="group">
								<button type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
							</div>
						</div>
					</div>
				</form>
			</div>
			<div class="col-md-12 helpnote">
				Por ejemplo: pelota de fútbol, tijeras para podar, etcétera.
			</div>
		</div>
		<div class="row title">
			<div class="col-sm-6 col-sm-offset-3">
				El producto que buscás
				<span>Más cerca, rápido y barato</span>
			</div>
		</div>
		<div class="row boxes">
			<div class="col-md-12 tit1">
				Publicaciones destacadas
				<span>Recomendadas para vos</span>
			</div>
			<div class="col-md-12 bx">
				<div class="col-sm-6 col-xs-12">
					<div class="col-md-12 np">
						<div class="col-md-9 col-sm-12 np">
							<div class="item-high">
								<div class="item-photo big ns">
									<img src="https://placehold.it/434x379?text=434:379" class="img-responsive" alt=""/>
									<div class="item-icons">
										<a href="#" data-toggle="tooltip" data-placement="top" title="Agregar a Favoritos"><i class="fa fa-heart" aria-hidden="true"></i></a>
										<a href="#" data-toggle="tooltip" data-placement="top" title="Comprar"><i class="fa fa-shopping-cart" aria-hidden="true"></i></a>
									</div>
								</div>
								<div class="item-info ns">
									<div class="item-text">
										<div class="sold">22 vendidos</div>
										<div class="category">Indumentaria > Mujer > Jeans</div>
										<div style="clear:both"></div>
									</div>
									<div class="item-price big">
										<span><?php echo parse__price(599.99); ?></span>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-3 col-sm-12 np small-items">
							<div class="col-md-12 col-sm-4 col-xs-6 np">
								<div class="item-high small">
									<div class="item-photo ns">
										<img src="https://placehold.it/500x500?text=1:1" class="img-responsive" alt=""/>
										<div class="item-icons">
											<a href="#" data-toggle="tooltip" data-placement="top" title="Agregar a Favoritos"><i class="fa fa-heart" aria-hidden="true"></i></a>
											<a href="#" data-toggle="tooltip" data-placement="top" title="Comprar"><i class="fa fa-shopping-cart" aria-hidden="true"></i></a>
										</div>
										<div class="item-price">
											<span><?php echo parse__price(579.99); ?></span>
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-12 col-sm-4 col-xs-6 np">
								<div class="item-high small">
									<div class="item-photo ns">
										<img src="https://placehold.it/500x500?text=1:1" class="img-responsive" alt=""/>
										<div class="item-icons">
											<a href="#" data-toggle="tooltip" data-placement="top" title="Agregar a Favoritos"><i class="fa fa-heart" aria-hidden="true"></i></a>
											<a href="#" data-toggle="tooltip" data-placement="top" title="Comprar"><i class="fa fa-shopping-cart" aria-hidden="true"></i></a>
										</div>
										<div class="item-price">
											<span><?php echo parse__price(1225); ?></span>
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-12 col-sm-4 col-xs-6 np">
								<div class="item-high small">
									<div class="item-photo ns">
										<img src="https://placehold.it/500x500?text=1:1" class="img-responsive" alt=""/>
										<div class="item-icons">
											<a href="#" data-toggle="tooltip" data-placement="top" title="Agregar a Favoritos"><i class="fa fa-heart" aria-hidden="true"></i></a>
											<a href="#" data-toggle="tooltip" data-placement="top" title="Comprar"><i class="fa fa-shopping-cart" aria-hidden="true"></i></a>
										</div>
										<div class="item-price">
											<span><?php echo parse__price(679); ?></span>
										</div>
									</div>
								</div>
							</div>
							<div class="hidden-lg hidden-md hidden-sm col-xs-6 np">
								<div class="item-high small">
									<div class="item-photo ns">
										<img src="https://placehold.it/500x500?text=1:1" class="img-responsive" alt=""/>
										<div class="item-icons">
											<a href="#" data-toggle="tooltip" data-placement="top" title="Agregar a Favoritos"><i class="fa fa-heart" aria-hidden="true"></i></a>
											<a href="#" data-toggle="tooltip" data-placement="top" title="Comprar"><i class="fa fa-shopping-cart" aria-hidden="true"></i></a>
										</div>
										<div class="item-price">
											<span><?php echo parse__price(870.5); ?></span>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div style="clear:both"></div>
					</div>
				</div>
				<div class="col-sm-6 col-xs-12">
					<div class="col-md-12 np">
						<div class="col-md-9 col-sm-12 np">
							<div class="item-high">
								<div class="item-photo big ns">
									<img src="https://placehold.it/434x379?text=434:379" class="img-responsive" alt=""/>
									<div class="item-icons">
										<a href="#" data-toggle="tooltip" data-placement="top" title="Agregar a Favoritos"><i class="fa fa-heart" aria-hidden="true"></i></a>
										<a href="#" data-toggle="tooltip" data-placement="top" title="Comprar"><i class="fa fa-shopping-cart" aria-hidden="true"></i></a>
									</div>
								</div>
								<div class="item-info ns">
									<div class="item-text">
										<div class="sold">16 vendidos</div>
										<div class="category">Indumentaria > Mujer > Jeans</div>
									</div>
									<div class="item-price big">
										<span><?php echo parse__price(899.90); ?></span>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-3 col-sm-12 np small-items">
							<div class="col-md-12 col-sm-4 col-xs-6 np">
								<div class="item-high small">
									<div class="item-photo ns">
										<img src="https://placehold.it/500x500?text=1:1" class="img-responsive" alt=""/>
										<div class="item-icons">
											<a href="#" data-toggle="tooltip" data-placement="top" title="Agregar a Favoritos"><i class="fa fa-heart" aria-hidden="true"></i></a>
											<a href="#" data-toggle="tooltip" data-placement="top" title="Comprar"><i class="fa fa-shopping-cart" aria-hidden="true"></i></a>
										</div>
										<div class="item-price">
											<span><?php echo parse__price(579.99); ?></span>
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-12 col-sm-4 col-xs-6 np">
								<div class="item-high small">
									<div class="item-photo ns">
										<img src="https://placehold.it/500x500?text=1:1" class="img-responsive" alt=""/>
										<div class="item-icons">
											<a href="#" data-toggle="tooltip" data-placement="top" title="Agregar a Favoritos"><i class="fa fa-heart" aria-hidden="true"></i></a>
											<a href="#" data-toggle="tooltip" data-placement="top" title="Comprar"><i class="fa fa-shopping-cart" aria-hidden="true"></i></a>
										</div>
										<div class="item-price">
											<span><?php echo parse__price(925); ?></span>
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-12 col-sm-4 col-xs-6 np">
								<div class="item-high small">
									<div class="item-photo ns">
										<img src="https://placehold.it/500x500?text=1:1" class="img-responsive" alt=""/>
										<div class="item-icons">
											<a href="#" data-toggle="tooltip" data-placement="top" title="Agregar a Favoritos"><i class="fa fa-heart" aria-hidden="true"></i></a>
											<a href="#" data-toggle="tooltip" data-placement="top" title="Comprar"><i class="fa fa-shopping-cart" aria-hidden="true"></i></a>
										</div>
										<div class="item-price">
											<span><?php echo parse__price(579); ?></span>
										</div>
									</div>
								</div>
							</div>
							<div class="hidden-lg hidden-md hidden-sm col-xs-6 np">
								<div class="item-high small">
									<div class="item-photo ns">
										<img src="https://placehold.it/500x500?text=1:1" class="img-responsive" alt=""/>
										<div class="item-icons">
											<a href="#" data-toggle="tooltip" data-placement="top" title="Agregar a Favoritos"><i class="fa fa-heart" aria-hidden="true"></i></a>
											<a href="#" data-toggle="tooltip" data-placement="top" title="Comprar"><i class="fa fa-shopping-cart" aria-hidden="true"></i></a>
										</div>
										<div class="item-price">
											<span><?php echo parse__price(870.5); ?></span>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div style="clear:both"></div>
					</div>
				</div>
			</div>
		</div>
		<div class="row mw-basic">
			<div class="col-sm-2 t1">
				Ropa y accesorios
				<span>Publicaciones visitadas</span>
				<div class="visitor-icons">
					<div class="visitor-item"><b>3</b> en lista <i class="fa fa-heart" aria-hidden="true"></i></div>
					<div class="visitor-item"><b>1</b> compra realizada <i class="fa fa-shopping-cart" aria-hidden="true"></i></div>
				</div>
			</div>
			<div class="col-sm-10 t2">
				<div class="row">
					<div class="col-sm-11 intro">
						<div class="row">
							<div id="highlight-items" class="carousel slide highlight" data-ride="carousel">									
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
</section>

<section class="start">
	<div class="container">
		<div class="row">
			<div class="col-sm-6 col-xs-12 element">
				<div class="row">
					<div class="col-sm-8 col-sm-offset-2 text">Ventajas de ser un Usuario registrado</div>
					<div class="col-xs-6 col-xs-offset-3 button br-5-child">
						<a href="#">Ver ventajas</a>
					</div>
				</div>
			</div>
			<div class="col-sm-6 col-xs-12 element">
				<div class="row">
					<div class="col-sm-6 col-sm-offset-3 text">¿Cómo usar este sitio?</div>
					<div class="col-xs-6 col-xs-offset-3 button br-5-child">
						<a href="#">Así de facil</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
