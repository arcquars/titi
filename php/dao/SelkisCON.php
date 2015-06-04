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
require_once 'control/UsuarioDAO.php';
require_once 'beans/Beans.php';
require_once 'beans/Usuario.php';
require_once "control/class.phpmailer.php";
require_once "control/class.smtp.php";
require_once 'control/SelkisDAO.php';
require_once 'beans/Selkis.php';
require_once 'beans/Producto.php';

$function = $_GET['function'];
$resultado = $_POST['resultado'];
$resultado = Utils::decode_this($resultado);
$json = new Services_JSON();
$datos = $json->decode($resultado);

if ($function == "conectarSelkis") {
    if ($_SESSION["user_cat"] == "Usuario") {
        SelkisDAO::conectarSelkis(false);
    } else {
        $dev['mensaje'] = "Es posible que ud no este con una sesion activa por favor presione f5 e inicie sesion";
        $dev['error'] = "false";
        Utils::parseJson3($dev, false);
    }
} else if ($function == "buscar") {
    SelkisDAO::buscar($_GET['q'], $_GET['p'], $_GET['cat'], "buscar");
} else if ($function == "buscarC") {
    SelkisDAO::buscar($_GET['q'], $_GET['p'], $_GET['cat'], "categoria");
} else if ($function == "getProducto") {
    SelkisDAO::getProducto($_GET['idproducto']);
}


//getProducto


//