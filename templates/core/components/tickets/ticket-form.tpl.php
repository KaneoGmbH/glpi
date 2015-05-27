<div class="row">
    <div class="col-md-12">
             <h4><?php echo __('General'); ?></h4>
    </div>
<div class="col-md-6">
   
    <?php
       echo $this->tt->getBeginHiddenFieldText('date');
      if (!$this->ID) {
         printf(__('%1$s%2$s'), __('Opening date'), $this->tt->getMandatoryMark('date'));
      } else {
         _e('Opening date');
      }
      echo $this->tt->getEndHiddenFieldText('date');

      
      echo $this->tt->getBeginHiddenFieldValue('date');

      if ($this->canupdate) {
         Html::showDateTimeField("date", array('value'      => $this->class->fields["date"],
                                               'timestep'   => 1,
                                               'maybeempty' => false));
      } else {
         echo Html::convDateTime($this->class->fields["date"]);
      }
      echo $this->tt->getEndHiddenFieldValue('date'); 
      ?>
</div>

<div class="col-md-6">
    

<?php 

      // SLA
      echo $this->tt->getBeginHiddenFieldText('due_date');

      if (!$this->ID) {
         printf(__('%1$s%2$s'), __('Due date'), $this->tt->getMandatoryMark('due_date'));
      } else {
         _e('Due date');
      }
      echo $this->tt->getEndHiddenFieldText('due_date');
  
    if ($this->ID) {
       
         if ($this->class->fields["slas_id"] > 0) {
  
            echo Html::convDateTime($this->class->fields["due_date"]);
            echo __('SLA');

            echo Dropdown::getDropdownName("glpi_slas", $this->class->fields["slas_id"]);
            $commentsla = "";
            $slalevel   = new SlaLevel();
            if ($slalevel->getFromDB($this->class->fields['slalevels_id'])) {
               $commentsla .= '<span class="b spaced">'.
                                sprintf(__('%1$s: %2$s'), __('Escalation level'),
                                        $slalevel->getName()).'</span>';
            }

            $nextaction = new SlaLevel_Ticket();
            if ($nextaction->getFromDBForTicket($this->class->fields["id"])) {
               $commentsla .= '<span class="b spaced">'.
                                sprintf(__('Next escalation: %s'),
                                        Html::convDateTime($nextaction->fields['date'])).
                                           '</span>';
               if ($slalevel->getFromDB($nextaction->fields['slalevels_id'])) {
                  $commentsla .= '<span class="b spaced">'.
                                   sprintf(__('%1$s: %2$s'), __('Escalation level'),
                                           $slalevel->getName()).'</span>';
               }
            }
            $slaoptions = array();
            if (Session::haveRight('config', READ)) {
               $slaoptions['link'] = Toolbox::getItemTypeFormURL('SLA')."?id=".$this->class->fields["slas_id"];
            }
            Html::showToolTip($commentsla,$slaoptions);
            if ($this->canupdate) {
               Html::showSimpleForm($this->class->getFormURL(), 'sla_delete',_x('button', 'Delete permanently'),array('id' => $this->class->getID()));
            }

         } else {
            echo $this->tt->getBeginHiddenFieldValue('due_date');
            if ($this->canupdate) {
               Html::showDateTimeField("due_date", array('value'      => $this->class->fields["due_date"],
                                                         'timestep'   => 1,
                                                         'maybeempty' => true));
            } else {
               echo Html::convDateTime($this->class->fields["due_date"]);
            }
            echo $this->tt->getEndHiddenFieldValue('due_date',$this);
      
            if ($this->canupdate) {
        
               echo $this->tt->getBeginHiddenFieldText('slas_id');
               echo "<span id='sla_action'>";
               echo "<a class='btn btn-info btn-xs' ".
                      Html::addConfirmationOnAction(array(__('The assignment of a SLA to a ticket causes the recalculation of the due date.'),
                       __("Escalations defined in the SLA will be triggered under this new date.")),
                                                    "cleanhide('sla_action');cleandisplay('sla_choice');").
                     ">".__('Assign a SLA').'</a>';
               echo "</span>";
               echo "<div id='sla_choice' style='display:none'>";
               echo "<span  class='b'>".__('SLA')."</span>&nbsp;";
               Sla::dropdown(array('entity' => $this->class->fields["entities_id"],
                                   'value'  => $this->class->fields["slas_id"]));
               echo "</div>";
               echo $this->tt->getEndHiddenFieldText('slas_id');
            }
         }

      } else { // New Ticket

         if ($this->class->fields["due_date"] == 'NULL') {
            $this->class->fields["due_date"]='';
         }
         echo $this->tt->getBeginHiddenFieldValue('due_date');
         Html::showDateTimeField("due_date", array('value'      => $this->class->fields["due_date"],
                                                   'timestep'   => 1,
                                                   'maybeempty' => false,
                                                   'canedit'    => $this->canupdate));
         echo $this->tt->getEndHiddenFieldValue('due_date',$this);

         if ($this->canupdate) {
            echo $this->tt->getBeginHiddenFieldText('slas_id');
            printf(__('%1$s%2$s'), __('SLA'), $this->tt->getMandatoryMark('slas_id'));
            echo $this->tt->getEndHiddenFieldText('slas_id')."</td>";
            echo $this->tt->getBeginHiddenFieldValue('slas_id');
            Sla::dropdown(array('entity' => $this->class->fields["entities_id"],
                                'value'  => $this->class->fields["slas_id"]));
            echo $this->tt->getEndHiddenFieldValue('slas_id',$this);

         }

      }
      ?>
</div>


<div class="col-md-6">
    <?php
       if ($this->ID) {
 
         echo __('By');

         if ($this->canupdate) {
            User::dropdown(array('name'   => 'users_id_recipient',
                                 'value'  => $this->class->fields["users_id_recipient"],
                                 'entity' => $this->class->fields["entities_id"],
                                 'right'  => 'all'));
         } else {
            echo getUserName($this->class->fields["users_id_recipient"], $showuserlink);
         }


         echo __('Last update');
 
         if ($this->class->fields['users_id_lastupdater'] > 0) {
            //TRANS: %1$s is the update date, %2$s is the last updater name
            printf(__('%1$s by %2$s'), Html::convDateTime($this->class->fields["date_mod"]),
                   getUserName($this->class->fields["users_id_lastupdater"], $this->showuserlink));
         }

      }
?>
</div>
    <div class="col-md-6">
    <?php
          if ($this->ID && (in_array($this->class->fields["status"], $this->class->getSolvedStatusArray())
              || in_array($this->class->fields["status"], $this->class->getClosedStatusArray()))) {


         echo __('Resolution date');

         Html::showDateTimeField("solvedate", array('value'      => $this->class->fields["solvedate"],
                                                    'timestep'   => 1,
                                                    'maybeempty' => false,
                                                    'canedit'    => $this->canupdate));
     
         if (in_array($this->class->fields["status"], $this->class->getClosedStatusArray())) {
            echo __('Close date');

            Html::showDateTimeField("closedate", array('value'      => $this->class->fields["closedate"],
                                                       'timestep'   => 1,
                                                       'maybeempty' => false,
                                                       'canedit'    => $this->canupdate));

         }
 
      }
      ?>
    
    </div>
    
    <div class="clearfix"></div>
    
    <div class="col-md-6">
    <?php
    
      echo sprintf(__('%1$s%2$s'), __('Type'),$this->tt->getMandatoryMark('type'));

      // Permit to set type when creating ticket without update right
      if ($this->canupdate || !$this->ID) {
         $opt = array('value' => $this->class->fields["type"]);
         /// Auto submit to load template
         if (!$this->ID) {
            $opt['on_change'] = 'this.form.submit()';
         }
         $rand = Ticket::dropdownType('type', $opt);

         if ($this->ID) {
            $params = array('type'            => '__VALUE__',
                            'entity_restrict' => $this->class->fields['entities_id'],
                            'value'           => $this->class->fields['itilcategories_id'],
                            'currenttype'     => $this->class->fields['type']);

            Ajax::updateItemOnSelectEvent("dropdown_type$rand", "show_category_by_type",
                                          $this->CFG_GLPI["root_doc"]."/ajax/dropdownTicketCategories.php",
                                          $params);
         }
      } else {
         echo self::getTicketTypeName($this->class->fields["type"]);
      }

      ?>
    </div>
    
      <div class="col-md-6">
    <?php
    echo sprintf(__('%1$s%2$s'), __('Category'),$this->tt->getMandatoryMark('itilcategories_id'));
   
      // Permit to set category when creating ticket without update right
      if ($this->canupdate
          || !$this->ID
          || $this->canupdate_descr) {

         $opt = array('value'  => $this->class->fields["itilcategories_id"],
                      'entity' => $this->class->fields["entities_id"]);
         if ($_SESSION["glpiactiveprofile"]["interface"] == "helpdesk") {
            $opt['condition'] = "`is_helpdeskvisible`='1' AND ";
         } else {
            $opt['condition'] = '';
         }
         /// Auto submit to load template
         if (!$this->ID) {
            $opt['on_change'] = 'this.form.submit()';
         }
         /// if category mandatory, no empty choice
         /// no empty choice is default value set on ticket creation, else yes
         if (($this->ID || $this->values['itilcategories_id'])
             && $this->tt->isMandatoryField("itilcategories_id")
             && ($this->class->fields["itilcategories_id"] > 0)) {
            $opt['display_emptychoice'] = false;
         }

         switch ($this->class->fields["type"]) {
            case Ticket::INCIDENT_TYPE :
               $opt['condition'] .= "`is_incident`='1'";
               break;

            case Ticket::DEMAND_TYPE :
               $opt['condition'] .= "`is_request`='1'";
               break;

            default :
               break;
         }
         echo "<span id='show_category_by_type'>";
         ITILCategory::dropdown($opt);
         echo "</span>";
      } else {
         echo Dropdown::getDropdownName("glpi_itilcategories", $this->class->fields["itilcategories_id"]);
      }
      ?>
      </div>
    

    <div class="col-md-12">
        <h4><?php echo __('Actor'); ?></h4>
      <?php echo $this->class->showActorsPartForm($this->ID, $this->values); ?>
    </div>
 
    <div class="col-md-6">
        <?php 
        echo $this->tt->getBeginHiddenFieldText('status');
      printf(__('%1$s%2$s'), __('Status'), $this->tt->getMandatoryMark('status'));
      echo $this->tt->getEndHiddenFieldText('status');
      

      echo $this->tt->getBeginHiddenFieldValue('status');
      if ($this->canstatus) {
         self::dropdownStatus(array('value'     => $this->class->fields["status"],
                                    'showtype'  => 'allowed'));
         TicketValidation::alertValidation($this->class, 'status');
      } else {
         echo self::getStatus($this->class->fields["status"]);
         if (in_array($this->class->fields["status"], $this->class->getClosedStatusArray())
             && $this->class->isAllowedStatus($this->class->fields['status'], Ticket::INCOMING)) {
            echo "<a class='btn btn-info btn-xs' href='".$this->class->getLinkURL()."&amp;forcetab=TicketFollowup$1&amp;_openfollowup=1'>". __('Reopen')."</a>";
         }
      }
      echo $this->tt->getEndHiddenFieldValue('status');
      ?>
    </div>
      <div class="col-md-6">
    <?php
          echo $this->tt->getBeginHiddenFieldText('requesttypes_id');
      printf(__('%1$s%2$s'), __('Request source'), $this->tt->getMandatoryMark('requesttypes_id'));
      echo $this->tt->getEndHiddenFieldText('requesttypes_id');

      echo $this->tt->getBeginHiddenFieldValue('requesttypes_id');
      if ($this->canupdate) {
         RequestType::dropdown(array('value' => $this->class->fields["requesttypes_id"]));
      } else {
         echo Dropdown::getDropdownName('glpi_requesttypes', $this->class->fields["requesttypes_id"]);
      }
      echo $this->tt->getEndHiddenFieldValue('requesttypes_id');

      ?>
      </div>
      <div class="col-md-6">
    <?php
     echo $this->tt->getBeginHiddenFieldText('urgency');
      printf(__('%1$s%2$s'), __('Urgency'), $this->tt->getMandatoryMark('urgency'));
      echo $this->tt->getEndHiddenFieldText('urgency');


      if (($this->canupdate && $this->canpriority)
          || !$this->ID
          || $this->canupdate_descr) {
         // Only change during creation OR when allowed to change priority OR when user is the creator
         echo $this->tt->getBeginHiddenFieldValue('urgency');
         $idurgency = Ticket::dropdownUrgency(array('value' => $this->class->fields["urgency"]));
         echo $this->tt->getEndHiddenFieldValue('urgency');

      } else {
         $idurgency = "value_urgency".mt_rand();
         echo "<input id='$idurgency' type='hidden' name='urgency' value='".
                $this->class->fields["urgency"]."'>";
         echo Ticket::getUrgencyName($this->class->fields["urgency"]);
      }

    ?>
      </div>
          <div class="col-md-6">
    <?php 

      if (!$this->ID) {
         echo $this->tt->getBeginHiddenFieldText('_add_validation');
         printf(__('%1$s%2$s'), __('Approval request'), $this->tt->getMandatoryMark('_add_validation'));
         echo $this->tt->getEndHiddenFieldText('_add_validation');
      } else {
         echo $this->tt->getBeginHiddenFieldText('global_validation');
         _e('Approval');
         echo $this->tt->getEndHiddenFieldText('global_validation');
      }

      if (!$this->ID) {
         echo $this->tt->getBeginHiddenFieldValue('_add_validation');
         $validation_right = '';
         if (($this->values['type'] == Ticket::INCIDENT_TYPE)
             && Session::haveRight('ticketvalidation', TicketValidation::CREATEINCIDENT)) {
            $validation_right = 'validate_incident';
         }
         if (($this->values['type'] == Ticket::DEMAND_TYPE)
             && Session::haveRight('ticketvalidation', TicketValidation::CREATEREQUEST)) {
            $validation_right = 'validate_request';
         }

         if (!empty($validation_right)) {
            echo "<input type='hidden' name='_add_validation' value='".
                   $this->values['_add_validation']."'>";

            $params = array('name'               => "users_id_validate",
                            'entity'             => $this->class->fields['entities_id'],
                            'right'              => $validation_right,
                            'users_id_validate'  => $this->values['users_id_validate']);
            TicketValidation::dropdownValidator($params);
         }
         echo $this->tt->getEndHiddenFieldValue('_add_validation');
         if ($this->tt->isPredefinedField('global_validation')) {
            echo "<input type='hidden' name='global_validation' value='".
                   $this->tt->predefined['global_validation']."'>";
         }
      } else {
         echo $this->tt->getBeginHiddenFieldValue('global_validation');

         if ($this->canupdate) {
            TicketValidation::dropdownStatus('global_validation',
                                             array('global' => true,
                                                   'value'  => $this->class->fields['global_validation']));
         } else {
            echo TicketValidation::getStatus($this->class->fields['global_validation']);
         }
         echo $this->tt->getEndHiddenFieldValue('global_validation');

      }


    
    ?>
          </div>
          <div class="col-md-6">
    <?php
    
    
      echo $this->tt->getBeginHiddenFieldText('impact');
      printf(__('%1$s%2$s'), __('Impact'), $this->tt->getMandatoryMark('impact'));
      echo $this->tt->getEndHiddenFieldText('impact');
 
      echo $this->tt->getBeginHiddenFieldValue('impact');

      if ($this->canupdate) {
         $idimpact = Ticket::dropdownImpact(array('value' => $this->class->fields["impact"]));
      } else {
         $idimpact = "value_impact".mt_rand();
         echo "<input id='$idimpact' type='hidden' name='impact' value='".$this->class->fields["impact"]."'>";
         echo Ticket::getImpactName($this->class->fields["impact"]);
      }
      echo $this->tt->getEndHiddenFieldValue('impact');
  

      
      ?>
              
          </div>
    
          <div class="col-md-6">
    <?php
    echo $this->tt->getBeginHiddenFieldText('locations_id');
      printf(__('%1$s%2$s'), __('Location'), $this->tt->getMandatoryMark('locations_id'));
      echo $this->tt->getEndHiddenFieldText('locations_id');

      echo $this->tt->getBeginHiddenFieldValue('locations_id');
      if ($this->canupdate) {
         Location::dropdown(array('value'  => $this->class->fields['locations_id'],
                                  'entity' => $this->class->fields['entities_id']));
      } else {
         echo Dropdown::getDropdownName('glpi_locations', $this->class->fields["locations_id"]);
      }
      echo $this->tt->getEndHiddenFieldValue('locations_id');


      ?>
</div>
       <div class="col-md-6">
    <?php
    
    echo sprintf(__('%1$s%2$s'), __('Priority'), $this->tt->getMandatoryMark('priority'));

      $idajax = 'change_priority_' . mt_rand();

      if ($this->canupdate
          && $this->canpriority
          && !$this->tt->isHiddenField('priority')) {
         $idpriority = Ticket::dropdownPriority(array('value'     => $this->class->fields["priority"],
                                                      'withmajor' => true));
         echo "<span id='$idajax' style='display:none'></span>";

      } else {
         $idpriority = 0;
         echo $this->tt->getBeginHiddenFieldValue('priority');
         echo "<span id='$idajax'>".Ticket::getPriorityName($this->class->fields["priority"])."</span>";
         echo $this->tt->getEndHiddenFieldValue('priority');
      }

      if ($this->canupdate
          || $this->canupdate_descr) {
         $params = array('urgency'  => '__VALUE0__',
                         'impact'   => '__VALUE1__',
                         'priority' => 'dropdown_priority'.$idpriority);
         Ajax::updateItemOnSelectEvent(array('dropdown_urgency'.$idurgency,
                                             'dropdown_impact'.$idimpact),
                                       $idajax,
                                       $this->CFG_GLPI["root_doc"]."/ajax/priority.php", $params);
      }
 

      
      ?>
    </div>
</div>