<?php

class user
{
    private $db;
    private $userCode;
    private $userName;
    private $userNickname;
    private $userEmail;
    private $userPhone;
    private $userPassword;
    private $userCreatedDate;
    private $userUpdatedDate;
    private $userDeletedDate;
    private $userRole;
    private $userStatus;
    private $userDeleted;

    //CONECTION
    function __construct()
    {
        $this->db = Database::connect();
    }

    function getUserCode()
    {
        return $this->userCode;
    }

    function setUserCode($userCode): void
    {
        $this->userCode = $userCode;
    }

    function getUserName()
    {
        return $this->userName;
    }

    function setUserName($userName): void
    {
        $this->userName = $userName;
    }

    function getUserNickname()
    {
        return $this->userNickname;
    }

    function setUserNickname($userNickname): void
    {
        $this->userNickname = $userNickname;
    }

    function getUserEmail()
    {
        return $this->userEmail;
    }

    function setUserEmail($userEmail): void
    {
        $this->userEmail = $userEmail;
    }

    function getUserPhone()
    {
        return $this->userPhone;
    }

    function setUserPhone($userPhone): void
    {
        $this->userPhone = $userPhone;
    }

    function getUserPassword()
    {
        // return $this->userPassword;
        return password_hash($this->db->real_escape_string($this->userPassword), PASSWORD_BCRYPT, ['cost' => 4]);
    }

    function setUserPassword($userPassword)
    {
        $this->userPassword = $userPassword;
    }

    function getUserCreatedDate()
    {
        return $this->userCreatedDate;
    }

    function setUserCreatedDate($userCreatedDate): void
    {
        $this->userCreatedDate = $userCreatedDate;
    }

    function getUserUpdatedDate()
    {
        return $this->userUpdatedDate;
    }

    function setUserUpdatedDate($userUpdatedDate): void
    {
        $this->userUpdatedDate = $userUpdatedDate;
    }

    function getUserDeletedDate()
    {
        return $this->userDeletedDate;
    }

    function setUserDeletedDate($userDeletedDate): void
    {
        $this->userDeletedDate = $userDeletedDate;
    }

    function getUserRole()
    {
        return $this->userRole;
    }

    function setUserRole($userRole): void
    {
        $this->userRole = $userRole;
    }

    function getUserStatus()
    {
        return $this->userStatus;
    }

    function setUserStatus($userStatus): void
    {
        $this->userStatus = $userStatus;
    }

    function getUserDeleted()
    {
        return $this->userDeleted;
    }

    function setUserDeleted($userDeleted): void
    {
        $this->userDeleted = $userDeleted;
    }

    // FUNCTIONS
    public function login()
    {
        $result = false;
        $_userEmail = $this->userEmail;
        $_userNickname = $this->userNickname;
        $_userPassword = $this->userPassword;

        $sql = "CALL login('$_userNickname', '$_userEmail')";
        $execute = $this->db->query($sql);
        $this->db->next_result();
        $this->db->use_result();
        //utils::drawDebug($this->db); $user = $execute->fetch_object(); $result = $user; utils::drawDebug($result); die();// No validar
        //*
        if ($execute && $execute->num_rows == 1) {
            echo "entro:";
            $user = $execute->fetch_object(); 
            // Validar pass codificada
            $verify = password_verify($_userPassword, $user->userPassword);         
            if ($verify) {
                $result = $user;
            }
        }
        //*/
        return $result;
    }
    // utils::drawDebug($result); die();

    public function getUserByCompany()
    {
        $sql = "SELECT *, date_format(userCreatedDate, '%d-%m-%Y') AS userDate FROM user WHERE userDeleted = 0 AND userStatus = 1 ORDER BY userCode ASC;";
        $execute = $this->db->query($sql);

        $result = false;
        if ($execute) {
            $result = $execute;
        }
        return $result;
    }

    public function getOne($userCode)
    {
        $sql = "SELECT * FROM user WHERE userCode = $userCode;";
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
        $_userRole = $this->userRole;
        $_userName = $this->userName;
        $_userPhone = $this->userPhone;
        $_userEmail = $this->userEmail;
        $_userNickname = $this->userNickname;
        $_userPassword = $this->getUserPassword();

        $sql = "CALL user_insert('$_userName', '$_userNickname', '$_userEmail', '$_userPassword', '$_userPhone', $_userRole);";
        $execute = $this->db->query($sql);
        $this->db->next_result();
        $this->db->use_result();

        if ($execute) {
            $result = $execute;
        }
        return $result;
    }

    public function update($userCode)
    {
        $result = false;
        $_userRole = $this->userRole;
        $_userName = $this->userName;
        $_userPhone = $this->userPhone;
        $_userEmail = $this->userEmail;
        $_userNickname = $this->userNickname;

        $sql = "CALL user_update('$userCode', '$_userName', '$_userNickname', '$_userEmail', '$_userPhone', $_userRole);";
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

    public function deleted($userCode)
    {
        $result = false;
        $sql = "CALL user_deleted($userCode);";
        $execute = $this->db->query($sql);
        $this->db->next_result();
        $this->db->use_result();

        if ($execute) {
            $result = $execute;
        }
        return $result;
    }

    public function exists($userNickname, $userEmail)
    {
        $sql = "CALL user_exists('$userNickname', '$userEmail')";
        $execute = $this->db->query($sql);
        $this->db->next_result();
        $this->db->use_result();
        $execute = $execute->fetch_object();

        $result = false;
        if ($execute) {
            $result = $execute;
        }
        return $result;
    }

    public function changePassword($userCode)
    {
        $userPassword = $this->getUserPassword();        
  
        $sql = "CALL user_changePassword($userCode, '$userPassword')";
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
