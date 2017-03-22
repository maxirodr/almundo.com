<?php
// load de cupones or what?
?>

<section class="site cuponera-listado" data-site="cuponera-listado" style="margin-bottom: 0px">
	
	<div class="container">
		<div class="row">
			<div class="col-xs-12 col-md-12 title">
				Cuponera
			</div>
		</div>
		
		<div class="row">
			<?php for ($i=0; $i < 12; $i++) { $random=mt_rand(5,25);?>
			<div class="col-xs-12 col-sm-6 col-md-4 fix_margin">
				<div class="col-xs-4 col-sm-4 col-md-4 fix">
					<div class="descuento-box">
						<?=$random?>%<br/>OFF
					</div>
				</div>
				<div class="col-xs-8 col-sm-8 col-md-8 fix">
					<div class="cupon-box">
						<img src="http://placehold.it/70x40" /><br/>
						<?=$random?>% de descuento en marca recomendada<br/>
						<div class="btn btn-primary br-5">
							<a href="#" id="adquirircupon">ADQUIRIR CUPON</a>
						</div>
					</div>
				</div>
			</div>
			<?php } ?>
		</div>

	</div>
	
</section>