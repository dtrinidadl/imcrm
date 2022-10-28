<?php

class report
{
    private $db;

    //CONECTION
    function __construct()
    {
        $this->db = Database::connect();
    }

    public function getParamsData($start_date, $final_date)
    {
        $sql = "CALL report_params_by_date('$start_date', '$final_date');";
        $execute = $this->db->query($sql);
        $this->db->next_result();
        $this->db->use_result();
        
        $result = false;
        if ($execute) {
            $result = $execute;
        }
        return $result;
    }

    public function getTicketMax($start_date, $final_date)
    {
        $sql = "CALL report_max_support('$start_date', '$final_date');";
        $execute = $this->db->query($sql);
        $this->db->next_result();
        $this->db->use_result();
        
        $result = false;
        if ($execute) {
            $result = $execute;
        }
        return $result;
    }

    public function getDate($start_date, $final_date)
    {
        $sql = "CALL report_by_date('$start_date', '$final_date');";
        $execute = $this->db->query($sql);
        $this->db->next_result();
        $this->db->use_result();

        $result = false;
        if ($execute) {
            $result = $execute;
        }
        return $result;
    }
}