<?php

class PluginReportReports extends CommonDBTM {

    public $startDate;
    public $endDate;
    public $entity;

    static function getMenuContent(){
        if(Session::haveRight("statistic", READ)){
          $menu['title']                              = __('Timereports');
          $menu['page']                               = '/plugins/report/front/timereport.php';
          return $menu;
        }
    }

    public function getTicktsToBeInvoived(){


      $condition = "type = 2 AND is_deleted != 1 AND status IN(6) AND entities_id = '".$this->entity."' AND ((closedate BETWEEN '".$this->startDate->format("Y-m-d 00:00:00")."' AND '".$this->endDate->format("Y-m-d 23:59:59")."')) ORDER BY date";

      $items = $this->queryTickets($condition);

      return array(
        'items' => $items,
        'headline' => 'Weiterentwicklung: Abgeschlossene Tickets',
        'description' => 'Diese Tickets werden zum nächsten Zeitpunkt abgerechnet.  Für den gewählten Zeitraum sind '.count($items->tickets).' Tickets mit einem Aufwand von '.$items->actiontime.' Stunden vorhanden.'
      );

      return false;
    }

    public function getTicktsMayBeInvoiced(){
      // $condition = "type = 2 AND status IN(1,2,3,4,5) AND entities_id = '".$this->entity."' AND ( (date BETWEEN '".$this->startDate->format("Y-m-d 00:00:00")."' AND '".$this->endDate->format("Y-m-d 23:59:59")."') OR (solvedate BETWEEN '".$this->startDate->format("Y-m-d 00:00:00")."' AND '".$this->endDate->format("Y-m-d 23:59:59")."'))";
      $condition = "type = 2 AND is_deleted != 1 AND status IN(1,2,3,4,5) AND entities_id = '".$this->entity."' ORDER BY status";

      $items = $this->queryTickets($condition);

        return array(
          'items' => $items,
          'headline' => 'Weiterentwicklung: Offene Tickets',
          'description' => 'Diese Tickets werden abgerechnet sobald diese durch den Kunden freigegeben und von kaneo abgeschlossen wurden.'
        );

      return false;
    }

    public function getTicketNotInvoiced(){
      $condition = "type = 1 AND is_deleted != 1 AND entities_id = '".$this->entity."' AND (date BETWEEN '".$this->startDate->format("Y-m-d 00:00:00")."' AND '".$this->endDate->format("Y-m-d 23:59:59")."')  ORDER BY status";

      $items = $this->queryTickets($condition);

        return array(
          'items' => $items,
          'headline' => 'Tickets innerhalb des SLA',
          'description' => 'Diese Tickets sind innerhalb des SLA. Für den gewählten Zeitraum sind '.count($items->tickets).' Tickets mit einem Aufwand von '.$items->actiontime.' Stunden vorhanden.'
        );

      return false;
    }

    protected function queryTickets($condition){
      global $DB;
      // $kaneo_users = "SELECT id from glpi_users where user_dn like '%DC=kaneo%'";
      // $kaneo_users = $DB->query($kaneo_users);
      // while($row = $DB->fetch_assoc($kaneo_users)){
      //     $Akaneo_users[] = $row['id'];
      // }

      $tickets = new Ticket();
      $tickets = $tickets->find($condition);
      $arrObjTickets = array();
      if(count($tickets)){
          foreach($tickets as $ticket){
            /**
            * check if a member of kaneo is assigned to this ticket
            */
              //$technician = 'SELECT id from glpi_tickets_users where type = 2 and tickets_id = '.$ticket['id'].' AND users_id in ('.implode($Akaneo_users,',').')';
              //$technician = $DB->query($technician);
              //if($technician->num_rows >= 1) {


                $objTicket = new Ticket();
                $objTicket->fields = $ticket;
                $objTicket->fields['costs'] = TicketCost::getCostsSummary('ticketcosts',$ticket['id']);

                $arrObjTickets[] = $objTicket;
            //  }
          }

          $total_query = $DB->query('SELECT sum(actiontime) as actiontime FROM glpi_tickets WHERE '.$condition);
          $total = $DB->fetch_assoc($total_query);
          $total = round($total['actiontime'] / (60 * 60),2);

          $return = new stdClass();
          $return->tickets = $arrObjTickets;
          $return->actiontime = $total;

          return $return;
      }else{
          return false;
      }
    }
}
