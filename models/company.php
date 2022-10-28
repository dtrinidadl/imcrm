<?php

class company
{
    private $db;
    private $companyCode;
    private $companyName;
    private $companyBusinessName;
    private $companyTaxDocument;
    private $companyAddress;
    private $companyEntry;
    private $companyContactName;
    private $companyContactEmail;
    private $companyContactPhone;
    private $companyCreatedDate;    
    private $companyUpdatedDate;
    private $companyDeletedDate;
    private $companyStatus;
    private $companyDeleted;

    //CONECTION
    function __construct()
    {
        $this->db = Database::connect();
    }

    function getCompanyCode()
    {
        return $this->companyCode;
    }

    function setCompanyCode($companyCode): void
    {
        $this->companyCode = $companyCode;
    }

    function getCompanyName()
    {
        return $this->companyName;
    }

    function setCompanyName($companyName): void
    {
        $this->companyName = $companyName;
    }

    function getCompanyBusinessName()
    {
        return $this->companyBusinessName;
    }

    function setCompanyBusinessName($companyBusinessName): void
    {
        $this->companyBusinessName = $companyBusinessName;
    }

    function getCompanyTaxDocument()
    {
        return $this->companyTaxDocument;        
    }

    function setCompanyTaxDocument($companyTaxDocument)
    {
        $this->companyTaxDocument = $companyTaxDocument;
    }

    function getCompanyAddress()
    {
        return $this->companyAddress;        
    }

    function setCompanyAddress($companyAddress)
    {
        $this->companyAddress = $companyAddress;
    }

    function getCompanyEntry()
    {
        return $this->companyEntry;
    }

    function setCompanyEntry($companyEntry): void
    {
        $this->companyEntry = $companyEntry;
    }

    function getCompanyContactName()
    {
        return $this->companyContactName;
    }

    function setCompanyContactName($companyContactName): void
    {
        $this->companyContactName = $companyContactName;
    }

    function getCompanyContactEmail()
    {
        return $this->companyContactEmail;
    }

    function setCompanyContactEmail($companyContactEmail): void
    {
        $this->companyContactEmail = $companyContactEmail;
    }

    function getCompanyContactPhone()
    {
        return $this->companyContactPhone;
    }

    function setCompanyContactPhone($companyContactPhone): void
    {
        $this->companyContactPhone = $companyContactPhone;
    }

    function getCompanyCreatedDate()
    {
        return $this->companyCreatedDate;
    }

    function setCompanyCreatedDate($companyCreatedDate): void
    {
        $this->companyCreatedDate = $companyCreatedDate;
    }

    function getCompanyUpdatedDate()
    {
        return $this->companyUpdatedDate;
    }

    function setCompanyUpdatedDate($companyUpdatedDate): void
    {
        $this->companyUpdatedDate = $companyUpdatedDate;
    }

    function getCompanyDeletedDate()
    {
        return $this->companyDeletedDate;
    }

    function setCompanyDeletedDate($companyDeletedDate): void
    {
        $this->companyDeletedDate = $companyDeletedDate;
    }

    function getCompanyStatus()
    {
        return $this->companyStatus;
    }

    function setCompanyStatus($companyStatus): void
    {
        $this->companyStatus = $companyStatus;
    }

    function getCompanyDeleted()
    {
        return $this->companyDeleted;
    }

    function setCompanyDeleted($companyDeleted): void
    {
        $this->companyDeleted = $companyDeleted;
    }

    public function getAll()
    {
        $sql = "SELECT *, date_format(companyCreatedDate, '%d-%m-%Y') AS companyDate FROM company WHERE companyDeleted = 0 AND companyStatus = 1 ORDER BY companyCode ASC;";
        $execute = $this->db->query($sql);

        $result = false;
        if ($execute) {
            $result = $execute;
        }
        return $result;
    }

    public function getOne($companyCode)
    {
        $sql = "SELECT * FROM company WHERE companyCode = $companyCode;";
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
        $_companyName = $this->companyName;
        $_companyBusinessName = $this->companyBusinessName;
        $_companyTaxDocument = $this->companyTaxDocument;
        $_companyEntry = $this->companyEntry;
        $_companyAddress = $this->companyAddress;
        $_companyContactName = $this->companyContactName;
        $_companyContactEmail = $this->companyContactEmail;
        $_companyContactPhone = $this->companyContactPhone;

        $sql = "CALL company_insert('$_companyName', '$_companyBusinessName', '$_companyTaxDocument', '$_companyEntry', '$_companyAddress', '$_companyContactName', '$_companyContactEmail', '$_companyContactPhone');";

        $execute = $this->db->query($sql);
        $this->db->next_result();
        $this->db->use_result();

        if ($execute) {
            $result = $execute;
        }
        return $result;
    }

    public function update($companyCode)
    {
        $result = false;
        $_companyName = $this->companyName;
        $_companyBusinessName = $this->companyBusinessName;
        $_companyTaxDocument = $this->companyTaxDocument;
        $_companyEntry = $this->companyEntry;
        $_companyAddress = $this->companyAddress;
        $_companyContactName = $this->companyContactName;
        $_companyContactEmail = $this->companyContactEmail;
        $_companyContactPhone = $this->companyContactPhone;

        $sql = "CALL company_update($companyCode, '$_companyName', '$_companyBusinessName', '$_companyTaxDocument', '$_companyEntry', '$_companyAddress', '$_companyContactName', '$_companyContactEmail', '$_companyContactPhone');";        

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

    public function deleted($companyCode)
    {
        $result = false;
        // $sql = "CALL company_deleted($companyCode);";
        $sql = "";
        $execute = $this->db->query($sql);
        $this->db->next_result();
        $this->db->use_result();

        if ($execute) {
            $result = $execute;
        }
        return $result;
    }
}
