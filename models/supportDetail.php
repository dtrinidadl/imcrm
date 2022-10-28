<?php

class supportDetail
{
    private $db;
    private $supportDetailCode;
    private $supportDetailUserCode;
    private $supportDetailSupportCode;    
    private $supportDetailDescription;

    //CONECTION
    function __construct()
    {
        $this->db = Database::connect();
    }

    function getSupportDetailCode()
    {
        return $this->supportDetailCode;
    }

    function setSupportDetailCode($supportDetailCode): void
    {
        $this->supportDetailCode = $supportDetailCode;
    }

    function getSupportDetailSupportCode()
    {
        return $this->supportDetailSupportCode;
    }

    function setSupportDetailSupportCode($supportDetailSupportCode): void
    {
        $this->supportDetailSupportCode = $supportDetailSupportCode;
    }

    function getSupportDetailIdentifier()
    {
        return $this->supportDetailIdentifier;
    }

    function setSupportDetailIdentifier($supportDetailIdentifier): void
    {
        $this->supportDetailIdentifier = $supportDetailIdentifier;
    }

    function getSupportDetailUserCode()
    {
        return $this->supportDetailUserCode;
    }

    function setSupportDetailUserCode($supportDetailUserCode): void
    {
        $this->supportDetailUserCode = $supportDetailUserCode;
    }

    function getSupportDetailDescription()
    {
        return $this->supportDetailDescription;
    }

    function setSupportDetailDescription($supportDetailDescription): void
    {
        $this->supportDetailDescription = $supportDetailDescription;
    }

    // FUNCTION
    public function save()
    {
        $result = false;
        $_supportDetailSupportCode = $this->supportDetailSupportCode;
        $_supportDetailDescription = $this->supportDetailDescription;
        $_supportDetailUserCode = $this->supportDetailUserCode;
          
        $sql = "CALL supportDetail_insert($_supportDetailUserCode, $_supportDetailSupportCode,'$_supportDetailDescription');";
        $execute = $this->db->query($sql); 
        $this->db->next_result();
        $this->db->use_result();

        if ($execute) {
            $result = $execute;
        }
        return $result;
    }
}
