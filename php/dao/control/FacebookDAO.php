<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of FacebookDAO
 *
 * @author edwin
 */
class FacebookDAO {

//put your code here
//        const ID_APP = 'ID APLICACION';  
//    const SECRETO = 'SECRETO APLICACION';  
//    const ACCESS_TOKEN = 'TOKEN ACCESO';  
//    const ID_ALBUM = 'ID ALBUM';  
//    const ID_PAGINA = 'ID PAGINA';  
    private $app_id;
    private $app_secret;
    private $token;
    private $idpagina;
    private $fb;

    function __construct() {
        $this->app_id = '802835486476344'; // Sustituimos las X por el ID de nuestra aplicación
        $this->app_secret = '2562da92236d3aabb373173f0403cc30'; // Sustituimos las X por el Secret de nuestra aplicación
        $this->token = 'CAALaLLP8CDgBADR8MVQMK48qZCguOxzksLK29pRpaYGvxnESxAvgs7jWPf4zjdHm684eqBoPvnn29a9znHCrThq20AvZBArVt7jNshSNauSGKYQCytsdPf0oZBabQoiBKoNfG0pDLD1tTZCmttRJ3lIHdZCoqJgRdaZAyrR9WYZBaZBce7cOmZAlDAhZC8HGHEvkHkNPUUaCaogsq1tuSTyXKX1p5ZCBdszrZCEZD'; // ponemos nuestro token
        $this->idpagina = "Zooe.ConcienciayRespetoAnimal";
        $this->fb = new Facebook(array(
            'appId' => $this->app_id,
            'secret' => $this->app_secret,
            'cookie' => true
        ));
    }

    function publicar() {

        $req = array(
            'access_token' => $token,
            'message' => 'Mensaje de prueba con mi aplicación');

//        $res = $facebook->api('/me/feed', 'POST', $req);
        $res = $this->fb->api('/' . $this->idpagina . '/feed', 'POST', $req);
    }

//    private $fb;  
//  
//    /** 
//     * Constructor de la clase. Crea el objeto Facebook que utilizaremos 
//     * en los métodos que interactúan con la red social 
//     */  
//    function __construct() {  
//        $this->fb = new Facebook(array(  
//          'appId'  => self::ID_APP,  
//          'secret' => self::SECRETO,  
//          'cookie' => true  
//        ));  
//    }  

    /**
     * Publica un evento 
     * @param string $titulo Título del evento 
     * @param string $descripcion Descripción del evento 
     * @param string $inicio Fecha o fecha y hora de inicio del evento, en formato ISO-8601 o timestamp UNIX 
     * @return bool Indica si la acción se llevó a cabo con éxito 
     */
    function publicarEvento($titulo, $descripcion, $inicio) {
        $params = array(
            'access_token' => $this->app_id,
            'name' => $titulo,
            'description' => $descripcion,
            'start_time' => $inicio,
        );

        $res = $this->fb->api('/' . $this->idpagina . '/events', 'POST', $params);
        if (!$res or $res->error)
            return false;

        return true;
    }

    /**
     * Publica una nota en el muro de la página 
     * @param string $mensaje 
     * @return bool Indica si la acción se llevó a cabo con éxito 
     */
    function publicarNota($mensaje) {
        $params = array(
            'access_token' => $this->app_id,
            'message' => $mensaje
        );
        $res = $this->fb->api('/' . $this->idpagina . '/feed', 'POST', $params);
        if (!$res or $res->error)
            return false;

        return true;
    }

    /**
     * Publica una imagen en el álbum de la página 
     * @param string $ruta Ruta absoluta a la imagen en nuestro servidor 
     * @param string $mensaje Mensaje a mostrar en el muro, si queremos avisar 
     * de la subida de la imagen 
     * @return bool Indica si la acción se llevó a cabo con éxito 
     */
    function publicarImagen($ruta, $mensaje = '') {
        $this->fb->setFileUploadSupport(true);

        $params = array(
            'access_token' => self::ACCESS_TOKEN,
            'source' => "@$ruta"
        );
        if ($mensaje)
            $params['message'] = $mensaje;

        $res = $this->fb->api('/' . self::ID_ALBUM . '/photos', 'POST', $params);
        if (!$res or $res->error)
            return false;

        return true;
    }

}

?>