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

if( !is_numeric($_SESSION['text'][1]) or !is_numeric($_SESSION['text'][2]) ) {
	$_SESSION['text'][1]=mt_rand(0,10);
	$_SESSION['text'][2]=mt_rand(0,10);
}

if($_POST['email']!="") {
	if(!isset($_SESSION['intentos_boosting'])) $_SESSION['intentos_boosting']=1;
	if($_SESSION['intentos_boosting']<=100) {$_SESSION['intentos_boosting']++;$_SESSION['time_boosting']=time();}
	if($_SESSION['intentos_boosting']>100) {
		$time_now=time()-$_SESSION['time_boosting'];
		if($time_now>60) unset($_SESSION['intentos_boosting']);
		exit(0);die(0);
	}
	
	$email = secure_input($_POST['email']);
	$txt_rand = secure_input($_POST['txt_rand']);
	
	$resultado_rand_txt=$_SESSION['text'][1]+$_SESSION['text'][2];
	
	if($txt_rand!=$resultado_rand_txt) $error['txt_rand']="La sumatoria es incorrecta";

	$query = "SELECT id,email,tipocat FROM `usuarios` WHERE email='$email' LIMIT 1";
	$resultado = mysqli_query($dbConn, $query);
	$test = mysqli_fetch_assoc($resultado);
	
	if( empty($test['email']) ){
		$error['email']="El e-mail especificado no existe.";
	} else {
		if( $test['tipocat']!="activo" ) $error['email'] = "La cuenta no se encuentra activada. Revise su casilla de email e ingrese al link de activación.";
	}
	
	if(!$error) {
		$_SESSION['text'][1]="";
		$_SESSION['text'][2]="";
		
		$random_pw = substr(md5(uniqid(rand())),0,6);
		$salt = 'Orange6f7cead48bd13a0cBlack0d61eb8a3502c68cacec32caYellow';
		$password = sha1($salt.$random_pw);
		
		$to=$email;
		
		$query  = "UPDATE `usuarios` set password = '$password' WHERE id = $test[id]"; 
		$result = mysqli_query($dbConn, $query);
		mysqli_close($dbConn);

		if($result) { 
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
			<div class="title">¡Tu cuenta ha sido <span>restaurada!</span> </div>
			<div class="div"> </div>
			<div class="text">Tu nueva contraseña ahora es:</div>
			<br/><br/>
			<div class="fix-a">'.$random_pw.'</div>
			<br/><br/>
			<div class="div"> </div>
			<div class="text2">
				Para cambiar la contraseña lo único que resta es iniciar sesión con tu nueva contraseña, e ingresar al panel de control, dirigirse abajo a la izquierda en 
				el menú, ingresar a <span>datos personales</span> y cambiar la contraseña.
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
			
			$subject = 'Tarjetealo.com ## Pedido de contraseña nueva';
			
			$mail = mail($to,$subject,$message,$headers);
			if(!$mail) $error['email']="Hubo un error restaurando su contraseña. Contáctese con el Adminsitrador.";
			else $reg_step=1;
		}
		else $error['email']="Hubo un error restaurando su contraseña. Contáctese con el Adminsitrador.";
	}
}
?>

<?php if($reg_step<1 or !isset($reg_step)) { ?>
<section class="site signup" data-site="signup">
	<div class="container">
		<div class="row">
			<div class="signup-form col-md-6 col-md-offset-3 col-sm-10 col-sm-offset-1 col-xs-10 col-xs-offset-1">
				<div class="col-sm-8 col-sm-offset-4 title">Registrate</div>
				<form class="form-horizontal" role="form" method="POST" action="">
					
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
							<?php if (!empty($error['email'])) echo '<span class="glyphicon glyphicon-remove form-control-feedback"></span>'; ?>
		    				<?php if (!empty($error['email'])) { echo('<label class="control-label">'.$error['email'].'</label>'); } ?>
						</div>
					</div>
					
					<div class="form-group">
						<label class="control-label col-sm-4" for="tel">Cuánto es <?=$_SESSION['text'][1]?> + <?=$_SESSION['text'][2]?>?</label>
						<div class="col-sm-8"> 
							<input
								type="number"
								name="txt_rand"
								id="txt_rand"
								placeholder="12"
								class="form-control"
								pattern="[0-9 ][0-9 ]{1,2}"
								title="ej. 10 (máximo 2 caracteres)"
								value="<?=isset($_POST['txt_rand']) ? $_POST['txt_rand'] : ""?>"
								required />
							<?php if (!empty($error['txt_rand'])) echo '<span class="glyphicon glyphicon-remove form-control-feedback"></span>'; ?>
		    				<?php if (!empty($error['txt_rand'])) { echo('<label class="control-label">'.$error['txt_rand'].'</label>'); } ?>
						</div>
					</div>

					<div class="form-group"> 
						<div class="col-sm-offset-4 col-sm-8">
							<button type="submit" name="submit" class="btn btn-default" value="submit">Enviar</button>
							<div class="accept">
								Su contraseña se reiniciará al enviar el formulario.
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
						¡Gracias por <span>restaurar su contraseña!</span>
					</div>
				</div>
				
				<div class="col-md-12 col-xs-12">
					<div class="separator"></div>
				</div>
				
				<div class="col-md-12 col-xs-12">
					<div class="text">
						Revisá tu casilla de correo. Te enviamos un e-mail para terminar de restaurar tu cuenta. ¡Queda solo un paso más!
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