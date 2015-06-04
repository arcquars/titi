<?php

session_name("ElTiTi");
session_start();
include '../bd/update.php';
include '../bd/bd.php';
/**
 * Generar codigo alfanumerico
 *
 * Esta funcion es la encargada de actualizar el sistema le el archivo ../bd/update.php y dependiendo
 * en que variable este actualmente recupera la consulta en la variable y lo ejecuta, y actualiza la
 * version del sistema en la tabla sistema.
 *
 * @access public
 * @author Edwin Salguero C.
 * @author edwin16@gmail.com
 * @copyright Kernel S.R.L.
 * @copyright http://www.kernel.com.bo
 * @version 1.0
 *
 */
$link = new BD;
$link->conectar();

$sql = "SELECT version FROM sistema";
$con = 999;
$re = $link->consulta($sql);
if ($fi = mysql_fetch_array($re)) {
    $con = $fi['version'];
}
$con = $con + 1;


for ($i = $con; $i <= 3000; $i++) {

    $var = "B" . $i;
    $sqlI = $$var;

    if (!$link->consulta($sqlI)) {
        echo $i . ".- " . $link->getError();
        exit;
    } else {
        
    }
    $sqlI = "UPDATE sistema SET version =" . $i;
    $link->consulta($sqlI);
}

//echo "<h3>Version " . (Utils::redondear((($i - 1) / 1000), 3)) . "</h3>";
?>