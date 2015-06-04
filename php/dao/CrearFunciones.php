<?php
session_name("Selkis");
session_start();
?>
<form action="CrearFunciones.php" method="GET">
    <input type="text" id='tabla' name="tabla">
    <input type="submit" value="Aceptar">
</form>

<?php
include("../bd/bd.php");
$link = new BD;
$link->conectar();
$sql = "describe " . $_GET['tabla'] . ";";
echo "class " . ucfirst($_GET['tabla']) . " implements Beans {<br>";
//******************************************* C A B E C E R A **********************************/
$cab = "";
$cuerpo = "";
$pie = "";
if ($re = $link->consulta($sql)) {
    if ($fi = mysql_fetch_array($re)) {
        do {
            $idprin = "id" . strtolower($_GET['tabla']);
            if ($fi['Field'] != $idprin) {
                echo "private \$" . $fi['Field'] . " = \"_esc_\";<br>";
            } else {
                echo "private \$" . $fi['Field'] . ";<br>";
            }
        } while ($fi = mysql_fetch_array($re));
    }
}
echo "<br><br><br>";


//******************************************* CONSTRUCTOR **********************************/
echo "  function __construct() {<br>   }<br><br>";

/* * *****************************para generar objeto***************************************** */
$cab = "";
$cuerpo = "";
$pie = "";
$cab .= "public function loadData(";
$cab .= "\$mensaje, \$return = false";
$cab .= ")<br>";
$cab .= "{<br>";
$cab .= "\$sql = \"SELECT * FROM " . $_GET['tabla'] . " WHERE $idprin = '\" . \$this->$idprin . \"'\";<br>";
$cab .= "\$this->loadDataGeneric(\$sql, \$mensaje, \$return);";
$cab .= "<br>}<br>";
if ($re = $link->consulta($sql)) {
    if ($fi = mysql_fetch_array($re)) {
        $i = 0;
        $cab .= "public function loadDataGeneric(";
        $cab .= "\$sql, \$mensaje, \$return = false";
        $cab .= ")<br>";
        $cab .= "{<br>";
        $idprin = "id" . strtolower($_GET['tabla']);
        $cab .= "\$object = Utils::getObjectOfSQL(\$sql);<br>";
        $cab .= "if (\$object['error'] == \"false\") {<br>";
        $cab .= "if (\$return == false) {<br>";
        $cab .= "    \$dev['mensaje'] = \$mensaje.\" No existe este id \" . \$this->$idprin.\"en la tabla\";<br>";
        $cab .= "    \$dev['error'] = \$cheO['error'];<br>";
        $cab .= "    Utils::parseJson3(\$dev, false);<br>";
        $cab .= "} else {<br>";
        $cab .= "\$this->$idprin = null;<br>";
        $cab .= "}<br>";
        $cab .= "} else {<br>";




        do {
//            if($i == 0)
//            {
//                $cab .= "\$".$fi['Field'];
//            }
//            else
//            {
//                $cab .= ", \$".$fi['Field'];
//            }
//            $this->banco = Utils::getDataBD($cheO['resultado']['banco']);
//            $idprin = "id" . strtolower($_GET['tabla']);
//            if ($idprin != $fi['Field']) {
            $cuerpo .= "\$this->" . $fi['Field'] . " = Utils::getDataBD(\$object['resultado']['" . $fi['Field'] . "']);";
            $cuerpo .= "<br>";
//            $cuerpo .= "\$setC[$i]['dato'] = \$this->" . $fi['Field'] . ";";
//            $cuerpo .= "<br>";
            $i++;
//            }
        } while ($fi = mysql_fetch_array($re));
    }

    echo $cab;
    echo $cuerpo;
    echo "<br>}<br>}";
}
echo "<br><br><br>";
/* * *************************************hasta aqui**************************** */


$cab = "";
$cuerpo = "";
$pie = "";
if ($re = $link->consulta($sql)) {
    if ($fi = mysql_fetch_array($re)) {
        $i = 0;
        $cab .= "public function getNewSql(";
        do {
//            if($i == 0)
//            {
//                $cab .= "\$".$fi['Field'];
//            }
//            else
//            {
//                $cab .= ", \$".$fi['Field'];
//            }
            $cuerpo .= "\$setC[$i]['campo'] = '" . $fi['Field'] . "';";
            $cuerpo .= "<br>";
            $cuerpo .= "\$setC[$i]['dato'] = \$this->" . $fi['Field'] . ";";
            $cuerpo .= "<br>";
            $i++;
        } while ($fi = mysql_fetch_array($re));
        $cab .= ")<br>";
    }
    $cab .= "{<br>";
    echo $cab;
    echo $cuerpo;
    echo "\$sql2 = Utils::generarInsertValues(\$setC);";
    echo "<br>";
    echo "return \"INSERT INTO " . $_GET['tabla'] . " \".\$sql2;";
    echo "<br>";
    echo "}";
}
echo "<br><br><br>";
$link = new BD;
$link->conectar();
$sql = "describe " . $_GET['tabla'] . ";";
$cab = "";
$cuerpo = "";
$pie = "";
if ($re = $link->consulta($sql)) {
    if ($fi = mysql_fetch_array($re)) {
        $z = 0;
        $i = 0;
        $ii = 0;
        $cab .= "public function getUpdateSql(";
        do {
//            if ($fi['Field'] != "numero") {
//                if ($z == 0) {
//                    $cab .= "\$" . $fi['Field'] . " ";
//                } else {
//                    $cab .= ", \$" . $fi['Field'];
//                }
//                $z++;
//            }
            $idprin = "id" . strtolower($_GET['tabla']);
            if ($fi['Field'] != $idprin) {
                if ($fi['Field'] != "numero") {
                    $cuerpo .= "\$setC[$i]['campo'] = '" . $fi['Field'] . "';";
                    $cuerpo .= "<br>";
                    $cuerpo .= "\$setC[$i]['dato'] = \$this->" . $fi['Field'] . ";";
                    $cuerpo .= "<br>";
                    $i++;
                }
            } else {
                $where .= "\$wher[$ii]['campo'] = '" . $fi['Field'] . "';";
                $where .= "<br>";
                $where .= "\$wher[$ii]['dato'] = \$this->" . $fi['Field'] . ";";
                $where .= "<br>";
                $ii++;
            }
        } while ($fi = mysql_fetch_array($re));
        $cab .= ")";
    }






    $cab .= "{<br>";
    echo $cab;
    echo $cuerpo;
    echo "<br>";
    echo "\$set = Utils::generarSetsUpdate(\$setC);";
    echo "<br>";
    echo $where;
    echo "<br>";
    echo "\$where = Utils::generarWhereUpdate(\$wher);";
    echo "<br>";
    echo "return \"UPDATE " . $_GET['tabla'] . " SET \".\$set.\" WHERE \".\$where;";
    echo "<br>";
    echo "}";

//para eliminar
    echo "<br>";
    echo "<br>";
    echo "<br>";
    echo "<br>";
    echo "<br>";
    $del .= "function getDeleteSql(){";
    $del .= "<br>";
    $del .= "return \"DELETE FROM " . strtolower($_GET['tabla']) . " WHERE id" . strtolower($_GET['tabla']) . " =  '\".\$this->id" . strtolower($_GET['tabla']) . ".\"'\";";
    $del .= "<br>";
    $del .= "}";
    echo $del;
}
/* * ************************************ GETER AND SETER ******************************** */
$cab = "";
$cuerpo = "";
$pie = "";
if ($re = $link->consulta($sql)) {
    if ($fi = mysql_fetch_array($re)) {
        do {

            echo "public function get" . ucfirst($fi['Field']) . "() {<br>";
            echo "return \$this->" . $fi['Field'] . ";<br>";
            echo "}<br><br>";

            echo "public function set" . ucfirst($fi['Field']) . "(\$" . $fi['Field'] . ") {<br>";
            echo "\$this->" . $fi['Field'] . " =  \$" . $fi['Field'] . ";<br>";
            echo "}<br><br>";



//
//    public function setNumero($numero) {
//        $this->numero = $numero;
//    }
//            $idprin = "id" . strtolower($_GET['tabla']);
//            if ($fi['Field'] != $idprin) {
//                echo "private \$" . $fi['Field'] . " = \"_esc_\";<br>";
//            } else {
//                echo "private \$" . $fi['Field'] . ";<br>";
//            }
        } while ($fi = mysql_fetch_array($re));
    }
}
echo "<br><br>";
echo "public function toJson() {<br>";
echo "\$vars_clase = get_class_vars(get_class());<br>";
echo "foreach (\$vars_clase as \$nombre => \$valor) {<br>";
echo "\$value{\$nombre} = \$this->\$nombre;<br>";
echo "}<br>";
echo "return \$value;<br>";
echo "}<br>";
echo "/**************************************************************************************************/<br><br><br>";
echo "/**************************************************************************************************/<br>";
echo "<br><br><br>}<br><br><br>";



//******************************************* C A B E C E R A **********************************/
$cab = "";
$cuerpo = "";
$pie = "";
if ($re = $link->consulta($sql)) {
    if ($fi = mysql_fetch_array($re)) {
        echo "\$" . substr(strtolower($_GET['tabla']), 0, 3) . "O = new " . ucfirst($_GET['tabla']) . "();<br>";
        do {
//            echo "public function set" . ucfirst($fi['Field']) . "(\$" . $fi['Field'] . ") {<br>";

            echo "\$" . substr(strtolower($_GET['tabla']), 0, 3) . "O->set" . ucfirst($fi['Field']) . "(\$" . $fi['Field'] . ");<br>";
//            echo "}<br><br>";
        } while ($fi = mysql_fetch_array($re));
    }
}
echo "<br><br><br>";
$cab = "";
$cuerpo = "";
$pie = "";
if ($re = $link->consulta($sql)) {
    if ($fi = mysql_fetch_array($re)) {
        echo "\$" . substr(strtolower($_GET['tabla']), 0, 3) . "O = new " . ucfirst($_GET['tabla']) . "();<br>";
        do {
//            echo "public function set" . ucfirst($fi['Field']) . "(\$" . $fi['Field'] . ") {<br>";

            echo "\$" . substr(strtolower($_GET['tabla']), 0, 3) . "O->set" . ucfirst($fi['Field']) . "(Utils::getDataBD(\$object['" . $fi['Field'] . "']));<br>";
//            echo "}<br><br>";
        } while ($fi = mysql_fetch_array($re));
    }
}
echo "<br><br><br>";
?>