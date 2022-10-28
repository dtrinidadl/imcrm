<?php
require_once 'models/support.php';
require_once 'models/userProject.php';
require_once 'models/notification.php';
require_once 'models/supportDetail.php';

class supportController
{
    public function getAjax()
    {
        $support = new support();
        $userProject = new userProject;
        $notification = new notification;

        if (isset($_GET['changeType'])) {
            $supportCode = $_GET['supportCode'];
            $supportType = $_GET['supportType'];

            $result = $support->updateSupportType($supportCode, $supportType);

            // Notificacione
            $supportUserCode = $_GET['supportUserCode'];
            $userProjectProjectCode = $_GET['supportProjectCode'];
            $userProject_list = $userProject->getUsersByProject($userProjectProjectCode);

            $i = 1;
            $value = '';
            while ($data = $userProject_list->fetch_assoc()) {
                if ($supportUserCode != $data['userProjectUserCode']) {
                    $value .= '(' . $data['userProjectUserCode'] . ", $supportCode, NULL, 'Cambio de Soporte'";
                    ($userProject_list->num_rows == $i) ? $value .= ');' : $value .= '),';
                }
                $i++;

                //Notificacion por correo
                $support->sendMail($data['userEmail'], $data['userName'], 'cambio de tipo.');
            }

            $notification_save = $notification->save($value);
            
            echo $result;
            die();
        } else if (isset($_GET['changeStatus'])) {
            $supportCode = $_GET['supportCode'];
            $supportStatus = $_GET['supportStatus'];

            switch ($supportStatus) {
                case 2:
                    $supportDate = 'supportAnalyzedDate';
                    break;
                case 3:
                    $supportDate = 'supportDevelopedDate';
                    break;
                case 4:
                    $supportDate = 'supportQADate';
                    break;
                case 5:
                    $supportDate = 'supportFinishDate';
                    break;
            }

            $result = $support->updateSupportStatus($supportCode, $supportStatus, $supportDate);

            // Notificacione
            $supportUserCode = $_GET['supportUserCode'];
            $userProjectProjectCode = $_GET['supportProjectCode'];
            $userProject_list = $userProject->getUsersByProject($userProjectProjectCode);

            $i = 1;
            $value = '';
            while ($data = $userProject_list->fetch_assoc()) {
                if ($supportUserCode != $data['userProjectUserCode']) {
                    $value .= '(' . $data['userProjectUserCode'] . ", $supportCode, NULL, 'Cambio de Estado'";
                    ($userProject_list->num_rows == $i) ? $value .= ');' : $value .= '),';
                }
                $i++;

                //Notificacion por correo
                $support->sendMail($data['userEmail'], $data['userName'], 'cambio de estado.');
            }

            $notification_save = $notification->save($value);

            echo $result;
            die();
        } else if (isset($_GET['upload'])) {
            $result = false;
            $request = [];

            (true === (isset($_GET['documentSupportCode']))) ? $documentSupportCode = intval($_GET['documentSupportCode']) : $documentSupportCode = 'NULL';
            (true === (isset($_GET['documentSupportDetailCode']))) ? $documentSupportDetailCode = intval($_GET['documentSupportDetailCode']) : $documentSupportDetailCode = 'NULL';

            
            $url = '';
            $icon = 'fa-file-text-o';
            $type = $_FILES['file']['type'];

            $Name = date('mdy_his', time());
            $info = new SplFileInfo($_FILES['file']['name']); 
            $extension = pathinfo($info, PATHINFO_EXTENSION);
            $originName = pathinfo($info, PATHINFO_FILENAME);
            $originName = str_replace(".", "_", $originName);;
            $nickName = substr($originName, 0, 10);

            $xlsx = 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet';
            $docx = 'application/vnd.openxmlformats-officedocument.wordprocessingml.document';

            if ($type == 'image/png' || $type == 'image/jpg' || $type == 'image/jpeg') {
                if (!is_dir('uploads/img')) {
                    mkdir('uploads/img', 0777, true);
                }

                if ($_FILES['file']['size'] < 1000000) {
                    move_uploaded_file($_FILES['file']['tmp_name'], 'uploads/img/' . $Name . '.' . $extension);
                    $url = 'uploads/img/' . $Name . '.' . $extension;
                    $icon = 'fa fa-picture-o';
                    $preview = $url;
                    $result = true;
                }
            } else if ($type == 'application/json' || $type == 'text/xml' || $type == 'application/pdf') {
                if (!is_dir('uploads/doc')) {
                    mkdir('uploads/doc', 0777, true);
                }

                if ($_FILES['file']['size'] < 1000000) {
                    move_uploaded_file($_FILES['file']['tmp_name'], 'uploads/doc/' . $Name . '.' . $extension);
                    $url = 'uploads/doc/' . $Name . '.' . $extension;
                    $result = true;
                }
            } else if ($type == $xlsx || $type == $docx) {
                if (!is_dir('uploads/office')) {
                    mkdir('uploads/office', 0777, true);
                }

                if ($_FILES['file']['size'] < 1000000) {
                    move_uploaded_file($_FILES['file']['tmp_name'], 'uploads/office/' . $Name . '.' . $extension);
                    $url = 'uploads/office/' . $Name . '.' . $extension;
                    $result = true;
                }
            }

            if ($result) {
                $insert_id = $support->uploadRecords($documentSupportCode, $documentSupportDetailCode, $originName, $Name, $extension, $url);

                $request = [
                    'documentCode' => $insert_id,
                    'name' => $nickName,
                    'url' =>  $preview,
                    'icon' => $icon,
                    'error' => 0
                ];

                print_r(json_encode($request));
                die();
            } else {
                $request = [
                    'error' => 500,
                    'message' => "Documento no cargado",
                ];

                print_r(json_encode($request));
                die();
            }
        } else if (isset($_GET['remove'])) {
            $request = [];
            $documentCode = intval($_GET['documentCode']);
            $document = $support->getDocument($documentCode)->fetch_assoc(); 

            if (is_file($document['documentLocation'])) {
                unlink($document['documentLocation']);

                $documentDeleted = $support->deletedDocument($documentCode);

                $request = [
                    'error' => 0,
                    'message' => "Archivo removido!"
                ];
            } else {
                $request = [
                    'error' => 500,
                    'message' => "Archivo no removido!"
                ];
            }
            print_r(json_encode($request));
            die();
        } else if (isset($_GET['download'])) {
            $exist = false;
            $documentName = $_GET['file'];

            if (is_file('uploads/img/' . $documentName)) {
                $exist = true;
                $documentLocation = 'uploads/img/';
            } else if (is_file('uploads/doc/' . $documentName)) {
                $exist = true;
                $documentLocation = 'uploads/doc/';
            } else if (is_file('uploads/office/' . $documentName)) {
                $exist = true;
                $documentLocation = 'uploads/office/';
            }

            if ($exist) {

                header('Content-Description: File Transfer');
                header('Content-Type: text/csv');
                header('Content-Disposition: attachment; filename=' . basename($documentName));
                header('Content-Transfer-Encoding: binary');
                header('Expires: 0');
                header('Cache-Control: must-revalidate');
                header('Pragma: public');
                header('Content-Length: ' . filesize($documentName));
                ob_clean();
                flush();
                readfile($documentName);
                exit;

                // Define headers
                header("Cache-Control: public");
                header("Content-Description: File Transfer");
                header("Content-Disposition: attachment; filename=$documentName");
                header("Content-Type: application/zip");
                header("Content-Transfer-Encoding: binary");

                // Read the file
                readfile($documentLocation . $documentName);

                $request = [
                    'error' => 0,
                    'message' => "Descarga Correcta!",
                    'doc' => $documentLocation . $documentName
                ];
                exit;
            } else {
                $request = [
                    'error' => 500,
                    'message' => "Error al descargar archivo!"
                ];
            }
            print_r(json_encode($request));
            die();
        }
    }

    // Utilizados
    public function index()
    {        
        // Logeado?        
        utils::isIdentity();
        $identityUserCode = $_SESSION['identity-imsupport']->userCode;
        $identityUserRole = $_SESSION['identity-imsupport']->userRole;

        // Rol de Cliente o PO?
        $userProject = new userProject;
        $project_insert_list = $userProject->getProjectByUser($identityUserCode);

        ($project_insert_list->num_rows > 0) ? $insert = true : $insert = false;

        //Obtener suportes creados por usuario
        $support = new support();
        $support_list = $support->getSupportByUserInsert($identityUserCode, 1);
        require_once 'views/support/index-support.php';
    }

    public function new()
    {
        utils::isIdentity();
        $identityUserCode = $_SESSION['identity-imsupport']->userCode;
        $userProject = new userProject;
        $project_list = $userProject->getProjectByUser($identityUserCode);

        if ($project_list->num_rows == 0) {
            header("Location:" . base_url . "support/index");
        }
        require_once 'views/support/new-support.php';
    }

    public function comment()
    {
        utils::isIdentity();
        $supportCode = $_SESSION['supportCodeView'];

        if (!isset($supportCode)) {
            header("Location:" . base_url . "support/index");
        } else {
            require_once 'views/support/new-comment-support.php';
        }
    }

    public function save()
    {
        if ($_POST) {
            $supportUserCode = $_SESSION['identity-imsupport']->userCode;
            $supportProjectCode = isset($_POST['opt_supportProjectCode']) ? trim($_POST['opt_supportProjectCode']) : null;
            $supporPriority = isset($_POST['opt_supportPriority']) ? trim($_POST['opt_supportPriority']) : null;
            $supportType = isset($_POST['opt_supportType']) ? intval(trim($_POST['opt_supportType'])) : null;
            $supportTitle = isset($_POST['txt_supportTitle']) ? trim($_POST['txt_supportTitle']) : null;
            $supportDescription = isset($_POST['ckeditor']) ? trim($_POST['ckeditor']) : null;

            if (
                $supportProjectCode < 1 || $supportUserCode < 1 || $supportType < 1 || $supporPriority < 1 ||
                $supportTitle == null || $supportDescription == null
            ) {
                $_SESSION['type-imSupport'] = "danger";
                $_SESSION['message-imSupport'] = "No has enviado algun valor requerido";
                header("Location:" . base_url . "support/new");
            } else {
                $support = new support();
                $support->setSupportProjectCode($supportProjectCode);
                $support->setSupportUserCode($supportUserCode);
                $support->setSupportType($supportType);
                $support->setSupporPriority($supporPriority);
                $support->setSupporrTitle($supportTitle);
                $support->setSupportDescription($supportDescription);
                $resultID = $support->save()->fetch_object();

                if ($resultID->insert_id > 0) {
                    // Generar notificaciones        

                    $userProject = new userProject;
                    $userProjectProjectCode = $supportProjectCode;
                    $userProject_list = $userProject->getUsersByProject($userProjectProjectCode);

                    $i = 1;
                    $value = '';
                    while ($data = $userProject_list->fetch_assoc()) {
                        if ($supportUserCode != $data['userProjectUserCode']) {
                            $value .= '(' . $data['userProjectUserCode'] . ", $resultID->insert_id, NULL, 'Nuevo Soporte'";
                            ($userProject_list->num_rows == $i) ? $value .= ');' : $value .= '),';
                        }
                        $i++;

                        //Notificacion por correo
                        $support->sendMail($data['userEmail'], $data['userName'], 'nuevo soporte.');
                    }

                    $notification = new notification;
                    $notification_save = $notification->save($value);

                    //Asociar documentos
                    foreach ($_POST as $name => $value) {
                        $variable = substr($name, 0, 3);
                        if ($variable == 'doc') {
                            $support->updateDocument($value, $resultID->insert_id, 'null'); 
                        }
                    }
                    $_SESSION['type-imSupport'] = "success";
                    $_SESSION['message-imSupport'] = "El registro se realizo con exito";
                    header("Location:" . base_url . "support/index");
                } else {
                    $_SESSION['type-imSupport'] = "warning";
                    $_SESSION['message-imSupport'] = "El registro no se realizo con exito";
                    header("Location:" . base_url . "support/new");
                }
            }
        } else {
            $_SESSION['type-imSupport'] = "danger";
            $_SESSION['message-imSupport'] = "No se enviaron datos por Post";
            header("Location:" . base_url . "support/new");
        }
    }

    //FALTA PUSH NOTIFICATION
    public function saveComment()
    {
        $supportDetailSupportCode = isset($_POST['txt_supportCode']) ? trim($_POST['txt_supportCode']) : null;
        if ($_POST) {
            $supportDetailUserCode = $_SESSION['identity-imsupport']->userCode;
            $supportDetailDescription = isset($_POST['ckeditor']) ? trim($_POST['ckeditor']) : null;

            // utils::drawDebug($_POST); 
            if ($supportDetailSupportCode < 1 || $supportDetailUserCode < 1 || $supportDetailDescription == null) {
                $_SESSION['type-imSupport'] = "danger";
                $_SESSION['message-imSupport'] = "No has enviado algun valor requerido";
                header("Location:" . base_url . "support/view?supportCode=" . $_SESSION['supportCodeView']);
            } else {
                $supportDetail = new supportDetail();
                $supportDetail->setSupportDetailUserCode($supportDetailUserCode);
                $supportDetail->setSupportDetailSupportCode($supportDetailSupportCode);
                $supportDetail->setSupportDetailDescription($supportDetailDescription);
                $resultID = $supportDetail->save()->fetch_object();

                if ($resultID->insert_id > 0) {
                    // Generar notificaciones 
                    $userProject = new userProject;
                    $userProjectProjectCode = $_SESSION['supportProjectCode'];
                    $supportCode = $_SESSION['supportCodeView'];
                    $userProject_list = $userProject->getUsersByProject($userProjectProjectCode);

                    $support = new support();

                    $i = 1;
                    $value = '';
                    while ($data = $userProject_list->fetch_assoc()) {
                        if ($supportDetailUserCode != $data['userProjectUserCode']) {
                            $value .= '(' . $data['userProjectUserCode'] . ", $supportCode, $resultID->insert_id, 'Nuevo Comentario'";
                            ($userProject_list->num_rows == $i) ? $value .= ');' : $value .= '),';
                        }
                        $i++;

                        //Notificacion por correo
                        $support->sendMail($data['userEmail'], $data['userName'], 'nuevo comentario.');
                    }
                    $notification = new notification;
                    $notification_save = $notification->save($value);
                    
                    // ACTUALIZAR DOCUMENTOS
                    foreach ($_POST as $name => $value) {
                        $variable = substr($name, 0, 3);
                        if ($variable == 'doc') {
                            $support->updateDocument($value, $supportDetailSupportCode, $resultID->insert_id); // $document = array(); // array_push($document, $value);
                        }
                    }                    

                    // Notificacion Push
                    $_SESSION['type-imSupport'] = "success";
                    $_SESSION['message-imSupport'] = "El registro se realizo con exito";
                    header("Location:" . base_url . "support/view&supportCode=" . $supportDetailSupportCode);
                } else {
                    $_SESSION['type-imSupport'] = "warning";
                    $_SESSION['message-imSupport'] = "El registro no se realizo con exito";
                    header("Location:" . base_url . "support/view&supportCode=" . $supportDetailSupportCode);
                }
            }
        } else {
            $_SESSION['type-imSupport'] = "danger";
            $_SESSION['message-imSupport'] = "No se enviaron datos por Post";
            header("Location:" . base_url . "support/view&supportCode=" . $supportDetailSupportCode);
        }
    }

    public function history()
    {
        // Logeado?        
        utils::isIdentity();
        $identityUserCode = $_SESSION['identity-imsupport']->userCode;

        //Obtener suportes creados por usuario
        $support = new support();
        $support_list = $support->getSupportByUserInsert($identityUserCode, 0);
        require_once 'views/support/history-support.php';
    }

    public function view()
    {
        utils::isIdentity();
        $identityUserCode = $_SESSION['identity-imsupport']->userCode;

        if (isset($_GET['supportCode'])) {
            $_SESSION['supportCodeView'] = $_GET['supportCode'];
            header("Location:" . base_url . "support/view");
        } else {
            $support = new support();
            $supportCode = $_SESSION['supportCodeView'];
            $support_head = $support->getHeader($supportCode)->fetch_object();
            $_SESSION['supportProjectCode'] = $support_head->supportProjectCode;

            $support_detail = $support->getDetail($supportCode);
            $document_list = $support->getAllDocument($supportCode); //->fetch_all();



            $document = array();
            $array = $document_list;
            while ($v = $array->fetch_assoc()) {
                array_push($document, $v);
            }

            // Rol de usuario con el proyecto
            $userProject = new userProject;
            $userProjectRol = $userProject->getRoleByUserAndProject($identityUserCode, $support_head->supportProjectCode)->fetch_object();
            $userProjectRol = $userProjectRol->userProjectRole;

            switch ($support_head->supportPriority) {
                case 1:
                    $supportPriorityName = "<span class='txt-priority' style='background: red;'>[Alto]</span>";
                    break;
                case 2:
                    $supportPriorityName = "<span class='txt-priority' style='background: orange;'>[Medio]</span>";
                    break;
                default:
                    $supportPriorityName = "<span class='txt-priority' style='background: #f1db1b;' >[Bajo]</span>";
                    break;
            }
            require_once 'views/support/view-support.php';
        }
    }
}
