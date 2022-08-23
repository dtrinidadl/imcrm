<?php

require_once 'models/usuario.php';
require_once 'models/comercio.php';
require_once 'models/tipoUsuario.php';
require_once 'models/catRol.php';
require_once 'models/catEstadoAI.php';
require_once 'models/perfil.php';
require_once 'models/usuario_perfil.php';
require_once 'views/usuario/view_comercio.php';

class usuarioController {

    public function getAjax() {
        if (isset($_GET["getAddArray"])) {
            $int_key = isset($_GET["key"]) ? intval($_GET["key"]) : 0;

            switch ($int_key) {
                case 1:
                    $nombre_comercio = isset($_GET["nombreComercio"]) ? trim($_GET["nombreComercio"]) : null;

                    $comercio = new comercio();
                    $comercio->setNombre($nombre_comercio);
                    $lista_comercios = $comercio->getAllByName();

                    $objArrayView = new view_comercio();
                    $objArrayView->drawListaComercio($lista_comercios);

                    break;
                case 2:
                    $id = isset($_GET["id"]) ? intval($_GET["id"]) : 0;
                    $nombre_comercio = isset($_GET["nombreComercio"]) ? trim($_GET["nombreComercio"]) : null;

                    //print $nombre_comercio; print $_GET['nombreComercio']; die();
                    $objArrayView = new view_comercio();
                    $objArrayView->drawComercioByCodigo($id, $nombre_comercio);

                    break;
                default:
                    break;
            }

            die();
        }
    }

    /*
      public function validate() {

      if (isset($_POST)) {
      // Identificar al usuario Consulta a la base de datos
      $usuario = new usuario();
      $usuario->setUsuario($_POST['txt_user']);
      $usuario->setContrasena($_POST['txt_pass']);
      $identity = $usuario->login();

      if ($identity && is_object($identity)) {

      // Crear Sesion con información de usuario
      $_SESSION['identity'] = $identity;

      print $_SESSION['identity']; die();
      // Crear sesion con información del menu accesible por el usuario
      //                $side_bar = new rolVistaPagina();
      //                $side_bar->setIdRol($identity->idRol);
      //                $menu = $side_bar->getSideBar();
      //
      //                $_SESSION['side-bar'] = $menu;
      //
      //                while($data = $_SESSION['side-bar']->fetch_object()){
      //                    print $data->pagina."<br/>";
      //                }
      //                die();

      header("Location:" . base_url . 'home/index');
      } else {

      $_SESSION['error_login'] = 'Identificacion Fallida';
      header("Location:" . base_url);
      }
      } else {

      header("Location:" . base_url);
      }
      }
     */

    public function validate() {
        if (isset($_POST)) {
            // Identificar al usuario Consulta a la base de datos
            $usuario = new usuario();
            $usuario->setUsuario($_POST['txt_usuario']);
            $usuario->setContrasena($_POST['txt_contrasena']);

            $identity = $usuario->login();


            if ($identity && is_object($identity)) {

                // Crear Sesion con informacion de usuario
                $_SESSION['identity-imfel'] = $identity;

                header("Location:" . base_url . 'home/index');
            } else {
                $_SESSION['error-login'] = 'error';
                header("Location:" . base_url);
            }
        } else {

            header("Location:" . base_url);
        }
    }

    public function logout() {

        if (isset($_SESSION['identity-imfel'])) {
            unset($_SESSION['identity-imfel']);
            unset($_SESSION['error-login']);
        }

        header("Location:" . base_url);
    }

    public function index() {
        #Validar que este loggeado
        utils::isIdentity();

        /* utils::isIdentity();
          if (utils::whatRol() != 1) {
          header("Location:" . base_url . "home/index");
          } */

        $usuario = new usuario();
        $lista_usuarios = $usuario->getAll();

        #Listado de tipos de usuario#
        /* Pierde funcionalidad con los roles
          $tipo_usuario = new tipoUsuario();
          $lista_tipo_usuario = $tipo_usuario->getAll(); */

        // Listar Roles
        $rol = new catRol();
        $lista_roles = $rol->getAll();

        #Listado de Estados#
        $estado = new catEstadoAI();
        $lista_estados = $estado->getAll();

        require_once 'views/usuario/crud-usuario.php';
    }

    public function edit() {
        #Validar que este loggeado
        utils::isIdentity();

        if ($_GET) {

            $id_usuario = isset($_GET['id_usuario']) ? intval($_GET['id_usuario']) : null;

            if ($id_usuario == null) {

                header("Location:" . base_url . "usuario/index");
            } else {
                //print 'entra'.$id_usuario;  die();
                # Instancia del objeto comercio
                $usuario = new usuario();
                $usuario->setId($id_usuario);
                $_usuario = $usuario->getOne()->fetch_object();
                // Dividimos el numero de telefono del contacto que recuperamos
                $telefono = $_usuario->telefono;
                $telefono = explode(" ", $telefono);

                // Listar Roles
                $rol = new catRol();
                $lista_roles = $rol->getAll();

                #Listado de Estados#
                $estado = new catEstadoAI();
                $lista_estados = $estado->getAll();

                //Listar Usuarios
                $lista_usuarios = $usuario->getAll();

                #Listado de perfiles#
                $perfil = new Perfil();
                $lista_perfiles = $perfil->getAll();

                ///Empieza
                $perfiles_usuario = new usuarioPerfil();
                $perfiles_usuario->setId_usuario($id_usuario);
                $yes_perfiles = $perfiles_usuario->getUserById();
//            utils::drawDebug($yes_perfiles);
//            die();

                $perfiles = array();
                while ($row = $yes_perfiles->fetch_object()) {
                    $perfiles[] = $row;
                }
//            utils::drawDebug($perfiles);
//            die();

                $arrPerfiles = array();
                while ($row1 = $lista_perfiles->fetch_object()) {
                    $arrPerfiles[] = $row1;
                }

                function compare_by_perfil($perfil, $usuario) {
                    $perfilId = $perfil->id_perfil;
                    $usuarioId = $usuario->id_perfil;
                    if ($usuarioId == $perfilId) {
                        return 0;
                    }
                    return -1;
                }

//            utils::drawDebug($arrPerfiles);
//            die();
                //$no_perfil = array_diff_key($arrPerfiles, $perfiles);
                $no_perfil = array_udiff($arrPerfiles, $perfiles, 'compare_by_perfil');
//            utils::drawDebug($no_perfil);
//            die();
//            
                //Termina

                require_once 'views/usuario/crud-usuario.php';
            }
        } else {
            header("Location:" . base_url . "cliente/index");
        }
    }

    public function save() {
        // Validacion si existe post
        if ($_POST) {

            //utils::drawDebug($_POST); utils::drawDebug($_GET); die();
            $id_comercio = isset($_POST['id_comercio']) ? intval(trim($_POST['id_comercio'])) : null;
            $idRol = isset($_POST['opt_rol']) ? intval(trim($_POST['opt_rol'])) : null;
            $nombre = isset($_POST['txt_nombre']) ? trim(strval($_POST['txt_nombre'])) : null;
            $nombre_usuario = isset($_POST['txt_usuario']) ? trim(strval($_POST['txt_usuario'])) : null;
            $dpi = isset($_POST['txt_dpi']) ? trim(strval($_POST['txt_dpi'])) : null;
            $telefono_1 = isset($_POST['txt_telefono1']) ? trim($_POST['txt_telefono1']) : null;
            $telefono_2 = isset($_POST['txt_telefono2']) ? trim($_POST['txt_telefono2']) : null;
            $email = isset($_POST['txt_email']) ? trim(strval($_POST['txt_email'])) : null;
            $contrasena = isset($_POST['txt_contrasena']) ? trim(strval($_POST['txt_contrasena'])) : null;
            $estado = isset($_POST['opt_estado']) ? trim(strval($_POST['opt_estado'])) : null;

            // Validacion de informacion nula (se evalua primero el error).
            if ($nombre == null || $nombre_usuario == null || $id_comercio == 0 || $dpi == null || $email == null || $idRol == 0) { //|| $rol == 0 $contrasena == null;
                //De encontrarse el campo nulo se envia la notificacion de valores nulos 
                $_SESSION['type-imfel'] = "danger";
                $_SESSION['message-imfel'] = "No has enviado algun valor requerido";
                header("Location:" . base_url . "usuario/index");
            } else {

                // Instanseamos el objeto de usuario 
                $usuario = new usuario();
                $usuario->setUsuario($nombre_usuario);
                $usuario->setDpi($dpi);
                $usuario->setEmail($email);
                $existe = $usuario->getEquals();
                $e_dpi = $usuario->getEqualsDPI();
                $e_correo = $usuario->getEqualsCorreo();

                // Validacion de usuario existente, o DPI exitente o Correo existente
                if ($existe >= 1 && $e_dpi >= 1 && $e_correo >= 1 && $id_usuario == 0) {

                    $_SESSION['type-imfel'] = 'warning';
                    $_SESSION['message-imfel'] = 'Ya existe registro con esa informacion';
                    header('Location:' . base_url . 'usuario/index');

                    die();
                } else {

                    $telefono = $telefono_1 . ' ' . $telefono_2;

                    $usuario->setIdRol($idRol);
                    $usuario->setTelefono($telefono);
                    $usuario->setIdComercio($id_comercio);
                    $usuario->setNombre($nombre);
                    $usuario->setUsuario($nombre_usuario);
                    $usuario->setContrasena($contrasena);
                    $usuario->setIdEstado($estado);
                    //$usuario->setIdRol($rol);
                    // si el id del usuario es mayor a cero entonces se procede al update
                    $id_usuario = isset($_GET['id']) ? intval(trim($_GET['id'])) : null;
                    if (isset($id_usuario) && $id_usuario > 0) {
                        $usuario->setId($id_usuario);
                        $result = $usuario->update();
                    } else {

                        //utils::drawDebug($usuario); die();
                        $result = $usuario->save();
                    }
                }
                if ($result) {
                    $_SESSION['type-imfel'] = "success";
                    $_SESSION['message-imfel'] = "El registro se realizo con exito";
                    header("Location:" . base_url . "usuario/index");
                } else {
                    $_SESSION['type-imfel'] = "warning";
                    $_SESSION['message-imfel'] = "El registro no se realizo con exito";
                    header("Location:" . base_url . "usuario/index");
                }
            }
        } else {
            $_SESSION['type-imfel'] = "danger";
            $_SESSION['message-imfel'] = "No se enviaron datos por Post";
            header("Location:" . base_url . "usuario/index");
        }
    }

    public function savePerfilUsuario() {
        if ($_GET) {
#validacion de get accesos y idPerfil#
            $id_usuario = isset($_GET['idUsuario']) ? $_GET['idUsuario'] : 0;
            $id_perfiles = isset($_GET['perfiles']) ? $_GET['perfiles'] : 0;

#Instancia objeto perfil#
            $perfiles_usuario = new usuarioPerfil();
            $perfiles_usuario->setId_usuario($id_usuario);

            $perfiles = explode(',', $id_perfiles);

            $count = count($perfiles);

            $perfiles_usuario->clearAccess();

            for ($i = 0; $i < $count; $i++) {
                $perfiles_usuario->setId_perfil($perfiles[$i]);
                $result = $perfiles_usuario->save();
                // utils::drawDebug($result);
            }

            if ($result) {
                $_SESSION['noti_tipo'] = "success";
                $_SESSION['noti_mensaje'] = "Acceso Guardado con Exito!";
                //  header('Location:' . base_url . 'usuario/index');
            } else {
                $_SESSION['noti_tipo'] = 'warning';
                $_SESSION['noti_mensaje'] = 'Se produjo un error al guardar acceso';
                // header('Location:' . base_url . 'usuario/index');
            }
        } else {
            $_SESSION['noti_tipo'] = 'danger';
            $_SESSION['noti_mensaje'] = 'Error al mandar datos por POST';
            //   header('Location:' . base_url . 'usuario/index');
        }
    }

    public function action() {
        if ($_GET) {

            $id_usuario = isset($_GET['id_usuario']) ? intval($_GET['id_usuario']) : null;
            $id_option = isset($_GET['id_option']) ? intval($_GET['id_option']) : null;

            if ($id_usuario == null) {

                header("Location:" . base_url . "usuario/index");
            } else {

# Instancia del objeto cliente
                $usuario = new usuario();
                $usuario->setId($id_usuario);

                if ($id_option == 1) {
                    $result = $usuario->activate();
                } else {
                    $result = $usuario->inactivate();
                }

                if ($result) {

                    header("Location:" . base_url . "usuario/index");
                } else {

                    header("Location:" . base_url . "usuario/index");
                }
            }
        } else {

            header("Location:" . base_url . "usuario/index");
        }
    }

    public function cambioClave() {
        if ($_POST) {
            // Variable para notificacion
            $result = false;

            // Seteamos la informacion que viene por POST
            $clave = isset($_POST['clave']) ? trim($_POST['clave']) : null;
            $confirmar_clave = isset($_POST['confirmar_clave']) ? trim($_POST['confirmar_clave']) : null;

            if ($clave == $confirmar_clave) {
                $usuario = new usuario();
                $usuario->setContrasena($clave);
                $usuario->setId($_SESSION['identity-imfel']->id);
                $result = $usuario->updateClave();

                if ($result) {
                    $_SESSION['noti_tipo'] = 'success';
                    $_SESSION['noti_mensaje'] = 'Cambio realizado exitosamente';
                    header('Location:' . base_url . 'home/index');
                } else {
                    $_SESSION['noti_tipo'] = 'danger';
                    $_SESSION['noti_mensaje'] = 'No se pudo realizar el cambio exitosamente';
                    header('Location:' . base_url . 'h'
                            . 'home/index');
                }
            } else {
                $_SESSION['noti_tipo'] = 'warning';
                $_SESSION['noti_mensaje'] = 'Problemas en la confirmacion de clave';
                header('Location:' . base_url . 'home/index');
            }
        } else {
            $_SESSION['noti_tipo'] = 'danger';
            $_SESSION['noti_mensaje'] = 'No pudimos cambiar tu contraseña';
            header('Location:' . base_url . 'home/index');
        }
    }

    public function changeComercio() {
        if ($_GET) {
            $id_comercio_new = isset($_GET['opt_comercio']) ? intval($_GET['opt_comercio']) : 0;

            $_SESSION['identity-imfel']->idComercio = $id_comercio_new;

            if (isset($_SESSION['orden_detalle']))
                unset($_SESSION['orden_detalle']);

            $_SESSION['noti_tipo'] = 'success';
            $_SESSION['noti_mensaje'] = 'Se cambio de empresa exitosamente';
            header('Location:' . base_url . 'home/index');
        } else {
            $_SESSION['noti_tipo'] = 'danger';
            $_SESSION['noti_mensaje'] = 'No se recibe empresa por GET';
            header('Location:' . base_url . 'home/index');
        }
    }

}
