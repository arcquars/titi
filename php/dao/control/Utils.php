<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Utils
 *
 * @author edwin
 */
class Utils {

    static function MostrarConsulta($a) {
        if ($a != NULL) {
            $i = 0;
            do {
                //            echo $i.".- ".$a[$i];
                echo $a[$i];
                echo "<br>";
                $i++;
            } while (next($a) != false);
        }
    }

    static function validarPassword($pass, $pass1, $return = false) {
        $dev = false;
        if ($pass != $pass1) {
            $mensaje = "Las contraseñas no coinciden";
        } else {
            if (strlen($pass) <= 7) {
                $mensaje = "Las contraseñas no coinciden";
            } else {
                $dev = true;
            }
        }

        if ($return == false) {
            if ($dev == false) {
                $dev2["error"] = "false";
                $dev2["mensaje"] = $mensaje;
                Utils::parseJson3($dev2, $return);
            }
        } else {
            return $dev;
        }
    }

    static function validarLogin($login, $return = false) {
//                           "/^[a-z]+$/i";
        $dev = preg_match("/^[a-z0-9]+$/", $login);
        if ($return == false) {
            if ($dev == false) {
                $dev2["error"] = "false";
                $dev2["mensaje"] = "El nombre de usuario " . $login . " no es valido, Solo puede contener letras minusculas y numeros";
                Utils::parseJson3($dev2, $return);
            }
        } else {
            return $dev;
        }
    }

    static function validarEmail($email, $return = false) {
        $dev = false;
        if (function_exists('filter_var')) { //Introduced in PHP 5.2
            if (filter_var($email, FILTER_VALIDATE_EMAIL) === FALSE) {
                $dev = false;
            } else {
                $dev = true;
            }
        } else {
            $dev = preg_match('/^(?:[\w\!\#\$\%\&\'\*\+\-\/\=\?\^\`\{\|\}\~]+\.)*[\w\!\#\$\%\&\'\*\+\-\/\=\?\^\`\{\|\}\~]+@(?:(?:(?:[a-zA-Z0-9_](?:[a-zA-Z0-9_\-](?!\.)){0,61}[a-zA-Z0-9_-]?\.)+[a-zA-Z0-9_](?:[a-zA-Z0-9_\-](?!$)){0,61}[a-zA-Z0-9_]?)|(?:\[(?:(?:[01]?\d{1,2}|2[0-4]\d|25[0-5])\.){3}(?:[01]?\d{1,2}|2[0-4]\d|25[0-5])\]))$/', $email);
        }

        if ($return == false) {
            if ($dev == false) {
                $dev2["error"] = "false";
                $dev2["mensaje"] = "El correo electronico " . $email . " No es valido";
                Utils::parseJson3($dev2, $return);
            }
        } else {
            return $dev;
        }
    }

    //put your code here
    static function aumentarEnUno() {
        $link = new BD();
        $link->conectar();
        $link->consulta("UPDATE contador SET contador = (contador+1);");
    }

    static function getLimit($start, $limit) {
        $start = $start * 1;
        $limit = $limit * 1;

        $dev = "";
        if ($limit > 0) {
            $dev = " LIMIT $start, $limit ";
        }
        return $dev;
    }

    static function getSort($sort, $dir, $default, $dirD = "ASC") {
        $order = "";
        if ($sort != null) {
            $order = "ORDER BY $sort ";
            if ($dir != null && $dir != "") {
                $order .= " $dir ";
            }
        } else {
            if ($default != null && $default != "") {
                $order = "ORDER BY $default ";
            }
            if ($dirD != null && $dirD != "") {
                $order .= " $dirD ";
            }
        }
        return $order;
    }

    static function genera_password($longitud, $tipo = "alfanumerico") {
        if ($tipo == "alfanumerico") {
            $exp_reg = "/[^A-Z0-9]/";
        } elseif ($tipo == "numerico") {
            $exp_reg = "/[^0-9]/";
        }
        return strtoupper(substr(preg_replace($exp_reg, "", md5(time())) .
                        preg_replace($exp_reg, "", md5(time())) .
                        preg_replace($exp_reg, "", md5(time())), 0, $longitud));
    }

    static function getTablaToArrayOfSQL2($sql, $sqltotal, $round = 6) {
        //
        //    echo $sql;
        $totalCount = 0;
        if ($link = new BD) {
            if ($link->conectar()) {
                if ($re = $link->consulta($sql)) {

                    //                echo mysql_num_rows($re);
                    if ($fi = mysql_fetch_array($re)) {
                        $ii = 0;
                        //$totalCount = mysql_num_rows($re);
                        for ($i = 0; $i < mysql_num_fields($re); $i++) {
                            $value[0][$i] = mysql_field_name($re, $i);
                        }
                        do {
//                            echo $fi['codigo']."<br>";
                            for ($i = 0; $i < mysql_num_fields($re); $i++) {
//                            echo mysql_field_type($re, $i);
                                if (mysql_field_type($re, $i) == "real") {
                                    //echo mysql_field_name($re, $i)."--".mysql_field_type($re, $i)."--------------".redondear($fi[$i]);;
                                    $value[$ii + 1][$i] = Utils::redondear($fi[$i], $round);
//                                $value{$ii}{mysql_field_name($re, $i)} = redondear($fi[$i]);
                                } else if (mysql_field_type($re, $i) == "date") {
                                    $value[$ii + 1][$i] = Utils::formatoFecha($fi[$i]);
                                } else {
                                    $value[$ii + 1][$i] = $fi[$i];
                                }
                            }

                            $ii++;
                        } while ($fi = mysql_fetch_array($re));
                        $dev['mensaje'] = "Existen resultados";
                        $dev['error'] = "true";
                        $dev['resultado'] = $value;
                    } else {
                        $dev['mensaje'] = "No se encontro datos en la consulta2 " . mysql_error();
                        $dev['error'] = "false";
                        $dev['resultado'] = "";
                    }
                } else {
                    $dev['mensaje'] = "Error en la consulta " . mysql_error();
                    $dev['error'] = "false";
                    $dev['resultado'] = "";
                }
            } else {
                $dev['mensaje'] = "No se pudo conectar a la BD";
                $dev['error'] = "false";
                $dev['resultado'] = "";
            }
        } else {
            $dev['mensaje'] = "No se pudo crear la conexion a la BD";
            $dev['error'] = "false";
            $dev['resultado'] = "";
        }
        if ($sqltotal != null) {
//            echo $sqltotal;
            $dev['totalCount'] = Utils::allBySql2($sqltotal);
        } else {
            $dev['totalCount'] = "0";
        }

        return $dev;
    }

    static function allBySql2($sql) {
//        echo $sql;
        $dev = 0;
        $link = new BD();
        $link->conectar();
        if ($sql != null) {
            $re = $link->consulta($sql);
            if ($fi = mysql_fetch_array($re)) {
                $dev = $fi['total'];
            }
//            else {
//                echo $sql;
//            }
        }
        return $dev;
    }

    static function MostrarErroresAvisos() {

        if ($_SESSION['error'] != NULL) {
            $dev = "<div style='color:red;'>" . $_SESSION['error'] . "</div>";
            $_SESSION['error'] = '';
        }
        if ($_SESSION['mensaje'] != NULL) {
            $dev = "<div style='color:green'>" . $_SESSION['mensaje'] . "</div>";
            $_SESSION['mensaje'] = '';
        }
        echo $dev;
    }

    static function generarWhereUpdate($setC) {
        $dev = "";
        if ($setC != NULL) {
            $i = 0;
            do {
                if ($setC[$i]['dato'] != null && $setC[$i]['dato'] != "") {
                    if ($dev == "") {
                        $dev = $setC[$i]['campo'] . " = '" . $setC[$i]['dato'] . "' ";
                    } else {
                        $dev .= " AND " . $setC[$i]['campo'] . " = '" . $setC[$i]['dato'] . "' ";
                    }
                }
                $i++;
            } while (next($setC) != false);
            $dev = $dev . ";";
        }
        return $dev;
    }

    static function generarSetsUpdate($setC) {
        $dev = '';
        if ($setC != NULL) {
            $i = 0;
            do {
                $data = "" . $setC[$i]['dato'];
//                echo  "|".$setC[$i]['campo']."|_______|".$setC[$i]['dato']."|<br>";
                if ($data != "_esc_") {

                    if ($devv == "") {
                        $tt = substr($data, 0, 1);
                        $ttt = substr($data, 0, 8);
                        $ttt = trim($ttt);

                        if ($tt == "(" || $ttt == "COALESCE") {
                            $dev = $setC[$i]['campo'] . " = " . $data . " ";
                        } else if ($setC[$i]['dato'] === NULL) {
                            $dev = $setC[$i]['campo'] . " = NULL ";
                        } else {
                            $dev = $setC[$i]['campo'] . " = '" . $data . "' ";
                        }
                        $devv = "asdf";
                    } else {
//                        echo $setC[$i]['dato'];
//                        echo "<br>";

                        $tt = substr($data, 0, 1);
                        $ttt = substr($data, 0, 8);
                        //                     echo $tt."--".$setC[$i]['dato']."<br>";
                        if ($tt == "(" || $ttt == "COALESCE") {
                            $dev .= ", " . $setC[$i]['campo'] . " = " . $data . " ";
                        } else if ($setC[$i]['dato'] === NULL) {
                            $dev .= ", " . $setC[$i]['campo'] . " = NULL ";
                        } else {
                            $dev .= ", " . $setC[$i]['campo'] . " = '" . $data . "' ";
                        }
                    }
                }
                $i++;
            } while (next($setC) != false);
        }
        return $dev;
    }

    static function getDataBD($data) {

        if ($data == "" || $data == null) {
            return "_esc_";
        } else {
            return $data;
        }
    }

    static function generarInsertValues($setC) {
        $tem = $setC;
        $dev = '';
        if ($setC != NULL) {
            $i = 0;
            do {
//            if (($setC[$i]['dato'] != null && $setC[$i]['dato'] != "") || ($setC[$i]['dato'] == "0")) {
                $data = "" . $setC[$i]['dato'];
                if ($data != "_esc_") {
                    //                echo $setC[$i]['campo']."----".$setC[$i]['dato']."---";
                    if ($dev == "") {
                        $dev = "(" . $setC[$i]['campo'] . " ";
                    } else {
                        $dev .= ", " . $setC[$i]['campo'] . " ";
                    }
                }
                $i++;
            } while (next($setC) != false);
            $dev .= ") VALUES";
            $devv = "";
            $i = 0;
            do {
                $data = "" . $setC[$i]['dato'];
                if ($data != "_esc_") {
                    if ($devv == "") {
                        $tt = substr($tem[$i]['dato'], 0, 1);
                        $ttt = substr($tem[$i]['dato'], 0, 8);
                        $ttt = trim($ttt);
                        if ($tt == "(" || $ttt == "COALESCE") {
                            $dev .= "(" . $tem[$i]['dato'] . " ";
                        } else {
                            $dev .= "('" . $tem[$i]['dato'] . "' ";
                        }
                        $devv = "asdf";
                    } else {
                        $tt = substr($tem[$i]['dato'], 0, 1);
                        $ttt = substr($tem[$i]['dato'], 0, 8);
                        if ($tt == "(" || $ttt == "COALESCE") {
                            $dev .= ", " . $tem[$i]['dato'] . " ";
                        } else {
                            $dev .= ", '" . $tem[$i]['dato'] . "' ";
                        }
                    }
                }
                $i++;
            } while (next($tem) != false);
        }
        $dev .= ");";
        return $dev;
    }

    static function ejecutarConsulta($sql) {
        $dev = false;

        if ($sql != NULL) {
            $link = new BD;
            $link->conectar();
            if ($link->consulta($sql)) {
                $dev = true;
            }
            $link->cerrar();
        }
        return $dev;
    }

    static function ejecutarConsultaSQLBeginCommit3($sql) {
        $dev = false;
        $consultaFalluda = "";
        if ($sql != NULL) {
            $link = new BD;
            $link->conectar();
            $i = 0;
            $link->consulta("begin");
            do {
                $consultaFalluda = $sql[$i];
                if ($link->consulta($sql[$i])) {
                    $pr = substr($consultaFalluda, 0, 6);
                    if ($pr == "UPDATE") {
                        $bandera = true;
                    } else {
                        $bandera = true;
                    }
                } else {
                    $bandera = false;
                    $errorrrr = $link->getLastError();
                    break;
                }
                $i++;
            } while (next($sql) != false);
            if ($bandera == true) {
                $link->consulta("commit");
//                $sqll = Utils::ReturnConsultas($sql);
//                Utils::GenerarErrorLog("error mysql", "Edwin", $sqll, "Ok", "no", "si", "");
                $dev = true;
            } else {
                $link->consulta("rollback");
//                $sqll = $consultaFalluda . "-->" . $errorrrr;
//                Utils::GenerarErrorLog("error", "Edwin", $sqll, "Error", "no", "si", "");
                $dev = false;
            }
            $link->cerrar();
        } else {
            $dev = false;
        }
//        echo $errorrrr;
        return $dev;
    }

    static function enviarEmail($direccion, $referencia, $mensaje, $adjuntos) {

        $mensaje = str_replace("_esc_", "\"", $mensaje);
        $mensaje = str_replace("_es1_", "<", $mensaje);
        $mensaje = str_replace("_es2_", ">", $mensaje);
        $mensaje = nl2br($mensaje);

        $mail = new PHPMailer();

//        $mail->IsSMTP();
//        $mail->SMTPAuth = true;                  // enable SMTP authentication
//        $mail->SMTPSecure = "TLS";                 // sets the prefix to the servier
//        $mail->Host = "smtp.gmail.com";      // sets GMAIL as the SMTP server
//        $mail->Port = "465";
//        $mail->Username = "selkisweb@gmail.com";  // GMAIL username
//        $mail->Password = "informacion16";            // GMAIL password
//        $mail->From = "selkisweb@gmail.com";
//        $mail->FromName = "El Titi.bo";
//        $mail->Subject = $referencia;
//        $mail->AltBody = "Texto alternativo"; //Text Body
//        $mail->WordWrap = 50; // set word wrap
//        $mail->AddReplyTo("selkisweb@gmail.com", "El TiTi.bo");

        $mail->SMTPSecure = "ssl";                 // sets the prefix to the servier
        $mail->Host = "smtp.eltiti.bo";      // sets GMAIL as the SMTP server
        $mail->Port = "465";
        $mail->Username = "info@eltiti.bo";  // GMAIL username
        $mail->Password = "informacion16";            // GMAIL password
        $mail->From = "info@eltiti.bo";
        $mail->FromName = "El Titi.bo";
        $mail->Subject = $referencia;
        $mail->AltBody = "Texto alternativo"; //Text Body
        $mail->WordWrap = 50; // set word wrap
        $mail->AddReplyTo("info@eltiti.bo", "El TiTi.bo");


        $mail->MsgHTML($mensaje);
        $dir = preg_split("/,/", $direccion);
        for ($s = 0; $s < count($dir); $s++) {
            $correo = $dir[$s];
            if (strlen($correo) > 1) {
                $mail->AddAddress($correo, $correo);
            }
        }

        $mail->IsHTML(true); // send as HTML

        if (!$mail->Send()) {
            $dev = false;
        } else {
            $dev = true;
        }
        return $dev;
    }

    static function parseJson4($dev, $return) {

        if ($return == true) {
            return $dev;
        } else {
            $json = new Services_JSON();
            $output = $json->encode($dev);
            echo Utils::selkisEncode($output);
            exit;
        }
    }

    static function parseJson3($dev, $return) {

        if ($return == true) {
            return $dev;
        } else {
            $json = new Services_JSON();
            $output = $json->encode($dev);
            echo Utils::encode_this($output);
            exit;
        }
    }

    static function selkisDecode($input) {
        $semilla = "HA6XC9cL2xvY2FsaG9zdFwvRWxUaXRpXC9idWlsZFwvd2Vi";
        $largo = strlen($input);
        if ($largo > (100 + strlen($semilla))) {
            $input = substr($input, 0, 100) . substr($input, (100 + strlen($semilla)));
        } else {
            $input = substr($input, 0, 4) . substr($input, (4 + strlen($semilla)));
        }
        $dev = Utils::decode_this($input);
        return $dev;
    }

    static function selkisEncode($input) {

        $semilla = "HA6XC9cL2xvY2FsaG9zdFwvRWxUaXRpXC9idWlsZFwvd2Vi";
        $dev = Utils::encode_this($input);
        $largo = strlen($dev);
        if ($largo > 100) {
            $dev = substr($dev, 0, 100) . $semilla . substr($dev, 100);
        } else {
            $dev = substr($dev, 0, 4) . $semilla . substr($dev, 4);
        }
        return $dev;
    }

    static function encode_this($string) {
        $control = "";
        $tmp_string = $string;
        $string = $control . $tmp_string . $control;
        $string = base64_encode($string);

        return($string);
    }

    static function decode_this($string) {
        $control = "";
        $tmp_string = $string;
        $string = $control . $tmp_string . $control;

        $string = base64_decode($string);

        return($string);
    }

    static function getUltimoID($tabla) {
        $dev = 99999;
        $sql = "SELECT id" . $tabla . " FROM $tabla ORDER BY id" . $tabla . " DESC LIMIT 1";
        if ($link = new BD) {
            if ($link->conectar()) {
                if ($re = $link->consulta($sql)) {
                    if ($fi = mysql_fetch_array($re)) {
                        $dev3 = $fi["id" . $tabla];
                        $dev = substr($dev3, 4);
                    }
                }
            }
        }
        return $dev + 1;
    }

    static function getObjectOfSQL($sql, $round = 6) {
        //
//                echo $sql;
        $totalCount = 0;
        if ($link = new BD) {
            if ($link->conectar()) {
                if ($re = $link->consulta($sql)) {

                    //                echo mysql_num_rows($re);
                    if ($fi = mysql_fetch_array($re)) {
                        for ($i = 0; $i < mysql_num_fields($re); $i++) {

                            if (mysql_field_type($re, $i) == "real") {
//                                echo mysql_field_name($re, $i) . "--" . $fi[$i] . "---" . Utils::redondear($fi[$i], $round);
                                $value{mysql_field_name($re, $i)} = Utils::redondear($fi[$i], $round);
//                            $value{mysql_field_name($re, $i)} = $fi[$i];
                            } else {
                                $value{mysql_field_name($re, $i)} = $fi[$i];
                            }
                        }
                        $dev['mensaje'] = "Existen resultados";
                        $dev['error'] = "true";
                        $dev['resultado'] = $value;
                    } else {
                        $dev['mensaje'] = "No se encontro datos en la consulta2" . $link->getLastError();
                        $dev['error'] = "false";
                        $dev['resultado'] = "";
                    }
                } else {
                    $dev['mensaje'] = "Error en la consulta " . $link->getLastError();
                    $dev['error'] = "false";
                    $dev['resultado'] = "";
                }
            } else {
                $dev['mensaje'] = "No se pudo conectar a la BD " . $link->getLastError();
                $dev['error'] = "false";
                $dev['resultado'] = "";
            }
        } else {
            $dev['mensaje'] = "No se pudo crear la conexion a la BD " . $link->getLastError();
            $dev['error'] = "false";
            $dev['resultado'] = "";
        }
//        echo $dev["resultado"]["idcliente"];
        return $dev;
    }

    static function getObjectOfSQL2($sql, $round = 6) {
        $dev = null;
        $totalCount = 0;
        if ($link = new BD) {
            if ($link->conectar()) {
                if ($re = $link->consulta($sql)) {
                    if ($fi = mysql_fetch_array($re)) {
                        for ($i = 0; $i < mysql_num_fields($re); $i++) {
                            if (mysql_field_type($re, $i) == "real") {
                                $dev{mysql_field_name($re, $i)} = Utils::redondear($fi[$i], $round);
                            } else {
                                $dev{mysql_field_name($re, $i)} = $fi[$i];
                            }
                        }
                    }
                }
            }
        }
        return $dev;
    }

    static function redondear($numero, $digito = 2) {
        $xx = strpos($numero, "E");
        if ($xx > 0) {
            $po = substr($numero, $xx + 2);
            if ($po > 3) {
                $numero = 0;
            }
        }
        $numero = $numero * 1;
        $numero = number_format($numero, 7, ".", "");
//        echo " ++" . $numero . "++ ";
        $dev = 0.00;

        if ($numero < 0) {
            $numero = $numero * (-1);
            $negativo = true;
        } else {
            $negativo = false;
        }

        if (substr($numero, 0, 1) > 0) {
            //mayor a 1
            if ($numero == NULL) {
                $numero = 0;
                $numero = $numero . ".";
                for ($i = 0; $i < $digito; $i++) {
                    $numero = $numero . "0";
                }
                $dev = $numero;
            } else {
                if (strpos($numero, '.') == false) {
                    //no tiene punto decimal
                    $numero = $numero . ".";
                    for ($i = 0; $i < $digito; $i++) {
                        $numero = $numero . "0";
                    }
                    $dev = $numero;
                } else {
                    //con punto decimal
                    if (strlen($numero) < (strpos($numero, '.') + $digito + 1)) {
                        $numero = substr($numero, 0, (strpos($numero, '.') + $digito + 1));
                        for ($i = 1; $i < $digito; $i++) {
                            $numero = $numero . "0";
                        }
                        $dev = $numero;
                    } else {
                        $numero = round($numero, $digito);
                        if (strpos($numero, '.') == false) {
                            //si no es decimal le aumentamos 0
                            $numero = $numero . ".";
                            for ($i = 0; $i < $digito; $i++) {
                                $numero = $numero . "0";
                            }
                            $dev = $numero;
                        } else {
//                            echo $numero . "---+" . (strpos($numero, '.') + $digito + 1);
                            $numero = substr($numero, 0, (strpos($numero, '.') + $digito + 1));
                            if (strlen($numero) < (strpos($numero, '.') + $digito + 1)) {
                                for ($ig = 0; $ig < ((strpos($numero, '.') + $digito + 1) - strlen($numero)); $ig++) {
                                    $numero = $numero . "0";
                                }
                            }
                            $dev = $numero;
                        }
                    }
                }
            }
        } else {

            if ($numero > 0) {

                $redt = "";
                for ($ju = 0; $ju < strlen($numero); $ju++) {
                    $x = substr($numero, $ju, 1);
                    if ($x > 0) {
                        $numero = substr($numero, $ju);
                        $numero = "0." . $numero;
                        $numero = round($numero, $digito);
                        $numeroF = substr($numero, 2);
                        $ju = 1000;
                    } else {
                        $redt .= $x;
                    }
                }
                $dev = $redt . $numeroF;
            } else {
//                echo "asdfasdf ".$numero;;
                //Cuando es 0
                $numero = 0;
                $numero = $numero . ".";
                for ($i = 0; $i < $digito; $i++) {
                    $numero = $numero . "0";
                }
                $dev = $numero;
            }
        }
        if ($negativo == true) {
            $dev = $dev * (-1);
        }

        return "" . $dev;
    }

}
