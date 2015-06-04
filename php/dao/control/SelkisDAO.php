<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of UsuarioDAO
 *
 * @author edwin
 */
class SelkisDAO {

//put your code here
    static function getProducto($idproducto) {
        $proO = new Producto();
        $proO->setIdproducto($idproducto);
        $proO->loadData("No existe el producto seleccionado");

        $sql = "SELECT p.idproducto, p.nombre, CONCAT(c.nombre,' -> ',s.nombre) AS categoria, p.cantidad, p.precio, p.marca, p.unidad, u.login, u.departamento, "
                . " COALESCE((u.puntos/u.votos),0) AS puntuacion, u.idusuario, p.cimg, p.fecha, p.hora FROM categoria c, producto p, subcategoria s, usuario u WHERE "
                . "  p.idsubcategoria = s.idsubcategoria AND s.idcategoria = c.idcategoria AND p.idusuario = u.idusuario AND p.idproducto = '$idproducto' ";
        $prov = Utils::getObjectOfSQL2($sql);

        $sql2 = "SELECT c.nombre, pc.valor FROM procar pc, caracteristica c WHERE pc.idcaracteristica =  c.idcaracteristica AND pc.idproducto = '$idproducto'";
        $dev2 = Utils::getTablaToArrayOfSQL2($sql2, null);


        $dev["error"] = "true";
        $dev["producto"] = $prov;
        $dev["car"] = $dev2['resultado'];
        Utils::parseJson3($dev, false);
    }

    static function buscar($q, $p, $c, $tipo) {
//        | idproducto     | varchar(25)  | NO   | PRI | NULL    |       |
//| idsubcategoria | varchar(10)  | NO   | MUL | NULL    |       |
//| nombre         | varchar(100) | NO   |     | NULL    |       |
//| tipo           | varchar(1)   | NO   |     | S       |       |
//| cantidad       | decimal(8,2) | NO   |     | NULL    |       |
//| precio         | decimal(8,2) | NO   |     | NULL    |       |
//| marca          | varchar(20)  | NO   |     | NULL    |       |
//| unidad         | varchar(20)  | NO   |     | NULL    |       |
//+----------------+--------------+------+-----+---------+-------+
        $trozos = explode(" ", $q);
        $numero = count($trozos);
        if ($tipo == "buscar") {
            $select = "SELECT p.idproducto, p.nombre, s.nombre AS categoria, p.cantidad, p.precio, p.marca, p.unidad, u.login, u.departamento, "
                    . " COALESCE((u.puntos/u.votos),0) AS puntuacion, u.idusuario, p.cimg  ";
        } else if ($tipo == "categoria") {
            $select = "SELECT s.idsubcategoria, s.nombre AS categoria, COUNT(s.idcategoria) AS cantidd ";
        }


        $from = " FROM subcategoria s,  producto p, usuario u";
        $where = " WHERE s.idsubcategoria = p.idsubcategoria AND p.idusuario = u.idusuario  ";
        if ($p != "all") {
            $where .= " AND u.login = '$p' ";
        }
        if ($c != "Todos") {
            $where .= " AND p.idsubcategoria = '$c' ";
        }
        if ($numero == 1) {
            if ($q == "") {
                if ($p != "all") {
                    $order .= " ORDER BY RAND()";
                } else {
                    if ($c == "Todos") {
                        $order .= " ORDER BY p.fecha DESC";
                    } else {
                        $order .= " ORDER BY RAND()";
                    }
                }
            } else {
                $where .= " AND p.nombre LIKE '%$q%' ";
            }
        } else {
            if ($q == "") {
                $order .= " ORDER BY p.fecha DESC";
            } else {
                $select .= " , MATCH(p.nombre, p.marca) AGAINST ('$q') AS ranking ";
                $where .= " AND MATCH(p.nombre, p.marca) AGAINST ('$q')  ";
                $order .= " ORDER BY ranking DESC ";
            }
        }
        if ($tipo == "buscar") {

            $sql = $select . $from . $where . "  $order LIMIT 25";
        } else if ($tipo == "categoria") {
            $sql = $select . $from . $where . " GROUP BY s.idcategoria, s.nombre ";
        }


//        echo $sql;




        $dev['mensaje'] = "No se encontraron resultados";
        $dev['error'] = "false";
        $dev['resultado'] = "";
//        echo $sql;
//        $totalCount = 0;
        $link = new BD();
        $link->conectar();
        $re = $link->consulta($sql);
        if ($fi = mysql_fetch_array($re)) {
            $ii = 0;
            //$totalCount = mysql_num_rows($re);
            for ($i = 0; $i < mysql_num_fields($re); $i++) {
                $value[0][$i] = mysql_field_name($re, $i);
            }
            do {
                for ($i = 0; $i < mysql_num_fields($re); $i++) {
                    $value[$ii + 1][$i] = $fi[$i];
                }

                $ii++;
            } while ($fi = mysql_fetch_array($re));
            $dev['mensaje'] = "Existen resultados";
            $dev['error'] = "true";
            $dev['resultado'] = $value;
        }

        /*         * ********************************************************************* */
        if ($tipo == "buscar") {
            $select = "SELECT DISTINCT a.* ";
            $from .= " , sucursal a";
            $where .= " AND u.idusuario = a.idusuario AND a.num = 0";
            $sqlD = $select . $from . $where . "  ";
            $reD = $link->consulta($sqlD);
            if ($fiD = mysql_fetch_array($reD)) {
                $iiD = 0;
                //$totalCount = mysql_num_rows($re);
                for ($iD = 0; $iD < mysql_num_fields($reD); $iD++) {
                    $valueD[0][$iD] = mysql_field_name($reD, $iD);
                }
                do {
                    for ($iD = 0; $iD < mysql_num_fields($reD); $iD++) {
                        $valueD[$iiD + 1][$iD] = $fiD[$iD];
                    }

                    $iiD++;
                } while ($fiD = mysql_fetch_array($reD));
                $dev['mensaje'] = "Existen resultados";
                $dev['error'] = "true";
                $dev['direccion'] = $valueD;
            }
        }

        /*         * ********************************************************************* */

        Utils::parseJson3($dev, false);
    }

    static function conectarSelkis($return = false) {
        $dev['error'] = "false";
        $dev['mensaje'] = "";

        $selO = new Selkis();
        $selO->setIdusuario($_SESSION['idusuario']);
        $selO->loadDataByIdUsuario("", true);

        if ($selO->getIdselkis() == null) {
            $numerSel = Utils::getUltimoID("selkis");
            $raro = Utils::genera_password(20);
            $raro = md5($raro);
            $selO->setIdselkis("sel-" . $numerSel);
            $selO->setSeguridad($raro);
            $selO->setBd(date("Y-m-d"));
            $selO->setUrl(date("H:i:s"));
            $selO->setEstado("Espera");
            $sql = $selO->getNewSql();
            if (Utils::ejecutarConsulta($sql) == false) {
                $dev['mensaje'] = "Lo sentimos tenemos problemas en nuestro servidor por favor intentelo mas tarde";
                Utils::parseJson3($dev, $return);
            }
        }
        $dev["resultado"] = $selO->toJson();
        $dev["error"] = "true";
        Utils::parseJson3($dev, $return);
    }

}
