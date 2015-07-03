<div class="row">
    <div class="col-md-12">
        <h4><?php echo __('General'); ?></h4>
    </div>

    <?php echo $this->tt->getBeginHiddenFieldText('date'); ?>
    <div class="col-md-6">
        <div class="form-group">
            <label>
                <?php if (!$this->ID) { ?>
                    <?php printf(__('%1$s%2$s'), __('Opening date'), $this->tt->getMandatoryMark('date')); ?>
                <?php } else { ?>
                    <?php _e('Opening date'); ?>
                <?php } ?>
            </label>
            <?php if ($this->canupdate) { ?>
                <?php Html::showDateTimeField("date", array('value' => $this->class->fields["date"], 'timestep' => 1, 'maybeempty' => false)); ?>
            <?php } else { ?>
                <?php echo Html::convDateTime($this->class->fields["date"]); ?> 
            <?php } ?> 
        </div>


    </div>
    <?php echo $this->tt->getEndHiddenFieldValue('date'); ?>

    <div class="col-md-6">

        <?php echo $this->tt->getBeginHiddenFieldText('due_date'); ?>
        <div class="form-group">
            <label>
                <?php if (!$this->ID) { ?>
                    <?php printf(__('%1$s%2$s'), __('Due date'), $this->tt->getMandatoryMark('due_date')); ?>
                <?php } else { ?>
                    <?php _e('Due date'); ?>
                <?php } ?>
            </label>
            <?php echo $this->tt->getEndHiddenFieldText('due_date'); ?>

            <?php if ($this->ID) { ?>

                <?php if ($this->class->fields["slas_id"] > 0) { ?>

                    <?php echo Html::convDateTime($this->class->fields["due_date"]); ?>
                    <?php echo __('SLA'); ?>

                    <?php echo Dropdown::getDropdownName("glpi_slas", $this->class->fields["slas_id"]); ?>
                    <?php $commentsla = ""; ?>
                    <?php $slalevel = new SlaLevel(); ?>
                    <?php if ($slalevel->getFromDB($this->class->fields['slalevels_id'])) { ?>
                        <?php $commentsla .= '<span class="b spaced">' . sprintf(__('%1$s: %2$s'), __('Escalation level'), $slalevel->getName()) . '</span>'; ?>
                    <?php } ?>

                    <?php $nextaction = new SlaLevel_Ticket(); ?>
                    <?php if ($nextaction->getFromDBForTicket($this->class->fields["id"])) { ?>
                        <?php $commentsla .= '<span class="b spaced">' . sprintf(__('Next escalation: %s'), Html::convDateTime($nextaction->fields['date'])) . '</span>'; ?>
                        <?php if ($slalevel->getFromDB($nextaction->fields['slalevels_id'])) { ?>
                            <?php $commentsla .= '<span class="b spaced">' ?>
                            <?php sprintf(__('%1$s: %2$s'), __('Escalation level'), $slalevel->getName()) . '</span>'; ?>
                        <?php } ?>
                    <?php } ?>
                    <?php $slaoptions = array(); ?>
                    <?php if (Session::haveRight('config', READ)) { ?>
                        <?php $slaoptions['link'] = Toolbox::getItemTypeFormURL('SLA') . "?id=" . $this->class->fields["slas_id"]; ?>
                    <?php } ?>
                    <?php Html::showToolTip($commentsla, $slaoptions); ?>
                    <?php if ($this->canupdate) { ?>
                        <?php Html::showSimpleForm($this->class->getFormURL(), 'sla_delete', _x('button', 'Delete permanently'), array('id' => $this->class->getID())); ?>
                    <?php } ?>
                <?php } else { ?>
                    <?php echo $this->tt->getBeginHiddenFieldValue('due_date'); ?>
                    <?php if ($this->canupdate) { ?>
                        <?php Html::showDateTimeField("due_date", array('value' => $this->class->fields["due_date"], 'timestep' => 1, 'maybeempty' => true)); ?>
                    <?php } else { ?>
                        <?php echo Html::convDateTime($this->class->fields["due_date"]); ?>
                    <?php } ?>
                    <?php echo $this->tt->getEndHiddenFieldValue('due_date', $this); ?>
                    <?php
                    if ($this->canupdate) {

                        echo $this->tt->getBeginHiddenFieldText('slas_id');
                        echo "<span id='sla_action'>";
                        echo "<a class='btn btn-info btn-xs' " .
                        Html::addConfirmationOnAction(array(__('The assignment of a SLA to a ticket causes the recalculation of the due date.'),
                            __("Escalations defined in the SLA will be triggered under this new date.")), "cleanhide('sla_action');cleandisplay('sla_choice');") .
                        ">" . __('Assign a SLA') . '</a>';
                        echo "</span>";
                        echo "<div id='sla_choice' style='display:none'>";
                        echo "<span  class='b'>" . __('SLA') . "</span>&nbsp;";
                        Sla::dropdown(array('entity' => $this->class->fields["entities_id"],
                            'value' => $this->class->fields["slas_id"]));
                        echo "</div>";
                        echo $this->tt->getEndHiddenFieldText('slas_id');
                    }
                }
            } else { // New Ticket
                if ($this->class->fields["due_date"] == 'NULL') {
                    $this->class->fields["due_date"] = '';
                }
                echo $this->tt->getBeginHiddenFieldValue('due_date');
                Html::showDateTimeField("due_date", array('value' => $this->class->fields["due_date"],
                    'timestep' => 1,
                    'maybeempty' => false,
                    'canedit' => $this->canupdate));
                echo $this->tt->getEndHiddenFieldValue('due_date', $this);

                if ($this->canupdate) {
                    echo $this->tt->getBeginHiddenFieldText('slas_id');
                    printf(__('%1$s%2$s'), __('SLA'), $this->tt->getMandatoryMark('slas_id'));
                    echo $this->tt->getEndHiddenFieldText('slas_id') . "</td>";
                    echo $this->tt->getBeginHiddenFieldValue('slas_id');
                    Sla::dropdown(array('entity' => $this->class->fields["entities_id"],
                        'value' => $this->class->fields["slas_id"]));
                    echo $this->tt->getEndHiddenFieldValue('slas_id', $this);
                }
            }
            ?>
        </div>
    </div>

    <div class="col-md-12">
        <?php
        if ($this->ID) {

            echo __('By');

            if ($this->canupdate) {
                User::dropdown(array('name' => 'users_id_recipient',
                    'value' => $this->class->fields["users_id_recipient"],
                    'entity' => $this->class->fields["entities_id"],
                    'right' => 'all'));
            } else {
                echo getUserName($this->class->fields["users_id_recipient"], $showuserlink);
            }


            echo __('Last update');

            if ($this->class->fields['users_id_lastupdater'] > 0) {
                //TRANS: %1$s is the update date, %2$s is the last updater name
                printf(__('%1$s by %2$s'), Html::convDateTime($this->class->fields["date_mod"]), getUserName($this->class->fields["users_id_lastupdater"], $this->showuserlink));
            }
        }
        ?>

    </div>

    <div class="col-md-12">
        <?php
        if ($this->ID && (in_array($this->class->fields["status"], $this->class->getSolvedStatusArray()) || in_array($this->class->fields["status"], $this->class->getClosedStatusArray()))) {


            echo __('Resolution date');

            Html::showDateTimeField("solvedate", array('value' => $this->class->fields["solvedate"],
                'timestep' => 1,
                'maybeempty' => false,
                'canedit' => $this->canupdate));

            if (in_array($this->class->fields["status"], $this->class->getClosedStatusArray())) {
                echo __('Close date');

                Html::showDateTimeField("closedate", array('value' => $this->class->fields["closedate"],
                    'timestep' => 1,
                    'maybeempty' => false,
                    'canedit' => $this->canupdate));
            }
        }
        ?>


    </div>

    <div class="col-md-6">
        <div class="form-group">
            <label>
                <?php echo sprintf(__('%1$s%2$s'), __('Type'), $this->tt->getMandatoryMark('type')); ?>
            </label>

            <?php
            // Permit to set type when creating ticket without update right
            if ($this->canupdate || !$this->ID) {
                $opt = array('value' => $this->class->fields["type"]);
                /// Auto submit to load template
                if (!$this->ID) {
                    $opt['on_change'] = 'this.form.submit()';
                }
                $rand = Ticket::dropdownType('type', $opt);

                if ($this->ID) {
                    $params = array('type' => '__VALUE__',
                        'entity_restrict' => $this->class->fields['entities_id'],
                        'value' => $this->class->fields['itilcategories_id'],
                        'currenttype' => $this->class->fields['type']);

                    Ajax::updateItemOnSelectEvent("dropdown_type$rand", "show_category_by_type", $this->CFG_GLPI["root_doc"] . "/ajax/dropdownTicketCategories.php", $params);
                }
            } else {
                echo self::getTicketTypeName($this->class->fields["type"]);
            }
            ?>
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <label>
<?php echo sprintf(__('%1$s%2$s'), __('Category'), $this->tt->getMandatoryMark('itilcategories_id')); ?>
            </label>

<?php
// Permit to set category when creating ticket without update right
if ($this->canupdate || !$this->ID || $this->canupdate_descr) {

    $opt = array('value' => $this->class->fields["itilcategories_id"],
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
    if (($this->ID || $this->values['itilcategories_id']) && $this->tt->isMandatoryField("itilcategories_id") && ($this->class->fields["itilcategories_id"] > 0)) {
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
    </div>
</div>

<div class="row">

<?php echo $this->tt->getBeginHiddenFieldText('urgency'); ?>
    <div class="col-md-4">
        <div class="form-group">
            <label>
<?php printf(__('%1$s%2$s'), __('Urgency'), $this->tt->getMandatoryMark('urgency')); ?>
            </label>

                <?php
                if (($this->canupdate && $this->canpriority) || !$this->ID || $this->canupdate_descr) {
                    // Only change during creation OR when allowed to change priority OR when user is the creator
                    echo $this->tt->getBeginHiddenFieldValue('urgency');
                    $idurgency = Ticket::dropdownUrgency(array('value' => $this->class->fields["urgency"]));
                    echo $this->tt->getEndHiddenFieldValue('urgency');
                } else {
                    $idurgency = "value_urgency" . mt_rand();
                    echo "<input id='$idurgency' type='hidden' name='urgency' value='" .
                    $this->class->fields["urgency"] . "'>";
                    echo Ticket::getUrgencyName($this->class->fields["urgency"]);
                }
                ?>
        </div>
    </div>
            <?php echo $this->tt->getEndHiddenFieldText('urgency'); ?>

            <?php echo $this->tt->getBeginHiddenFieldText('impact'); ?>
    <div class="col-md-4">
        <div class="form-group">
            <label><?php printf(__('%1$s%2$s'), __('Impact'), $this->tt->getMandatoryMark('impact')); ?></label>
    <?php
    if ($this->canupdate) {
        $idimpact = Ticket::dropdownImpact(array('value' => $this->class->fields["impact"]));
    } else {
        $idimpact = "value_impact" . mt_rand();
        echo "<input id='$idimpact' type='hidden' name='impact' value='" . $this->class->fields["impact"] . "'>";
        echo Ticket::getImpactName($this->class->fields["impact"]);
    }
    ?>
        </div>
    </div>
            <?php echo $this->tt->getEndHiddenFieldValue('impact'); ?>

    <div class="col-md-4">
        <div class="form-group">
            <label><?php echo sprintf(__('%1$s%2$s'), __('Priority'), $this->tt->getMandatoryMark('priority')); ?></label>


<?php
$idajax = 'change_priority_' . mt_rand();

if ($this->canupdate && $this->canpriority && !$this->tt->isHiddenField('priority')) {
    $idpriority = Ticket::dropdownPriority(array('value' => $this->class->fields["priority"],
                'withmajor' => true));
    echo "<span id='$idajax' style='display:none'></span>";
} else {
    $idpriority = 0;
    echo $this->tt->getBeginHiddenFieldValue('priority');
    echo "<span id='$idajax'>" . Ticket::getPriorityName($this->class->fields["priority"]) . "</span>";
    echo $this->tt->getEndHiddenFieldValue('priority');
}

if ($this->canupdate || $this->canupdate_descr) {
    $params = array('urgency' => '__VALUE0__',
        'impact' => '__VALUE1__',
        'priority' => 'dropdown_priority' . $idpriority);
    Ajax::updateItemOnSelectEvent(array('dropdown_urgency' . $idurgency,
        'dropdown_impact' . $idimpact), $idajax, $this->CFG_GLPI["root_doc"] . "/ajax/priority.php", $params);
}
?>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <?php echo $this->tt->getBeginHiddenFieldText('name'); ?>


            <label><?php printf(__('%1$s%2$s'), __('Title'), $this->tt->getMandatoryMark('name')); ?></label>


<?php
echo $this->tt->getEndHiddenFieldText('name');

if (!$this->ID || $this->canupdate_descr) {
    echo $this->tt->getBeginHiddenFieldValue('name');
    echo "<input class='form-control' type='text' size='90' maxlength=250 name='name' " .
    " value=\"" . Html::cleanInputText($this->class->fields["name"]) . "\">";
    echo $this->tt->getEndHiddenFieldValue('name', $this);
} else {
    if (empty($this->class->fields["name"])) {
        _e('Without title');
    } else {
        echo $this->class->fields["name"];
    }
}
?>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="form-group">

            <?php echo $this->tt->getBeginHiddenFieldText('content'); ?>

            <label><?php printf(__('%1$s%2$s'), __('Description'), $this->tt->getMandatoryMark('content')); ?></label>

<?php echo $this->tt->getEndHiddenFieldText('content'); ?>

<?php if (!$this->ID || $this->canupdate_descr) : ?>

                <?php
                echo $this->tt->getBeginHiddenFieldValue('content');
                $rand = mt_rand();
                $rand_text = mt_rand();
                $cols = 90;
                $rows = 6;
                $content_id = "content$rand";
                if ($this->CFG_GLPI["use_rich_text"]) {
                    $this->class->fields["content"] = $this->class->setRichTextContent($content_id, $this->class->fields["content"], $rand);
                    $cols = 100;
                    $rows = 10;
                } else {
                    $this->class->fields["content"] = $this->class->setSimpleTextContent($this->class->fields["content"]);
                }

                echo "<div id='content$rand_text'>";
                echo "<textarea class='form-control'  id='$content_id' name='content' cols='$cols' rows='$rows'>" .
                $this->class->fields["content"] . "</textarea></div>";
                echo $this->tt->getEndHiddenFieldValue('content');
                ?>
            <?php else: ?>
                <?php
                $content = Toolbox::unclean_cross_side_scripting_deep(Html::entity_decode_deep($this->class->fields['content']));
                echo nl2br(Html::Clean($content));
                ?>
            <?php endif; ?>

        </div>
    </div>
</div>
<div class="row">

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
    Ticket::dropdownStatus(array('value' => $this->class->fields["status"],
        'showtype' => 'allowed'));
    TicketValidation::alertValidation($this->class, 'status');
} else {
    echo Ticket::getStatus($this->class->fields["status"]);
    if (in_array($this->class->fields["status"], $this->class->getClosedStatusArray()) && $this->class->isAllowedStatus($this->class->fields['status'], Ticket::INCOMING)) {
        echo "<a class='btn btn-info btn-xs' href='" . $this->class->getLinkURL() . "&amp;forcetab=TicketFollowup$1&amp;_openfollowup=1'>" . __('Reopen') . "</a>";
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
            if (($this->values['type'] == Ticket::INCIDENT_TYPE) && Session::haveRight('ticketvalidation', TicketValidation::CREATEINCIDENT)) {
                $validation_right = 'validate_incident';
            }
            if (($this->values['type'] == Ticket::DEMAND_TYPE) && Session::haveRight('ticketvalidation', TicketValidation::CREATEREQUEST)) {
                $validation_right = 'validate_request';
            }

            if (!empty($validation_right)) {
                echo "<input type='hidden' name='_add_validation' value='" .
                $this->values['_add_validation'] . "'>";

                $params = array('name' => "users_id_validate",
                    'entity' => $this->class->fields['entities_id'],
                    'right' => $validation_right,
                    'users_id_validate' => $this->values['users_id_validate']);
                TicketValidation::dropdownValidator($params);
            }
            echo $this->tt->getEndHiddenFieldValue('_add_validation');
            if ($this->tt->isPredefinedField('global_validation')) {
                echo "<input type='hidden' name='global_validation' value='" .
                $this->tt->predefined['global_validation'] . "'>";
            }
        } else {
            echo $this->tt->getBeginHiddenFieldValue('global_validation');

            if ($this->canupdate) {
                TicketValidation::dropdownStatus('global_validation', array('global' => true,
                    'value' => $this->class->fields['global_validation']));
            } else {
                echo TicketValidation::getStatus($this->class->fields['global_validation']);
            }
            echo $this->tt->getEndHiddenFieldValue('global_validation');
        }
        ?>
    </div>

    <div class="col-md-6">
        <?php
        echo $this->tt->getBeginHiddenFieldText('locations_id');
        printf(__('%1$s%2$s'), __('Location'), $this->tt->getMandatoryMark('locations_id'));
        echo $this->tt->getEndHiddenFieldText('locations_id');

        echo $this->tt->getBeginHiddenFieldValue('locations_id');
        if ($this->canupdate) {
            Location::dropdown(array('value' => $this->class->fields['locations_id'],
                'entity' => $this->class->fields['entities_id']));
        } else {
            echo Dropdown::getDropdownName('glpi_locations', $this->class->fields["locations_id"]);
        }
        echo $this->tt->getEndHiddenFieldValue('locations_id');
        ?>
    </div>
</div>

<div class="row">
    <div class="col-md-6">

        <?php
        echo $this->tt->getBeginHiddenFieldText('itemtype');
        printf(__('%1$s%2$s'), _n('Associated element', 'Associated elements', Session::getPluralNumber()), $this->tt->getMandatoryMark('itemtype'));
        if ($this->ID && $this->canupdate) {
            echo "<a  href='" . $this->class->getFormURL() . "?id=" . $this->ID . "&amp;forcetab=Item_Ticket$1'><img title='" . __s('Update') . "' alt='" . __s('Update') . "'
                      class='pointer' src='" . $this->CFG_GLPI["root_doc"] . "/pics/showselect.png'></a>";
        }
        echo $this->tt->getEndHiddenFieldText('itemtype');

        if (!$this->ID) {
            echo $this->tt->getBeginHiddenFieldValue('itemtype');

            // Select hardware on creation or if have update right
            if ($this->canupdate || $this->canupdate_descr) {

                $dev_user_id = $this->values['_users_id_requester'];
                $dev_itemtype = $this->values["itemtype"];
                $dev_items_id = $this->values["items_id"];

                if ($dev_user_id > 0) {
                    Item_Ticket::dropdownMyDevices($dev_user_id, $this->class->fields["entities_id"], $dev_itemtype, $dev_items_id);
                }
                Item_Ticket::dropdownAllDevices("itemtype", $dev_itemtype, $dev_items_id, 1, $dev_user_id, $this->class->fields["entities_id"]);

                echo "<span id='item_ticket_selection_information'></span>";
            }
            echo $this->tt->getEndHiddenFieldValue('itemtype');
        } else {
            // display associated elements
            $item_tickets = getAllDatasFromTable(getTableForItemType('Item_Ticket'), "`tickets_id`='" . $this->ID . "'");
            $i = 0;
            foreach ($item_tickets as $itdata) {
                if ($i >= 5) {
                    echo "<i><a href='" . $this->getFormURL() . "?id=" . $this->ID . "&amp;forcetab=Item_Ticket$1'>"
                    . __('Display all items') . " (" . count($item_tickets) . ")</a></i>";
                    break;
                }
                $item = new $itdata['itemtype'];
                $item->getFromDB($itdata['items_id']);
                echo $item->getTypeName(1) . ": " . $item->getLink(array('comments' => true)) . "<br/>";
                $i++;
            }
        }
        ?>
    </div>
    <div class="col-md-6">

        <?php
        if (!$this->ID && Session::haveRight('followup', TicketFollowup::ADDALLTICKET)) {
            echo $this->tt->getBeginHiddenFieldText('actiontime');
            printf(__('%1$s%2$s'), __('Total duration'), $this->tt->getMandatoryMark('actiontime'));
            echo $this->tt->getEndHiddenFieldText('actiontime');

            echo $this->tt->getBeginHiddenFieldValue('actiontime');
            Dropdown::showTimeStamp('actiontime', array('value' => $this->values['actiontime'],
                'addfirstminutes' => true));
            echo $this->tt->getEndHiddenFieldValue('actiontime', $this);
        }
        ?>
    </div>
</div>

