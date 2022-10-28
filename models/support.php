<?php

class support
{
    private $db;
    private $supportCode;
    private $supportProjectCode;
    private $supportIdentifier;
    private $supportUserCode;
    private $supportType;
    private $supporPriority;
    private $supporrTitle;
    private $supportDescription;

    //CONECTION
    function __construct()
    {
        $this->db = Database::connect();
    }

    function getSupportCode()
    {
        return $this->supportCode;
    }

    function setSupportCode($supportCode): void
    {
        $this->supportCode = $supportCode;
    }

    function getSupportProjectCode()
    {
        return $this->supportProjectCode;
    }

    function setSupportProjectCode($supportProjectCode): void
    {
        $this->supportProjectCode = $supportProjectCode;
    }

    function getSupportIdentifier()
    {
        return $this->supportIdentifier;
    }

    function setSupportIdentifier($supportIdentifier): void
    {
        $this->supportIdentifier = $supportIdentifier;
    }

    function getSupportUserCode()
    {
        return $this->supportUserCode;
    }

    function setSupportUserCode($supportUserCode): void
    {
        $this->supportUserCode = $supportUserCode;
    }

    function getSupportType()
    {
        return $this->supportType;
    }

    function setSupportType($supportType): void
    {
        $this->supportType = $supportType;
    }

    function getSupporPriority()
    {
        return $this->supporPriority;
    }

    function setSupporPriority($supporPriority): void
    {
        $this->supporPriority = $supporPriority;
    }

    function getSupporrTitle()
    {
        return $this->supporrTitle;
    }

    function setSupporrTitle($supporrTitle): void
    {
        $this->supporrTitle = $supporrTitle;
    }

    function getSupportDescription()
    {
        return $this->supportDescription;
    }

    function setSupportDescription($supportDescription): void
    {
        $this->supportDescription = $supportDescription;
    }

    public function getCompany()
    {
        $sql = "SELECT companyCode, companyBusinessName FROM company WHERE supportDescription = 1 AND companyDeleted = 0 ORDER BY companyCode ASC;";
        $execute = $this->db->query($sql);

        $result = false;
        if ($execute) {
            $result = $execute;
        }
        return $result;
    }

    public function getUser()
    {
        $sql = "SELECT Code, Name FROM  WHERE Status = 1 AND Deleted = 0 ORDER BY Code ASC;";
        $execute = $this->db->query($sql);

        $result = false;
        if ($execute) {
            $result = $execute;
        }
        return $result;
    }

    public function getSupport($supportProjectCode)
    {
        $sql = "SELECT supportCode, supportName FROM support WHERE supportStatus < 7 AND supportProjectCode = $supportProjectCode ORDER BY supportCode ASC;";
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
        $sql = "CALL support_get_all();";
        $execute = $this->db->query($sql);
        $this->db->next_result();
        $this->db->use_result();

        if ($execute) {
            $result = $execute;
        }
        return $result;
    }

    public function getOne($supportCode)
    {
        $sql = "SELECT * FROM support WHERE supportCode = $supportCode;";
        $execute = $this->db->query($sql);

        $result = false;
        if ($execute) {
            $result = $execute;
        }
        return $result;
    }

    public function getHeader($supportCode){
        $result = false;
        $sql = "CALL support_get_one($supportCode)";
        $execute = $this->db->query($sql);
        $this->db->next_result();
        $this->db->use_result();

        if ($execute) {
            $result = $execute;
        }
        return $result;
    }

    public function getDetail($supportCode){
        $result = false;

        $sql = "SELECT sd.supportDetailCode, sd.supportDetailUserCode, u.userName, 
         date_format(sd.supportDetailCreatedDate, '%d-%m-%Y') AS supportDetailCreatedDate, supportDetailDescription
         FROM supportDetail AS sd
         LEFT JOIN user AS u ON u.userCode = sd.supportDetailUserCode
         WHERE sd.supportDetailSupportCode = $supportCode ORDER BY sd.supportDetailCode, sd.supportDetailCreatedDate ASC;";
        $execute = $this->db->query($sql);
        $this->db->next_result();
        $this->db->use_result();

        if ($execute) {
            $result = $execute;
        }
        return $result;
    }

    public function getSupportByUserInsert($userCode, $active)
    {
        $result = false;
        $sql = "CALL support_get_by_user_insert($userCode, $active);";
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
        $_supportProjectCode = $this->supportProjectCode;
        $_supportDescription = $this->supportDescription;
        $_supportUserCode = $this->supportUserCode;
        $_supporPriority = $this->supporPriority;
        $_supporrTitle = $this->supporrTitle;
        $_supportType = $this->supportType;
        $_supportIdentifier = date('mdyhis', time());  
          
        $sql = "CALL support_insert('$_supportIdentifier', $_supportUserCode, $_supportProjectCode, $_supportType, $_supporPriority, '$_supporrTitle', '$_supportDescription');";
        $execute = $this->db->query($sql);
        $this->db->next_result();
        $this->db->use_result();

        if ($execute) {
            $result = $execute;
        }
        return $result;
    }

    // Actualizar el tipo de soporte
    function updateSupportType($supportCode, $supportType){
        $result = false;

        $sql = "UPDATE support SET supportType = $supportType WHERE supportCode = $supportCode;";    
        $execute = $this->db->query($sql);
        $this->db->next_result();
        $this->db->use_result();

        if ($execute) {
            $result = true;
        }
        return $result;
    }

    // Actualizar el tipo de soporte
    function updateSupportStatus($supportCode, $supportStatus, $supportDate){
        $result = false;

        $sql = "UPDATE support SET supportStatus = $supportStatus, $supportDate = CURRENT_TIMESTAMP() WHERE supportCode = $supportCode;";    
        $execute = $this->db->query($sql);
        $this->db->next_result();
        $this->db->use_result();

        if ($execute) {
            $result = true;
        }
        return $result;
    }

    // Subir archivos
    function uploadRecords($documentSupportCode, $documentSupportDetailCode, $documentOriginName, $documentName, $extension, $documentLocation){
        $result_id = false;

        $sql = "INSERT INTO document (documentSupportCode, documentSupportDetailCode, documentOriginName, documentName, documentExtension, documentLocation) 
                VALUES($documentSupportCode, $documentSupportDetailCode, '$documentOriginName', '$documentName', '$extension', '$documentLocation');";        
        $execute = $this->db->query($sql);
        
        if ($execute) {
            $result_id = $this->db->insert_id;
        }
        return $result_id;
    }

    // Obtener un documento
    function getDocument($documentCode){
        $result = false;

        $sql = "SELECT * FROM document WHERE documentCode = $documentCode;";                
        $execute = $this->db->query($sql);
        
        if ($execute) {
            $result = $execute;
        }
        return $result;
    }

    // Obtener un documento
    function getAllDocument($documentCode){
        $result = false;

        $sql = "SELECT documentSupportCode, documentSupportDetailCode, documentOriginName, documentLocation, documentName, documentExtension FROM document WHERE documentSupportCode = $documentCode;";                
        $execute = $this->db->query($sql);
        
        if ($execute) {
            $result = $execute;
        }
        return $result;
    }

    // Eliminar documento
    function deletedDocument($documentCode){
        $result = false;

        $sql = "DELETE FROM document WHERE documentCode = $documentCode;";                
        $execute = $this->db->query($sql);
        
        if ($execute) {
            $result = $execute;
        }
        return $result;
    }

    // Eliminar documento
    function updateDocument($documentCode, $documentSupportCode, $documentSupportDetailCode){
        $sql = "UPDATE document SET documentSupportCode = $documentSupportCode, documentSupportDetailCode = $documentSupportDetailCode 
                WHERE documentCode = $documentCode;";                
        $execute = $this->db->query($sql);
    }

    // Enviar Correo
    public function sendMail($to, $name, $notification)
    {
        $subject = "[imSupport] Notificación - $notification";

        $mail = "<html>
                    <head> <title>Prueba de correo</title> </head>
                    <body align='center'>
                        <br>
                        <h2 style='color: #086d8e; margin-top: 2.75rem;'>Hola $name.</h2>
                        <p>
                            <b>¡Que gusto saludarte!</b>
                            <br>Tienes una nueva notificación, puede ingresar a www.imsupport-dev.gq para poder verla.
                        </p>
                        <p>atte.:</p>
                        <span href='https://ima.com.gt/' target='_blank'>
                            <img src='https://imsupport.000webhostapp.com/assets/img/logo-1.png' alt='logotipo IMA' width='95px'>
                        </span>
                        <div style='display: block; margin: 30px; text-align: center;'>
                            <span href='https://google.com/' target='_blank'
                                style='font-weight: 600; margin: 25px; color: white; padding: 5px 28px; align-items: center; border-radius: 15px; text-decoration: none;
                                background: linear-gradient(90deg, #086d8e -10%,#32ba9b 110%); border: 2px solid #086d8e; box-shadow: 0px 3px 5px 3px rgba(1, 43, 58, 0.14);'>imSupport</span>
                        </div>
                        <span style='font-size: 12px; color: grey'>IMA&copy; | www.ima.com.gt</span>
                        <hr style='border: none; padding: 0.33rem; background: #086d8e; background: linear-gradient(90deg, #086d8e 0%,#32ba7f 100%);'>
                    </body>
                </html>";

        $headers = "MIME-Version: 1.0\r\n";
        $headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
        $headers .= "From: Soporte IMA <noreply@ima.com.gt>\r\n";
        $headers .= "Return-path: info-support@ima.com.gt\r\n";

        mail($to, $subject, $mail, $headers);
    }
}
