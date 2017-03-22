<?php
verificar($_SESSION['nickname'], $_SESSION['password'], array('admin','vendedor','user'), $dbConn, $index_web, $url_web);

if(isset($_POST['submit']) && $_POST['submit']!="") {
	//falta archivo connect a la DB y archvio de FUNCIONES(bbcode)
	
	$img=array();
	// definimos las variables
	if ( !empty($_POST['descripcion']) ) 		$descripcion 		= secure_input(BBcode($_POST['descripcion']));
	if ( !empty($_POST['tamaño']) ) 			$tamaño 			= secure_input($_POST['tamaño']);
	if ( !empty($_POST['castrado']) ) 			$castrado 			= secure_input($_POST['castrado']);
	if ( !empty($_POST['edad']) ) 				$edad	 			= secure_input($_POST['edad']);
	if ( !empty($_FILES['img1']['name']) ) 		$img[1]['name']		= mysqli_real_escape_string($dbConn, $_FILES['img1']['name']);
	if ( !empty($_FILES['img2']['name']) ) 		$img[2]['name']		= mysqli_real_escape_string($dbConn, $_FILES['img2']['name']);
	if ( !empty($_FILES['img3']['name']) ) 		$img[3]['name']		= mysqli_real_escape_string($dbConn, $_FILES['img3']['name']);
	if ( !empty($_FILES['img4']['name']) ) 		$img[4]['name']		= mysqli_real_escape_string($dbConn, $_FILES['img4']['name']);
	if ( !empty($_FILES['img5']['name']) ) 		$img[5]['name']		= mysqli_real_escape_string($dbConn, $_FILES['img5']['name']);
	if ( !empty($_FILES['img6']['name']) ) 		$img[6]['name']		= mysqli_real_escape_string($dbConn, $_FILES['img6']['name']);

	// completamos la variable error si es necesario
	if ( empty($descripcion) ) 					$error['descripcion']	= 'Es obligatorio completar éste campo';
	if ( empty($tamaño) ) 						$error['tamaño']		= 'Es obligatorio especificar un tamaño aproximado';
	if ( strlen($_POST['descripcion'])>601 )	$error['descripcion']	= 'La descripción no puede contener más de 600 caracteres ('.strlen($_POST['descripcion']).')';
	if ( empty($castrado) ) 					$error['castrado']		= 'Es obligatorio indicar si la mascota está castrada';
	if ( empty($edad) ) 						$error['edad']			= 'Es obligatorio indicar un rango aproximado de edad';
	if ( !in_array($tamaño,array("no lo sé","muy pequeño","pequeño","normal","grande","muy grande")) )
												$error['tamaño']		= 'Es obligatorio especificar un tamaño aproximado';
	if ( !in_array($castrado,array("no lo sé","si","no")) )
												$error['castrado']		= 'Es obligatorio indicar si la mascota está castrada';
	if ( !in_array($edad,array("no lo sé","1","1-3","4-6","7-9","+10")) )
												$error['edad']			= 'Es obligatorio indicar un rango aproximado de edad';
	if ( count($img)<1 )						$error['img'][0]		= 'Debe subir aunque sea 1 imagen';
												
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

	// si no hay errores registramos el articulo
	if ( empty($error) ) {
		// inserto los datos de registro en la db
		$fCreacion = date("Y-m-d H:i:s");
		$fCreacionUsuario = $_SESSION['id'];

		$fModificacion = date("Y-m-d H:i:s");
		$fModificacionUsuario = $_SESSION['id'];
		
		//titulo random para las mascotas
		$random_titles=array("Adopción de mascota", "Mascota en adopción", "Ayudalo, te necesita", "Necesito un hogar", "Sólo necesito que me quieras", "Compartamos nuestro amor", "Agranda tu familia, adóptame", "No compres, adopta", "Hacelo tu compañero");
		$random_title=$random_titles[mt_rand(0,count($random_titles)-1)];
		
		//agregar upload de imágenes
		$image_uploaded="";
		foreach($img as $key => $values) {
			if($values['file_type']=="image/jpeg") {$extension="jpg";$calidad_img=85;}
			elseif($values['file_type']=="image/png") {$extension="png";$calidad_img=3;}
			else redireccionar("/ayuda_mascotas", $url_web);
			
			if($key!=1)
				$image_uploaded = $image_uploaded.";".upload_img($values["tmp_name"],$values["name"],"guardar","hd",$calidad_img,"$base_url_web/uploads/img/mascotas/",$extension,"linux");
			if($key==1)
				$image_uploaded = upload_img($values["tmp_name"],$values["name"],"guardar","hd",$calidad_img,"$base_url_web/uploads/img/mascotas/",$extension,"linux");
		}

		if(!$error) {
			$adicionales=$tamaño.";;".$castrado.";;".$edad;
			
			$query  = "INSERT INTO `articulos_mascotas` 
			(`id_user`,`imagenes`,`titulo`,`descripcion`,`adicionales`,
			`fModificacionUsuario`,`fModificacion`,`fCreacionUsuario`,`fCreacion`) VALUES 
			('$fCreacionUsuario','$image_uploaded','$random_title','$descripcion','$adicionales',
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

			redireccionar("/mascotas/$id_back/", $url_web); //me falta agregarle el ID al que lo redirecciona

			mysqli_close($dbConn);
		}
	}
		
}//isset submit

?>

<form action="" method="post" enctype="multipart/form-data">
<section class="site" data-site="publish_pets">
	<div class="container">
		<div class="row">
			<div class="col-sm-12 tel">
				<div class="t1">0800 999 333</div>
				<div class="t12">¿Necesitás ayuda? <br> Llamanos.</div>
			</div>
		</div>

			<div class="item">
				<div class="row">
					<div class="col-sm-12">
						<div class="big-title">Donar mascota</div>
						<div class="section-title">Imágenes de la mascota</div>
						<div class="space-height" style="height: 30px;"></div>
					</div>
					
					<?php $var_form_web='img'; ?>
					<?php if($error['img']) { foreach ($error['img'] as $key => $value) { ?>
					<div class="form-group has-error has-feedback">
						<div class="col-md-12">
	                            <?php //='<span class="glyphicon glyphicon-remove form-control-feedback"></span>'?>
						    	<?='<label class="control-label">'.$value.'</label>'?>
                        </div>
                    </div>
                    <?php } }//if img ?>
					
					<div class="form-group">
						<div class="col-md-12 box-upload">
	                        <div class="col-md-2">
	                        	<label for="img1" class="img-box-upload">
							        <div><img style="max-width:140px;max-height:141px;" id="img1-response" src="" /></div>
							    </label>
	                            <input type="file" id="img1" name="img1" accept="image/jpeg, image/png" onchange="readURL(this);" />
	                        </div>
	                        
	                        <div class="col-md-2">
	                        	<label for="img2" class="img-box-upload">
							        <div><img style="max-width:140px;max-height:141px;" id="img2-response" src="" /></div>
							    </label>
	                            <input type="file" id="img2" name="img2" accept="image/jpeg, image/png" onchange="readURL(this);" />
	                        </div>
	                        
	                        <div class="col-md-2">
	                        	<label for="img3" class="img-box-upload">
							        <div><img style="max-width:140px;max-height:141px;" id="img3-response" src="" /></div>
							    </label>
	                            <input type="file" id="img3" name="img3" value="img3" accept="image/jpeg, image/png" onchange="readURL(this);" />
	                        </div>
	                        
	                        <div class="col-md-2">
	                        	<label for="img4" class="img-box-upload">
							        <div><img style="max-width:140px;max-height:141px;" id="img4-response" src="" /></div>
							    </label>
	                            <input type="file" id="img4" name="img4" value="img4" accept="image/jpeg, image/png" onchange="readURL(this);" />
	                        </div>
	                        
	                        <div class="col-md-2">
	                        	<label for="img5" class="img-box-upload">
							        <div><img style="max-width:140px;max-height:141px;" id="img5-response" src="" /></div>
							    </label>
	                            <input type="file" id="img5" name="img5" value="img5" accept="image/jpeg, image/png" onchange="readURL(this);" />
	                        </div>
	                        
	                        <div class="col-md-2">
	                        	<label for="img6" class="img-box-upload">
							        <div><img style="max-width:140px;max-height:141px;" id="img6-response" src="" /></div>
							    </label>
	                            <input type="file" id="img6" name="img6" value="img6" accept="image/jpeg, image/png" onchange="readURL(this);" />
	                        </div>
	                        
	                        
	                    </div>

                        <div class="small-text">* Por lo menos 1, y deben medir igual o superior a 560x420 pixeles.</div>
                        <div class="space-height" style="height: 30px;"></div>
                    </div>
					<?php unset($var_form_web); ?>
					
					<div class="col-md-12 divisor"></div>
					
					<?php $var_form_web='descripcion'; ?>
					<div class="form-group<?php if (!empty($error[$var_form_web])) echo " has-error has-feedback"; ?>">
						<div class="col-md-2"></div>
					    <label class="col-md-2 control-label">Descripción</label>
					    <div class="col-md-6">
					        <textarea name="<?=$var_form_web?>" class="form-control" maxlength="500" rows="8" placeholder="Es lindo, sensible, y no rompe los muebles, aprovechen esta oportunidad. (máximo 500 caracteres)" required="required"><?=$_POST[$var_form_web]?></textarea>
					        <?php //if (!empty($error[$var_form_web])) echo '<span class="glyphicon glyphicon-remove form-control-feedback"></span>'; ?>
					    	<?php if (!empty($error[$var_form_web])) { echo('<label class="control-label">'.$error[$var_form_web].'</label>'); } ?>
					    </div>
					    <div class="col-md-2"></div>
					</div>
					<?php unset($var_form_web); ?>
					
					<div class="col-md-12 divisor"></div>
					
					<div class="col-md-4">
						<?php $var_form_web='tamaño'; ?>
						<div class="form-group<?php if (!empty($error[$var_form_web])) echo " has-error has-feedback"; ?>">
						    <label class="col-md-4 control-label">Tamaño</label>
						    <div class="col-md-8">
						        <select class="form-control select" name="<?=$var_form_web?>" required="required">
						        	<option value="" disabled="disabled" selected="selected" hidden="hidden">Seleccionar</option>
                                    <option value="no lo sé"<?=($_POST[$var_form_web]=="no lo sé")?" selected=\"selected\"":""?>>no lo sé</option>
                                    <option value="muy pequeño"<?=($_POST[$var_form_web]=="muy pequeño")?" selected=\"selected\"":""?>>muy pequeño</option>
                                    <option value="pequeño"<?=($_POST[$var_form_web]=="pequeño")?" selected=\"selected\"":""?>>pequeño</option>
                                    <option value="normal"<?=($_POST[$var_form_web]=="normal")?" selected=\"selected\"":""?>>normal</option>
                                    <option value="grande"<?=($_POST[$var_form_web]=="grande")?" selected=\"selected\"":""?>>grande</option>
                                    <option value="muy grande"<?=($_POST[$var_form_web]=="muy grande")?" selected=\"selected\"":""?>>muy grande</option>
                                </select>
						        <?php //if (!empty($error[$var_form_web])) echo '<span class="glyphicon glyphicon-remove form-control-feedback"></span>'; ?>
						    	<?php if (!empty($error[$var_form_web])) { echo('<label class="control-label">'.$error[$var_form_web].'</label>'); } ?>
						    </div>
						</div>
						<?php unset($var_form_web); ?>
					</div>
					
					<div class="col-md-4">
						<?php $var_form_web='castrado'; ?>
						<div class="form-group<?php if (!empty($error[$var_form_web])) echo " has-error has-feedback"; ?>">
						    <label class="col-md-4 control-label">Castrado</label>
						    <div class="col-md-8">
						        <select class="form-control select" name="<?=$var_form_web?>" required="required">
						        	<option value="" disabled="disabled" selected="selected" hidden="hidden">Seleccionar</option>
                                    <option value="no lo sé"<?=($_POST[$var_form_web]=="no lo sé")?" selected=\"selected\"":""?>>no lo sé</option>
                                    <option value="si"<?=($_POST[$var_form_web]=="si")?" selected=\"selected\"":""?>>si</option>
                                    <option value="no"<?=($_POST[$var_form_web]=="no")?" selected=\"selected\"":""?>>no</option>
                                </select>
						        <?php //if (!empty($error[$var_form_web])) echo '<span class="glyphicon glyphicon-remove form-control-feedback"></span>'; ?>
						    	<?php if (!empty($error[$var_form_web])) { echo('<label class="control-label">'.$error[$var_form_web].'</label>'); } ?>
						    </div>
						</div>
						<?php unset($var_form_web); ?>
					</div>
					
					<div class="col-md-4">
						<?php $var_form_web='edad'; ?>
						<div class="form-group<?php if (!empty($error[$var_form_web])) echo " has-error has-feedback"; ?>">
						    <label class="col-md-4 control-label">Edad</label>
						    <div class="col-md-8">
						         <select class="form-control select" name="<?=$var_form_web?>" required="required">
						         	<option value="" disabled="disabled" selected="selected" hidden="hidden">Seleccionar</option>
                                    <option value="no lo sé"<?=($_POST[$var_form_web]=="no lo sé")?" selected=\"selected\"":""?>>no lo sé</option>
                                    <option value="1"<?=($_POST[$var_form_web]=="1")?" selected=\"selected\"":""?>>12 meses o menos</option>
                                    <option value="1-3"<?=($_POST[$var_form_web]=="1-3")?" selected=\"selected\"":""?>>1-3</option>
                                    <option value="4-6"<?=($_POST[$var_form_web]=="4-6")?" selected=\"selected\"":""?>>4-6</option>
                                    <option value="7-9"<?=($_POST[$var_form_web]=="7-9")?" selected=\"selected\"":""?>>7-9</option>
                                    <option value="+10"<?=($_POST[$var_form_web]=="+10")?" selected=\"selected\"":""?>>+10</option>
                                </select>
						        <?php //if (!empty($error[$var_form_web])) echo '<span class="glyphicon glyphicon-remove form-control-feedback"></span>'; ?>
						    	<?php if (!empty($error[$var_form_web])) { echo('<label class="control-label">'.$error[$var_form_web].'</label>'); } ?>
						    </div>
						</div>
						<?php unset($var_form_web); ?>
					</div>
					
					
					
					
				</div>
				
				

				

				<div class="publish-tos">El uso de este sitio implica la aceptació de los <a href="#">Términos y Condiciones</a> y las <a href="#">Políticas de Privacidad</a> de Tarjetealo.</div>
				
				<div style="padding-left:42%;"><input type="submit" class="button-continue can-continue" name="submit" value="Continuar"></input></div>

			</div>

	</div>
</section>
</form>