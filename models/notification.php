<?php

class notification
{
    private $db;

    //CONECTION
    function __construct()
    {
        $this->db = Database::connect();
    }

    // FUNCTION
    public function getNotificationByUser($userCode)
    {
        $sql = "CALL notification_get_by_user($userCode)";
        $execute = $this->db->query($sql);
        $this->db->next_result();
        $this->db->use_result();

        $result = false;
        if ($execute) {
            $result = $execute;
        }
        return $result;
    }

    public function update($notificationCode)
    {
        $result = false;
        $_notificationCode = $notificationCode;

        $sql = "UPDATE notification SET notificationStatus = 0, notificationReadingDate = CURRENT_TIMESTAMP() WHERE notificationCode = $_notificationCode;";
        $execute = $this->db->query($sql);

        if ($execute) {
            $result = $execute;
        } else {
            $result = $this->db->error;
        }
        return $result;
    }

    public function save($values)
    {
        $sql = "INSERT INTO notification (notificationUserCode, notificationSupportCode, notificationSupportDetailCode, notificationText) VALUES $values"; 
        $execute = $this->db->query($sql);

        // echo "$sql  <br>";
    }
}
