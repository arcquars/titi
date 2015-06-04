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
class UsuarioDAO {

//put your code here
    static function txNewPassword($datos, $return = false) {
        $dev['error'] = "false";
        $dev['mensaje'] = "";
        $usuarO = new Usuario();
        $usuarO->setEmail($datos->email);
        $usuarO->loadDataByEmail("", true);
        if ($usuarO->getIdusuario() != null) {
            if ($usuarO->getSeguridad() == $datos->seguridad) {
                $usuarO->setSeguridad("asdfa fasas asdf");
                $usuarO->setPassword(md5($datos->pass));
                $sqlA[] = $usuarO->getUpdateSql();
                if (Utils::ejecutarConsultaSQLBeginCommit3($sqlA)) {
                    $dev['mensaje'] = "Se cambio su contraseña correctamente";
                } else {
                    $dev['mensaje'] = "No se pudo cambiar la contraseña por favor intente nuevamente";
                }
            } else {
                $dev['mensaje'] = "No coincide el codigo de seguridad generado";
            }
        } else {
            $dev['mensaje'] = "No tenemos ningun usuario registrado con este correo electronico: " . $datos->email;
        }

        Utils::parseJson3($dev, $return);
    }

    static function txSolicitarContrasena($datos, $return = false) {
        $dev['error'] = "false";
        $dev['mensaje'] = "";
        $usuarO = new Usuario();
        $usuarO->setEmail($datos->email);
        $usuarO->loadDataByEmail("", true);
        if ($usuarO->getIdusuario() != null) {
            if ($usuarO->getEstado() == "Activo") {
                $usuarO->setSeguridad(md5(date("y-m-d") . date("H:i:s")));
                $sqlA[] = $usuarO->getUpdateSql();
                if (Utils::ejecutarConsultaSQLBeginCommit3($sqlA)) {
                    $enlace = "http://www.eltiti.bo/index.php?p=all&cat=Todos&q=&f=perdiContrasena&vee=" . $datos->email . "&ves=" . $usuarO->getSeguridad();
                    $mensaje = "<a href='$enlace'>$enlace</a>";
                    $dev['error'] = "true";
                    if (Utils::enviarEmail($datos->email, "El TiTi.com - Solicitud nueva contraseña", $mensaje, null)) {
                        $dev['mensaje'] = "Se envio correctamente el codigo de verificacion a su correo electronico";
                    } else {
                        $dev['mensaje'] = "No se pudo enviar el codigo de verificacion a su correo electronico";
                    }
                } else {
                    $dev['mensaje'] = "Error al genera el codigo de seguridad";
                }
            } else {
                $dev['mensaje'] = "El usuario no esta activo actualmente para que podamos enviarle su contraseña";
            }
        } else {
            $dev['mensaje'] = "No tenemos registrado un usuario con este correo electronico: " . $datos->email;
        }

        Utils::parseJson3($dev, $return);
    }

    static function txSolicitarCodigo($datos, $return = false) {
        $dev['error'] = "false";
        $dev['mensaje'] = "";
        $usuarO = new Usuario();
        $usuarO->setEmail($datos->email);
        $usuarO->loadDataByEmail("", true);
        if ($usuarO->getIdusuario() != null) {
            if ($usuarO->getEstado() == "Espera") {


                $usuarO->setSeguridad(md5(date("y-m-d") . date("H:i:s")));
                $sqlA[] = $usuarO->getUpdateSql();
                if (Utils::ejecutarConsultaSQLBeginCommit3($sqlA)) {
                    $enlace = "http://www.eltiti.bo/index.php?p=all&cat=Todos&q=&f=validarEmail&vee=" . $datos->email . "&ves=" . $usuarO->getSeguridad();
                    $mensaje = "<a href='$enlace'>$enlace</a>";
                    $dev['error'] = "true";
                    if (Utils::enviarEmail($datos->email, "El TiTi.com - Validar direccion de correo electronico", $mensaje, null)) {
                        $dev['mensaje'] = "Se envio correctamente el codigo de verificacion a su correo electronico";
                    } else {
                        $dev['mensaje'] = "No se pudo enviar el codigo de verificacion a su correo electronico";
                    }
                } else {
                    $dev['mensaje'] = "Error al genera el codigo de seguridad";
                }
            } else {
                $dev['mensaje'] = "El usuario ya valido su correo electronico ";
            }
        } else {
            $dev['mensaje'] = "No tenemos registrado un usuario con este correo electronico: " . $datos->email;
        }

        Utils::parseJson3($dev, $return);
    }

    static function txVerificarEmail($datos, $return = false) {
        $dev['error'] = "false";
        $dev['mensaje'] = "";
        $usuarO = new Usuario();
        $usuarO->setEmail($datos->email);
        $usuarO->loadDataByEmail("", true);
        if ($usuarO->getIdusuario() != null) {
            if ($usuarO->getSeguridad() == $datos->seguridad) {
                $usuarO->setEstado("Activo");
                $sqlA[] = $usuarO->getUpdateSql();
                if (Utils::ejecutarConsultaSQLBeginCommit3($sqlA)) {
                    $dev['error'] = "true";
                    $dev['mensaje'] = "Se verifico correctamente su usuario por favor inicie sesion";
                } else {
                    $dev['mensaje'] = "No se pudo verificar su correo electronico, intentelo nuevamente o solicite un nuevo codigo de seguridad";
                }
            } else {
                $dev['mensaje'] = "No coincide el codigo de seguridad por favor solicite otro codigo";
            }
        } else {
            $dev['mensaje'] = "No tenemos ningun usuario registrado con este correo electronico: " . $datos->email;
        }

        Utils::parseJson3($dev, $return);
    }

    static function txSaveUsuario($datos, $return = false) {
        $dev['error'] = "false";
        $dev['mensaje'] = "";
        Utils::validarPassword($datos->pass, $datos->pass1);
        Utils::validarLogin($datos->login);
        Utils::validarEmail($datos->email);
        $usuarO = new Usuario();
        $usuarO->setLogin($datos->login);
        $usuarO->loadDataByLogin("", true);
        if ($usuarO->getIdusuario() == null) {
            $usuarO->setNit($datos->nit);
            $usuarO->loadDataByNit("", true);
            if ($usuarO->getIdusuario() == null) {
                $usuarO->setEmail($datos->email);
                $usuarO->loadDataByEmail("", true);
                if ($usuarO->getIdusuario() == null) {
                    $ultimoId = Utils::getUltimoID("usuario");
                    $usuarO->setIdusuario("usr-" . $ultimoId);
                    $usuarO->setNombre($datos->nombre);
                    $usuarO->setCi($datos->ci);
                    $usuarO->setDepartamento($datos->departamento);
                    $usuarO->setSexo($datos->sexo);
                    $usuarO->setEstado("Espera");
                    $usuarO->setSeguridad(md5(date("y-m-d") . date("H:i:s")));
                    $usuarO->setPassword(md5($datos->pass));
                    $sqlA[] = $usuarO->getNewSql();
                    if (Utils::ejecutarConsultaSQLBeginCommit3($sqlA)) {
                        $enlace = "http://www.eltiti.bo/index.php?p=all&cat=Todos&q=&f=validarEmail&vee=" . $datos->email . "&ves=" . $usuarO->getSeguridad();
//                        $mensaje = "<a href='$enlace'>$enlace</a>";
                        $mensaje = "<center><table width='500px' border='0' cellpadding='10' cellspacing='0' style='border: 1px solid #AAAAAA;'>
                <tbody><tr>
                        <td bgcolor='#eeeeee' style='font:12px Arial,Helvetica,sans-serif;color:#666666;line-height:140%'><p>Estimado " . $usuarO->getNombre() . ",</p>
                            <p><strong> Confirme su direccion de correo electronico</strong>.<br>
                                Está recibiendo este correo electronico porque ud se registro en nuestro sistema de ventas online ElTiTi.bo y necesitamos que confirme que este correo electronico le pertenece a Ud.
                                <span>Si ud no se registro en ElTiTi.bo, tan solo ignórelo. Si sigue recibiendo este e-mail, por favor <a href='http://www.eltiti.bo/index.php?p=all&cat=Todos&q=&f=contacto&pro=' style='color:#1a199d' target='_blank'>contáctenos</a>.</span></p>
                            <p>Para confirmar su correo electronico haga click en el siguiente enlace o seleccione el mismo y pegue en su navegador</p>
                            <span><a href='$enlace' style='color:#1a199d' target='_blank'>" . $enlace . "</a></span></p>
                            <p style='border-bottom:1px dashed #666666;padding-bottom:10px'>Saludos!<br>
                                <strong>El equipo de ElTiTi</strong></p>
                            <a href='http://www.eltiti.bo' target='_blank'>http://www.eltiti.bo</a></td>
                    </tr>
                </tbody></table></center>";
                        $dev['error'] = "true";
                        if (Utils::enviarEmail($datos->email, "El TiTi.com - Validar direccion de correo electronico", $mensaje, null)) {
                            $dev['mensaje'] = "Se guardo el usuario correctamente y se envio el correo de verificacion. Gracias por ser parte de nuestra familia";
                        } else {
                            $dev['mensaje'] = "Se guardo el usuario correctamente pero no se pudo enviar el correo de verificacion";
                        }
                    } else {
                        $dev['mensaje'] = "No se pudo guardar el usuario.. por favor intente otra vez " . $sqlA[0];
                    }
                } else {
                    $dev['mensaje'] = "Ya tenemos un usuario registrado con este correo electronico: " . $datos->email;
                }
            } else {
                $dev['mensaje'] = "Ya tenemos un usuario registrado con este numero de nit: " . $datos->nit;
            }
        } else {
            $dev['mensaje'] = "Ya tenemos un usuario registrado con este nombre de usuario: " . $datos->login;
        }
        Utils::parseJson3($dev, $return);
    }

    static function verificarLogin($datos, $return = false) {
        $userO = new Usuario();
        $userO->setLogin($datos->login);
        $userO->loadDataByLogin("asdf", $return);
        $dev = $userO->toJson();
        Utils::parseJson3($dev, $return);
    }

    static function verificarNit($datos, $return = false) {
        $userO = new Usuario();
        $userO->setNit($datos->nit);
        $userO->loadDataByNit("asdf", $return);
        $dev = $userO->toJson();
        Utils::parseJson3($dev, $return);
    }

}
