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


        $condition = "type = 2 AND status IN(5,6) AND entities_id = '".$entity_id."' AND ((closedate BETWEEN '".$startDate."' AND '".$endDate."') OR (solvedate BETWEEN '".$startDate."' AND '".$endDate."'))";
        $solvedTickets =  new Ticket();
        $solvedTickets = $solvedTickets->find($condition);
        $objSolvedTickets = array();
        if(count($solvedTickets)){
            foreach($solvedTickets as $ticket){
                $objTicket = new Ticket();
                $objTicket->fields = $ticket;
                $objSolvedTickets[] = $objTicket;
            }
            $template->assign('solvedTickets',$objSolvedTickets);
        }else{
            $template->assign('solvedTickets',false);
        }

        $condition = "type = 2  AND status IN(1,2,3,4) AND entities_id = '".$entity_id."' AND (date BETWEEN '".$startDate."' AND '".$endDate."')";
        $openTickets =  new Ticket();
        $openTickets = $openTickets->find($condition);
        $objOpenTickets = array();

        if(count($openTickets)){
            foreach($openTickets as $ticket){
                $objTicket = new Ticket();
                $objTicket->fields = $ticket;
                $objOpenTickets[] = $objTicket;
            }
            $template->assign('openTickets',$objOpenTickets);
        }else{
            $template->assign('openTickets',false);
        }

        if($solvedTickets || $openTickets){
            $template->display('timereport.tpl.php');
        }
    }

    Html::footer();