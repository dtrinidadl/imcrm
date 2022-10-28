<?php
require_once 'models/notification.php';

class homeController
{

    public function getAjax()
    {
        $notification = new notification();
        
        if (isset($_GET['getNotification'])) {
            $userCode = $_SESSION['identity-imsupport']->userCode;
            $notification_list = $notification->getNotificationByUser($userCode);
            $data = array();

            while ($row = $notification_list->fetch_assoc()) {
                $data[] = $row;
            }
            echo json_encode($data);
            die();            
        }

        if (isset($_GET['notificationUpdate'])) {
            $_notificationCode = $_GET['notificationCode'];        
            $result = $notification->update($_notificationCode);
            
            echo $result;
            die();
        }
    }

    public function index()
    {
        #Validar que este loggeado
        utils::isIdentity();
        require_once 'views/home/home.php';
    }
}
