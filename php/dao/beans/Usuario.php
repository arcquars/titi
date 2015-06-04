<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Usuario
 *
 * @author edwin
 */
class Usuario implements Beans {

    private $idusuario;
    private $login = "_esc_";
    private $email = "_esc_";
    private $nombre = "_esc_";
    private $nit = "_esc_";
    private $ci = "_esc_";
    private $departamento = "_esc_";
    private $sexo = "_esc_";
    private $estado = "_esc_";
    private $seguridad = "_esc_";
    private $password = "_esc_";

    function __construct() {
        
    }

    public function loadData($mensaje, $return = false) {
        $sql = "SELECT * FROM usuario WHERE idusuario = '" . $this->idusuario . "'";
        $this->loadDataGeneric($sql, $mensaje, $return);
    }

    public function loadDataGeneric($sql, $mensaje, $return = false) {
        $object = Utils::getObjectOfSQL($sql);
        if ($object['error'] == "false") {
            if ($return == false) {
                $dev['mensaje'] = $mensaje . " No existe este id " . $this->idusuario . "en la tabla";
                $dev['error'] = "false";
                Utils::parseJson3($dev, false);
            } else {
                $this->idusuario = null;
            }
        } else {
            $this->idusuario = Utils::getDataBD($object['resultado']['idusuario']);
            $this->login = Utils::getDataBD($object['resultado']['login']);
            $this->email = Utils::getDataBD($object['resultado']['email']);
            $this->nombre = Utils::getDataBD($object['resultado']['nombre']);
            $this->nit = Utils::getDataBD($object['resultado']['nit']);
            $this->ci = Utils::getDataBD($object['resultado']['ci']);
            $this->departamento = Utils::getDataBD($object['resultado']['departamento']);
            $this->sexo = Utils::getDataBD($object['resultado']['sexo']);
            $this->estado = Utils::getDataBD($object['resultado']['estado']);
            $this->seguridad = Utils::getDataBD($object['resultado']['seguridad']);
            $this->password = Utils::getDataBD($object['resultado']['password']);
        }
    }

    public function getNewSql() {
        $setC[0]['campo'] = 'idusuario';
        $setC[0]['dato'] = $this->idusuario;
        $setC[1]['campo'] = 'login';
        $setC[1]['dato'] = $this->login;
        $setC[2]['campo'] = 'email';
        $setC[2]['dato'] = $this->email;
        $setC[3]['campo'] = 'nombre';
        $setC[3]['dato'] = $this->nombre;
        $setC[4]['campo'] = 'nit';
        $setC[4]['dato'] = $this->nit;
        $setC[5]['campo'] = 'ci';
        $setC[5]['dato'] = $this->ci;
        $setC[6]['campo'] = 'departamento';
        $setC[6]['dato'] = $this->departamento;
        $setC[7]['campo'] = 'sexo';
        $setC[7]['dato'] = $this->sexo;
        $setC[8]['campo'] = 'estado';
        $setC[8]['dato'] = $this->estado;
        $setC[9]['campo'] = 'seguridad';
        $setC[9]['dato'] = $this->seguridad;
        $setC[10]['campo'] = 'password';
        $setC[10]['dato'] = $this->password;
        $sql2 = Utils::generarInsertValues($setC);
        return "INSERT INTO usuario " . $sql2;
    }

    public function getUpdateSql() {
        $setC[0]['campo'] = 'login';
        $setC[0]['dato'] = $this->login;
        $setC[1]['campo'] = 'email';
        $setC[1]['dato'] = $this->email;
        $setC[2]['campo'] = 'nombre';
        $setC[2]['dato'] = $this->nombre;
        $setC[3]['campo'] = 'nit';
        $setC[3]['dato'] = $this->nit;
        $setC[4]['campo'] = 'ci';
        $setC[4]['dato'] = $this->ci;
        $setC[5]['campo'] = 'departamento';
        $setC[5]['dato'] = $this->departamento;
        $setC[6]['campo'] = 'sexo';
        $setC[6]['dato'] = $this->sexo;
        $setC[7]['campo'] = 'estado';
        $setC[7]['dato'] = $this->estado;
        $setC[8]['campo'] = 'seguridad';
        $setC[8]['dato'] = $this->seguridad;
        $setC[9]['campo'] = 'password';
        $setC[9]['dato'] = $this->password;

        $set = Utils::generarSetsUpdate($setC);
        $wher[0]['campo'] = 'idusuario';
        $wher[0]['dato'] = $this->idusuario;

        $where = Utils::generarWhereUpdate($wher);
        return "UPDATE usuario SET " . $set . " WHERE " . $where;
    }

    function getDeleteSql() {
        return "DELETE FROM usuario WHERE idusuario = '" . $this->idusuario . "'";
    }

    public function getIdusuario() {
        return $this->idusuario;
    }

    public function setIdusuario($idusuario) {
        $this->idusuario = $idusuario;
    }

    public function getLogin() {
        return $this->login;
    }

    public function setLogin($login) {
        $this->login = $login;
    }

    public function getEmail() {
        return $this->email;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function getNit() {
        return $this->nit;
    }

    public function setNit($nit) {
        $this->nit = $nit;
    }

    public function getCi() {
        return $this->ci;
    }

    public function setCi($ci) {
        $this->ci = $ci;
    }

    public function getDepartamento() {
        return $this->departamento;
    }

    public function setDepartamento($departamento) {
        $this->departamento = $departamento;
    }

    public function getSexo() {
        return $this->sexo;
    }

    public function setSexo($sexo) {
        $this->sexo = $sexo;
    }

    public function getEstado() {
        return $this->estado;
    }

    public function setEstado($estado) {
        $this->estado = $estado;
    }

    public function getSeguridad() {
        return $this->seguridad;
    }

    public function setSeguridad($seguridad) {
        $this->seguridad = $seguridad;
    }

    public function getPassword() {
        return $this->password;
    }

    public function setPassword($password) {
        $this->password = $password;
    }

    public function toJson() {
        $vars_clase = get_class_vars(get_class());
        foreach ($vars_clase as $nombre => $valor) {
            $value{$nombre} = $this->$nombre;
        }
        return $value;
    }

    /*     * *********************************************************************************************** */

    public function loadDataByLogin($mensaje, $return = false) {
        $sql = "SELECT * FROM usuario WHERE login = '" . $this->login . "'";
        return $this->loadDataGeneric($sql, $mensaje, $return);
    }

    public function loadDataByNit($mensaje, $return = false) {
        $sql = "SELECT * FROM usuario WHERE nit = '" . $this->nit . "'";
        return $this->loadDataGeneric($sql, $mensaje, $return);
    }

    public function loadDataByEmail($mensaje, $return = false) {
        $sql = "SELECT * FROM usuario WHERE email = '" . $this->email . "'";
        return $this->loadDataGeneric($sql, $mensaje, $return);
    }

    /*     * *********************************************************************************************** */
}
