<?php

class userProject
{
    private $db;
    private $userProjectCode;
    private $userProjectCompanyCode;
    private $userProjectProjectCode;
    private $userProjectUserCode;
    private $userProjectRole;
    private $userProjectCreatedDate;
    private $userProjectUpdatedDate;
    private $userProjectDeletedDate;
    private $userProjectStatus;
    private $userProjectDeleted;

    //CONECTION
    function __construct()
    {
        $this->db = Database::connect();
    }

    function getUserProjectCode()
    {
        return $this->userProjectCode;
    }

    function setUserProjectCode($userProjectCode): void
    {
        $this->userProjectCode = $userProjectCode;
    }

    function getUserProjectCompanyCode()
    {
        return $this->userProjectCompanyCode;
    }

    function setUserProjectCompanyCode($userProjectCompanyCode): void
    {
        $this->userProjectCompanyCode = $userProjectCompanyCode;
    }

    function getUserProjectProjectCode()
    {
        return $this->userProjectProjectCode;
    }

    function setUserProjectProjectCode($userProjectProjectCode): void
    {
        $this->userProjectProjectCode = $userProjectProjectCode;
    }

    function getUserProjectUserCode()
    {
        return $this->userProjectUserCode;
    }

    function setUserProjectUserCode($userProjectUserCode): void
    {
        $this->userProjectUserCode = $userProjectUserCode;
    }

    function getUserProjectRole()
    {
        return $this->userProjectRole;
    }

    function setUserProjectRole($userProjectRole): void
    {
        $this->userProjectRole = $userProjectRole;
    }

    function getUserProjectCreatedDate()
    {
        return $this->userProjectCreatedDate;
    }

    function setUserProjectCreatedDate($userProjectCreatedDate): void
    {
        $this->userProjectCreatedDate = $userProjectCreatedDate;
    }

    function getUserProjectUpdatedDate()
    {
        return $this->userProjectUpdatedDate;
    }

    function setUserProjectUpdatedDate($userProjectUpdatedDate): void
    {
        $this->userProjectUpdatedDate = $userProjectUpdatedDate;
    }

    function getUserProjectDeletedDate()
    {
        return $this->userProjectDeletedDate;
    }

    function setUserProjectDeletedDate($userProjectDeletedDate): void
    {
        $this->userProjectDeletedDate = $userProjectDeletedDate;
    }

    function getUserProjectStatus()
    {
        return $this->userProjectStatus;
    }

    function setUserProjectStatus($userProjectStatus): void
    {
        $this->userProjectStatus = $userProjectStatus;
    }

    function getUserProjectDeleted()
    {
        return $this->userProjectDeleted;
    }

    function setUserProjectDeleted($userProjectDeleted): void
    {
        $this->userProjectDeleted = $userProjectDeleted;
    }

    // FUNCTION
    // utils::drawDebug($result); die();
    public function getCompany()
    {
        $sql = "SELECT companyCode, companyBusinessName FROM company WHERE companyStatus = 1 AND companyDeleted = 0 ORDER BY companyCode ASC;";
        $execute = $this->db->query($sql);

        $result = false;
        if ($execute) {
            $result = $execute;
        }
        return $result;
    }

    public function getUser()
    {
        $sql = "SELECT userCode, userName FROM user WHERE userStatus = 1 AND userDeleted = 0 ORDER BY userCode ASC;";
        $execute = $this->db->query($sql);

        $result = false;
        if ($execute) {
            $result = $execute;
        }
        return $result;
    }

    public function getProject($projectCompanyCode)
    {
        $sql = "SELECT projectCode, projectName FROM project WHERE projectStatus < 8 AND projectCompanyCode = $projectCompanyCode ORDER BY projectCode ASC;";
        $execute = $this->db->query($sql);

        $result = false;
        if ($execute) {
            $result = $execute;
        }
        return $result;
    }

    public function getProjectByUser($userProjectUserCode)
    {
        $result = false;
        $sql = "CALL get_project_by_user($userProjectUserCode);";
        $execute = $this->db->query($sql);
        $this->db->next_result();
        $this->db->use_result();
        if ($execute) {
            $result = $execute;
        }
        return $result;
    }

    public function getUsersByProject($userProjectProjectCode)
    {
        echo $userProjectProjectCode;
        $result = false;
        $sql = "SELECT u.userName, u.userEmail, up.userProjectUserCode
                FROM userProject AS up 
                LEFT JOIN user AS u ON u.userCode = up.userProjectUserCode
                WHERE userProjectProjectCode = $userProjectProjectCode AND userProjectStatus = 1 AND userProjectDeleted = 0;";

        $execute = $this->db->query($sql);

        if ($execute) {
            $result = $execute;
        }
        return $result;
    }

    public function getRoleByUserAndProject($userProjectUserCode, $userProjectProjectCode)
    {
        $sql = "SELECT userProjectRole FROM userProject WHERE userProjectProjectCode =  $userProjectProjectCode AND userProjectUserCode =  $userProjectUserCode AND userProjectStatus = 1;";
        $execute = $this->db->query($sql);

        $result = false;
        if ($execute) {
            $result = $execute;
        }
        return $result;
    }

    public function getOne($userProjectCode)
    {
        $sql = "SELECT * FROM userProject WHERE userProjectCode = $userProjectCode;";
        $execute = $this->db->query($sql);

        $result = false;
        if ($execute) {
            $result = $execute;
        }
        return $result;
    }

    public function getAll()
    {
        $result = false;
        $sql = "CALL userProject_get_all();";
        $execute = $this->db->query($sql);
        $this->db->next_result();
        $this->db->use_result();

        if ($execute) {
            $result = $execute;
        }
        return $result;
    }

    public function save()
    {
        $result = false;
        $_userProjectCompanyCode = $this->userProjectCompanyCode;
        $_userProjectProjectCode = $this->userProjectProjectCode;
        $_userProjectUserCode = $this->userProjectUserCode;
        $_userProjectRole = $this->userProjectRole;

        $sql = "insert into userProject (userProjectCompanyCode, userProjectProjectCode, userProjectUserCode, userProjectRole) 
        VALUES ($_userProjectCompanyCode, $_userProjectProjectCode, $_userProjectUserCode, $_userProjectRole);";
        $execute = $this->db->query($sql);

        if ($execute) {
            $result = $execute;
        }
        return $result;
    }

    public function update($userProjectCode)
    {
        $result = false;
        $_userProjectCode = $this->userProjectCode;
        $_userProjectCompanyCode = $this->userProjectCompanyCode;
        $_userProjectProjectCode = $this->userProjectProjectCode;
        $_userProjectUserCode = $this->userProjectUserCode;
        $_userProjectRole = $this->userProjectRole;

        $sql = "UPDATE userProject SET userProjectCompanyCode = $_userProjectCompanyCode, userProjectProjectCode = $_userProjectProjectCode, userProjectUserCode = $_userProjectUserCode, userProjectRole = $_userProjectRole, userProjectUpdatedDate = CURRENT_TIMESTAMP() WHERE userProjectCode = $userProjectCode;";
        echo $sql;
        $execute = $this->db->query($sql);

        if ($execute) {
            $result = $execute;
        } else {
            $result = $this->db;
        }
        return $result;
    }

    public function deleted($userProjectCode)
    {
        $result = false;
        $sql = "UPDATE userProject SET userProjectStatus = 0, userProjectDeleted = 1, userProjectDeletedDate = CURRENT_TIMESTAMP() WHERE userProjectCode = $userProjectCode;";
        $execute = $this->db->query($sql);

        if ($execute) {
            $result = $execute;
        }
        return $result;
    }
}
