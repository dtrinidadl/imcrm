<?php
require_once 'models/project.php';
require_once 'models/company.php';

class projectController
{
    public function getAjax()
    {
        if (isset($_GET['view'])) {
            $projectCode = $_GET['projectCode'];
            $project = new project();
            $_project = $project->getOneView($projectCode)->fetch_object();
            print_r(json_encode($_project));
            die();            
        }
    }

    public function view(){            
            $projectCode = isset($_POST['projectCode']) ? intval(trim($_POST['projectCode'])) : null;
            $projectCode = isset($_POST['projectCode']) ? intval(trim($_POST['projectCode'])) : null;
            $projectCode = 6;
            $project = new project();
            $_project = $project->getOneView($projectCode)->fetch_object();
            print_r(json_encode($_project));
            die();            
    }

    public function index()
    {
        // Logeado?        
        utils::isIdentity();
        $identityUserRole = $_SESSION['identity-imsupport']->userRole;
        
        if ($identityUserRole > 2) {
            header("Location:" . base_url . "home/index");
        }

        $project = new project();
        $company = new company();
        $company_list = $company->getAll();
        $project_list = $project->getAll();
        require_once 'views/project/crud-project.php';
    }

    public function save()
    {
        // Validacion si existe post
        if ($_POST) {
            $projectName = isset($_POST['txt_projectName']) ? trim($_POST['txt_projectName']) : null;
            $projectRank = isset($_POST['opt_projectRank']) ? intval(trim($_POST['opt_projectRank'])) : null;
            $projectStatus = isset($_POST['opt_projectStatus']) ? intval(trim($_POST['opt_projectStatus'])) : null;
            $projectStartDate = isset($_POST['txt_projectStartDate']) ? trim($_POST['txt_projectStartDate']) : null;
            $projectFinishDate = isset($_POST['txt_projectFinishDate']) ? trim($_POST['txt_projectFinishDate']) : null;
            $projectRepository = isset($_POST['txt_projectRepository']) ? trim($_POST['txt_projectRepository']) : null;
            $projectCategory = isset($_POST['opt_projectCategory']) ? intval(trim($_POST['opt_projectCategory'])) : null;
            $projectDescription = isset($_POST['txt_projectDescription']) ? trim($_POST['txt_projectDescription']) : null;
            $projectDocumentation = isset($_POST['txt_projectDocumentation']) ? trim($_POST['txt_projectDocumentation']) : null;
            $projectCompanyCode = isset($_POST['opt_projectCompanyCode']) ? intval(trim($_POST['opt_projectCompanyCode'])) : null;

            // Validar valores != null
            if (
                $projectRank == 0 || $projectStatus == 0 || $projectCategory == 0 || $projectCompanyCode == 0 ||
                $projectName == null || $projectStartDate == null || $projectDescription == null
            ) {
                $_SESSION['type-imSupport'] = "danger";
                $_SESSION['message-imSupport'] = "No has enviado algun valor requerido";
                header("Location:" . base_url . "project/index");
            } else {
                $project = new project();
                $project->setProjectName($projectName);
                $project->setProjectRank($projectRank);
                $project->setProjectStatus($projectStatus);
                $project->setProjectStartDate($projectStartDate);
                $project->setProjectFinishDate($projectFinishDate);
                $project->setProjectRepository($projectRepository);
                $project->setProjectCategory($projectCategory);
                $project->setProjectDescription($projectDescription);
                $project->setProjectDocumentation($projectDocumentation);
                $project->setProjectCompanyCode($projectCompanyCode);

                $result = $project->save();
                if ($result) {
                    $_SESSION['type-imSupport'] = "success";
                    $_SESSION['message-imSupport'] = "El registro se realizo con exito";
                    header("Location:" . base_url . "project/index");
                } else {
                    $_SESSION['type-imSupport'] = "warning";
                    $_SESSION['message-imSupport'] = "El registro no se realizo con exito";
                    header("Location:" . base_url . "project/index");
                }
            }
        } else {
            $_SESSION['type-imSupport'] = "danger";
            $_SESSION['message-imSupport'] = "No se enviaron datos por Post";
            header("Location:" . base_url . "project/index");
        }
    }

    public function edit()
    {
        utils::isIdentity();
        $identityUserRole = $_SESSION['identity-imsupport']->userRole;

        if (isset($_GET['projectCode'])) {
            $_SESSION['projectCodeEdit'] = $_GET['projectCode'];
            header("Location:" . base_url . "project/edit");
        } else {
            $project = new project();
            $projectCode = $_SESSION['projectCodeEdit'];
            $company = new company();
            $company_list = $company->getAll();
            $project_list = $project->getAll();
            $_project = $project->getOne($projectCode)->fetch_object();
            require_once 'views/project/crud-project.php';
        }
    }

    public function update()
    {
        // Validacion si existe post
        if ($_POST) {
            $projectCode = isset($_POST['txt_projectCode']) ? intval(trim($_POST['txt_projectCode'])) : null;
            $projectName = isset($_POST['txt_projectName']) ? trim($_POST['txt_projectName']) : null;
            $projectRank = isset($_POST['opt_projectRank']) ? intval(trim($_POST['opt_projectRank'])) : null;
            $projectStatus = isset($_POST['opt_projectStatus']) ? intval(trim($_POST['opt_projectStatus'])) : null;
            $projectStartDate = isset($_POST['txt_projectStartDate']) ? trim($_POST['txt_projectStartDate']) : null;
            $projectFinishDate = !empty($_POST['txt_projectFinishDate']) ? trim("'" . $_POST['txt_projectFinishDate'] . "'") : 'null';
            $projectRepository = isset($_POST['txt_projectRepository']) ? trim($_POST['txt_projectRepository']) : null;
            $projectCategory = isset($_POST['opt_projectCategory']) ? intval(trim($_POST['opt_projectCategory'])) : null;
            $projectDescription = isset($_POST['txt_projectDescription']) ? trim($_POST['txt_projectDescription']) : null;
            $projectDocumentation = isset($_POST['txt_projectDocumentation']) ? trim($_POST['txt_projectDocumentation']) : null;
            $projectCompanyCode = isset($_POST['opt_projectCompanyCode']) ? intval(trim($_POST['opt_projectCompanyCode'])) : null;

            // Validar valores != null
            if (
                $projectRank == 0 || $projectStatus == 0 || $projectCategory == 0 || $projectCompanyCode == 0 ||
                $projectName == null || $projectStartDate == null || $projectDescription == null
            ) {
                $_SESSION['type-imSupport'] = "danger";
                $_SESSION['message-imSupport'] = "No has enviado algun valor requerido";
                header("Location:" . base_url . "project/index");
            } else {
                $project = new project();
                $project->setProjectName($projectName);
                $project->setProjectRank($projectRank);
                $project->setProjectStatus($projectStatus);
                $project->setProjectStartDate($projectStartDate);
                $project->setProjectFinishDate($projectFinishDate);
                $project->setProjectRepository($projectRepository);
                $project->setProjectCategory($projectCategory);
                $project->setProjectDescription($projectDescription);
                $project->setProjectDocumentation($projectDocumentation);
                $project->setProjectCompanyCode($projectCompanyCode);
                $result = $project->update($projectCode);

                if ($result->error) {
                    $_SESSION['type-imSupport'] = "danger";
                    $_SESSION['message-imSupport'] = 'Error: ' . $result->error;
                    header("Location:" . base_url . "project/index");
                } else {
                    $_SESSION['type-imSupport'] = "success";
                    $_SESSION['message-imSupport'] = "El registro se realizo con exito";
                    header("Location:" . base_url . "project/index");
                }
            }
        } else {
            $_SESSION['type-imSupport'] = "danger";
            $_SESSION['message-imSupport'] = "No se enviaron datos por Post";
            header("Location:" . base_url . "project/index");
        }
    }
}
