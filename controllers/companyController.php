<?php
require_once 'models/company.php';

class companyController
{
    public function index()
    {
        // Logeado?        
        utils::isIdentity();
        $identityUserRole = $_SESSION['identity-imsupport']->userRole;
        if ($identityUserRole != 1) {
            header("Location:" . base_url . "home/index");
        }

        $company = new company();
        $company_list = $company->getAll();
        require_once 'views/company/crud-company.php';
    }

    public function save()
    {
        // Validacion si existe post
        if ($_POST) {
            $companyCode = isset($_POST['txt_companyCode']) ? intval(trim($_POST['txt_companyCode'])) : -1;
            $companyName = isset($_POST['txt_companyName']) ? trim($_POST['txt_companyName']) : null;
            $companyBusinessName = isset($_POST['txt_companyBusinessName']) ? trim($_POST['txt_companyBusinessName']) : null;
            $companyTaxDocument = isset($_POST['txt_companyTaxDocument']) ? trim($_POST['txt_companyTaxDocument']) : null;
            $companyEntry = isset($_POST['txt_companyEntry']) ? trim($_POST['txt_companyEntry']) : null;
            $companyAddress = isset($_POST['txt_companyAddress']) ? trim($_POST['txt_companyAddress']) : null;
            $companyContactName = isset($_POST['txt_companyContactName']) ? trim($_POST['txt_companyContactName']) : null;
            $companyContactPhone = isset($_POST['txt_companyContactPhone']) ? trim($_POST['txt_companyContactPhone']) : null;
            $companyContactEmail = isset($_POST['txt_companyContactEmail']) ? trim($_POST['txt_companyContactEmail']) : null;

            // Validar valores != null
            if (
                $companyName == null || $companyBusinessName == null || $companyTaxDocument == 0 ||
                $companyEntry == null || $companyAddress == null || $companyContactName == null || $companyContactPhone == null
            ) {
                $_SESSION['type-imSupport'] = "danger";
                $_SESSION['message-imSupport'] = "No has enviado algun valor requerido";
                header("Location:" . base_url . "company/index");
            } else {
                $company = new company();
                $company->setCompanyName($companyName);
                $company->setCompanyBusinessName($companyBusinessName);
                $company->setCompanyTaxDocument($companyTaxDocument);
                $company->setCompanyEntry($companyEntry);
                $company->setCompanyAddress($companyAddress);
                $company->setCompanyContactName($companyContactName);
                $company->setCompanyContactEmail($companyContactEmail);
                $company->setCompanyContactPhone($companyContactPhone);

                $result = $company->save();
                if ($result) {
                    $_SESSION['type-imSupport'] = "success";
                    $_SESSION['message-imSupport'] = "El registro se realizo con exito";
                    header("Location:" . base_url . "company/index");
                } else {
                    $_SESSION['type-imSupport'] = "warning";
                    $_SESSION['message-imSupport'] = "El registro no se realizo con exito";
                    header("Location:" . base_url . "company/index");
                }
            }
        } else {
            $_SESSION['type-imSupport'] = "danger";
            $_SESSION['message-imSupport'] = "No se enviaron datos por Post";
            header("Location:" . base_url . "company/index");
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

        if (isset($_GET['companyCode'])) {
            $_SESSION['companyCodeEdit'] = $_GET['companyCode'];
            header("Location:" . base_url . "company/edit");
        } else {
            $company = new company();
            $companyCode = $_SESSION['companyCodeEdit'];
            $company_list = $company->getAll();
            $_company = $company->getOne($companyCode)->fetch_object();
            require_once 'views/company/crud-company.php';
        }
    }

    public function update()
    {
        // Validacion si existe post
        if ($_POST) {
            $companyCode = isset($_POST['txt_companyCode']) ? intval(trim($_POST['txt_companyCode'])) : null;
            $companyName = isset($_POST['txt_companyName']) ? trim($_POST['txt_companyName']) : null;
            $companyBusinessName = isset($_POST['txt_companyBusinessName']) ? trim($_POST['txt_companyBusinessName']) : null;
            $companyTaxDocument = isset($_POST['txt_companyTaxDocument']) ? trim($_POST['txt_companyTaxDocument']) : null;
            $companyEntry = isset($_POST['txt_companyEntry']) ? trim($_POST['txt_companyEntry']) : null;
            $companyAddress = isset($_POST['txt_companyAddress']) ? trim($_POST['txt_companyAddress']) : null;
            $companyContactName = isset($_POST['txt_companyContactName']) ? trim($_POST['txt_companyContactName']) : null;
            $companyContactPhone = isset($_POST['txt_companyContactPhone']) ? trim($_POST['txt_companyContactPhone']) : null;
            $companyContactEmail = isset($_POST['txt_companyContactEmail']) ? trim($_POST['txt_companyContactEmail']) : null;

            // Validar valores != null
            if (
                $companyName == null || $companyBusinessName == null || $companyTaxDocument == 0 ||
                $companyEntry == null || $companyAddress == null || $companyContactName == null || $companyContactPhone == null
            ) {
                $_SESSION['type-imSupport'] = "danger";
                $_SESSION['message-imSupport'] = "No has enviado algun valor requerido";
                header("Location:" . base_url . "company/index");
            } else {
                $company = new company();
                $company->setCompanyName($companyName);
                $company->setCompanyBusinessName($companyBusinessName);
                $company->setCompanyTaxDocument($companyTaxDocument);
                $company->setCompanyEntry($companyEntry);
                $company->setCompanyAddress($companyAddress);
                $company->setCompanyContactName($companyContactName);
                $company->setCompanyContactEmail($companyContactEmail);
                $company->setCompanyContactPhone($companyContactPhone);
                $result = $company->update($companyCode);

                if ($result->error) {
                    $_SESSION['type-imSupport'] = "danger";
                    $_SESSION['message-imSupport'] = 'Error: ' . $result->error;
                    header("Location:" . base_url . "company/index");
                } else {
                    $_SESSION['type-imSupport'] = "success";
                    $_SESSION['message-imSupport'] = "El registro se realizo con exito";
                    header("Location:" . base_url . "company/index");
                }
            }
        } else {
            $_SESSION['type-imSupport'] = "danger";
            $_SESSION['message-imSupport'] = "No se enviaron datos por Post";
            header("Location:" . base_url . "company/index");
        }
    }

    public function deleted()
    {
        utils::isIdentity();
        if (isset($_GET['companyCode'])) {
            $_SESSION['companyCodeEdit'] = $_GET['companyCode'];
            header("Location:" . base_url . "company/deleted");
        } else {
            $company = new company();
            $companyCode = $_SESSION['companyCodeEdit'];
            $result = $company->deleted($companyCode);
            if ($result) {
                $_SESSION['type-imSupport'] = "success";
                $_SESSION['message-imSupport'] = "El registro se elimino con exito";
                header("Location:" . base_url . "company/index");
            } else {
                $_SESSION['type-imSupport'] = "warning";
                $_SESSION['message-imSupport'] = "El registro no se elimino con exito";
                header("Location:" . base_url . "company/index");
            }
        }
    }
}
