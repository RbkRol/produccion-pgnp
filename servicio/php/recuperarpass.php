<?php
header('content-type: application/json; charset=utf-8');
header("access-control-allow-origin: *");
include("conexion.php");
      $con=conectar();
        if (!$con)
        {
          die (" No se puede usar la base de datos " . mysqli_error($con));
        }
else{
 $resultado=mysqli_query($con,"SELECT password FROM usr WHERE correo='" . $_GET['correo'] . "'");
            if(!$resultado){
					$data="No se encontro el correo del proveedor";
			}
			else{
				$row = mysqli_fetch_row($resultado);
if(!$row){
$data="No se encontro el correo del proveedor";

}
else{
	$nuevopass=generarCodigo(8);
	if(mysqli_query($con,"UPDATE usr SET password='" . $nuevopass . "' WHERE correo='" . $_GET['correo'] . "'")){

				$destinatario = $_GET['correo']; 
				$asunto = "Contrase�a Proveedores GNP";  
				$cuerpo = ' 
					<html> 
						<head> 
   							<title>Contrase�a Proveedores GNP</title> 
						</head> 
						<body> 
							<h1>Tu contrase�a temporal es: '. $nuevopass . '</h1> 
							<p> 
							<b>Contacta con el administrador del sistema para crear una nueva</b>. 
							</p> 
							<img src="https://gnp-fuentes-ext-proveedores.appspot.com/img/gnPicono.png"  width="20%">
						</body> 
					</html> 
				'; 

					//para el env�o en formato HTML 
				$headers = "MIME-Version: 1.0\r\n"; 
				$headers .= "Content-type: text/html; charset=iso-8859-1\r\n"; 

				//direcci�n del remitente 
				$headers .= "From: Mario Fernando Reyes Morales <mario.reyesmorales@gnp.com.mx>\r\n"; 

				mail($destinatario,$asunto,$cuerpo,$headers);
				$data="Ok";
}
else{
$data="No se encontro el correo del proveedor";
}
}
			}
}
			mysqli_close($con);
header('Content-Type: application/json');
echo json_encode($data);

function generarCodigo($longitud, $tipo=0)
{
    //creamos la variable codigo
    $codigo = "";
    //caracteres a ser utilizados
    $caracteres="abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    //el maximo de caracteres a usar
    $max=strlen($caracteres)-1;
    //creamos un for para generar el codigo aleatorio utilizando parametros min y max
    for($i=0;$i < $longitud;$i++)
    {
        $codigo.=$caracteres[rand(0,$max)];
    }
    //regresamos codigo como valor
    return $codigo;
}
	
?>