<?php
require_once 'models/report.php';

class reportController
{
    public function index()
    {
        utils::isIdentity();
        $identityUserRole = $_SESSION['identity-imsupport']->userRole;
        if ($identityUserRole != 1) {
            header("Location:" . base_url . "home/index");
        }
        
        $start_date = date('Y-m-d', time());
        $final_date = date('Y-m-d', time());
        $report_type = 1;
        if (isset($_POST['report_type'])) {
            $report = new report();
            $start_date = isset($_POST['start_date']) ? trim($_POST['start_date']) : null;
            $final_date = isset($_POST['final_date']) ? trim($_POST['final_date']) : null;
            $report_type = intval($_POST['report_type']);            
            require_once 'views/report/report-params.php';
            $report_list = $report->getDate($start_date, $final_date);
            $params = $report->getParamsData($start_date, $final_date)->fetch_object();
            $ticket_max = $report->getTicketMax($start_date, $final_date)->fetch_object();

            switch (intval($_POST['report_type'])) {
                case 1:
                    require_once 'views/report/report-data-center.php';
                    break;
                case 2:
                    require_once 'views/report/report-time.php';
                    break;
                case 3:
                    require_once 'views/report/report-date.php';
                    break;
            }
            
        }else{
            require_once 'views/report/report-params.php';
        }
        
    }
}
