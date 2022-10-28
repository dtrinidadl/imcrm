<?php
require_once 'models/userProject.php';

class userProjectController
{
    public function getAjax()
    {
        if (isset($_GET['view'])) {
            $projectCompanyCode = $_GET['projectCompanyCode'];
            $userProject = new userProject();
            $_project = $userProject->getProject($projectCompanyCode);

            print " <div class='form-group'>
                        <select  class='selectpicker' data-style='select-with-transition'>
                            <option selected disabled>Projecto</option>";

            while ($data = $_project->fetch_assoc()) {
                echo "<option value=" . $data['projectCode'] . ">" . $data['projectName'] . "</option>";
            }

            echo "      </select>
                    </div>";
            die();
        }
    }

    public function index()
    {
        // Logeado?        
        utils::isIdentity();
        $identityUserRole = $_SESSION['identity-imsupport']->userRole;

        if ($identityUserRole != 1) {
            header("Location:" . base_url . "home/index");
        }

        $userProject = new userProject();
        $user_list = $userProject->getUser();
        $company_list = $userProject->getCompany();
        $userProject_list = $userProject->getAll();
        require_once 'views/userProject/crud-userProject.php';
    }

    public function save()
    {
        // Validacion si existe post
        if ($_POST) {
            $userProjectCompanyCode = isset($_POST['opt_userProjectCompanyCode']) ? intval(trim($_POST['opt_userProjectCompanyCode'])) : null;
            $userProjectProjectCode = isset($_POST['opt_userProjectProjectCode']) ? intval(trim($_POST['opt_userProjectProjectCode'])) : null;
            $userProjectUserCode = isset($_POST['opt_userProjectUserCode']) ? intval(trim($_POST['opt_userProjectUserCode'])) : null;
            $userProjectRole = isset($_POST['opt_userProjectRole']) ? intval(trim($_POST['opt_userProjectRole'])) : null;

            // Validar valores != null
            if ($userProjectCompanyCode < 0 || $userProjectProjectCode < 0 || $userProjectUserCode < 0 || $userProjectRole < null) {
                $_SESSION['type-imSupport'] = "danger";
                $_SESSION['message-imSupport'] = "No has enviado algun valor requerido";
                header("Location:" . base_url . "userProject/index");
            } else {
                $userProject = new userProject();
                $userProject->setUserProjectCompanyCode($userProjectCompanyCode);
                $userProject->setUserProjectProjectCode($userProjectProjectCode);
                $userProject->setUserProjectUserCode($userProjectUserCode);
                $userProject->setUserProjectRole($userProjectRole);

                $result = $userProject->save();
                if ($result) {
                    $_SESSION['type-imSupport'] = "success";
                    $_SESSION['message-imSupport'] = "El registro se realizo con exito";
                    header("Location:" . base_url . "userProject/index");
                } else {
                    $_SESSION['type-imSupport'] = "warning";
                    $_SESSION['message-imSupport'] = "El registro no se realizo con exito";
                    header("Location:" . base_url . "userProject/index");
                }
            }
        } else {
            $_SESSION['type-imSupport'] = "danger";
            $_SESSION['message-imSupport'] = "No se enviaron datos por Post";
            header("Location:" . base_url . "userProject/index");
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

        if (isset($_GET['userProjectCode'])) {
            $_SESSION['userProjectCodeEdit'] = $_GET['userProjectCode'];
            header("Location:" . base_url . "userProject/edit");
        } else {
            $userProjectCode = $_SESSION['userProjectCodeEdit'];
            $userProject = new userProject();
            $_userProject = $userProject->getOne($userProjectCode)->fetch_object();
            $project_list = $userProject->getProject($_userProject->userProjectCompanyCode);
            $user_list = $userProject->getUser();
            $company_list = $userProject->getCompany();
            $userProject_list = $userProject->getAll();
            require_once 'views/userProject/crud-userProject.php';
        }
    }

    public function update()
    {
        // Validacion si existe post
        if ($_POST) {
            $userProjectCode = isset($_POST['txt_userProjectCode']) ? intval(trim($_POST['txt_userProjectCode'])) : null;
            $userProjectCompanyCode = isset($_POST['opt_userProjectCompanyCode']) ? intval(trim($_POST['opt_userProjectCompanyCode'])) : null;
            $userProjectProjectCode = isset($_POST['opt_userProjectProjectCode']) ? intval(trim($_POST['opt_userProjectProjectCode'])) : null;
            $userProjectUserCode = isset($_POST['opt_userProjectUserCode']) ? intval(trim($_POST['opt_userProjectUserCode'])) : null;
            $userProjectRole = isset($_POST['opt_userProjectRole']) ? intval(trim($_POST['opt_userProjectRole'])) : null;

            // Validar valores != null
            if ($userProjectCode < 0 || $userProjectCompanyCode < 0 || $userProjectProjectCode < 0 || $userProjectUserCode < 0 || $userProjectRole < null) {
                $_SESSION['type-imSupport'] = "danger";
                $_SESSION['message-imSupport'] = "No has enviado algun valor requerido";
                header("Location:" . base_url . "userProject/index");
            } else {
                $userProject = new userProject();
                $userProject->setUserProjectCode($userProjectCode);
                $userProject->setUserProjectCompanyCode($userProjectCompanyCode);
                $userProject->setUserProjectProjectCode($userProjectProjectCode);
                $userProject->setUserProjectUserCode($userProjectUserCode);
                $userProject->setUserProjectRole($userProjectRole);

                $result = $userProject->update($userProjectCode);
                if ($result) {
                    unset($_SESSION['userProjectCodeEdit']);
                    $_SESSION['type-imSupport'] = "success";
                    $_SESSION['message-imSupport'] = "El registro se realizo con exito";
                    header("Location:" . base_url . "userProject/index");
                } else {
                    $_SESSION['type-imSupport'] = "warning";
                    $_SESSION['message-imSupport'] = "El registro no se realizo con exito";
                    header("Location:" . base_url . "userProject/index");
                }
            }
        } else {
            $_SESSION['type-imSupport'] = "danger";
            $_SESSION['message-imSupport'] = "No se enviaron datos por Post";
            header("Location:" . base_url . "userProject/index");
        }
    }

    public function deleted()
    {
        utils::isIdentity();
        if (isset($_GET['userProjectCode'])) {
            $_SESSION['userProjectCodeEdit'] = $_GET['userProjectCode'];
            header("Location:" . base_url . "userProject/deleted");
        } else {
            $userProject = new userProject();
            $userProjectCode = $_SESSION['userProjectCodeEdit'];
            $result = $userProject->deleted($userProjectCode);
            if ($result) {
                $_SESSION['type-imSupport'] = "success";
                $_SESSION['message-imSupport'] = "El registro se elimino con exito";
                header("Location:" . base_url . "userProject/index");
            } else {
                $_SESSION['type-imSupport'] = "warning";
                $_SESSION['message-imSupport'] = "El registro no se elimino con exito";
                header("Location:" . base_url . "userProject/index");
            }
        }
    }
}
