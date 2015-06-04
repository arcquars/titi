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
require_once 'control/CategoriaDAO.php';
require_once 'control/SubcategoriaDAO.php';

$function = $_GET['function'];
$resultado = $_POST['resultado'];
$resultado = Utils::decode_this($resultado);
$json = new Services_JSON();
$datos = $json->decode($resultado);

if ($function == "verificarLogin") {
    UsuarioDAO::verificarLogin($datos, false);
} else if ($function == "verificarNit") {
    UsuarioDAO::verificarNit($datos, false);
} else if ($function == "txSaveUsuario") {
    UsuarioDAO::txSaveUsuario($datos, false);
} else if ($function == "txNewPassword") {
    UsuarioDAO::txNewPassword($datos, false);
} else if ($function == "txSolicitarCodigo") {
    UsuarioDAO::txSolicitarCodigo($datos, false);
} else if ($function == "txSolicitarContrasena") {
    UsuarioDAO::txSolicitarContrasena($datos, false);
} else if ($function == "txVerificarEmail") {
    UsuarioDAO::txVerificarEmail($datos, false);
} else if ($function == "getDatos") {
    $userO = new Usuario();
    $userO->setIdusuario($_SESSION['idusuario']);
    $userO->loadData("", true);
    if ($userO->getIdusuario() == null) {
        $userO->setLogin("Invitado");
    }
    $link = new BD();
    $link->conectar();
    $re = $link->consulta("SELECT * FROM contador");
    $contador = "100";
    if ($fi = mysql_fetch_array($re)) {
        $contador = "" . $fi['contador'];
    }
    $cat = CategoriaDAO::findAllCategoria(0, 0, "nombre", "ASC", true);
    $scat = SubcategoriaDAO::findAllSubcategoria(0, 0, "nombre", "ASC", true);
    $dev['visitante'] = $contador;
    $dev['error'] = "true";
    $dev['usuario'] = $userO->toJson();
    $dev['categoria'] = $cat['resultado'];
    $dev['subcategoria'] = $scat['resultado'];
    Utils::parseJson3($dev, false);
}

//