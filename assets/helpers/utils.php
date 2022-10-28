<?php
class utils {
    
    /*     * ******** Validar Login ********* */
    public static function isIdentity() {
        if (!isset($_SESSION['identity-imsupport'])) {
            header("Location:" . base_url);
        } else {
            return true;
        }
    }
    
    /*     * ******** Metodo para eliminar sesion ********* */
    public static function deleteSession($name) {
        if (isset($_SESSION[$name])) {
            $_SESSION[$name] = null;
            unset($_SESSION[$name]);
        }
        return $name;
    }

    // /*     * ******** Metodo pintar array's con estilo ********** */
    public static function drawDebug($strContent = ""){
        
        if($strContent == "" || $strContent == null || $strContent == false){
            var_dump($strContent);
        }
        else{
            print_r("<pre style='text-align: left!important; direction:ltr;'>\r\r");
            print_r($strContent);
            print_r("\r\r</pre>");
        }    
    }
    
    }
