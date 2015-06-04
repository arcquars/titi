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
require_once 'beans/Beans.php';
require_once 'control/CategoriaDAO.php';
require_once 'control/SubcategoriaDAO.php';

$function = $_GET['function'];
$resultado = $_POST['resultado'];
$resultado = Utils::decode_this($resultado);
$json = new Services_JSON();
$datos = $json->decode($resultado);

if ($function == "verificarLogin") {
    UsuarioDAO::verificarLogin($datos, false);
}

//