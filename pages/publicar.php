<?php
verificar($_SESSION['nickname'], $_SESSION['password'], $permisos_generales, $dbConn, $index_web, $url_web);

$edit=mysqli_real_escape_string($dbConn, trim($_SESSION['id']));
$query = "SELECT * FROM `usuarios_superpremium` WHERE id = '$edit' LIMIT 0,1";
$resultado = mysqli_query($dbConn, $query);
$row_sp = mysqli_fetch_assoc($resultado);

if($row_sp['tipo']!="activo" && !in_array($_SESSION['tipo'],array("super premium","premium","admin","vendedor"))) $error_sp=true;

if(isset($_POST['descripcion']) && $_POST['descripcion']!="") {
	$img=array();
	// definimos las variables
	//categoria,video,titulo,descripcion,stock,precio,tipo_envio,metodo_pago,tipo_publicidad
	
	if ( !empty($_POST['categoria']) ) 			$categoria 				= secure_input($_POST['categoria']);
	if ( !empty($_POST['link_video']) ) 		$link_video 			= secure_input($_POST['link_video']);
	if ( !empty($_POST['titulo']) ) 			$titulo 				= secure_input($_POST['titulo']);
	if ( !empty($_POST['descripcion']) ) 		$descripcion 			= secure_input($_POST['descripcion']);
	if ( !empty($_POST['stock']) ) 				$stock 					= secure_input($_POST['stock']);
	if ( !empty($_POST['precio']) ) 			$precio 				= secure_input($_POST['precio']);
	if ( !empty($_POST['tipo_envio']) ) 		$tipo_envio 			= secure_input($_POST['tipo_envio']);
	if ( !empty($_POST['metodo_pago']) ) 		$metodo_pago 			= secure_input($_POST['metodo_pago']);
	if ( !empty($_POST['tipo_publicidad']) ) 	$tipo_publicidad		= secure_input($_POST['tipo_publicidad']);
	if ( !empty($_FILES['img1']['name']) ) 		$img[1]['name']			= mysqli_real_escape_string($dbConn, $_FILES['img1']['name']);
	if ( !empty($_FILES['img2']['name']) ) 		$img[2]['name']			= mysqli_real_escape_string($dbConn, $_FILES['img2']['name']);
	if ( !empty($_FILES['img3']['name']) ) 		$img[3]['name']			= mysqli_real_escape_string($dbConn, $_FILES['img3']['name']);
	if ( !empty($_FILES['img4']['name']) ) 		$img[4]['name']			= mysqli_real_escape_string($dbConn, $_FILES['img4']['name']);
	if ( !empty($_FILES['img5']['name']) ) 		$img[5]['name']			= mysqli_real_escape_string($dbConn, $_FILES['img5']['name']);
	if ( !empty($_FILES['img6']['name']) ) 		$img[6]['name']			= mysqli_real_escape_string($dbConn, $_FILES['img6']['name']);

	// completamos la variable error si es necesario
	if ( empty($categoria) ) 						$error['categoria']					= 'Es obligatorio seleccionar categorias';
	if ( empty($link_video) ) 						$link_video="";
	if ( empty($descripcion) ) 						$error['descripcion']				= 'Es obligatorio completar éste campo';
	if ( strlen($descripcion)>600 )					$error['descripcion']				= 'La descripción no puede contener más de 600 carácteres';
	if ( !is_numeric($stock) || empty($stock) )		$error['stock']						= 'La cantidad a vender es obligatoria y numérica.';
	if ( !is_numeric($precio) || empty($precio) ) 	$error['precio']					= 'El precio es obligatorio y numérico.';
	if ( !is_array($tipo_envio) || empty($tipo_envio) )
													$error['tipo_envio']				= 'Es obligatorio indicar el tipo de envío';
	if ( !is_array($metodo_pago) || empty($metodo_pago) )
													$error['metodo_pago']				= 'Es obligatorio indicar el método de pago';
	if ( !is_numeric($tipo_publicidad) || empty($tipo_publicidad) )
													$error['tipo_publicidad']			= 'Es obligatorio indicar el tipo de publicidad';

	if ( count($img)<1 )							$error['img'][0]					= 'Debe subir aunque sea 1 imagen';

	//chequeo de imágenes
	for ($n_img=1; $n_img <= 6; $n_img++) {
		if( !empty($img[$n_img]) ) {
			if ( $_FILES['img'.$n_img]['type'])
				$img[$n_img]['file_type'] = mysqli_real_escape_string($dbConn, $_FILES['img'.$n_img]['type']);
			else
				$error['img'][$n_img] 		= "La imagen $n_img no es un tipo de imagen permitida.";

			list($h, $b) = getimagesize($_FILES['img'.$n_img]['tmp_name']);

			if (($_FILES['img'.$n_img]['size']>6291456)) 
				$error['img'][$n_img] 		= "La imagen $n_img no puede pesar mas de 6MB";
			if (!in_array($img[$n_img]['file_type'],array("image/jpeg","image/png")))
				$error['img'][$n_img]	 	= "La imagen $n_img no concuerda con los tipos permitidos (JPG,PNG).";
			if($h < "559" or $b < "419")
				$error['img'][$n_img] 		= "La imagen $n_img debe medir igual o superior a 560x420 pixeles.";
			if($h > "3999" or $b > "3499")
				$error['img'][$n_img] 		= "La imagen $n_img no debe medir superior a 4000x3500 pixeles.";
				
			if ( empty($_FILES['img'.$n_img]['tmp_name']) )
				$error['img'][$n_img] 		= "La imagen $n_img tiene algún tipo de caracter inválido en el nombre.";
			else
				$img[$n_img]['tmp_name']	= secure_input($_FILES['img'.$n_img]['tmp_name']);
		}
		unset($file_type);
	}

	$id_cats="";
	foreach ($categoria as $key => $value) {
		if($key=="cat")
			$id_cats="A$value";
		if($key=="subcat")
			$id_cats="$id_cats;B$value";
		if($key=="subsubcat")
			$id_cats="$id_cats;C$value";
		if($key=="subsubsubcat")
			$id_cats="$id_cats;D$value";
	}unset($key,$value);
	
	$db_tipo_envio="";
	foreach ($tipo_envio as $key => $value) {
		if($db_tipo_envio=="") $db_tipo_envio=$value;
		else $db_tipo_envio=$db_tipo_envio.";$value";
	}unset($tipo_envio,$key,$value);
	
	$db_metodo_pago="";
	foreach ($metodo_pago as $key => $value) {
		if($db_metodo_pago=="") $db_metodo_pago=$value;
		else $db_metodo_pago=$db_metodo_pago.";$value";
	}unset($metodo_pago,$key,$value);

	// si no hay errores registramos el articulo
	if ( empty($error) ) {
		// inserto los datos de registro en la db
		$fCreacion = date("Y-m-d H:i:s");
		$fCreacionUsuario = $_SESSION['id'];

		$fModificacion = date("Y-m-d H:i:s");
		$fModificacionUsuario = $_SESSION['id'];
		
		//agregar upload de imágenes
		$image_uploaded="";
		foreach($img as $key => $values) {
			if($values['file_type']=="image/jpeg") {$extension="jpg";$calidad_img=85;}
			elseif($values['file_type']=="image/png") {$extension="png";$calidad_img=3;}
			else redireccionar("/vende_ya", $url_web);
			
			if($key!=1)
				$image_uploaded = $image_uploaded.";".upload_img($values["tmp_name"],$values["name"],"guardar","hd",$calidad_img,"/basic/uploads/img/articulos/",$extension,"linux");
			if($key==1)
				$image_uploaded = upload_img($values["tmp_name"],$values["name"],"guardar","hd",$calidad_img,"/basic/uploads/img/articulos/",$extension,"linux");
		} unset($key,$value);

		if(!$error) {
			//id_cats,imagenes,link_video,titulo,descripcion,stock,precio,metodo_envio,metodo_pago,tipo_perfil
			
			$query  = "INSERT INTO `articulos` 
			(`id_user`,`id_cats`,`imagenes`,`link_video`,`titulo`,`descripcion`,`stock`,`precio`,`metodo_envio`,`metodo_pago`,`tipo_perfil`,
			`fModificacionUsuario`,`fModificacion`,`fCreacionUsuario`,`fCreacion`) VALUES 
			('$_SESSION[id]','$id_cats','$image_uploaded','$link_video','$titulo','$descripcion','$stock','$precio','$db_tipo_envio','$db_metodo_pago','$tipo_publicidad',
			'$fModificacionUsuario','$fModificacion','$fCreacionUsuario','$fCreacion')";
			$result = mysqli_query($dbConn, $query);
			
			$id_back = mysqli_insert_id($dbConn);
			
			
			//agregar función de envío de mail
			/*$to = "$email";
			$subject = "tarjetealo.com.ar ## Bienvenido usuario!";

			$message = "
			<html>
			<head>
			<title>Bienvenido a tarjetealo.com.ar</title>
			</head>
			<body>
			<p>Este es un mail de confirmación. Estamos trabajando en el diseño de este mail para que sea mas atractivo y llamativo, te pedimos disculpas por el diseño tan simple.</p>
			<p>$firstname</p>
			<p>$lastname</p>
			<p>$cel</p>
			Click <a href='http://$url_web/registrarse?confirm_mail=true_confirm&code=$fecha&email=$email'>aquí</a> para confirmar el mail, o en el siguiente link:<br />
			<a href='http://$url_web/registrarse?confirm_mail=true_confirm&code=$fecha&email=$email'>http://$url_web/registrarse?confirm_mail=true_confirm&code=$fecha&email=$email</a>
			<br /><br /><br />
			Este link expirará el $fecha_expiracion (UTC-03:00 ARG).
			</p>
			</body>
			</html>
			";

			// Always set content-type when sending HTML email
			$headers = "MIME-Version: 1.0" . "\r\n";
			$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

			// More headers
			$headers .= 'From: Tarjetealo.com.ar <no-reply@tarjetealo.com.ar>' . "\r\n";
			$headers .= 'Reply-to: Tarjetealo.com.ar <info@tarjetealo.com.ar>' . "\r\n";

			$mail = mail($to,$subject,$message,$headers);*/

			redireccionar("/producto/$id_back/", $url_web); //me falta agregarle el ID al que lo redirecciona

			mysqli_close($dbConn);
		}
	}
		
}//isset submit

?>

<?php if(isset($error_sp)) { ?>
<section class="site" data-site="publish">
	<div class="container">
		<div class="publish-carousel">
			<div class="item" id="categoria" data-item="1">
				<div class="row" style="padding:50px;">
					<div class="col-sm-12">
						<div class="big-title">Publicar un artículo</div>
						<div class="section-title">Para vender necesita estar habilitado como perfil Súper Premium o Premium. Si desea realizar esta acción, deberá contactarse con un representante de su ciudad.</div>
						<div class="space-height" style="height: 30px;"></div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<?php } else { ?>
<form action="" method="post" enctype="multipart/form-data" id="form-publish" name="submitform">
<section class="site" data-site="publish">
	<div class="container">
		<div class="row">
			<div class="col-sm-12 tel">
				<div class="t1">0800 999 333</div>
				<div class="t12">¿Necesitás ayuda? <br> Llamanos.</div>
			</div>
		</div>

		<div class="publish-carousel">
			<div class="col-md-12 col-sm-12">
			<?php
			if(isset($error)) {
				foreach ($error as $key => $value) {
			?>
				<?php if (!empty($error[$value])) echo '<span class="glyphicon glyphicon-remove form-control-feedback"></span>'; ?>
		    	<?php if (!empty($error[$value])) { echo('<label class="control-label">'.$error[$value].'</label>'); } ?><br/>
			<?php
				} 
			}
			?>
			</div>

			<div class="item" id="categoria" data-item="1">
				<div class="row">
					<div class="col-sm-12">
						<div class="big-title">Publicar un artículo</div>
						<div class="section-title">Contanos, <span>¿qué vas a publicar?</span></div>
						<div class="space-height" style="height: 30px;"></div>
					</div>
				</div>

				<div class="cat-select">
					<div class="row">
						<div class="col-xs-12 col-sm-3 col-md-3">
							<div class="box-sec" data-level="1"></div>
						</div>
						<div class="col-xs-12 col-sm-3 col-md-3">
							<div class="box-sec" data-level="2"></div>
						</div>
						<div class="col-xs-12 col-sm-3 col-md-3">
							<div class="box-sec" data-level="3"></div>
						</div>
						<div class="col-xs-12 col-sm-3 col-md-3">
							<div class="box-sec" data-level="4"></div>
						</div>
					</div>
				</div>

				<div class="publish-tos">El uso de este sitio implica la aceptació de los <a href="#">Términos y Condiciones</a> y las <a href="#">Políticas de Privacidad</a> de Tarjetealo.</div>

				<div class="button-continue" data-actual="categoria" data-next="descripcion">Continuar</div>
			</div>

			<div class="item" id="descripcion" data-item="2">
				<div class="row">
					<div class="col-sm-12">
						<div class="big-title">Describí tu Producto</div>
						<div class="section-title">Imágenes del producto</div>
						<div class="space-height" style="height: 30px;"></div>
					</div>
					
					<?php $var_form_web='img'; ?>
					<div class="form-group<?php if (!empty($error[$var_form_web]) or is_array($error[$var_form_web])) echo " has-error has-feedback"; ?>">
						<div class="col-md-12 box-upload">
	                        <div class="col-md-2">
	                        	<label for="img1" class="img-box-upload">
							        <div><img style="max-width:140px;max-height:141px;" id="img1-response" src="" /></div>
							    </label>
	                            <input type="file" id="img1" name="img1" accept="image/jpeg, image/png" onchange="readURL(this);" />
						    	<?php if (!empty($error[$var_form_web][1])) { echo('<label class="control-label" style="color:color: #ff1744;font-weight:bold;">'.$error[$var_form_web][1].'</label>'); } ?>
	                        </div>
	                        
	                        <div class="col-md-2">
	                        	<label for="img2" class="img-box-upload">
							        <div><img style="max-width:140px;max-height:141px;" id="img2-response" src="" /></div>
							    </label>
	                            <input type="file" id="img2" name="img2" accept="image/jpeg, image/png" onchange="readURL(this);" />
						    	<?php if (!empty($error[$var_form_web][2])) { echo('<label class="control-label" style="color:color: #ff1744;font-weight:bold;">'.$error[$var_form_web][2].'</label>'); } ?>
	                        </div>
	                        
	                        <div class="col-md-2">
	                        	<label for="img3" class="img-box-upload">
							        <div><img style="max-width:140px;max-height:141px;" id="img3-response" src="" /></div>
							    </label>
	                            <input type="file" id="img3" name="img3" value="img3" accept="image/jpeg, image/png" onchange="readURL(this);" />
						    	<?php if (!empty($error[$var_form_web][3])) { echo('<label class="control-label" style="color:color: #ff1744;font-weight:bold;">'.$error[$var_form_web][3].'</label>'); } ?>
	                        </div>
	                        
	                        <div class="col-md-2">
	                        	<label for="img4" class="img-box-upload">
							        <div><img style="max-width:140px;max-height:141px;" id="img4-response" src="" /></div>
							    </label>
	                            <input type="file" id="img4" name="img4" value="img4" accept="image/jpeg, image/png" onchange="readURL(this);" />
						    	<?php if (!empty($error[$var_form_web][4])) { echo('<label class="control-label" style="color:color: #ff1744;font-weight:bold;">'.$error[$var_form_web][4].'</label>'); } ?>
	                        </div>
	                        
	                        <div class="col-md-2">
	                        	<label for="img5" class="img-box-upload">
							        <div><img style="max-width:140px;max-height:141px;" id="img5-response" src="" /></div>
							    </label>
	                            <input type="file" id="img5" name="img5" value="img5" accept="image/jpeg, image/png" onchange="readURL(this);" /> 
						    	<?php if (!empty($error[$var_form_web][5])) { echo('<label class="control-label" style="color:color: #ff1744;font-weight:bold;">'.$error[$var_form_web][5].'</label>'); } ?>
	                        </div>
	                        
	                        <div class="col-md-2">
	                        	<label for="img6" class="img-box-upload">
							        <div><img style="max-width:140px;max-height:141px;" id="img6-response" src="" /></div>
							    </label>
	                            <input type="file" id="img6" name="img6" value="img6" accept="image/jpeg, image/png" onchange="readURL(this);" />
						    	<?php if (!empty($error[$var_form_web][6])) { echo('<label class="control-label" style="color:color: #ff1744;font-weight:bold;">'.$error[$var_form_web][6].'</label>'); } ?>
	                        </div>
	                    </div>
                        
                        <div class="small-text"><span class="input obligatorio">(*)</span> Por lo menos 1, y deben medir igual o superior a 560x420 pixeles.</div>
                        <div class="space-height" style="height: 30px;"></div>
                        <div class="small-text"><span class="input obligatorio">(*)</span> Los campos marcados son obligatorios.</div>
                    </div>
					<?php unset($var_form_web); ?>
					
					<?php $var_form_web='link_video'; ?>
					<div class="form-group<?php if (!empty($error[$var_form_web])) echo " has-error has-feedback"; ?>">
					    <label class="col-md-4 control-label">Coloca un video de <span>youtube</span>:</label>
					    <div class="col-md-6">
					        <input name="<?=$var_form_web?>" class="form-control"  max-lenght="255" value="<?=$_POST[$var_form_web]?>" placeholder="www.youtube.com/watch?v=ab12AS1asAS" required="required" />
					        <?php if (!empty($error[$var_form_web])) echo '<span class="glyphicon glyphicon-remove form-control-feedback"></span>'; ?>
					    	<?php if (!empty($error[$var_form_web])) { echo('<label class="control-label">'.$error[$var_form_web].'</label>'); } ?>
					    </div>
					    <div class="col-md-2"></div>
					</div>
					<?php unset($var_form_web); ?>
					
					<div class="col-md-12 divisor"></div>
					
					<div class="col-md-12">
						<?php $var_form_web='titulo'; ?>
						<div class="form-group<?php if (!empty($error[$var_form_web])) echo " has-error has-feedback"; ?>">
						    <label class="col-md-4 control-label">Título <span class="input obligatorio">(*)</span>:</label>
						    <div class="col-md-6">
						        <input name="<?=$var_form_web?>" class="form-control"  max-lenght="100" value="<?=$_POST[$var_form_web]?>" placeholder="Vendo increíble artículo" required="required" />
						        <?php if (!empty($error[$var_form_web])) echo '<span class="glyphicon glyphicon-remove form-control-feedback"></span>'; ?>
						    	<?php if (!empty($error[$var_form_web])) { echo('<label class="control-label">'.$error[$var_form_web].'</label>'); } ?>
						    </div>
						    <div class="col-md-2"></div>
						</div>
						<?php unset($var_form_web); ?>
					</div>
					
					<?php $var_form_web='descripcion'; ?>
					<div class="form-group<?php if (!empty($error[$var_form_web])) echo " has-error has-feedback"; ?>">
					    <label class="col-md-4 control-label">Descripción <span class="input obligatorio">(*)</span>:</label>
					    <div class="col-md-6">
					        <textarea name="<?=$var_form_web?>" class="form-control" rows="8" maxlenght="600" placeholder="Puede ser una descripción breve o compleja sobre el artículo a públicar (600 caracteres máximo)." required="required"><?=$_POST[$var_form_web]?></textarea>
					        <?php if (!empty($error[$var_form_web])) echo '<span class="glyphicon glyphicon-remove form-control-feedback"></span>'; ?>
					    	<?php if (!empty($error[$var_form_web])) { echo('<label class="control-label">'.$error[$var_form_web].'</label>'); } ?>
					    </div>
					</div>
					<?php unset($var_form_web); ?>
					
					<div class="col-md-12 divisor"></div>
					
					<div class="col-md-6 col-xs-12">
						<?php $var_form_web='stock'; ?>
						<div class="form-group<?php if (!empty($error[$var_form_web])) echo " has-error has-feedback"; ?>">
						    <label class="col-md-6 control-label">Cantidad a vender (stock) <span class="input obligatorio">(*)</span></label>
						    <div class="col-md-6">
						        <input name="<?=$var_form_web?>" class="form-control" value="<?=$_POST[$var_form_web]?>" placeholder="1 (números)" required="required" type="number" />
						        <?php if (!empty($error[$var_form_web])) echo '<span class="glyphicon glyphicon-remove form-control-feedback"></span>'; ?>
						    	<?php if (!empty($error[$var_form_web])) { echo('<label class="control-label">'.$error[$var_form_web].'</label>'); } ?>
						    </div>
						</div>
						<?php unset($var_form_web); ?>
					</div>
					
					<div class="col-md-6 col-xs-12">
						<?php $var_form_web='precio'; ?>
						<div class="form-group<?php if (!empty($error[$var_form_web])) echo " has-error has-feedback"; ?>">
						    <label class="col-md-6 control-label">Precio <span class="input obligatorio">(*)</span></label>
						    <div class="col-md-6">
						        <input name="<?=$var_form_web?>" class="form-control" value="<?=$_POST[$var_form_web]?>" placeholder="190.10 (números)" required="required" type="number" />
						        <?php if (!empty($error[$var_form_web])) echo '<span class="glyphicon glyphicon-remove form-control-feedback"></span>'; ?>
						    	<?php if (!empty($error[$var_form_web])) { echo('<label class="control-label">'.$error[$var_form_web].'</label>'); } ?>
						    </div>
						</div>
						<?php unset($var_form_web); ?>
					</div>
					
				</div>
				
				

				

				<div class="publish-tos">El uso de este sitio implica la aceptació de los <a href="#">Términos y Condiciones</a> y las <a href="#">Políticas de Privacidad</a> de Tarjetealo.</div>
				
				<div class="button-continue" data-actual="descripcion" data-next="envio">Continuar</div>

			</div>
			
			
			
			
			<div class="item" id="envio" data-item="3">
				<div class="row">
					<div class="col-sm-12">
						<div class="big-title">Si se concreta la venta</div>
						<div class="section-title">Método de envío (seleccioná la cantidad que quieras)</div>
						<div class="space-height" style="height: 30px;"></div>
						<div class="metodo_envio">
							<div class="col-xs-12 col-sm-3 col-md-3">
								<label><input type="checkbox" name="tipo_envio[1]" value="1"> Rápido<br/><span>(24hs)</span></label>
							</div>
							<div class="col-xs-12 col-sm-3 col-md-3">
								<label><input type="checkbox" name="tipo_envio[2]" value="2"> Express<br/><span>(48hs)</span></label>
							</div>
							<div class="col-xs-12 col-sm-3 col-md-3">
								<label><input type="checkbox" name="tipo_envio[3]" value="3"> Tradicional<br/><span>(Fecha a definir)</span></label>
							</div>
							<div class="col-xs-12 col-sm-3 col-md-3">
								<label><input type="checkbox" name="tipo_envio[4]" value="4"> Acuerdo con el comprador<br/><span>(Tarjetealo queda excento de responsabilidad)</span></label>
							</div>
						</div>
						<div class="div-space col-xs-12"></div>
						<div class="section-title">Método de pago (seleccioná la cantidad que quieras)</div>
						<div class="space-height col-xs-12" style="height: 30px;"></div>
						<div class="metodo_pago">
							<div class="col-xs-12 col-sm-3 col-md-3">
								<label><input type="checkbox" name="metodo_pago[1]" value="1"> Tarjeta de crédito</label>
							</div>
							<div class="col-xs-12 col-sm-3 col-md-3">
								<label><input type="checkbox" name="metodo_pago[2]" value="2"> Tarjeta de débito</label>
							</div>
							<div class="col-xs-12 col-sm-3 col-md-3">
								<label><input type="checkbox" name="metodo_pago[3]" value="3"> Depósito</label>
							</div>
							<div class="col-xs-12 col-sm-3 col-md-3">
								<label><input type="checkbox" name="metodo_pago[4]" value="4"> Acuerdo con el comprador<br/><span>(Tarjetealo queda excento de responsabilidad)</span></label>
							</div>
						</div>
						<div class="div-space col-xs-12"></div>
					</div>
				</div>
				
				<div class="button-continue" data-actual="envio" data-next="publicacion">Continuar</div>
			</div>
			
			<div class="item" id="publicacion" data-item="4">
				<div class="row">
					<div class="col-sm-12">
						<div class="big-title">Incrementa las ventas</div>
						<div class="space-height" style="height: 30px;"></div>
						<div class="tipo_perfil">
							<div id="fila1" class="col-xs-12 col-sm-12">
								<div class="col-xs-12 col-sm-3 col-md-3">
									<div class="title">Tipo de publicidad</div>
								</div>
								<div class="col-xs-12 col-sm-3 col-md-3">
									<div class="title">Costo publicación</div>
								</div>
								<div class="col-xs-12 col-sm-3 col-md-3">
									<div class="title">Costo por venta</div>
								</div>
								<div class="col-xs-12 col-sm-3 col-md-3">
									<div class="title">Detalles</div>
								</div>
							</div>
							<div class="div-space col-xs-12"></div>
							<div id="fila2" class="col-xs-12 col-sm-12">
								<div class="col-xs-12 col-sm-3 col-md-3">
									<div class="col-xs-12"><input type="radio" name="tipo_publicidad" value="1"> <span class="decorado">Súper Premium - 10 veces mas visitas</span></input></div>
									<div class="col-xs-12"><span>Promocioná tu perfil en Tarjetealo ©</span></div>
								</div>
								<div class="col-xs-12 col-sm-3 col-md-3">
									<div class="costo_publicacion">Gratis</div>
								</div>
								<div class="col-xs-12 col-sm-3 col-md-3">
									<div class="costo_venta_box br5">12%</div>
								</div>
								<div class="col-xs-12 col-sm-3 col-md-3">
									<div class="text_detalles">Tu perfil es mostrado primero en los resultados de búsqueda relacionados.</div>
								</div>
							</div>
							<div class="div-space col-xs-12"></div>
							<div id="fila3" class="col-xs-12 col-sm-12">
								<div class="col-xs-12 col-sm-3 col-md-3">
									<div class="col-xs-12"><input type="radio" name="tipo_publicidad" value="2"> <span class="decorado">Premium - 5 veces mas visitas</span></input></div>
									<div class="col-xs-12"><span>Promocioná esta publicación</span></div>
								</div>
								<div class="col-xs-12 col-sm-3 col-md-3">
									<div class="costo_publicacion">$440</div>
								</div>
								<div class="col-xs-12 col-sm-3 col-md-3">
									<div class="costo_venta_box br5">8%</div>
								</div>
								<div class="col-xs-12 col-sm-3 col-md-3">
									<div class="text_detalles">Tu publicación es mostrada inmediatamente después de los perfiles súper premium en los resultados de búsqueda relacionados.</div>
								</div>
							</div>
							<div class="div-space col-xs-12"></div>
							<div id="fila4" class="col-xs-12 col-sm-12">
								<div class="col-xs-12 col-sm-3 col-md-3">
									<div class="col-xs-12"><input type="radio" name="tipo_publicidad" value="3"> <span class="decorado">Normal</span></input></div>
									<div class="col-xs-12"><span>No promocionás la publicación</span></div>
								</div>
								<div class="col-xs-12 col-sm-3 col-md-3">
									<div class="costo_publicacion">Gratis</div>
								</div>
								<div class="col-xs-12 col-sm-3 col-md-3">
									<div class="costo_venta_box br5">0%</div>
								</div>
								<div class="col-xs-12 col-sm-3 col-md-3">
									<div class="text_detalles">Tu primer mes de publicación es gratis. ¡Aprovechalo!</div>
								</div>
							</div>
							<div class="div-space col-xs-12"></div>
							<div class="col-xs-12">Aviso: <span class="text_detalles">seleccionando tipo de publicidad normal no se ofrece financiación con tarjetas de crédito</span></div>
						</div>
					</div>
					<div class="div-space col-xs-12"></div>
					<div class="col-xs-12 title">¡Estas son tus ganancias!</div>
					<div class="col-sm-12">
						<div class="col-sm-10 col-sm-offset-2">
							<div class="col-sm-6 content_ganancias1 left">Costo total del artículo</div>
							<div class="col-sm-6 content_ganancias1 right"><label name="costo_total"></label></div>
							<div class="div-space col-xs-12"></div>
							<div class="col-sm-6 content_ganancias1 left">Gastos administrativos</div>
							<div class="col-sm-6 content_ganancias1 right"><label name="gastos_admin"></label></div>
							<div class="div-space col-xs-12"></div>
							<div class="col-sm-6 content_ganancias1 left black">Vos recibís</div>
							<div class="col-sm-6 content_ganancias1 right"><span><label name="ganancia"></label></span></div>
						</div>
					</div>
					<div class="div-space col-xs-12"></div>
					<div class="col-xs-12">Aviso2: <span class="text_detalles">el artículo estará publicado por 30 días, luego se le enviará un mail para la renovación de la publicación</span></div>
					<div class="div-space col-xs-12"></div>
				</div>
				
				<div class="button-continue" data-actual="publicacion" data-next="subir" onclick="document.getElementById('form-publish').submit();">PUBLICAR YA</div>
			</div>
			
			<div class="item" id="subir" data-item="5">
				<div class="row">
					<div class="col-sm-12" align="center">
						<div class='uil-default-css' style='transform:scale(0.6);'>
							<div style='top:80px;left:93px;width:14px;height:40px;background:#ff1744;-webkit-transform:rotate(0deg) translate(0,-60px);transform:rotate(0deg) translate(0,-60px);border-radius:10px;position:absolute;'></div>
							<div style='top:80px;left:93px;width:14px;height:40px;background:#ff1744;-webkit-transform:rotate(30deg) translate(0,-60px);transform:rotate(30deg) translate(0,-60px);border-radius:10px;position:absolute;'></div>
							<div style='top:80px;left:93px;width:14px;height:40px;background:#ff1744;-webkit-transform:rotate(60deg) translate(0,-60px);transform:rotate(60deg) translate(0,-60px);border-radius:10px;position:absolute;'></div>
							<div style='top:80px;left:93px;width:14px;height:40px;background:#ff1744;-webkit-transform:rotate(90deg) translate(0,-60px);transform:rotate(90deg) translate(0,-60px);border-radius:10px;position:absolute;'></div>
							<div style='top:80px;left:93px;width:14px;height:40px;background:#ff1744;-webkit-transform:rotate(120deg) translate(0,-60px);transform:rotate(120deg) translate(0,-60px);border-radius:10px;position:absolute;'></div>
							<div style='top:80px;left:93px;width:14px;height:40px;background:#ff1744;-webkit-transform:rotate(150deg) translate(0,-60px);transform:rotate(150deg) translate(0,-60px);border-radius:10px;position:absolute;'></div>
							<div style='top:80px;left:93px;width:14px;height:40px;background:#ff1744;-webkit-transform:rotate(180deg) translate(0,-60px);transform:rotate(180deg) translate(0,-60px);border-radius:10px;position:absolute;'></div>
							<div style='top:80px;left:93px;width:14px;height:40px;background:#ff1744;-webkit-transform:rotate(210deg) translate(0,-60px);transform:rotate(210deg) translate(0,-60px);border-radius:10px;position:absolute;'></div>
							<div style='top:80px;left:93px;width:14px;height:40px;background:#ff1744;-webkit-transform:rotate(240deg) translate(0,-60px);transform:rotate(240deg) translate(0,-60px);border-radius:10px;position:absolute;'></div>
							<div style='top:80px;left:93px;width:14px;height:40px;background:#ff1744;-webkit-transform:rotate(270deg) translate(0,-60px);transform:rotate(270deg) translate(0,-60px);border-radius:10px;position:absolute;'></div>
							<div style='top:80px;left:93px;width:14px;height:40px;background:#ff1744;-webkit-transform:rotate(300deg) translate(0,-60px);transform:rotate(300deg) translate(0,-60px);border-radius:10px;position:absolute;'></div>
							<div style='top:80px;left:93px;width:14px;height:40px;background:#ff1744;-webkit-transform:rotate(330deg) translate(0,-60px);transform:rotate(330deg) translate(0,-60px);border-radius:10px;position:absolute;'></div>
						</div>
					</div>
				</div>
			</div>
			
		</div>

	</div>
</section>
</form>
<?php } ?>
<style type='text/css'>
@-webkit-keyframes uil-default-anim {
	0% { opacity: 1} 100% {opacity: 0}
}
@keyframes uil-default-anim {
	0% { opacity: 1}100% {opacity: 0}
}
.uil-default-css > div:nth-of-type(1){
	-webkit-animation: uil-default-anim 1s linear infinite;animation: uil-default-anim 1s linear infinite;-webkit-animation-delay: -0.5s;animation-delay: -0.5s;
}
.uil-default-css {
	position: relative;background:none;width:200px;height:200px;
}
.uil-default-css > div:nth-of-type(2) {
	-webkit-animation: uil-default-anim 1s linear infinite;animation: uil-default-anim 1s linear infinite;-webkit-animation-delay: -0.4166666666666667s;animation-delay: -0.4166666666666667s;
}
.uil-default-css {
	position: relative;background:none;width:200px;height:200px;
}
.uil-default-css > div:nth-of-type(3){
	-webkit-animation: uil-default-anim 1s linear infinite;animation: uil-default-anim 1s linear infinite;-webkit-animation-delay: -0.33333333333333337s;animation-delay: -0.33333333333333337s;
}
.uil-default-css {
	position: relative;background:none;width:200px;height:200px;
}
.uil-default-css > div:nth-of-type(4){
	-webkit-animation: uil-default-anim 1s linear infinite;animation: uil-default-anim 1s linear infinite;-webkit-animation-delay: -0.25s;animation-delay: -0.25s;
}
.uil-default-css {
	position: relative;background:none;width:200px;height:200px;
}
.uil-default-css > div:nth-of-type(5){
	-webkit-animation: uil-default-anim 1s linear infinite;animation: uil-default-anim 1s linear infinite;-webkit-animation-delay: -0.16666666666666669s;animation-delay: -0.16666666666666669s;
}
.uil-default-css {
	position: relative;background:none;width:200px;height:200px;
}.uil-default-css > div:nth-of-type(6){
	-webkit-animation: uil-default-anim 1s linear infinite;animation: uil-default-anim 1s linear infinite;-webkit-animation-delay: -0.08333333333333331s;animation-delay: -0.08333333333333331s;
}
.uil-default-css {
	position: relative;background:none;width:200px;height:200px;
}
.uil-default-css > div:nth-of-type(7){
	-webkit-animation: uil-default-anim 1s linear infinite;animation: uil-default-anim 1s linear infinite;-webkit-animation-delay: 0s;animation-delay: 0s;
}
.uil-default-css {
	position: relative;background:none;width:200px;height:200px;
}
.uil-default-css > div:nth-of-type(8){
	-webkit-animation: uil-default-anim 1s linear infinite;animation: uil-default-anim 1s linear infinite;-webkit-animation-delay: 0.08333333333333337s;animation-delay: 0.08333333333333337s;
}
.uil-default-css {
	position: relative;background:none;width:200px;height:200px;
}
.uil-default-css > div:nth-of-type(9){
	-webkit-animation: uil-default-anim 1s linear infinite;animation: uil-default-anim 1s linear infinite;-webkit-animation-delay: 0.16666666666666663s;animation-delay: 0.16666666666666663s;
}
.uil-default-css { 
	position: relative;background:none;width:200px;height:200px;
}
.uil-default-css > div:nth-of-type(10){
	-webkit-animation: uil-default-anim 1s linear infinite;animation: uil-default-anim 1s linear infinite;-webkit-animation-delay: 0.25s;animation-delay: 0.25s;
}
.uil-default-css { 
	position: relative;background:none;width:200px;height:200px;
}
.uil-default-css > div:nth-of-type(11){
	-webkit-animation: uil-default-anim 1s linear infinite;animation: uil-default-anim 1s linear infinite;-webkit-animation-delay: 0.33333333333333337s;animation-delay: 0.33333333333333337s;
}
.uil-default-css {
	position: relative;background:none;width:200px;height:200px;
}
.uil-default-css > div:nth-of-type(12){
	-webkit-animation: uil-default-anim 1s linear infinite;animation: uil-default-anim 1s linear infinite;-webkit-animation-delay: 0.41666666666666663s;animation-delay: 0.41666666666666663s;
	}
.uil-default-css {
	position: relative;background:none;width:200px;height:200px;
}
</style>
<style>
	@media(max-width:767px) {
		.cat-select .box-sec {
			margin-top:10px;
		}
	}
</style>