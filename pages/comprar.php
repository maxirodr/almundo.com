<?php

//se hace el siguiente arbol cronológico:
/*
 * 1º al ingresar se genera un insert a la DB temporal a compras_temporal
 * 2º agarro todos los registros que no superen 10min del articulo en compras_temporal
 * 3º se chequea si el stock-cant_compras_temporal es menor a 0(y no estrictamento igual), si es menor a 0, avisa que no hay mas stock
 * 4º si este check paso, sigue adelante
 */

$_POST['id']=1;//debug
if(isset($_POST['id'])) $id_producto = mysqli_real_escape_string($dbConn, $_POST['id']);

//ahora que tengo el id del producto, extraigo la data de la db


//confirma o no?
if(isset($_POST['submit'])) {
	
}//isset post SUBMIT

?>

<div class="countdown-buy" data-countdown="600" data-url="<?="//$url_web/producto/$_GET[select]"?>">
	<div class="countdown-title">Su compra tiene una validez de 10 minutos</div>
	<div class="countdown-description">
		Tiempo restante
		<span></span>
	</div>
</div>

<form action="" method="post" id="buyform" enctype="multipart/form-data">
<section class="site" data-site="buy">
	<div class="container">
		<div class="row">
			<div class="col-sm-12 tel">
				<div class="t1">0800 999 333</div>
				<div class="t12">¿Necesitás ayuda? <br> Llamanos.</div>
			</div>
		</div>

		<div class="row">
			<div class="col-sm-8 col-sm-offset-2">
				<div class="section-title">Seleccioná tu método de envío</div>
			</div>
		</div>

		<div class="row shipping">
			<div class="col-sm-8 col-sm-offset-2">
				<div class="row">
					<div class="col-sm-4">
						<label for="shipping1"><img src="/basic/img/buy-rocket.png" alt="" class="img-responsive"></label>
						<label class="check"><input type="radio" id="shipping1" name="shipping" value="1">Rápido</label>
						<span class="duration">24hs</span>
					</div>
					<div class="col-sm-4">
						<label for="shipping2"><img src="/basic/img/buy-express.png" alt="" class="img-responsive"></label>
						<label class="check"><input type="radio" id="shipping2" name="shipping" value="2">Express</label>
						<span class="duration">48hs</span>
					</div>
					<div class="col-sm-4">
						<label for="shipping3"><img src="/basic/img/buy-normal.png" alt="" class="img-responsive"></label>
						<label class="check"><input type="radio" id="shipping3" name="shipping" value="3">Tradicional</label>

						<label class="date">
							<input type="text" id="select_shipping_date" readonly value="Selecciona tu fecha" data-date="">
							<i class="fa fa-chevron-down" aria-hidden="true"></i>
						</label>
					</div>
				</div>
			</div>
		</div>

		<div class="row options-shipping">
			<div class="col-sm-8 col-sm-offset-2">
				<div class="ps_">
					<label> <input type="checkbox" name="secure_shipping" value="true"> Contratación de seguro de envío </label>
				</div>
				<div class="ps_">
					<label> <input type="radio" name="shipping" value="4"> Acuerdo con el vendedor. <span>(Tarjetealo queda excento de responsabilidad)</span> </label>
				</div>
			</div>
		</div>

		<div class="row user_data us_data">
			<div class="col-sm-8 col-sm-offset-2">
				<div class="section-title separate-top">Detalles del comprador</div>
				<ul>
					<li><i class="fa fa-user" aria-hidden="true"></i> Juan Pérez</li>
					<li><i class="fa fa-home" aria-hidden="true"></i> Av. Alem 520, Bahía Blanca, Buenos Aires</li>
					<li><i class="fa fa-phone" aria-hidden="true"></i> 291 5439515</li>
				</ul>
			</div>
		</div>

		<div class="row user_data">
			<div class="col-sm-8 col-sm-offset-2">
				<div class="section-title separate-top separate-more">Método de pago</div>
				<div class="pay_credit">
					<div class="option-group">
						<div class="the_name">Tarjetas de crédito <a class="ver-promociones">ver promociones</a></div>
						<div class="the-promo">
							Contenido PHP, Linea 96 de comprar.php
						</div>
						<div class="the_options">
							
							<input type="radio" name="pay" id="card-1">
							<label class="card" for="card-1">
								<div class="promo">12</div>
								<img src="http://placehold.it/50x30/dcdcdc/dcdcdc" alt="">
							</label>

							<input type="radio" name="pay" id="card-2">
							<label class="card" for="card-2">
								<div class="promo">12</div>
								<img src="http://placehold.it/50x30/dcdcdc/dcdcdc" alt="">
							</label>

							<input type="radio" name="pay" id="card-3">
							<label class="card" for="card-3">
								<div class="promo">3</div>
								<img src="http://placehold.it/50x30/dcdcdc/dcdcdc" alt="">
							</label>

							<input type="radio" name="pay" id="card-4">
							<label class="card" for="card-4">
								<img src="http://placehold.it/50x30/dcdcdc/dcdcdc" alt="">
							</label>

							<input type="radio" name="pay" id="card-5">
							<label class="card" for="card-5">
								<img src="http://placehold.it/50x30/dcdcdc/dcdcdc" alt="">
							</label>

							<input type="radio" name="pay" id="card-6">
							<label class="card" for="card-6">
								<img src="http://placehold.it/50x30/dcdcdc/dcdcdc" alt="">
							</label>

						</div>
						<div class="the_promo">
							<i class="fa fa-circle" aria-hidden="true"></i>
							<strong>Promoción: </strong> Cuotas sin intereses dependiendo de tu entidad bancaria.
						</div>
					</div>

					<div class="option-group">
						<div class="the_name">Pago en efectivo</div>
						<div class="the_options">
							
							<input type="radio" name="pay" id="cash-1">
							<label class="card" for="cash-1">
								<img src="http://placehold.it/50x30/dcdcdc/dcdcdc" alt="">
							</label>

							<input type="radio" name="pay" id="cash-2">
							<label class="card" for="cash-2">
								<img src="http://placehold.it/50x30/dcdcdc/dcdcdc" alt="">
							</label>

							<input type="radio" name="pay" id="cash-3">
							<label class="card" for="cash-3">
								<img src="http://placehold.it/50x30/dcdcdc/dcdcdc" alt="">
							</label>

						</div>
					</div>

					<div class="option-group">
						<div class="the_name">Transferencia bancaria</div>
						<div class="the_options">
							
							<input type="radio" name="pay" id="bank-1">
							<label class="card" for="bank-1">
								<img src="http://placehold.it/50x30/dcdcdc/dcdcdc" alt="">
							</label>

						</div>
					</div>

					<div class="option-group">
						<div class="the_name">Puntos de pago</div>
						<div class="the_options">
							
							<input type="radio" name="pay" id="point-1">
							<label class="card" for="point-1">
								<img src="http://placehold.it/50x30/dcdcdc/dcdcdc" alt="">
							</label>

							<input type="radio" name="pay" id="point-2">
							<label class="card" for="point-2">
								<img src="http://placehold.it/50x30/dcdcdc/dcdcdc" alt="">
							</label>

						</div>
					</div>

				</div>
			</div>
		</div>

		<div class="row user_data">
			<div class="col-sm-8 col-sm-offset-2">
				<div class="section-title separate-top separate-more">Detalles de la compra</div>
				<ul>
					<li>Nombre del producto</li>
					<li>Cantidad</li>
					<li>Talle</li>
					<li>Precio</li>
					<li>Método de pago</li>
					<li>3 cuotas de $</li>
				</ul>
			</div>
		</div>

		<div class="row user_data">
			<div class="col-sm-8 col-sm-offset-2">
				<div class="section-title separate-top separate-more separate-bott">Código de descuento</div>
				<div class="row">
					<div class="col-sm-6">
						<p>Código de descuentos obtenidos en promociones especiales o acuerdos previos con el vendedor.</p>
					</div>
					<div class="col-sm-6">
						<input type="text" name="discount" class="discount block" placeholder="codigosecreto">
						<p class="show_discount">Código válido, <span>15% de descuento</span></p>
					</div>
				</div>
			</div>
		</div>

		<div class="row user_data">
			<div class="col-sm-8 col-sm-offset-2">
				<div class="section-title separate-top separate-more separate-bott"></div>
				<div class="row">
					<div class="col-sm-4 col-sm-offset-2">
						<button class="button submit" type="submit" name="submit" value="submit">Lo quiero ya</button>
					</div>
					<div class="col-sm-4">
						<button class="button cancel">Cancelar</button>
					</div>
				</div>
			</div>
		</div>

	</div>
</section>
</form>