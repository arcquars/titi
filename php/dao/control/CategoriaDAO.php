<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CategoriaDAO
 *
 * @author edwin
 */
class CategoriaDAO {

    //put your code here
    static function findAllCategoria($start, $limit, $sort, $dir, $return) {
        $limite = Utils::getLimit($start, $limit);
        $order = Utils::getSort($sort, $dir, "nombre");
        if ($consubcategoria == true) {
            $sql = "SELECT c.* FROM categoria c WHERE (SELECT COUNT(ss.idsubcategoria) FROM subcategoria ss WHERE ss.idcategoria = c.idcategoria)>=1 $order $limite ";
            $sqlT = "SELECT COUNT(*) AS total FROM categoria c WHERE (SELECT COUNT(ss.idsubcategoria) FROM subcategoria ss WHERE ss.idcategoria = c.idcategoria)>=1 ";
        } else {
            $sql = "SELECT * FROM categoria $order $limite ";
            $sqlT = "SELECT COUNT(*) AS total FROM categoria ";
        }
        $dev = Utils::getTablaToArrayOfSQL2($sql, $sqlT);
        return Utils::parseJson3($dev, $return);
    }

}
