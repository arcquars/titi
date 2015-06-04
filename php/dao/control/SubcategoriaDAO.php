<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SubcategoriaDAO
 *
 * @author edwin
 */
class SubcategoriaDAO {

    //put your code here
    static function findAllSubcategoria($start, $limit, $sort, $dir, $return) {
        $limite = Utils::getLimit($start, $limit);
        $order = Utils::getSort($sort, $dir, "nombre");
        $sql = "SELECT * FROM subcategoria $order $limite ";
        $sqlT = "SELECT COUNT(*) AS total FROM subcategoria ";
        $dev = Utils::getTablaToArrayOfSQL2($sql, $sqlT);
        return Utils::parseJson3($dev, $return);
    }

}
