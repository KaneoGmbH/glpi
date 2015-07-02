<?php

    include ("../../../inc/includes.php");

    Session::checkRight("software", READ);

    Html::header(Software::getTypeName(Session::getPluralNumber()), $_SERVER['PHP_SELF'], "helpfdesk", "ticket");

    $DBread = DBConnection::getReadConnection();

    if(isset($_GET['startDate'])){
        $startDateObj = new DateTime($_GET['startDate']);
    }else{
        $startDateObj = new DateTime("first day of last month");
    }

    if(isset($_GET['endDate'])){
        $endDateObj = new DateTime($_GET['endDate']);
    }else{
        $endDateObj = new DateTime("today");
    }

    $startDate = $startDateObj->format('Y-m-d 00:00:00');
    $endDate = $endDateObj->format('Y-m-d 23:59:59');


    $holderTPL = new Template();
    $holderTPL->assign('startDate',$startDateObj);
    $holderTPL->assign('endDate',$endDateObj);
    $holderTPL->display('timereport-holder.tpl.php');


    /**
    * Get all entities
    */
    $resEntities = $DBread->query("SELECT * FROM glpi_entities WHERE level > 1");

    while($entities = $resEntities->fetch_assoc()){

        $entity_id = $entities['id'];
        /* @var $resTickets mysqli_result */

        $template = new Template();

        $template->assign('customer_id',$entities['id']);
        $template->assign('customer',$entities['name']);


        $resSolvedTickets = $DBread->query("SELECT * FROM glpi_tickets WHERE type = 2 AND status IN(5,6) AND entities_id = '".$entity_id."' AND ((closedate BETWEEN '".$startDate."' AND '".$endDate."') OR (solvedate BETWEEN '".$startDate."' AND '".$endDate."'))");

        $solvedTickets = parseRecords($resSolvedTickets);
        $template->assign('solvedTickets',$solvedTickets);

        $resOpenTickets = $DBread->query("SELECT * FROM glpi_tickets WHERE type = 2  AND status IN(1,2,3,4) AND entities_id = '".$entity_id."' AND (date BETWEEN '".$startDate."' AND '".$endDate."') ");
        $openTickets = parseRecords($resOpenTickets);
        $template->assign('openTickets',$openTickets);

        if($solvedTickets || $openTickets){
            $template->display('timereport.tpl.php');
        }

    }


    Html::footer();
    
    
    function parseRecords($resTickets){
        $DBread = DBConnection::getReadConnection();

        $aCollection = array();

        if($resTickets->num_rows > 0){
            while($ticket = $resTickets->fetch_assoc()){
                $ticket['date'] = date('d.m.Y H:i',strtotime($ticket['date']));
                $ticket['closedate']= date('d.m.Y H:i',strtotime($ticket['closedate']));
                $ticket['solvedate']= date('d.m.Y H:i',strtotime($ticket['solvedate']));
                $ticket['solve_delay_stat'] = $ticket['solve_delay_stat'] / (60 * 60 ); 

                $resTime = $DBread->query("SELECT *,glpi_tickettasks.id as task_id,date as task_date, actiontime as task_actiontime FROM glpi_tickettasks JOIN glpi_users ON glpi_users.id = glpi_tickettasks.users_id  WHERE is_private = 0 AND actiontime > 0 AND name like '%kaneo.corp' AND tickets_id = ".$ticket['id']);

                while($timeRow = $resTime->fetch_assoc()){
                    $timeRow['task_actiontime'] = $timeRow['task_actiontime'] / ( 60 * 60 );
                    $ticket['time-records'][] = $timeRow;
                }
                $aCollection[] = $ticket;
            }
        }else{
            $aCollection = false;
        }
        return $aCollection;     
    }
    
    
    function export($data){
//        ob_start();
//
//        $fh = fopen('php://output', 'w');
//
//        $headings = array(
//            'ticket_id',
//            'name',
//            'date',
//            'closedate',
//            'solvedate',
//            'solve_delay_stat',
//            'task_id',
//            'task_date',
//            'task_actiontime'
//        );
//        fputcsv($fh, $headings,';');
//
//        foreach($data as $csvRow){
//            fputcsv($fh, $csvRow,';');
//        }
//
//        // Get the contents of the output buffer
//        $string = ob_get_clean();
//
//        //$filename = 'timereport_' . $startDate .'-' . $endDate;
//
//        // Output CSV-specific headers
//        header("Pragma: public");
//        header("Expires: 0");
//        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
//        header("Cache-Control: private",false);
//        header("Content-Type: application/octet-stream");
//        header("Content-Disposition: attachment; filename=\"$filename.csv\";" );
//        header("Content-Transfer-Encoding: binary");
//
//        exit($string);
  
    }