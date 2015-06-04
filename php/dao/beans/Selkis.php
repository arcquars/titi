<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Selkis
 *
 * @author edwin
 */
class Selkis implements Beans {

    private $seguridad = "_esc_";
    private $idusuario = "_esc_";
    private $url = "_esc_";
    private $bd = "_esc_";
    private $estado = "_esc_";
    private $idselkis;

    function __construct() {
        
    }

    public function loadData($mensaje, $return = false) {
        $sql = "SELECT * FROM selkis WHERE idselkis = '" . $this->idselkis . "'";
        $this->loadDataGeneric($sql, $mensaje, $return);
    }

    public function loadDataGeneric($sql, $mensaje, $return = false) {
        $object = Utils::getObjectOfSQL($sql);
        if ($object['error'] == "false") {
            if ($return == false) {
                $dev['mensaje'] = $mensaje . " No existe este id " . $this->idselkis . "en la tabla";
                $dev['error'] = $cheO['error'];
                Utils::parseJson3($dev, false);
            } else {
                $this->idselkis = null;
            }
        } else {
            $this->seguridad = Utils::getDataBD($object['resultado']['seguridad']);
            $this->idusuario = Utils::getDataBD($object['resultado']['idusuario']);
            $this->url = Utils::getDataBD($object['resultado']['url']);
            $this->bd = Utils::getDataBD($object['resultado']['bd']);
            $this->estado = Utils::getDataBD($object['resultado']['estado']);
            $this->idselkis = Utils::getDataBD($object['resultado']['idselkis']);
        }
    }

    public function getNewSql() {
        $setC[0]['campo'] = 'seguridad';
        $setC[0]['dato'] = $this->seguridad;
        $setC[1]['campo'] = 'idusuario';
        $setC[1]['dato'] = $this->idusuario;
        $setC[2]['campo'] = 'url';
        $setC[2]['dato'] = $this->url;
        $setC[3]['campo'] = 'bd';
        $setC[3]['dato'] = $this->bd;
        $setC[4]['campo'] = 'estado';
        $setC[4]['dato'] = $this->estado;
        $setC[5]['campo'] = 'idselkis';
        $setC[5]['dato'] = $this->idselkis;
        $sql2 = Utils::generarInsertValues($setC);
        return "INSERT INTO selkis " . $sql2;
    }

    public function getUpdateSql() {
        $setC[0]['campo'] = 'seguridad';
        $setC[0]['dato'] = $this->seguridad;
        $setC[1]['campo'] = 'idusuario';
        $setC[1]['dato'] = $this->idusuario;
        $setC[2]['campo'] = 'url';
        $setC[2]['dato'] = $this->url;
        $setC[3]['campo'] = 'bd';
        $setC[3]['dato'] = $this->bd;
        $setC[4]['campo'] = 'estado';
        $setC[4]['dato'] = $this->estado;

        $set = Utils::generarSetsUpdate($setC);
        $wher[0]['campo'] = 'idselkis';
        $wher[0]['dato'] = $this->idselkis;

        $where = Utils::generarWhereUpdate($wher);
        return "UPDATE selkis SET " . $set . " WHERE " . $where;
    }

    function getDeleteSql() {
        return "DELETE FROM selkis WHERE idselkis = '" . $this->idselkis . "'";
    }

    public function getSeguridad() {
        return $this->seguridad;
    }

    public function setSeguridad($seguridad) {
        $this->seguridad = $seguridad;
    }

    public function getIdusuario() {
        return $this->idusuario;
    }

    public function setIdusuario($idusuario) {
        $this->idusuario = $idusuario;
    }

    public function getUrl() {
        return $this->url;
    }

    public function setUrl($url) {
        $this->url = $url;
    }

    public function getBd() {
        return $this->bd;
    }

    public function setBd($bd) {
        $this->bd = $bd;
    }

    public function getEstado() {
        return $this->estado;
    }

    public function setEstado($estado) {
        $this->estado = $estado;
    }

    public function getIdselkis() {
        return $this->idselkis;
    }

    public function setIdselkis($idselkis) {
        $this->idselkis = $idselkis;
    }

    public function toJson() {
        $vars_clase = get_class_vars(get_class());
        foreach ($vars_clase as $nombre => $valor) {
            $value{$nombre} = $this->$nombre;
        }
        return $value;
    }

    /*     * *********************************************************************************************** */

    public function loadDataByIdUsuario($mensaje, $return = false) {
        $sql = "SELECT * FROM selkis WHERE idusuario = '" . $this->idusuario . "'";
        $this->loadDataGeneric($sql, $mensaje, $return);
    }

    public function loadDataByIdUsuarioSeguridad($mensaje, $return = false) {
        $sql = "SELECT * FROM selkis WHERE idusuario = '" . $this->idusuario . "' AND seguridad = '" . $this->seguridad . "'";
        $this->loadDataGeneric($sql, $mensaje, $return);
    }

    /*     * *********************************************************************************************** */
}
