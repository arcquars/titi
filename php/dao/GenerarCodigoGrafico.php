<?php

session_name("ElTiTi");
session_start();
header("Content-type: image/png");
$im = @ImageCreate(60, 17);
$color_fondo = ImageColorAllocate($im, 240, 240, 240);
$color_texto = ImageColorAllocate($im, 233, 14, 91);
//echo $_SESSION["codigoGrafico"];
imagestring($im, 10, 2, 1, $_SESSION["codigoGrafico"], $color_texto);
//ImageString ($im, 10, 25, 5, $_SESSION["codigoGrafico"], $color_texto);
ImagePng($im);
?>