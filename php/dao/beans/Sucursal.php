<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Sucursal
 *
 * @author edwin
 */
class Sucursal implements Beans {

    private $idsucursal;
    private $direccion = "_esc_";
    private $telefono = "_esc_";
    private $fax = "_esc_";
    private $email = "_esc_";
    private $idusuario = "_esc_";
    private $latitud = "_esc_";
    private $longitud = "_esc_";
    private $num = "_esc_";

    function __construct() {
        
    }

    public function loadData($mensaje, $return = false) {
        $sql = "SELECT * FROM sucursal WHERE idsucursal = '" . $this->idsucursal . "'";
        $this->loadDataGeneric($sql, $mensaje, $return);
    }

    public function loadDataGeneric($sql, $mensaje, $return = false) {
        $object = Utils::getObjectOfSQL($sql);
        if ($object['error'] == "false") {
            if ($return == false) {
                $dev['mensaje'] = $mensaje . " No existe este id " . $this->idsucursal . "en la tabla";
                $dev['error'] = $cheO['error'];
                Utils::parseJson3($dev, false);
            } else {
                $this->idsucursal = null;
            }
        } else {
            $this->idsucursal = Utils::getDataBD($object['resultado']['idsucursal']);
            $this->direccion = Utils::getDataBD($object['resultado']['direccion']);
            $this->telefono = Utils::getDataBD($object['resultado']['telefono']);
            $this->fax = Utils::getDataBD($object['resultado']['fax']);
            $this->email = Utils::getDataBD($object['resultado']['email']);
            $this->idusuario = Utils::getDataBD($object['resultado']['idusuario']);
            $this->latitud = Utils::getDataBD($object['resultado']['latitud']);
            $this->longitud = Utils::getDataBD($object['resultado']['longitud']);
            $this->num = Utils::getDataBD($object['resultado']['num']);
        }
    }

    public function getNewSql() {
        $setC[0]['campo'] = 'idsucursal';
        $setC[0]['dato'] = $this->idsucursal;
        $setC[1]['campo'] = 'direccion';
        $setC[1]['dato'] = $this->direccion;
        $setC[2]['campo'] = 'telefono';
        $setC[2]['dato'] = $this->telefono;
        $setC[3]['campo'] = 'fax';
        $setC[3]['dato'] = $this->fax;
        $setC[4]['campo'] = 'email';
        $setC[4]['dato'] = $this->email;
        $setC[5]['campo'] = 'idusuario';
        $setC[5]['dato'] = $this->idusuario;
        $setC[6]['campo'] = 'latitud';
        $setC[6]['dato'] = $this->latitud;
        $setC[7]['campo'] = 'longitud';
        $setC[7]['dato'] = $this->longitud;
        $setC[8]['campo'] = 'num';
        $setC[8]['dato'] = $this->num;
        $sql2 = Utils::generarInsertValues($setC);
        return "INSERT INTO sucursal " . $sql2;
    }

    public function getUpdateSql() {
        $setC[0]['campo'] = 'direccion';
        $setC[0]['dato'] = $this->direccion;
        $setC[1]['campo'] = 'telefono';
        $setC[1]['dato'] = $this->telefono;
        $setC[2]['campo'] = 'fax';
        $setC[2]['dato'] = $this->fax;
        $setC[3]['campo'] = 'email';
        $setC[3]['dato'] = $this->email;
        $setC[4]['campo'] = 'idusuario';
        $setC[4]['dato'] = $this->idusuario;
        $setC[5]['campo'] = 'latitud';
        $setC[5]['dato'] = $this->latitud;
        $setC[6]['campo'] = 'longitud';
        $setC[6]['dato'] = $this->longitud;
        $setC[7]['campo'] = 'num';
        $setC[7]['dato'] = $this->num;

        $set = Utils::generarSetsUpdate($setC);
        $wher[0]['campo'] = 'idsucursal';
        $wher[0]['dato'] = $this->idsucursal;

        $where = Utils::generarWhereUpdate($wher);
        return "UPDATE sucursal SET " . $set . " WHERE " . $where;
    }

    function getDeleteSql() {
        return "DELETE FROM sucursal WHERE idsucursal = '" . $this->idsucursal . "'";
    }

    public function getIdsucursal() {
        return $this->idsucursal;
    }

    public function setIdsucursal($idsucursal) {
        $this->idsucursal = $idsucursal;
    }

    public function getDireccion() {
        return $this->direccion;
    }

    public function setDireccion($direccion) {
        $this->direccion = $direccion;
    }

    public function getTelefono() {
        return $this->telefono;
    }

    public function setTelefono($telefono) {
        $this->telefono = $telefono;
    }

    public function getFax() {
        return $this->fax;
    }

    public function setFax($fax) {
        $this->fax = $fax;
    }

    public function getEmail() {
        return $this->email;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function getIdusuario() {
        return $this->idusuario;
    }

    public function setIdusuario($idusuario) {
        $this->idusuario = $idusuario;
    }

    public function getLatitud() {
        return $this->latitud;
    }

    public function setLatitud($latitud) {
        $this->latitud = $latitud;
    }

    public function getLongitud() {
        return $this->longitud;
    }

    public function setLongitud($longitud) {
        $this->longitud = $longitud;
    }

    public function getNum() {
        return $this->num;
    }

    public function setNum($num) {
        $this->num = $num;
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
