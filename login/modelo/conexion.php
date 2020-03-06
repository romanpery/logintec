<?php
class conexion{
		private $conexion;
		private $server = "localhost";
		private $usuario = "root";
		private $pass = "";
		private $db = "deseos";
		private $user ;
	  private $password;

		public function __construct(){
			$this->conexion = new mysqli($this->server, $this->usuario, $this->pass, $this->db);
			if($this->conexion->connect_errno){
			die("Fallo al trratar de conectar con MySQL: (". $this->conexion->connect_errno.")");
			}
		}


	public function cerrar(){
 		$this->conexion->close();
	}


	public function logeo($user, $pass){

		$this->user = $user;
		$this->password = $pass;

		$query = "select idCuenta,usuario,cargo_id from datos where usuario = '".$this->user."' and pass2 = '".$this->password."'";
		$consulta = $this->conexion->query($query);
		$row = mysqli_fetch_array($consulta);

				if($row['cargo_id'] == 1){ //administrador
				session_start();//inicia sesion
				$_SESSION['validacion'] = 1;
        $_SESSION['idCuenta']=$row['idCuenta'];
	    	$_SESSION['usuario'] = $row['usuario'];
				echo "../vista/sistema.php"; //Respuesta Mensaje donde redireccionara

			}else if($row['cargo_id'] == 2) { // usuario

		session_start();
		$_SESSION['validacion'] = 1 ;
    $_SESSION['idCuenta']=$row['idCuenta'];
		$_SESSION['usuario'] = $row['usuario'];
		echo "../vista/sistema.php";

				}else{
				session_start();
				$_SESSION['validacion'] = 0 ;
				echo "1";
				}
			} //fin logeo

	public function registro($usuario, $email, $pass1, $pass2){

	         if($pass1 == $pass2){
	             $validacion_pass = true;
	         }else{
	             $validacion_pass= false;
	         }

	         if($validacion_pass){
	         $consult = $this->conexion->query("select correo from datos where correo = '".$email."'");
				       if(mysqli_num_rows($consult)> 0){
	             	echo '1';// usuario ya existe
	             }else{
	              $this->conexion->query("insert into datos (usuario,correo,pass1,pass2,cargo_id)
									values('".$usuario."','".$email."', MD5('".$pass1."'),'".$pass2."',2)");
	                session_start();
	                $_SESSION['validacion'] = 1 ;
									$_SESSION['usuario'] = $usuario;
	              	echo "../vista/sistema.php";
	             }

	         }else{
	             echo '2';//las contraseñas no coinciden
	         }

					 $consult2 = $this->conexion->query("select usuario,pass2 from datos where usuario = '".$usuario."'");
			 		 if(mysqli_num_rows($consult2)> 0){
  	 		 	$row = mysqli_fetch_array($consult2);
			 	   mail($email, "Su cuenta de acceso es :", "Usuario  : $row[0] \n Password : $row[1]");
			 		}
	     }

	public function recupera($correo){
		$consult = $this->conexion->query("select correo,pass2 from datos where correo = '".$correo."'");

		 if(mysqli_num_rows($consult)> 0){
			  	$row = mysqli_fetch_array($consult);

			mail($correo, "Su cuenta de acceso al sistema es :", "Usuario  : $row[0] \n contraseña : $row[1]");
			header ("location:../vista/index.php?ncapa=0");

		}else{
		echo "<script type='text/javascript'>
		 alert('El correo no existe. Verifique que su correo que este registrado'); window.location.href='index.php?ncapa=0';	</script>";
		}
	}

  } //fin de la clase conexion
  ?>
