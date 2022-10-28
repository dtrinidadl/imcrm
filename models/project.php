<?php

class project
{
    private $db;
    private $projectCode;
    private $projectName;
    private $projectCompanyCode;
    private $projectDescription;
    private $projectRank;
    private $projectStatus;
    private $projectCategory;
    private $projectStartDate;    
    private $projectFinishDate;
    private $projectRepository;
    private $projectDocumentation;
    private $projectCreatedDate;    
    private $projectUpdatedDate;

    //CONECTION
    function __construct()
    {
        $this->db = Database::connect();
    }

    function getProjectCode()
    {
        return $this->projectCode;
    }

    function setProjectCode($projectCode): void
    {
        $this->projectCode = $projectCode;
    }

    function getProjectName()
    {
        return $this->projectName;
    }

    function setProjectName($projectName): void
    {
        $this->projectName = $projectName;
    }

    function getProjectCompanyCode()
    {
        return $this->projectCompanyCode;
    }

    function setProjectCompanyCode($projectCompanyCode): void
    {
        $this->projectCompanyCode = $projectCompanyCode;
    }

    function getProjectDescription()
    {
        return $this->projectDescription;        
    }

    function setProjectDescription($projectDescription)
    {
        $this->projectDescription = $projectDescription;
    }

    function getProjectRank()
    {
        return $this->projectRank;
    }

    function setProjectRank($projectRank): void
    {
        $this->projectRank = $projectRank;
    }

    function getProjectStatus()
    {
        return $this->projectStatus;
    }

    function setProjectStatus($projectStatus): void
    {
        $this->projectStatus = $projectStatus;
    }

    function getProjectCategory()
    {
        return $this->projectCategory;        
    }

    function setProjectCategory($projectCategory)
    {
        $this->projectCategory = $projectCategory;
    }

    function getProjectStartDate()
    {
        return $this->projectStartDate;
    }

    function setProjectStartDate($projectStartDate): void
    {
        $this->projectStartDate = $projectStartDate;
    }

    function getProjectFinishDate()
    {
        return $this->projectFinishDate;
    }

    function setProjectFinishDate($projectFinishDate): void
    {
        $this->projectFinishDate = $projectFinishDate;
    }

    function getProjectRepository()
    {
        return $this->projectRepository;
    }

    function setProjectRepository($projectRepository): void
    {
        $this->projectRepository = $projectRepository;
    }

    function getProjectDocumentation()
    {
        return $this->projectDocumentation;
    }

    function setProjectDocumentation($projectDocumentation): void
    {
        $this->projectDocumentation = $projectDocumentation;
    }

    function getProjectCreatedDate()
    {
        return $this->projectCreatedDate;
    }

    function setProjectCreatedDate($projectCreatedDate): void
    {
        $this->projectCreatedDate = $projectCreatedDate;
    }

    function getProjectUpdatedDate()
    {
        return $this->projectUpdatedDate;
    }

    function setProjectUpdatedDate($projectUpdatedDate): void
    {
        $this->projectUpdatedDate = $projectUpdatedDate;
    }

    public function getAll()
    {
        $sql = "CALL project_get_all()";
        $execute = $this->db->query($sql);
        $this->db->next_result();
        $this->db->use_result();
        
        $result = false;
        if ($execute) {
            $result = $execute;
        }
        return $result;
    }

    public function getOneView($projectCode)
    {                
        $sql = "CALL project_get_one($projectCode);";
        $execute = $this->db->query($sql);
        $this->db->next_result();
        $this->db->use_result();
        $result = false;
        if ($execute) {
            $result = $execute;
        }
        return $result;
    }

    public function getOne($projectCode)
    {
        $sql = "SELECT * FROM project WHERE projectCode = $projectCode;";
        $execute = $this->db->query($sql);
        $result = false;
        if ($execute) {
            $result = $execute;
        }
        return $result;
    }
    
    public function save()
    {
        $result = false;
        $_projectName = $this->projectName;
        $_projectRank = $this->projectRank;
        $_projectStatus = $this->projectStatus;
        $_projectStartDate = $this->projectStartDate;
        $_projectFinishDate = $this->projectFinishDate;
        $_projectRepository = $this->projectRepository;
        $_projectCategory = $this->projectCategory;
        $_projectDescription = $this->projectDescription;
        $_projectDocumentation = $this->projectDocumentation;
        $_projectCompanyCode = $this->projectCompanyCode;
  
        $sql = "CALL project_insert('$_projectName', $_projectCompanyCode, $_projectCategory, $_projectStatus, $_projectRank, '$_projectStartDate', '$_projectFinishDate', '$_projectRepository', '$_projectDocumentation', '$_projectDescription');";
        $execute = $this->db->query($sql);
        $this->db->next_result();
        $this->db->use_result();

        if ($execute) {
            $result = $execute;
        }
        return $result;
    }

    public function update($projectCode)
    {
        $result = false;
        $_projectName = $this->projectName;
        $_projectRank = $this->projectRank;
        $_projectStatus = $this->projectStatus;
        $_projectStartDate = $this->projectStartDate;
        $_projectFinishDate = $this->projectFinishDate;
        $_projectRepository = $this->projectRepository;
        $_projectCategory = $this->projectCategory;
        $_projectDescription = $this->projectDescription;
        $_projectDocumentation = $this->projectDocumentation;
        $_projectCompanyCode = $this->projectCompanyCode;

        $sql = "CALL project_update($projectCode, '$_projectName', $_projectCompanyCode, $_projectCategory, $_projectStatus, $_projectRank,
                '$_projectStartDate', $_projectFinishDate, '$_projectRepository', '$_projectDocumentation', '$_projectDescription');";
       
        $execute = $this->db->query($sql);
        $this->db->next_result();
        $this->db->use_result();

        if ($execute) {
            $result = $execute;
        } else {
            $result = $this->db;
        }
        return $result;
    }

    public function deleted($projectCode)
    {
        $result = false;
        $sql = "CALL project_deleted($projectCode);";
        $execute = $this->db->query($sql);
        $this->db->next_result();
        $this->db->use_result();

        if ($execute) {
            $result = $execute;
        }
        return $result;
    }
}
