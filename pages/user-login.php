<?php
//Chequeamos si el user está conectado?
//acá función -hay que hacerla-

//Si no está conectado sigo



//FORM?
if($_POST['submit']) {
	//declaro variables
	$user	= mysqli_real_escape_string($dbConn, trim($_POST['email']));
	$pw		= mysqli_real_escape_string($dbConn, trim($_POST['pw']));
	$pw		= base64_encode($pw);
	$error=array();
	
	//errores
	if(empty($user)) $error[0] = "Falta completar el usuario.";
	if(empty($pw)) $error[1] = "Falta completar la contraseña.";
	
	
	if(empty($error)) {
		//busco al usuario y comparo num cliente
		$query = "SELECT * FROM usuarios WHERE email = '$user' AND password = '$pw' LIMIT 0,1";
		//$result = $dbConn->$query;
		$result = mysqli_query($dbConn, $query);
		
		if(!$result) $error[3] = "El nombre de usuario o contraseña son incorrectos.";
		else $row = mysqli_fetch_array($result);

		if(!$error) {
			if($row['tipo'] == "banned") {
				$error[4] = "El usuario no se encuentra habilitado. Contáctese con el administrador.";
			}
			else {
				// definimos el dia y la hora y el estado
				$date_h = date('G');
				$date_m = date('i');
				$date_s = date('s');
				//conversion a segundos totales
				$date_real1 = $date_h*3600+$date_m*60+$date_s;
				$query  = "UPDATE `usuarios` set status = 'Conectado', act_day = '".date('j/n/Y')."', act_time = '".$date_real1."' WHERE id = '".$row['id']."'";
				$result = mysqli_query($dbConn, $query);
				
				$_SESSION['id'] = $row['id'];
				$_SESSION['fullname'] = $row['fullname'];
				$_SESSION['password'] = $row['password'];
				$_SESSION['email'] = $row['email'];
				$_SESSION['sexo'] = $row['sexo'];
				$_SESSION['act_day'] = $row['act_day'];
				$_SESSION['act_time'] = $row['act_time'];
				$_SESSION['status'] = $row['status'];
				$_SESSION['tipo'] = $row['tipo'];
				$_SESSION['tipocat'] = $row['tipocat'];
				redireccionar($index_web, $url_web);
				mysqli_close();
			}
		}//empty error class2
	}//if empty error
}//post userlogin

?>


    <body>
        
        <div class="login-container">
        
            <div class="login-box animated fadeInDown">
                <!--<div class="login-logo"></div>!-->
                <?php if($_GET['login']=="true") { ?>
                <div class="login-body">
                    <div class="login-title"><strong>Iniciar sesión</strong></div>
                    <?php if($error) {foreach ($error as $values) { echo $values."<br/>"; } } ?>
                    <form action="" class="form-horizontal" method="post">
                    <div class="form-group">
                        <div class="col-md-12">
                            <input name="email" class="form-control" type="email" value="<?=$_POST['email']?>" placeholder="email@email.com" required="required" />
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-12">
                            <input name="pw" class="form-control" type="password" value="<?=$_POST['pw']?>" placeholder="Contraseña" required="required" />
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-6">
                            <a href="#" class="btn btn-link btn-block">Olvidaste tu contraseña?</a>
                        </div>
                        <div class="col-md-6">
                            <button class="btn btn-info btn-block" type="submit" name="submit" value="Enviar">Iniciar sesión</button>
                        </div>
                    </div>
                    

                    <div class="login-or">O</div>
                    <div class="form-group">
                        <div class="col-md-4">
                            <button class="btn btn-info btn-block btn-twitter"><span class="fa fa-twitter"></span> Twitter</button>
                        </div>
                        <div class="col-md-4">
                            <button class="btn btn-info btn-block btn-facebook"><span class="fa fa-facebook"></span> Facebook</button>
                        </div>
                        <div class="col-md-4">                            
                            <button class="btn btn-info btn-block btn-google"><span class="fa fa-google-plus"></span> Google</button>
                        </div>
                    </div>
                    <div class="login-subtitle">
                        Sin cuenta todavía? <a href="registrar">Podes registrarte aquí</a>
                    </div>
                    </form>
                </div>
                <?php } elseif($_GET['registro']=="true") { ?>
                	
                <div class="login-body">
                    <div class="login-title"><strong>Formulario de registro</strong></div>
                    <?php if($error) {foreach ($error as $values) { echo $values."<br/>"; } } ?>
                    <form action="" class="form-horizontal" method="post">
                    <div class="form-group">
                        <div class="col-md-12">
                            <input name="nombres" class="form-control" type="text" value="<?=$_POST['nombres']?>" placeholder="Nombre(s)" required="required" />
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <div class="col-md-12">
                            <input name="apellidos" class="form-control" type="text" value="<?=$_POST['apellidos']?>" placeholder="Apellido(s)" required="required" />
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <div class="col-md-12">
                            <input name="email" class="form-control" type="email" value="<?=$_POST['email']?>" placeholder="email@email.com" required="required" />
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <div class="col-md-12">
                            <input name="pw" class="form-control" type="password" value="<?=$_POST['pw']?>" placeholder="Contraseña" required="required" />
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <div class="col-md-12">
                            <input name="pw2" class="form-control" type="password" value="<?=$_POST['pw2']?>" placeholder="Repetir contraseña" required="required" />
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <div class="col-md-12">
                            <input name="localidad" class="form-control" type="text" value="<?=$_POST['localidad']?>" placeholder="Localidad" required="required" />
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <div class="col-md-12">
                            <input name="direccion" class="form-control" type="text" value="<?=$_POST['direccion']?>" placeholder="calle 123" required="required" />
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <div class="col-md-12">
                            <input name="facebook" class="form-control" type="text" value="<?=$_POST['facebook']?>" placeholder="Link de perfil o nombre completo en Facebook" required="required" />
                            <span style="color:#fff;">* te contactaremos por Facebook</span>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <div class="col-md-12">
                            <input name="cajero" class="form-control" type="text" value="<?=$_POST['cajero']?>" placeholder="Nombre del cajero" required="required" />
                            <span style="color:#fff;">enviando este formulario aceptas los términos y condiciones del sitio web!</span>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <div class="col-md-12">
                            <input name="email" class="form-control" type="email" value="<?=$_POST['email']?>" placeholder="email@email.com" required="required" />
                        </div>
                    </div>


                    <div class="form-group">
                        <div class="col-md-6">
                            <a href="#" class="btn btn-link btn-block">términos y condiciones</a>
                        </div>
                        <div class="col-md-6">
                            <button class="btn btn-info btn-block" type="submit" name="submitREG" value="Enviar">Enviar</button>
                        </div>
                    </div>
                    
                    </form>
                </div>
                	
                <?php }/*registro if*/ elseif($_GET['lost_pw']=="true") {}//lostpw ?>
                
                <div class="login-footer">
                    <div class="pull-left">
                        &copy; 2016 <?=$_SERVER['SERVER_NAME']?>
                    </div>
                    <div class="pull-right">
                        <a href="#">Nosotros</a> |
                        <a href="#">Privacidad</a> |
                        <a href="#">Contáctenos</a>
                    </div>
                </div>
            </div>
            
        </div>
