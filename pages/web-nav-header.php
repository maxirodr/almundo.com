<div class="cas-container container">
<div class="row">
	<div class="cas-header col-lg-12 col-md-12">
        <div class="col-lg-6 col-md-12 wrap-logo">
        	<img src="img/logo.png"  />
        </div><!-- WRAP-LOGO -->
        <?php if(!$_SESSION['email']) { ?>
        <div class="wrap-login col-lg-6 clearfix">
            <form class="cas-login" action="ingresar" method="POST">
                <div class="wrap-input">
                    <i class="fa fa-user"></i>
                    <input class="cas-input" name="email" type="email" placeholder="MAIL@MAIL.COM" required="required" autofocus="autofocus" />
                </div><!-- WRAP-INPUT -->
                <div class="wrap-input">
                    <i class="fa fa-lock"></i>
                    <input class="cas-input" name="pw" type="password" placeholder="CONTRASEÑA" required="required" />
                </div><!-- WRAP-INPUT -->
                <button class="
                btn-login btn btn-primary" type="submit" name="submit" value="submit">ENTRAR</button>
            </form>
        </div><!-- WRAP-LOGIN -->
        <?php } else { ?>
        Usuario detalles acá. <a href="cp/">Panel de control.</a>
        <?php } ?>
    </div><!-- CAS-HEADER -->
</div><!-- ROW -->
<div class="row">
    <div class="cas-nav col-lg-12 col-md-12">
        <div class="wrap-nav-btn">
        <img src="img/catalog.png" />
        <a class="nav-btn" href="#">CATALOGO ONLINE</a>
        </div>
        <div class="wrap-nav-btn">
        <img src="img/games.png" />
        <a class="nav-btn" href="#" role="button">SELECCIONAR JUEGO</a>
        </div>
        <div class="wrap-nav-btn">
        <img src="img/casino.png" />
        <a class="nav-btn" href="#" role="button">CASINO ONLINE</a>
        </div>
    </div><!-- CAS-NAV -->
</div>
<div class="row">
	<div class="carousel slide" data-ride="carousel" id="featured">
    	<div class="carousel-inner">
        	<div class="item active"><img src="img/carousel/Livedealers-Homepage-Slider-CC-1400x355.jpg" width="1400" height="355" /></div>
            <!--<div class="item"><img src="img/carousel/CapA-Homepage-Slider-CC-1400x355.jpg" width="1400" height="355" /></div> 
            <div class="item"><img src="img/carousel/Generic-table-games-Homepage-Slider-CC-1400x355.jpg" width="1400" height="355" /></div>
			!-->
    		<?php
			// traemos listado de TODAS las noticias
			$slider_a = array();
			//$catalogo_q = "SELECT * FROM `catalogo` WHERE categoria!='borrado' ORDER BY id LIMIT ".$inicio.",".$TAMANO_PAGINA;;
			$slider_q = "SELECT * FROM `slider` WHERE categories!='borrado' ORDER BY id DESC LIMIT 0,5";
			$slider_r = mysqli_query($dbConn, $slider_q);
			while ( $row_slider = mysqli_fetch_assoc($slider_r)) {
				array_push( $slider_a,$row_slider );
			}
    		
    		foreach ($slider_a as $slider_c)
    		{ ?>
    		<div class="item"><img src="<?=$slider_c['image']?>" width="1400" height="355" /></div>
            <?php } ?>
        </div><!-- CAROUSEL-INNER -->
        <a class="left carousel-control" href="#featured" role="button" data-slide="prev">
        <span class="glyphicon glyphicon-chevron-left"></span>
        </a>
        <a class="right carousel-control" href="#featured" role="button" data-slide="next">
        <span class="glyphicon glyphicon-chevron-right"></span>
        </a>
    </div><!-- FEATURED CAROUSEL-->
</div><!-- ROW -->
<div class="catalog row" align="center" style="padding:15px;">
	<a id="catalogo_link">CATALOGO</a>
</div>
<div class="catalog row" style="display:none;" id="catalogo_id">
<nav class="nav-catalog navbar navbar-inverse">
	<div class="navbar-header">
    	<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
      		<span class="sr-only">Toggle navigation</span>
      		<span class="icon-bar"></span>
      		<span class="icon-bar"></span>
      		<span class="icon-bar"></span>
    	</button>
	</div><!-- NAVBAR-HEADER -->
    <div class="collapse navbar-collapse navbar-ex1-collapse">
        <ul class="nav-list nav navbar-nav" role="navigation">
            <li><a href="#">INICIO</a></li>
            <!--
            <li><a href="#">BAZAR</a></li>
            <li><a href="#">BELLEZA Y SALUD</a></li>
            <li><a href="#">BLANQUERIA</a></li>
            <li><a href="#">ELECTRODOMESTICOS Y TECNOLOGIA</a></li>
            <li><a href="#">HERRAMIENTAS</a></li>
            <li><a href="#">HOGAR</a></li>
            <li><a href="#">NIÑOS</a></li>
			!-->
    		<?php
			// traemos listado de TODAS las noticias
			$cat_a = array();
			//$catalogo_q = "SELECT * FROM `catalogo` WHERE categoria!='borrado' ORDER BY id LIMIT ".$inicio.",".$TAMANO_PAGINA;;
			$cat_q = "SELECT * FROM `categorias` ORDER BY id_orden ASC";
			$cat_r = mysqli_query($dbConn, $cat_q);
			while ( $row_cat = mysqli_fetch_assoc($cat_r)) {
				array_push( $cat_a,$row_cat );
			}
    		
    		foreach ($cat_a as $cat_c)
    		{ ?>
    		<li><a href="#"><?=strtoupper($cat_c['nombre'])?></a></li>
            <?php } ?>
        </ul><!-- NAV-LIST -->
    </div><!-- COLLAPSE -->
</nav><!-- NAV-CATALOG -->