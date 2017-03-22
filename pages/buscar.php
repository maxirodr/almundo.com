<?php
//si esta el query, redireccionar correctamente con rewrite content y que se haga directamente acá, una vez que está redireccionado, ahí, recién ahí, le hago rewrite

if($_GET['search_query']) {
	$search_string = mysqli_real_escape_string($dbConn, $_GET['search_query']);
	
	$val_related_search=array();
	
	$search_words = explode(" ",$search_string);
	foreach ($search_words as $key => $value_searched) {
		$mascotas_related=array("mascota","mascotas","cachorro","cachorros","perro","perros","perra","perras","cachorra","cachorras","animal","animales","gato","gatos");
		if(in_array($value_searched, $mascotas_related) && !$skip_this_search) {
			$skip_this_search=true;
			//activar solamente el view de mascotas
			$has_superp=NULL;
			$has_premium=NULL;
			$has_totales=true;
			$has_related=true;
			$has_banners=NULL;
			$has_mascotas=true;
			$has_filters=NULL;
			
			$total_related_mascotas=count($mascotas_related);
			for ($i=1; $i < 5; $i++) { 
				$val_related_search[$i]=$mascotas_related[mt_rand(0, $total_related_mascotas)];
				if($val_related_search[$i]==$val_related_search[($i-1)]) $i--;
			} unset($i);
			

			$arrNoticias = array();
			$query="SELECT id,imagenes,titulo,adicionales FROM `articulos_mascotas` WHERE categories='activo'";
			//$paginar_pagina = paginar_resultados($_GET['pagina']);
			//$query = $paginar_pagina['query'];
			$resultado = mysqli_query($dbConn, $query);
			while ( $row = mysqli_fetch_assoc($resultado)) {
				array_push( $arrNoticias,$row );
			} unset($resultado,$query,$row);
		}//in array mascotas
		elseif(in_array($value_searched,array("prueba")) && !$skip_this_search) {
			$skip_this_search=true;
			
			$has_superp=true;
			$has_premium=true;
			$has_totales=true;
			$has_related=true;
			$has_banners=true;
			$has_filters=true;
			
			
			$arrNoticias = array();
			$query="";
			$paginar_pagina = paginar_resultados($_GET['pagina']);
			$query = $paginar_pagina['query'];
			$resultado = mysqli_query($dbConn, $query);
			while ( $row = mysqli_fetch_assoc($resultado)) {
				array_push( $arrNoticias,$row );
			} unset($resultado,$query,$row);
		}
		else {
			//handle de error? redirecciono a la home por el momento?
		}//todavia no tengo definidas las otras busquedas y vergas
		
		if(isset($skip_this_search)) break; //ya está, para qué seguir haciendo búcle?
	}//foreach de busqueda
	
	//+++++++++++++++++++++++++++++++
	//BUSQUEDAS GENERALES NO APUNTADAS
	//+++++++++++++++++++++++++++++++
	if(!isset($skip_this_search)) {
		$skip_this_search=true;
		
		
		
		//activar solamente el view de mascotas
		$has_superp=NULL;
		$has_premium=NULL;
		$has_totales=true;
		$has_related=NULL;
		$has_banners=NULL;
		$has_mascotas=NULL;
		$has_filters=NULL;
		
		/* TODAVIA NO TENGO SCRIPT PARA RELATED, YA LO VAMO A HACER
		$total_related_mascotas=count($mascotas_related);
		for ($i=1; $i < 5; $i++) { 
			$val_related_search[$i]=$mascotas_related[mt_rand(0, $total_related_mascotas)];
			if($val_related_search[$i]==$val_related_search[($i-1)]) $i--;
		} unset($i);
		*/

		$arrNoticias = array();
		$query="SELECT id,id_cats,precio,imagenes,titulo FROM `articulos` WHERE titulo LIKE '%$search_string%' OR descripcion LIKE '%$search_string%' AND categories='activo'";
		$paginar_pagina = paginar_resultados($_GET['pagina']);
		$query = $paginar_pagina['query'];
		$resultado = mysqli_query($dbConn, $query);
		while ( $row = mysqli_fetch_assoc($resultado)) {
			array_push( $arrNoticias,$row );
		} unset($resultado,$query,$row);
	}//!isset $skip_this_search
	
} else {
	//handle de error? redirecciono a la home por el momento?
	$has_superp=true;
	$has_premium=true;
	$has_totales=true;
	$has_related=true;
	$has_banners=true;
	$has_filters=true;
}
?>

<section class="site search" data-site="search" style="margin-bottom: 0px">
	
	<div class="container">
		<div class="row">
			<div class="col-sm-12">
				<?php if(isset($has_related)) { ?>
				<div class="related-search wb">
					Busquedas relacionadas <a href="<?="//$url_web/buscar?search_query=$val_related_search[1]#resultados"?>"><?=$val_related_search[1]?>,</a> 
					<a href="<?="//$url_web/buscar?search_query=$val_related_search[2]#resultados"?>"><?=$val_related_search[2]?>,</a> 
					<a href="<?="//$url_web/buscar?search_query=$val_related_search[3]#resultados"?>"><?=$val_related_search[3]?>,</a> 
					<a href="<?="//$url_web/buscar?search_query=$val_related_search[4]#resultados"?>"><?=$val_related_search[4]?></a>
				</div>
				<?php } ?>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="big-title">Resultados encontrados</div>
			</div>
		</div>
		
		<?php if(isset($has_filters)) { ?>
		<div class="row">
			<div class="col-sm-12">
				<div class="row filters">
					<div class="col-sm-6">
						<span class="filter">Filtrar</span>
						<span class="categories selected">Categorías</span>
					</div>
					<div class="col-sm-6 icons">
						<span class="rows"><i class="fa fa-list" aria-hidden="true"></i></span>
						<span class="cols selected"><i class="fa fa-th" aria-hidden="true"></i></span>
					</div>
				</div>
			</div>
			<div class="col-sm-12">
				<div class="border-bot"></div>
			</div>
		</div>

		<div class="row filter_categories">
			<div class="col-sm-12">
				<div class="hug_all">
					<ul>
						<li><input type="radio" name="cat" id="cat1" checked><label for="cat1"> Indumentaria</label></li>
						<li><input type="radio" name="cat" id="cat2"><label for="cat2"> Electrónica</label></li>
						<li><input type="radio" name="cat" id="cat3"><label for="cat3"> Casa y jardín</label></li>
						<li><input type="radio" name="cat" id="cat4"><label for="cat4"> Vehículos</label></li>
						<li><input type="radio" name="cat" id="cat5"><label for="cat5"> Deportes</label></li>
						<li><input type="radio" name="cat" id="cat6"><label for="cat6"> Coleccionismo</label></li>
						<li><input type="radio" name="cat" id="cat7"><label for="cat7"> Ocio</label></li>
						<li><input type="radio" name="cat" id="cat8"><label for="cat8"> Servicios</label></li>
						<li><input type="radio" name="cat" id="cat9"><label for="cat9"> Mascotas</label></li>
					</ul>
					<div style="clear:both"></div>
				</div>
			</div>
			<div class="col-sm-12"><a name="resultados"></a>
				<div class="hug_all">
					<ul>
						<li><label for="sub1"><input type="checkbox" id="sub1" checked><label for="sub1"> Mujer</label></li>
						<li><label for="sub2"><input type="checkbox" id="sub2"><label for="sub2"> Hombre</label></li>
						<li><label for="sub3"><input type="checkbox" id="sub3"><label for="sub3"> Niño</label></li>
					</ul>
					<div style="clear:both"></div>
				</div>
			</div>
			<div class="col-sm-12">
				<div class="hug_all">
					<ul>
						<li><input type="checkbox" id="subsub1" checked><label for="subsub1"> Jean</label></li>
						<li><input type="checkbox" id="subsub2"><label for="subsub2"> Remera</label></li>
						<li><input type="checkbox" id="subsub3"><label for="subsub3"> Calzado</label></li>
					</ul>
					<div style="clear:both"></div>
				</div>
			</div>
		</div>

		<div class="row filter_filters" style="display: none">
			<div class="col-md-2 col-sm-3">

				<div class="icon_filter">
					<div class="icon">
						<i class="fa fa-minus" aria-hidden="true"></i>
						<i class="fa fa-usd" aria-hidden="true"></i>
					</div>
					<div class="i-text">
						Menor precio
					</div>
				</div>

			</div>
			<div class="col-md-2 col-sm-3">
				
				<div class="icon_filter">
					<div class="icon">
						<i class="fa fa-plus" aria-hidden="true"></i>
						<i class="fa fa-usd" aria-hidden="true"></i>
					</div>
					<div class="i-text">
						Mayor precio
					</div>
				</div>

			</div>
			<div class="col-md-2 col-sm-3">
					
				<div class="icon_filter selected">
					<div class="icon">
						<i class="fa fa-star" aria-hidden="true"></i>
					</div>
					<div class="i-text">
						Calificaciones
					</div>
				</div>

			</div>
		</div>
		<?php }//hasfilters ?>

		<div class="row">
			<div class="col-md-12">
				<?php if(isset($has_superp)) { ?>
				<div class="featured">
					<div class="flagsp"><i class="fa fa-star" aria-hidden="true"></i><div class="triangle"></div></div>
					<div class="row">
						<div class="col-sm-12 col-md-12">
							<div id="highlight-items" class="carousel slide highlight carousel-search" data-ride="carousel">									
								<div class="carousel-inner" role="listbox">
									<div class="item smaller active">
										<div class="col-sm-3">
											<div class="section-titl small sp">Nombre o Logo de la tienda recomendada 1.</div>
											<p class="section-descp">Perfil recomendado por Tarjetealo.</p>
											<div class="repu11">
												<div class="repu11_ti">Reputación</div>
												<span class="perc">95%</span> ventas concretadas
												<div class="repu11_fill">
													<div class="fill" style="width: 95%"></div>
												</div>
												<div class="repu11_sells">
													<span class="f">4567 ventas</span> en Tarjetealo
												</div>
											</div>
										</div>
										<div class="col-sm-9">
										<?=generate_mini_box(3, '', 0, "slider");?>
										<?=generate_mini_box(3, '', 0, "slider");?>
										<?=generate_mini_box(3, '', 0, "slider");?>
										<?=generate_mini_box(3, '', 0, "slider");?>
										<?=generate_mini_box(3, '', 0, "slider");?>
										<?=generate_mini_box(3, '', 0, "slider");?>
										<span class="hidden-sm">
											<?=generate_mini_box(3, '', 0, "slider");?>
											<?=generate_mini_box(3, '', 0, "slider");?>
										</span>
										</div>
									</div>
									<div class="item smaller">
										<div class="col-sm-3">
											<div class="section-titl small sp">Nombre o Logo de la tienda recomendada 2.</div>
											<p class="section-descp">Perfil recomendado por Tarjetealo.</p>
											<div class="repu11">
												<div class="repu11_ti">Reputación</div>
												<span class="perc">95%</span> ventas concretadas
												<div class="repu11_fill">
													<div class="fill" style="width: 95%"></div>
												</div>
												<div class="repu11_sells">
													<span class="f">4567 ventas</span> en Tarjetealo
												</div>
											</div>
										</div>
										<div class="col-sm-9">
										<?=generate_mini_box(3, '', 0, "slider");?>
										<?=generate_mini_box(3, '', 0, "slider");?>
										<?=generate_mini_box(3, '', 0, "slider");?>
										<?=generate_mini_box(3, '', 0, "slider");?>
										<?=generate_mini_box(3, '', 0, "slider");?>
										<?=generate_mini_box(3, '', 0, "slider");?>
										<span class="hidden-sm">
											<?=generate_mini_box(3, '', 0, "slider");?>
											<?=generate_mini_box(3, '', 0, "slider");?>
										</span>
										</div>
									</div>
									<div class="item smaller">
										<div class="col-sm-3">
											<div class="section-titl small sp">Nombre o Logo de la tienda recomendada 3.</div>
											<p class="section-descp">Perfil recomendado por Tarjetealo.</p>
											<div class="repu11">
												<div class="repu11_ti">Reputación</div>
												<span class="perc">95%</span> ventas concretadas
												<div class="repu11_fill">
													<div class="fill" style="width: 95%"></div>
												</div>
												<div class="repu11_sells">
													<span class="f">4567 ventas</span> en Tarjetealo
												</div>
											</div>
										</div>
										<div class="col-sm-9">
										<?=generate_mini_box(3, '', 0, "slider");?>
										<?=generate_mini_box(3, '', 0, "slider");?>
										<?=generate_mini_box(3, '', 0, "slider");?>
										<?=generate_mini_box(3, '', 0, "slider");?>
										<?=generate_mini_box(3, '', 0, "slider");?>
										<?=generate_mini_box(3, '', 0, "slider");?>
										<span class="hidden-sm">
											<?=generate_mini_box(3, '', 0, "slider");?>
											<?=generate_mini_box(3, '', 0, "slider");?>
										</span>
										</div>
									</div>
									<div class="item smaller">
										<div class="col-sm-3">
											<div class="section-titl small sp">Nombre o Logo de la tienda recomendada 4.</div>
											<p class="section-descp">Perfil recomendado por Tarjetealo.</p>
											<div class="repu11">
												<div class="repu11_ti">Reputación</div>
												<span class="perc">95%</span> ventas concretadas
												<div class="repu11_fill">
													<div class="fill" style="width: 95%"></div>
												</div>
												<div class="repu11_sells">
													<span class="f">4567 ventas</span> en Tarjetealo
												</div>
											</div>
										</div>
										<div class="col-sm-9">
										<?=generate_mini_box(3, '', 0, "slider");?>
										<?=generate_mini_box(3, '', 0, "slider");?>
										<?=generate_mini_box(3, '', 0, "slider");?>
										<?=generate_mini_box(3, '', 0, "slider");?>
										<?=generate_mini_box(3, '', 0, "slider");?>
										<?=generate_mini_box(3, '', 0, "slider");?>
										<span class="hidden-sm">
											<?=generate_mini_box(3, '', 0, "slider");?>
											<?=generate_mini_box(3, '', 0, "slider");?>
										</span>
										</div>
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

								<ol class="carousel-indicators">
									<li data-target="#highlight-items" data-slide-to="0" class="active"></li>
									<li data-target="#highlight-items" data-slide-to="1"></li>
									<li data-target="#highlight-items" data-slide-to="2"></li>
									<li data-target="#highlight-items" data-slide-to="3"></li>
								</ol>
							</div>
						</div>
					</div>
				</div>
				<?php }//hassuperp ?>
			</div>
		</div>

		<div class="row">
			<div class="col-md-12">
				<?php if(isset($has_premium)) { ?>
				<div class="results">
					<div class="all">
						<div class="row">
							<div class="col-sm-12">
								
							</div>
						</div>
						<div class="row">
							<div class="col-md-2 col-sm-4">
								<div class="section-titl small">Artículos recomendados</div>
								<p class="section-descp">Mirá primero las mejores publicaciones de Tarjetealo.</p>
							</div>
							<?php echo generate_mini_box(2, '', 0); ?>
							<?php echo generate_mini_box(2, '', 0); ?>
							<?php echo generate_mini_box(2, '', 0); ?>
							<?php echo generate_mini_box(2, '', 0); ?>
							<?php echo generate_mini_box(2, '', 0); ?>
							<?php echo generate_mini_box(2, '', 0); ?>
							<?php echo generate_mini_box(2, '', 0); ?>
							<?php echo generate_mini_box(2, '', 0); ?>
							<?php echo generate_mini_box(2, '', 0); ?>
							<?php echo generate_mini_box(2, '', 0); ?>
							<?php echo generate_mini_box(2, '', 0); ?>
						</div>
					</div>
				</div>
				<?php } ?>
			</div>
		</div>
		
		

		<div class="row">
			<?php if(isset($has_banners)) { ?>
			<div class="container-fluid np">
				<div class="row nm">
					<div class="col-sm-3 e-np">
						<img src="http://placehold.it/480x480/ffa726/8c6429?text=1:1" class="img-responsive">
					</div>
					
					<div class="col-sm-3 e-np">
						<img src="http://placehold.it/480x480/ffa726/8c6429?text=1:1" class="img-responsive">
					</div>
					
					<div class="col-sm-3 e-np">
						<img src="http://placehold.it/480x480/ffa726/8c6429?text=1:1" class="img-responsive">
					</div>
					
					<div class="col-sm-3 e-np">
						<img src="http://placehold.it/480x480/ffa726/8c6429?text=1:1" class="img-responsive">
					</div>
				</div>
			</div>
			<?php } ?>
			
			<div class="col-md-12">
				<?php if(isset($has_totales)) { ?>
				<div class="results">
					<div class="all">
						<div class="row">
							<div class="col-sm-12">
								<div class="section-titl brds">Todas las publicaciones</div>
							</div>
						</div>
						<div class="row<?php if(isset($has_mascotas)) echo " mw-basic\" style='border-top: none;'"; else echo "\""; ?>>
							<?php if(!isset($has_mascotas)) {
								foreach ($arrNoticias as $key => $value) { ?>
									<?=generate_mini_box(2, $value['imagenes'], $value['precio'], "totales", $value['id'], $value['titulo'])?>
								<?php } ?>
							<?php } else {
								foreach ($arrNoticias as $key => $value) { ?>
									<?=generate__item($value['id'],$value['titulo'],$value['imagenes'],"mascotas")?>
								<?php } ?>
							<?php } ?>
							
							
							<br /><br />
    						<?=$paginar_pagina['text']?>
						</div>
					</div>
				</div>
				<?php }//isset has totales ?>
			</div>
		</div>

	</div>
	
</section>