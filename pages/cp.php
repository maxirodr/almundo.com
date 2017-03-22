<?php
	verificar($_SESSION['nickname'], $_SESSION['password'], array('admin','vendedor','super premium','premium','user'), $dbConn, $index_web, $url_web);
	//si entramos al panel desde 0
	if(!isset($_GET['section'])) $_GET['section']="resumen";
	
	//scripts responsive talbe
	$footer_include_website="
	<script src=\"//$url_web/js/jquery.dataTables.min.js\" type='text/javascript'></script>
	<script src=\"//$url_web/js/icheck.min.js\" type='text/javascript'></script>
	<script type=\"text/javascript\" src=\"//$url_web/js/bootstrap-file-input.js\"></script>
    <script type=\"text/javascript\" src=\"//$url_web/js/jquery.tagsinput.min.js\"></script>
    
    
    <script>
    (function($) {
		\"use strict\";
		$(document).ready(function() {
			$('.datatable').dataTable( {
	    		\"lengthChange\": false,
	    		\"paging\": true
			} );
			
	        var feTagsinput = function(){
	            if($(\".tagsinput\").length > 0){
	                
	                $(\".tagsinput\").each(function(){
	                    
	                    if($(this).data(\"placeholder\") != ''){
	                        var dt = $(this).data(\"placeholder\");
	                    }else
	                        var dt = 'palabras o tags';
	                                                            
	                    $(this).tagsInput({width: '100%',height:'auto',defaultText: dt});
	                });
	
	            }
	        }
	        
	        var feBsFileInput = function(){
	            
	            if($(\"input.fileinput\").length > 0)
	                $(\"input.fileinput\").bootstrapFileInput();
	            
	        }

			feTagsinput();
			feBsFileInput();
		});
	})(jQuery);
    
    </script>
	";
?>
<section class="site" data-site="panel">
	<div class="container">
		<div class="row">
			<div class="col-sm-2 panel-left">

				<ul<?php if($_GET['section']=='resumen') echo ' class="selected"'; ?>>
					<li class="title"><a href="?section=resumen">Resumen</a></li>
				</ul>

				<ul<?php if($_GET['section']=='imprimir_fact') echo ' class="selected"'; ?>>
					<li class="title"><a href="?section=imprimir_fact">Facturación</a></li>
				</ul>

				<ul<?php if($_GET['section']=='reputacion') echo ' class="selected"'; ?>>
					<li class="title"><a href="?section=reputacion">Reputación</a></li>
				</ul>
				
				<ul<?php if($_GET['section']=='mascotas') echo ' class="selected"'; ?>>
					<li class="title"><a href="">Adopción mascota</a></li>
					<li><a href="?section=mascotas&viewing=publicaciones">Mis publicaciones</a></li>
					<li><a href="ayuda_mascotas">Publicar mascota</a></li>
				</ul>

				<ul<?php if($_GET['section']=='compras') echo ' class="selected"'; ?>>
					<li class="title">Compras</li>
					<li><a href="?section=compras&viewing=favs">Favoritos</a></li>
					<li><a href="?section=compras&viewing=preguntas">Preguntas</a></li>
					<li><a href="?section=compras&viewing=compras">Compras</a></li>
					<li><a href="?section=compras&viewing=subastas">Subastas</a></li>
				</ul>

				<ul<?php if($_GET['section']=='ventas') echo ' class="selected"'; ?>>
					<li class="title">Ventas</li>
					<li><a href="?section=ventas&viewing=publicaciones">Publicaciones</a></li>
					<li><a href="?section=ventas&viewing=preguntas">Preguntas</a></li>
					<!--<li><a href="#">Datos de mis interesados</a></li>
					<li><a href="#">Campaña de publicidad</a></li>!-->
					<li><a href="?section=ventas&viewing=profile">Editar mi perfil de ventas</a></li>
				</ul>

<?php
	if(in_array($_SESSION['tipo'], array('vendedor','admin'))) {
?>
				<ul<?php if($_GET['cat']=='admin') echo ' class="selected"'; ?>>
					<li class="title">Administrador</li>
					<li><a href="#">Transacciones</a></li>

					<li><a href="usuario?section=users&cat=admin">Usuarios</a></li>

					<li><a href="usuario?section=prov&cat=admin">Provincias</a></li>
					<li><a href="usuario?section=ciud&cat=admin">Ciudades</a></li>

					<li><a href="usuario?section=cats&cat=admin">Categorías</a></li>

					<li><a href="usuario?section=comercios&cat=admin">Comercios locales</a></li>

					<li><a href="#">Publicidades</a></li>
					<li><a href="usuario?section=cat&cat=admin">Categorias Artículos</a></li>
					<li><a href="usuario?section=subcat&cat=admin">Sub-Categorias Artículos</a></li>
					<li><a href="usuario?section=subsubcat&cat=admin">SUB-sub-Categorias Artículos</a></li>
					<li><a href="usuario?section=subsubsubcat&cat=admin">SUBsub-sub-Categorias Artículos</a></li>

					<li><a href="#">Artículos/Subastas/etc.</a></li>
					<li><a href="#">Hoteles</a></li>
					<li><a href="usuario?section=cartprof&cat=admin">Cartilla profesionales</a></li>
					<li><a href="#">Disputas</a></li>
					<li><a href="#">Sorteos semanales</a></li>
					<li><a href="#">Preguntas y respuestas (*)</a></li>
					<li><a href="usuario?section=palprob&cat=admin">Palabras prohibidas</a></li>
					<li><a href="#">Reputacion vendedores</a></li>

					<li><a href="usuario?section=sliders&cat=admin">Sliders</a></li>

					<li><a href="#">Mayores artículos vendidos/interacciones</a></li>
				</ul>
<?php } ?>

				<ul<?php if($_GET['cat']=='resumen') echo ' class="selected"'; ?>>
					<li class="title">Configuración</li>
					<li><a href="#">Datos personales</a></li>
					<li><a href="#">Seguridad</a></li>
					<li><a href="#">E-mails</a></li>
				</ul>

			</div>

			<?php
				if($_GET['section']=="resumen") include('panel/resumen.php');
			 	elseif($_GET['section']=="imprimir_fact") include('panel/facturacion.php'); 
				elseif($_GET['section']=="reputacion") include('panel/reputacion.php');
				elseif($_GET['cat']=="admin") {
					if($_GET['section']=="users") include('panel/adm-usuarios.php');

					if($_GET['section']=="cats") include('panel/adm-cats.php');
					
					if($_GET['section']=="palprob") include('panel/adm-palabras.php');
					
					if($_GET['section']=="sliders") include('panel/adm-sliders.php');

					if($_GET['section']=="comercios") include('panel/adm-comercios.php');
					if($_GET['section']=="cartprof") include('panel/adm-profesionales.php');
					

					if($_GET['section']=="cat") include('panel/adm-cat.php');
					if($_GET['section']=="subcat") include('panel/adm-subcat.php');
					if($_GET['section']=="subsubcat") include('panel/adm-subsubcat.php');
					if($_GET['section']=="subsubsubcat") include('panel/adm-subsubsubcat.php');
					
					if($_GET['section']=="prov") include('panel/adm-provincias.php');
					if($_GET['section']=="ciud") include('panel/adm-ciudades.php');
				}//cat==admin
				elseif($_GET['section']=="ventas") {
					if($_GET['viewing']=="profile") include('panel/ventas_perfil.php');
					if($_GET['viewing']=="publicaciones") include('panel/ventas_publicaciones.php');
					if($_GET['viewing']=="preguntas") include('panel/ventas_preguntas.php');
				}//cat==venats
				elseif($_GET['section']=="compras") {
					if($_GET['viewing']=="favs") include('panel/compras_favoritos.php');
					if($_GET['viewing']=="preguntas") include('panel/compras_preguntas.php');
					if($_GET['viewing']=="compras") include('panel/compras_listado.php');
					if($_GET['viewing']=="subastas") include('panel/compras_subastas.php');
					
				}//section=compras&viewing=
				elseif($_GET['section']=="mascotas") {
					if($_GET['viewing']=="publicaciones") include('panel/mascotas_publicaciones.php');
				}//cat==mascotas
			?>
			
		</div>
	</div>
</section>
