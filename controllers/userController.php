<?php
require_once 'models/user.php';

class userController
{
    public function validate()
    {
        if (isset($_POST)) {
            $userEmail = isset($_POST['txt_userEmail']) ? trim(strval($_POST['txt_userEmail'])) : null;
            $userNickname = isset($_POST['txt_userNickname']) ? trim(strval($_POST['txt_userNickname'])) : null;
            $userPassword = isset($_POST['txt_userPassword']) ? trim(strval($_POST['txt_userPassword'])) : null;

            if ($userNickname != null && $userEmail != null && $userPassword != null) {
                $user = new user();
                $user->setUserEmail($userEmail);
                $user->setUserNickname($userNickname);
                $user->setUserPassword($userPassword);
                $identity = $user->login();

                if ($identity && is_object($identity)) {
                    $identity->userPassword = '';
                    // Crear Sesion con informacion de usuario    
                    $_SESSION['identity-imsupport'] = $identity;
                    header("Location:" . base_url . 'home/index');
                } else {
                    $_SESSION['error-login'] = 'error';
                    header("Location:" . base_url);
                }
            } else {
                $_SESSION['error-login'] = 'error';
                header("Location:" . base_url);
            }
        } else {
            header("Location:" . base_url);
        }
    }

    public function logout()
    {
        if (isset($_SESSION['identity-imsupport'])) {
            unset($_SESSION['identity-imsupport']);
            unset($_SESSION['error-login']);
            session_destroy();
        }
        header("Location:" . base_url);
    }

    public function index()
    {
        // Logeado?        
        utils::isIdentity();
        $identityUserRole = $_SESSION['identity-imsupport']->userRole;

        if ($identityUserRole != 1) {
            header("Location:" . base_url . "home/index");
        }

        $user = new user();
        $user_list = $user->getUserByCompany();
        require_once 'views/user/crud-user.php';
    }

    public function save()
    {        
        if ($_POST) {
            $userCode = isset($_POST['txt_userCode']) ? intval(trim($_POST['txt_userCode'])) : null;
            $userPhone = isset($_POST['txt_userPhone']) ? trim($_POST['txt_userPhone']) : null;
            $userName = isset($_POST['txt_userName']) ? trim(strval($_POST['txt_userName'])) : null;
            $userRole = isset($_POST['opt_userRole']) ? intval(trim($_POST['opt_userRole'])) : null;
            $userEmail = isset($_POST['txt_userEmail']) ? trim(strval($_POST['txt_userEmail'])) : null;
            $userNickname = isset($_POST['txt_userNickname']) ? trim(strval($_POST['txt_userNickname'])) : null;
            $userPassword = isset($_POST['txt_userPassword']) ? trim(strval($_POST['txt_userPassword'])) : null;
            
            // Validar valores != null
            if ($userName == null || $userNickname == null || $userPhone == null || $userEmail == null || $userPassword == null || $userRole == 0) {
                $_SESSION['type-imSupport'] = "danger";
                $_SESSION['message-imSupport'] = "No has enviado algun valor requerido";
                header("Location:" . base_url . "user/index");
            } else {
                $user = new user();
                $user->setUserName($userName);
                $user->setUserNickname($userNickname);
                $user->setUserEmail($userEmail);
                $exists = $user->exists($userNickname, $userEmail);

                // Existe usuario & email?         
                if ($exists->userNickname >= 1 || $exists->userEmail >= 1) {
                    $_SESSION['type-imSupport'] = 'warning';
                    $_SESSION['message-imSupport'] = 'Ya existe registro con esa informacion';
                    header('Location:' . base_url . 'user/index');
                    die();
                } else {
                    $user->setUserPhone($userPhone);
                    $user->setUserPassword($userPassword);
                    $user->setUserRole($userRole);
                    $result = $user->save();
                }
                if ($result) {
                    $_SESSION['type-imSupport'] = "success";
                    $_SESSION['message-imSupport'] = "El registro se realizo con exito";
                    header("Location:" . base_url . "user/index");
                } else {
                    $_SESSION['type-imSupport'] = "warning";
                    $_SESSION['message-imSupport'] = "El registro no se realizo con exito";
                    header("Location:" . base_url . "user/index");
                }
            }
        } else {
            $_SESSION['type-imSupport'] = "danger";
            $_SESSION['message-imSupport'] = "No se enviaron datos por Post";
            header("Location:" . base_url . "user/index");
        }
    }

    public function edit()
    {
        utils::isIdentity();
        $identityUserRole = $_SESSION['identity-imsupport']->userRole;
        if ($identityUserRole != 1) {
            header("Location:" . base_url . "home/index");
            die();
        }
        
        if (isset($_GET['userCode'])) {
            $_SESSION['userCodeEdit'] = $_GET['userCode'];
            header("Location:" . base_url . "user/edit");
        } else {
            $user = new user();
            $userCode = $_SESSION['userCodeEdit'];
            $user_list = $user->getUserByCompany();
            $_user = $user->getOne($userCode)->fetch_object();
            require_once 'views/user/crud-user.php';
        }
    }

    public function update()
    {
        // Validacion si existe post
        if ($_POST) {
            $userCode = empty($_POST['txt_userCode']) ? intval(trim($_POST['txt_userCode'])) : null;
            $userPhone = empty($_POST['txt_userPhone']) ? trim($_POST['txt_userPhone']) : null;
            $userName = empty($_POST['txt_userName']) ? trim(strval($_POST['txt_userName'])) : null;
            $userRole = empty($_POST['opt_userRole']) ? intval(trim($_POST['opt_userRole'])) : null;
            $userEmail = empty($_POST['txt_userEmail']) ? trim(strval($_POST['txt_userEmail'])) : null;
            $userNickname = empty($_POST['txt_userNickname']) ? trim(strval($_POST['txt_userNickname'])) : null;

            
            // Validar valores != null
            if ($userCode == null || $userName == null || $userNickname == null || $userPhone == null || $userEmail == null || $userRole == 0) {        
                $_SESSION['type-imSupport'] = "danger";
                $_SESSION['message-imSupport'] = "No has enviado algun valor requerido";
                header("Location:" . base_url . "user/index");
            } else {
                $user = new user();
                $user->setUserName($userName);
                $user->setUserNickname($userNickname);
                $user->setUserEmail($userEmail);
                $exists = $user->exists($userNickname, $userEmail);
                isset($exists->userEmail) ? $exists->userEmail : $exists->userEmail = $userCode;
                isset($exists->userNickname) ? $exists->userNickname : $exists->userNickname = $userCode;

                // Existe usuario & email?
                if ($userCode != $exists->userNickname || $userCode != $exists->userEmail) {
                    $_SESSION['type-imSupport'] = 'warning';
                    $_SESSION['message-imSupport'] = 'Ya existe registro con esa informacion';
                    header('Location:' . base_url . 'user/index');
                    die();
                } else {
                    $user->setUserPhone($userPhone);
                    $user->setUserRole($userRole);
                    $result = $user->update($userCode);
                }
                if ($result->error) {
                    $_SESSION['type-imSupport'] = "danger";
                    // $_SESSION['message-imSupport'] = "El registro no se realizo con exito";
                    $_SESSION['message-imSupport'] = 'Error: ' . $result->error;
                    header("Location:" . base_url . "user/index");
                } else {
                    $_SESSION['type-imSupport'] = "success";
                    $_SESSION['message-imSupport'] = "El registro se realizo con exito";
                    header("Location:" . base_url . "user/index");
                }
            }
        } else {
            $_SESSION['type-imSupport'] = "danger";
            $_SESSION['message-imSupport'] = "No se enviaron datos por Post";
            header("Location:" . base_url . "user/index");
        }
    }

    public function deleted()
    {
        utils::isIdentity();
        if (isset($_GET['userCode'])) {
            $_SESSION['userCodeEdit'] = $_GET['userCode'];
            header("Location:" . base_url . "user/deleted");
        } else {
            $user = new user();
            $userCode = $_SESSION['userCodeEdit'];
            $result = $user->deleted($userCode);
            if ($result) {
                $_SESSION['type-imSupport'] = "success";
                $_SESSION['message-imSupport'] = "El registro se elimino con exito";
                header("Location:" . base_url . "user/index");
            } else {
                $_SESSION['type-imSupport'] = "warning";
                $_SESSION['message-imSupport'] = "El registro no se elimino con exito";
                header("Location:" . base_url . "user/index");
            }
        }
    }

    public function changePassword()
    {
        if ($_POST) {
            $result = false;

            $userPassword = isset($_POST['password']) ? trim($_POST['password']) : null;
            $confirm_userPassword = isset($_POST['confirm_password']) ? trim($_POST['confirm_password']) : null;

            if ($userPassword == $confirm_userPassword) {
                $user = new user();
                $user->setUserPassword($userPassword);
                $userCode = ($_SESSION['identity-imsupport']->userCode);
                $result = $user->changePassword($userCode);

                if ($result) {
                    $_SESSION['noti_tipo'] = 'success';
                    $_SESSION['noti_mensaje'] = 'Cambio realizado exitosamente';
                    header('Location:' . base_url . 'home/index');
                } else {
                    $_SESSION['noti_tipo'] = 'danger';
                    $_SESSION['noti_mensaje'] = 'No se pudo realizar el cambio exitosamente';
                    header('Location:' . base_url . 'home/index');
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
}
