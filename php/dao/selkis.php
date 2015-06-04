<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of UsuarioCON
 *
 * @author edwin
 */
//class UsuarioCON {
//    //put your code here
//}
session_name("ElTiTi");
session_start();
include("../bd/bd.php");

require_once 'control/Utils.php';
require_once 'control/JSON.php';
//require_once 'control/UsuarioDAO.php';
require_once 'beans/Beans.php';
require_once 'beans/Usuario.php';
require_once 'beans/Selkis.php';
require_once 'beans/Producto.php';
require_once 'beans/Sucursal.php';
//require_once "control/class.phpmailer.php";
//require_once "control/class.smtp.php";


$function = $_GET['function'];
$resultado = $_POST['resultado'];
$resultado = Utils::selkisDecode($resultado);
$json = new Services_JSON();
$datos = $json->decode($resultado);
//echo $datos->function;
if ($datos->function == "sincronizar") {
    $dev["error"] = "false";
    $userO = new Usuario();
    $userO->setEmail($datos->email);
    $userO->loadDataByEmail("", true);
    if ($userO->getIdusuario() != null) {
        $selkO = new Selkis();
        $selkO->setIdusuario($userO->getIdusuario());
        $selkO->loadDataByIdUsuario("", true);
        if ($selkO->getIdselkis() != null) {
            if ($selkO->getSeguridad() == $datos->seguridad) {
                $selkO->setUrl($datos->urlu);
                $selkO->setBd($datos->bd);
                $selkO->setEstado("Activo");
                $sqlU = $selkO->getUpdateSql();
                if (Utils::ejecutarConsulta($sqlU)) {
                    $dev["error"] = "true";
                    $dev["idusuario"] = $selkO->getIdusuario();
                    $dev["seguridad"] = $selkO->getSeguridad();
                    $dev["mensaje"] = "Se sincronizo correctamente con el servidor de El TiTi";
                } else {
                    $dev["mensaje"] = "Se produjo un error al sincronizar con el servidor del TiTi... por favor intente mas tarde1" . $sqlU;
                }
            } else {
                $dev["mensaje"] = "El codigo de seguridad no coincide.. por favor verique los datos";
            }
        } else {
            $dev["mensaje"] = "Este usuario aun no activo conexion con selkis en el TiTi ";
        }
    } else {
        $dev["mensaje"] = "No tenemos registrado ningun usuario con el correo electronico " . $datos->email;
    }
    Utils::parseJson4($dev, false);
} else if ($datos->function == "updateProducto") {
    $productos = $datos->resultado;
    $userO = new Usuario();
    $userO->setIdusuario($datos->idusuario);
    $userO->loadData("No existe el usuario");
    $codigo = str_replace("usr-", "", $userO->getIdusuario());
    $proGi = 0;
    $i = 1;
//        p.idproducto, idsubcategoria, p.nombre, marca, unidad, bs
//        echo base64_encode("100000p10000");
//        usr-1 00000 pro-1 0000
//        MTAwM DAwcD EwMDA w
//        dTEwM DAwMH AxMDA wMA==
//        dXNyL Tk5OT k5OXB yby05 OTk5O Q==
//        dXNyL TEwMD AwMHB yby0x MDAwM A==
//        5     10      15  20      25  

    $prodO = $productos[$i];
    $codiPro = $codigo . "p" . str_replace("pro-", "", $prodO[0]);
    $codiPro = base64_encode($codiPro);
    $isNEw = true;
    $proO = new Producto();
    $proO->setIdproducto($codiPro);
    $proO->loadData("", true);
    if ($proO->getIdproducto() == null) {
        $isNEw = true;
    } else {
        $isNEw = false;
    }
    $proO->setIdproducto($codiPro);
    $proO->setIdsubcategoria($prodO[1]);
    $proO->setNombre(str_replace("___esc___", "\"", $prodO[2]));
    $proO->setTipo("S");
    $proO->setCantidad($prodO[6]);
    $proO->setPrecio($prodO[5]);
    $proO->setMarca($prodO[3]);
    $proO->setUnidad($prodO[4]);
    $proO->setIdusuario($datos->idusuario);
    $proO->setFecha(date("Y-m-d"));
    $proO->setHora(date("H:i:s"));

    /*     * ************************************************************************* */
    $caimg = 0;
    for ($z = 0; $z < 5; $z++) {
        if ($_FILES["imagen" . $z]["tmp_name"]) {
            $caimg ++;
        }
    }
    $proO->setCimg($caimg);
    /*     * ************************************************************************* */


    if ($isNEw == true) {
        $sqlG[] = $proO->getNewSql();
    } else {
        $sqlG[] = $proO->getUpdateSql();
    }
    $cars = $datos->carac;
    $sqlG[] = "DELETE FROM procar WHERE idproducto = '" . $codiPro . "';";
    if ($cars != null) {
        for ($iz = 0; $iz < count($cars); $iz++) {
            $carO = $cars[$iz];
            $sqlG[] = "INSERT INTO procar(idproducto, idcaracteristica, valor) VALUES('$codiPro', '" . $carO[0] . "', '" . $carO[1] . "');";
        }
    }


    $xDefT = 120;
    $yDefT = 160;

//    Utils::MostrarConsulta($sqlG);
//    exit;


    if (Utils::ejecutarConsultaSQLBeginCommit3($sqlG)) {
        $retu = true;
        for ($z = 0; $z < 5; $z++) {
//                echo $_FILES["imagen" . $z]["type"];
//                echo "<br>";
            if ($_FILES["imagen" . $z]["tmp_name"]) {
                $enlace = "../../images/" . $userO->getLogin() . "/" . $codiPro . "_" . $z . ".jpg";
                $enlaceT = "../../images/" . $userO->getLogin() . "/tumb/" . $codiPro . "_" . $z . ".jpg";
                if (move_uploaded_file($_FILES["imagen" . $z]["tmp_name"], $enlace)) {

                    /*                     * ************************************************************************************* */
                    $original = imagecreatefromjpeg($enlace);
                    $x = imagesx($original);
                    $xo = $x;
                    $y = imagesy($original);
                    $yo = $y;

                    $xt = $x;
                    $yt = $y;
                    if ($xt > $xDefT || $yt > $yDefT) {
                        if ($yt > $yDefT) {
                            $aux = (($yDefT * 100) / $yt);
                            $xt = $aux * ($xt / 100);
                            $yt = $aux * ($yt / 100);
                        }

                        if ($xt > $xDefT) {
                            $aux = (($xDefT * 100) / $xt);
                            $xt = $aux * ($xt / 100);
                            $yt = $aux * ($yt / 100);
                        }
                    }



                    $imaget = imagecreatetruecolor($xt, $yt);
                    imagecopyresampled($imaget, $original, 0, 0, 0, 0, $xt, $yt, $xo, $yo);
                    imagejpeg($imaget, $enlaceT, 90);
//                    $dev['mensaje'] = "Se cargo correctamente la imagen";
//                    $dev['error'] = "true";
//                    Utils::parseJson3($dev, false);
//                    exit;
                    /*                     * ************************************************************************************* */
                } else {
                    $retu = false;
                    $s .= $z . " -";
                }
            }
        }
        $proG[$proGi] = $prodO[0];
        $proGi++;

        if ($retu == true) {
            $dev["error"] = "true";
            $dev["mensaje"] = "Se sincronizo el producto correctamente";
        } else {
            $dev["error"] = "false";
            $dev["mensaje"] = $s . " t3 El producto se copio correctamente pero uno o mas imagenes no se pudieron copiar";
        }
    } else {
        $dev["error"] = "false";
        $dev["mensaje"] = " Error al sincronizar con ElTiTi.bo 3";
    }

    $dev["resultado"] = $proG;
    Utils::parseJson4($dev, false);
} else if ($datos->function == "updateAlmacen") {
    $selkO = new Selkis();
    $selkO->setIdusuario($datos->idusuario);
    $selkO->setSeguridad($datos->seguridad);
    $selkO->loadDataByIdUsuarioSeguridad("", true);
    $dev["error"] = "false";
    if ($selkO->getIdselkis() != null) {
        $almacenes = $datos->resultado;
        $codigo = str_replace("usr-", "", $selkO->getIdusuario());
        for ($i = 1; $i < count($almacenes); $i++) {
//            0 idalmacen, 1 dir, 2 telefono, 3 fax, 4 email, 5 latitud, 6 longitud

            $almO = $almacenes[$i];
            $codiAlm = $codigo . "a" . str_replace("alm-", "", $almO[0]);
            $codiAlm = base64_encode($codiAlm);
            $isNEw = true;
            $sucO = new Sucursal();
            $sucO->setIdsucursal($codiAlm);
            $sucO->loadData("", true);
            if ($sucO->getIdsucursal() == null) {
                $isNEw = true;
            } else {
                $isNEw = false;
            }
            $sucO->setIdsucursal($codiAlm);
            $sucO->setDireccion($almO[1]);
            $sucO->setTelefono($almO[2]);
            $sucO->setFax($almO[3]);
            $sucO->setEmail($almO[4]);
            $sucO->setIdusuario($datos->idusuario);
            $sucO->setLatitud($almO[5]);
            $sucO->setLongitud($almO[6]);
            $sucO->setNum($almO[7]);


            if ($isNEw == true) {
                $sqlG[] = $sucO->getNewSql();
            } else {
                $sqlG[] = $sucO->getUpdateSql();
            }
        }
        if (Utils::ejecutarConsultaSQLBeginCommit3($sqlG)) {
            $dev["mensaje"] = "Se sincronizo correctamente los almacenes";
            $dev["error"] = "true";
        } else {
            $dev["mensaje"] = "Error al sincronizar los almacenes ";
        }
    } else {
        $dev["mensaje"] = "Ud no tiene una cuenta en ElTiTi.bo";
    }
    Utils::parseJson4($dev, false);
} else if ($datos->function == "findAllCategoriaTiti") {
    $sql = "SELECT s.idsubcategoria, c.nombre AS categoria, s.nombre AS subcategoria FROM categoria c, subcategoria s WHERE c.idcategoria = s.idcategoria ";
    $sqlT = "SELECT COUNT(*) FROM categoria c, subcategoria s WHERE c.idcategoria = s.idcategoria ";

    $dev = Utils::getTablaToArrayOfSQL2($sql, $sqlT);
    return Utils::parseJson3($dev, $return);
}

//eyJlcnJvciI6ImZhbHNlIiwibWVuc2FqZSI6Ik5vIHRlbmVtb3MgcmVnaXN0cmFkbyBuaW5ndW4gdXN1YXJpbyBjb24gZWwgY29ycmVvIGVsZWN0cm9uaWNvIGVkd2luMTZAZ21haWwuY293In0=
//eyJlcnJvciI6ImZhbHNlIiwibWVuc2FqZSI6Ik5vIHRlbmVtb3MgcmVnaXN0cmFkbyBuaW5ndW4gdXN1YXJpbyBjb24gZWwgY29ycmVvIGVsZWN0cm9uaWNvIGVkd2luMTZAZ21haWwuY293In0=