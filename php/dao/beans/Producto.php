<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Producto
 *
 * @author edwin
 */
class Producto implements Beans {

    private $idproducto;
    private $idsubcategoria = "_esc_";
    private $nombre = "_esc_";
    private $tipo = "_esc_";
    private $cantidad = "_esc_";
    private $precio = "_esc_";
    private $marca = "_esc_";
    private $unidad = "_esc_";
    private $idusuario = "_esc_";
    private $cimg = "_esc_";
    private $fecha = "_esc_";
    private $hora = "_esc_";

    function __construct() {
        
    }

    public function loadData($mensaje, $return = false) {
        $sql = "SELECT * FROM producto WHERE idproducto = '" . $this->idproducto . "'";
        $this->loadDataGeneric($sql, $mensaje, $return);
    }

    public function loadDataGeneric($sql, $mensaje, $return = false) {
        $object = Utils::getObjectOfSQL($sql);
        if ($object['error'] == "false") {
            if ($return == false) {
                $dev['mensaje'] = $mensaje . " No existe este id " . $this->idproducto . "en la tabla";
                $dev['error'] = $cheO['error'];
                Utils::parseJson3($dev, false);
            } else {
                $this->idproducto = null;
            }
        } else {
            $this->idproducto = Utils::getDataBD($object['resultado']['idproducto']);
            $this->idsubcategoria = Utils::getDataBD($object['resultado']['idsubcategoria']);
            $this->nombre = Utils::getDataBD($object['resultado']['nombre']);
            $this->tipo = Utils::getDataBD($object['resultado']['tipo']);
            $this->cantidad = Utils::getDataBD($object['resultado']['cantidad']);
            $this->precio = Utils::getDataBD($object['resultado']['precio']);
            $this->marca = Utils::getDataBD($object['resultado']['marca']);
            $this->unidad = Utils::getDataBD($object['resultado']['unidad']);
            $this->idusuario = Utils::getDataBD($object['resultado']['idusuario']);
            $this->cimg = Utils::getDataBD($object['resultado']['cimg']);
            $this->fecha = Utils::getDataBD($object['resultado']['fecha']);
            $this->hora = Utils::getDataBD($object['resultado']['hora']);
        }
    }

    public function getNewSql() {
        $setC[0]['campo'] = 'idproducto';
        $setC[0]['dato'] = $this->idproducto;
        $setC[1]['campo'] = 'idsubcategoria';
        $setC[1]['dato'] = $this->idsubcategoria;
        $setC[2]['campo'] = 'nombre';
        $setC[2]['dato'] = $this->nombre;
        $setC[3]['campo'] = 'tipo';
        $setC[3]['dato'] = $this->tipo;
        $setC[4]['campo'] = 'cantidad';
        $setC[4]['dato'] = $this->cantidad;
        $setC[5]['campo'] = 'precio';
        $setC[5]['dato'] = $this->precio;
        $setC[6]['campo'] = 'marca';
        $setC[6]['dato'] = $this->marca;
        $setC[7]['campo'] = 'unidad';
        $setC[7]['dato'] = $this->unidad;
        $setC[8]['campo'] = 'idusuario';
        $setC[8]['dato'] = $this->idusuario;
        $setC[9]['campo'] = 'cimg';
        $setC[9]['dato'] = $this->cimg;
        $setC[10]['campo'] = 'fecha';
        $setC[10]['dato'] = $this->fecha;
        $setC[11]['campo'] = 'hora';
        $setC[11]['dato'] = $this->hora;
        $sql2 = Utils::generarInsertValues($setC);
        return "INSERT INTO producto " . $sql2;
    }

    public function getUpdateSql() {
        $setC[0]['campo'] = 'idsubcategoria';
        $setC[0]['dato'] = $this->idsubcategoria;
        $setC[1]['campo'] = 'nombre';
        $setC[1]['dato'] = $this->nombre;
        $setC[2]['campo'] = 'tipo';
        $setC[2]['dato'] = $this->tipo;
        $setC[3]['campo'] = 'cantidad';
        $setC[3]['dato'] = $this->cantidad;
        $setC[4]['campo'] = 'precio';
        $setC[4]['dato'] = $this->precio;
        $setC[5]['campo'] = 'marca';
        $setC[5]['dato'] = $this->marca;
        $setC[6]['campo'] = 'unidad';
        $setC[6]['dato'] = $this->unidad;
        $setC[7]['campo'] = 'idusuario';
        $setC[7]['dato'] = $this->idusuario;
        $setC[8]['campo'] = 'cimg';
        $setC[8]['dato'] = $this->cimg;
        $setC[9]['campo'] = 'fecha';
        $setC[9]['dato'] = $this->fecha;
        $setC[10]['campo'] = 'hora';
        $setC[10]['dato'] = $this->hora;

        $set = Utils::generarSetsUpdate($setC);
        $wher[0]['campo'] = 'idproducto';
        $wher[0]['dato'] = $this->idproducto;

        $where = Utils::generarWhereUpdate($wher);
        return "UPDATE producto SET " . $set . " WHERE " . $where;
    }

    function getDeleteSql() {
        return "DELETE FROM producto WHERE idproducto = '" . $this->idproducto . "'";
    }

    public function getIdproducto() {
        return $this->idproducto;
    }

    public function setIdproducto($idproducto) {
        $this->idproducto = $idproducto;
    }

    public function getIdsubcategoria() {
        return $this->idsubcategoria;
    }

    public function setIdsubcategoria($idsubcategoria) {
        $this->idsubcategoria = $idsubcategoria;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function getTipo() {
        return $this->tipo;
    }

    public function setTipo($tipo) {
        $this->tipo = $tipo;
    }

    public function getCantidad() {
        return $this->cantidad;
    }

    public function setCantidad($cantidad) {
        $this->cantidad = $cantidad;
    }

    public function getPrecio() {
        return $this->precio;
    }

    public function setPrecio($precio) {
        $this->precio = $precio;
    }

    public function getMarca() {
        return $this->marca;
    }

    public function setMarca($marca) {
        $this->marca = $marca;
    }

    public function getUnidad() {
        return $this->unidad;
    }

    public function setUnidad($unidad) {
        $this->unidad = $unidad;
    }

    public function getIdusuario() {
        return $this->idusuario;
    }

    public function setIdusuario($idusuario) {
        $this->idusuario = $idusuario;
    }

    public function getCimg() {
        return $this->cimg;
    }

    public function setCimg($cimg) {
        $this->cimg = $cimg;
    }

    public function getFecha() {
        return $this->fecha;
    }

    public function setFecha($fecha) {
        $this->fecha = $fecha;
    }

    public function getHora() {
        return $this->hora;
    }

    public function setHora($hora) {
        $this->hora = $hora;
    }

    public function toJson() {
        $vars_clase = get_class_vars(get_class());
        foreach ($vars_clase as $nombre => $valor) {
            $value{$nombre} = $this->$nombre;
        }
        return $value;
    }

    /*     * *********************************************************************************************** */


    /*     * *********************************************************************************************** */
}
