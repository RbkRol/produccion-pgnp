<?php //Ejemplo aprenderaprogramar.com
header('content-type: application/json; charset=UTF-8');
header("access-control-allow-origin: *");
$archivo = fopen("ATC.csv", "r");
//Lo recorremos
$datos = fgetcsv($archivo, ","); 
fclose($archivo);
$datos2= str_replace("\n", " ", $datos);
$datos3= str_replace("  ", " ", $datos2);
$datos4= str_replace(", ", "-", $datos3);
$datos5= str_replace('"', "", $datos4);
$datos6= remove_utf8_bom($datos5);
$json = json_encode($datos6);
//Cerramos el archivo
echo($json);

function remove_utf8_bom($text)
{
    $bom = pack('H*','EFBBBF');
    $text = preg_replace("/^$bom/", '', $text);
    return $text;
}

?>