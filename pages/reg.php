<?php
if(isset($_SESSION['nickname'])) {
	redireccionar("/inicio",$url_web);
}

$arrCiudades = array();
$query = "SELECT id,id_provincia,nombre FROM `provincias_ciudades` WHERE id_orden!='1234567890' ORDER BY nombre ASC";
$resultado = mysqli_query($dbConn, $query);
while ( $row = mysqli_fetch_assoc($resultado)) {
	array_push( $arrCiudades,$row );
} unset($row,$query,$resultado);

if($_GET['confirm_mail']=="true_confirm") {
	$codigo_confirm = mysqli_real_escape_string($dbConn, $_GET['code']);
	$email = mysqli_real_escape_string($dbConn, $_GET['email']);
	
	
	$query = "SELECT id,email,tipocat FROM `usuarios` WHERE tipocat = '$codigo_confirm' AND email='$email' LIMIT 1";
	$resultado = mysqli_query($dbConn, $query);
	$test = mysqli_fetch_assoc($resultado);
	//chequeo que el tipocat sea menor a fecha de hoy, convirtiendo, eso lo pongo despues
	if($test['tipocat']==$codigo_confirm && $test['email']==$email) {
		$query  = "UPDATE `usuarios` set tipocat = 'activo' WHERE id = $test[id]"; 
		$result = mysqli_query($dbConn, $query);
		mysqli_close($dbConn);

		$reg_step=2;//echo "Registro completado!! Aca iria un mensaje lindo y atractivo para luego redirect. Lex?";die(0);//redireccionar("/usuario?section={$_GET['section']}&cat={$_GET['cat']}&edit=true", $url_web);
	}
	else {
		$reg_step=3;
	}
}

//chekeo la cantidad de veces que se envió el formulario para prevenir spam Y TAMBIEN TENGO QUE LINKEAR UNA BASE DE DATOS CON EL IP Y LAS TRANSACCIONES PARA PREVENIR SPAM
if(!isset($_SESSION['check_regtimes'])) {
	$_SESSION['check_regtimes']=0;
} else {
	if($_SESSION['check_regtimes']>10) {
		//exit;die;
		//acá tendría que haber algún tipo de activación para prevenir spam y no ésto.
	} else {
		$_SESSION['check_regtimes']++;	
	}
}

// si se envio el formulario
if ( !empty($_POST['submit']) ) {
	if(!isset($_SESSION['intentos_boosting'])) $_SESSION['intentos_boosting']=1;
	if($_SESSION['intentos_boosting']<=100) {$_SESSION['intentos_boosting']++;$_SESSION['time_boosting']=time();}
	if($_SESSION['intentos_boosting']>100) {
		$time_now=time()-$_SESSION['time_boosting'];
		if($time_now>60) unset($_SESSION['intentos_boosting']);
		exit(0);die(0);
	}
	
	// definimos las variables
	if ( !empty($_POST['nickname']) ) 			$nickname 			= mysqli_real_escape_string($dbConn, $_POST['nickname']);
	if ( !empty($_POST['firstname']) ) 			$firstname 			= mysqli_real_escape_string($dbConn, $_POST['firstname']);
	if ( !empty($_POST['lastname']) ) 			$lastname 			= mysqli_real_escape_string($dbConn, $_POST['lastname']);
	if ( !empty($_POST['email']) ) 				$email	 			= mysqli_real_escape_string($dbConn, $_POST['email']);
	if ( !empty($_POST['cel']) ) 				$cel	 			= mysqli_real_escape_string($dbConn, $_POST['cel']);
	if ( !empty($_POST['ciudad']) ) 			$ciudad 			= mysqli_real_escape_string($dbConn, $_POST['ciudad']);
	if ( !empty($_POST['password']) ) 			$password 			= mysqli_real_escape_string($dbConn, $_POST['password']);
	if ( !empty($_POST['repassword']) ) 		$repassword 		= mysqli_real_escape_string($dbConn, $_POST['repassword']);

	// completamos la variable error si es necesario
	if ( empty($nickname) ) 					$error['nickname']		= 'Es obligatorio completar éste campo';
	if ( empty($firstname) ) 					$error['firstname']		= 'Es obligatorio completar éste campo';
	if ( strlen($firstname)>100 )				$error['firstname']		= 'El/Los nombre(s) no puede contener mas de 100 caracteres';
	if ( empty($lastname) ) 					$error['lastname']		= 'Es obligatorio completar éste campo';
	if ( strlen($lastname)>150 )				$error['lastname']		= 'El/Los apellido(s) no puede contener mas de 150 caracteres';
	if ( empty($email) ) 						$error['email']			= 'Es obligatorio completar éste campo';
	if ( strlen($email)>70 )					$error['email']			= 'El E-Mail no puede contener mas de 70 caracteres';
	if ( empty($cel) ) 							$error['cel']			= 'Es obligatorio completar éste campo';
	if ( strlen($cel)>50 )						$error['cel']			= 'El número de telefono no puede contener mas de 50 caracteres';
	if ( !is_numeric($ciudad))  				$error['ciudad']		= 'Debes seleccionar alguna ciudad';
	if ( empty($password) ) 					$error['password']		= 'Es obligatorio completar éste campo';
	if ( strlen($password)<6 || strlen($password)>30 )
												$error['password']		= 'La contraseña no puede contener menos de 6 y mas de 30 caracteres';
	if ( $password!=$repassword )				$error['repassword']	= 'Las contraseñas no coinciden';
	
	//checking nickname 
	if(isset($nickname)) {
		$query = "SELECT id,nickname,email FROM `usuarios` WHERE nickname = '$nickname' LIMIT 1";
		$resultado = mysqli_query($dbConn, $query);
		$test = mysqli_fetch_assoc($resultado);
		if($test['nickname'])		$error['nickname']	=	'El nombre de usuario que intenta utilizar ya está ocupado';
		
		//consultamos espacios
		if(preg_match('/\s/',$foo)>0)$error['nickname']	=	'El nombre de usuario no puede contener tener espacios';
		
		//palabras prohibidas
		$palabras_ofensivas = array("puto","forro","puta","forra","admin","administrador","tarjetealo","tarjeta","tarjeteala",".com",".ar");
		foreach ($palabras_ofensivas as $palabras) {
		    if (strpos($nickname, $palabras) !== FALSE) 
		        					$error['nickname']	=	'El nombre de usuario no puede contener "'.$palabras.'", borre o modifique la palabra';
		}
		
		//largo del string
		if(strlen($nickname)<6 || strlen($nickname)>30)
		        					$error['nickname']	=	'El nombre de usuario no puede tener menos de 6 caracteres o más de 30';
									
	}
	
	//checking si el mail ya se registró
	if(isset($email)) {
		$query = "SELECT id,nickname,email FROM `usuarios` WHERE email = '$email' LIMIT 1";
		$resultado = mysqli_query($dbConn, $query);
		$test = mysqli_fetch_assoc($resultado);
		if($test['email']) 			$error['email']		=	'El E-Mail que intenta utilizar ya está registrado';
	}

	//le asigno provincia a la ciudad
	foreach ($arrCiudades as $key => $value) {
		if ( isset($ciudad) && $value['id']==$ciudad) $provincia = $value["id_provincia"];
	} unset($key,$value);
	if ( !is_numeric($provincia) ) $error['provincia'] = "Error seleccionando la ciudad. Reintente.";

	// si no hay errores registramos el articulo
	if ( empty($error) ) {
		// inserto los datos de registro en la db
		$fCreacion = date("Y-m-d H:i:s");
		$fCreacionUsuario = $nickname;

		$fModificacion = date("Y-m-d H:i:s");
		$fModificacionUsuario = $nickname;

		$fullname = $firstname." ".$lastname;
		$salt = 'Orange6f7cead48bd13a0cBlack0d61eb8a3502c68cacec32caYellow';
		$password = sha1($salt.$password);
		
		//creo fecha de expiración para el link de REG
		// Consulto ultima publicacion
		$fecha_expiracion=date('Y-m-d H:i:s', strtotime("+2 days"));
		$fecha=date_to_time($fecha_expiracion);

		if(!$error) {
			$query  = "INSERT INTO `usuarios` (nickname,fullname,email,cel,password,prov,ciudad,
			fModificacionUsuario,fModificacion,fCreacionUsuario,fCreacion,tipocat) VALUES 
			('$nickname','$fullname','$email','$cel','$password','$provincia','$ciudad',
			'$fModificacionUsuario','$fModificacion','$fCreacionUsuario','$fCreacion','$fecha')";
			$result = mysqli_query($dbConn, $query);
			mysqli_close();
			
			$to = "$email";
			$subject = "tarjetealo.com.ar ## Bienvenido usuario!";
			
			/*$message = "
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
			";*/
			
			$message='
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<style>
		* {
			font-family:"Open Sans";
			color: #424242;
			font-size:16px;
			text-align:left;
		}
		.content {
			margin:auto;
			max-width:600px;
			max-height:900px;
			background-color:#FFFFFF;
			border:1px solid #9E9E9E;
		}
		.content .first {
			padding:15px;
			background-color:#FF1744;
			height:50px;
		}
		.content .first .bonus1 {
			float:left;
			max-height:40px;
		}
		.content .first .bonus2 {
			max-height: 120px;
			float: right;
		}
		.content .second {
			padding:15px;
		}
		.content .second .title {
			font-weight:bold;
			font-size:35px;
		}
		.content .second .title span {
			color:#FFA726;
			font-weight:bold;
			font-size:35px;
		}
		.content .second .div {
			border-top:1px solid #9E9E9E;
			height:1px;
			width:100%;
			margin-top:30px;
			margin-bottom:30px;
		}
		.content .second .text2 {
			font-size:14px;
		}
		.content .second .fix-a {
			margin:auto;
			align-content:center;
			text-align:center;
		}
		.content .second .link {
			margin:auto;
			text-align:center;
			color:#FAFAFA;
			border: 1px solid #FF1744;
    		border-radius: 5px;
    		-moz-border-radius: 5px;
    		-webkit-border-radius: 5px;
    		background-color:#FF1744;
    		padding:5px;
    		text-decoration:none;
    		font-weight:bold;
		}
		.content .second a:hover { 
			color:#E8E8E8;
		}
		.content .second .text2 span a {
			color:#FF1744;
		}
	</style>
</head>
<body>
	<div class="content">
		<div class="first">
			<img class="bonus1" src="http://tarjetealo.com/basic/img/logo_av.png" /> <img class="bonus2" src="http://tarjetealo.com/basic/img/tarjeta_bolsa.png" />
		</div>
		<div class="second">
			<div class="title">¡Gracias por <span>Registrarte!</span> </div>
			<div class="div"> </div>
			<div class="text">Para veriﬁcar tu casilla de correo, activar y usar tu cuenta, sólo clickeá en el siguiente botón.</div>
			<br/><br/>
			<div class="fix-a"><a href="http://'.$url_web.'/registrarse?confirm_mail=true_confirm&code='.$fecha.'&email='.$email.'" class="link">¡ACTIVAR SUPERPODERES!</a></div>
			<br/><br/>
			<div class="div"> </div>
			<div class="text2">
				Si no funciona, copia y pega el siguiente enlace en tu navegador. Este link expirará el '.$fecha_expiracion.' (UTC-03:00 ARG).:<br/><br/>
				<span>http://'.$url_web.'/registrarse?confirm_mail=true_confirm&code='.$fecha.'&email='.$email.'</span><br/>
			</div>
			<div class="div"> </div>
			<div class="text2">
				Por cualquier inconveniente comunicate con<br/>
				<span>soporte@tarjetealo.com</span>
			</div>
		</div>
	</div>
</body>
</html>
';
			
			// Always set content-type when sending HTML email
			$headers = "MIME-Version: 1.0" . "\r\n";
			$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
			
			// More headers
			$headers .= 'From: Tarjetealo.com.ar <no-reply@tarjetealo.com.ar>' . "\r\n";
			$headers .= 'Reply-to: Tarjetealo.com.ar <info@tarjetealo.com.ar>' . "\r\n";
			
			$mail = mail($to,$subject,$message,$headers);

			if(isset($result) && $mail) $reg_step=1; else $reg_error=true;
			//redireccionar("/registrarse", $url_web); si hace falta, redireccionamo
		}
	}
		
}

?>

<?php if($reg_step<1 or !isset($reg_step)) { ?>
<?php if(isset($reg_error)) echo "ERROR_REG_QUERY: Contáctese con el administrador."; if(isset($error)) foreach ($error as $key => $value) {
	echo "Error: $value<br/>";
} ?>
<section class="site signup" data-site="signup">
	<div class="container">
		<div class="row">
			<div class="signup-form col-md-6 col-md-offset-3 col-sm-10 col-sm-offset-1 col-xs-10 col-xs-offset-1">
				<div class="col-sm-8 col-sm-offset-4 title">Registrate</div>
				<form class="form-horizontal" role="form" method="POST" action="">
					<div class="form-group">
						<label class="control-label col-sm-4" for="name">Usuario</label>
						<div class="col-sm-8">
							<input
								type="text"
								name="nickname"
								id="nickname"
								placeholder="dani2017"
								class="form-control"
								pattern="[0-9a-zA-Z][0-9a-zA-Z]{6,30}"
								title="EL nombre de usuario solo puede tener letras y números(máximo 30 caracteres). ej. dani2017"
								value="<?=isset($_POST['nickname']) ? $_POST['nickname'] : ""?>"
								required />
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-4" for="name">Nombre(s)</label>
						<div class="col-sm-8">
							<input
								type="text"
								name="firstname"
								id="name"
								placeholder="Daniela"
								class="form-control"
								pattern="[a-zA-ZÑÁÉÍÓÚáéíóú][a-zA-Zñáéíóú ]{1,100}"
								title="El nombre solo debe contener caracteres válidos(máximo 100 caracteres). ej. Daniela"
								value="<?=isset($_POST['firstname']) ? $_POST['firstname'] : ""?>"
								required />
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-4" for="lastname">Apellido(s)</label>
						<div class="col-sm-8"> 
							<input
								type="text"
								name="lastname"
								id="lastname"
								placeholder="Rodriguez"
								class="form-control"
								pattern="[a-zA-ZÑÁÉÍÓÚáéíóú][a-zA-Zñáéíóú ]{1,150}"
								title="El apellido solo debe contener caracteres válidos(máximo 150 caracteres). ej. Rodriguez"
								value="<?=isset($_POST['lastname']) ? $_POST['lastname'] : ""?>"
								required />
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-4" for="email">E-mail</label>
						<div class="col-sm-8"> 
							<input
								type="email"
								name="email"
								id="email"
								placeholder="ejemplo@dominio.com"
								class="form-control"
								patter="{1,70}"
								title="ej. ejemplo@dominio.com (máximo 70 caracteres)"
								value="<?=isset($_POST['email']) ? $_POST['email'] : ""?>"
								required />
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-4" for="tel">Celular</label>
						<div class="col-sm-8"> 
							<input
								type="tel"
								name="cel"
								id="tel"
								placeholder="297 7894565"
								class="form-control"
								pattern="[0-9 ][0-9 ]{1,50}"
								title="ej. 111234567 (máximo 50 caracteres)"
								value="<?=isset($_POST['cel']) ? $_POST['cel'] : ""?>"
								required />
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-4" for="ciudad">Ciudad</label>
						<div class="col-sm-8"> 
							<select class="form-control select" name="ciudad" required="required">
						        <option value="" disabled="disabled" selected="selected" hidden="hidden">Buscar</option>
						        <?php foreach ($arrCiudades as $key => $value) { ?>
						        <option value="<?=$value['id']?>"<?=($_POST['ciudad']==$value['id'])?" selected=\"selected\"":""?>><?=$value['nombre']?></option>
						        <?php } ?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-4" for="password">Contraseña</label>
						<div class="col-sm-8"> 
							<input
								type="password"
								name="password"
								id="password"
								placeholder="******"
								class="form-control"
								pattern=".{6,30}"
								title="Debe ingresar al menos 6 y no más de 30 caracteres"
								value="<?=isset($_POST['password']) ? $_POST['password'] : ""?>"
								required />
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-4" for="password">Re-Contraseña</label>
						<div class="col-sm-8"> 
							<input
								type="password"
								name="repassword"
								id="repassword"
								placeholder="******"
								class="form-control"
								pattern=".{6,30}"
								title="Debe ingresar al menos 6 y no más de 30 caracteres"
								value="<?=isset($_POST['repassword']) ? $_POST['repassword'] : ""?>"
								required />
						</div>
					</div>
					<div class="form-group"> 
						<div class="col-sm-offset-4 col-sm-8">
							<button type="submit" name="submit" class="btn btn-default" value="submit">Registrarme</button>
							<div class="accept">
								Al registrarme declaro que soy mayor de edad y acepto los <a href="#" target="_blank">Términos y Condiciones</a> y las <a href="#" target="_blank">Políticas de Privacidad</a> de Tarjetealo.
							</div>
						</div>
					</div>
				</form>

			</div>
		</div>
	</div>
</section>
<?php } elseif($reg_step==1) { ?>
<section class="site signup confirm" data-site="confirm">
	<div class="container">
		<div class="row">
			<div class="float">
				<div class="col-md-12 col-xs-12">
					<div class="title">
						¡Gracias por <span>Registrarte!</span>
					</div>
				</div>
				
				<div class="col-md-12 col-xs-12">
					<div class="separator"></div>
				</div>
				
				<div class="col-md-12 col-xs-12">
					<div class="text">
						Revisá tu casilla de correo. Te enviamos un e-mail para terminar de activar tu cuenta. ¡Queda solo un paso más!
					</div>
				</div>
				
				<div class="col-md-12 col-xs-12">
					<div class="space"></div>
				</div>
				
				<div class="col-md-12 col-xs-12">
					<div class="col-md-6 col-xs-6">
						<div class="boton br-5">
							<a href="<?="//".$url_web."/"?>full">VOLVER AL INICIO</a>
						</div>
					</div>
					
					
					<div class="col-md-6 col-xs-6">
						<div class="bolsa"><img src="//<?=$url_web?>/img/tarjeta_bolsa.png" /></div>
					</div>
				</div>
				
			</div>
		</div>
	</div>
</section>
<?php } elseif($reg_step==2 or $reg_step==3) { ?>
<section class="site signup confirm" data-site="confirm">
	<div class="container">
		<div class="row">
			<div class="float">
				<div class="col-md-12 col-xs-12">
					<div class="title">
						¡Gracias por <span>Registrarte!</span>
					</div>
				</div>
				
				<div class="col-md-12 col-xs-12">
					<div class="separator"></div>
				</div>
				
				<div class="col-md-12 col-xs-12">
					<div class="text">
						Tu mail ya está confirmado y ya podes empezar a utilizar tu cuenta, solo te resta iniciar sesión. Gracias por ser parte!
					</div>
				</div>
				
				<div class="col-md-12 col-xs-12">
					<div class="space"></div>
				</div>
				
				<div class="col-md-12 col-xs-12">
					<div class="col-md-6 col-xs-6">
						<div class="boton br-5">
							<a href="<?="//".$url_web."/"?>full">VOLVER AL INICIO</a>
						</div>
					</div>
					
					
					<div class="col-md-6 col-xs-6">
						<div class="bolsa"><img src="//<?=$url_web?>/img/tarjeta_bolsa.png" /></div>
					</div>
				</div>
				
			</div>
		</div>
	</div>
</section>
<?php } ?>
