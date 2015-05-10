<?php
/*
 * @version $Id$
 -------------------------------------------------------------------------
 GLPI - Gestionnaire Libre de Parc Informatique
 Copyright (C) 2003-2014 by the INDEPNET Development Team.

 http://indepnet.net/   http://glpi-project.org
 -------------------------------------------------------------------------

 LICENSE

 This file is part of GLPI.

 GLPI is free software; you can redistribute it and/or modify
 it under the terms of the GNU General Public License as published by
 the Free Software Foundation; either version 2 of the License, or
 (at your option) any later version.

 GLPI is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 GNU General Public License for more details.

 You should have received a copy of the GNU General Public License
 along with GLPI. If not, see <http://www.gnu.org/licenses/>.
 --------------------------------------------------------------------------
 */

/** @file
* @brief
*/

include ('../inc/includes.php');

// Change profile system
if (isset($_REQUEST['newprofile'])) {
   if (isset($_SESSION["glpiprofiles"][$_REQUEST['newprofile']])) {
      Session::changeProfile($_REQUEST['newprofile']);

      if ($_SESSION["glpiactiveprofile"]["interface"] == "central") {
         Html::redirect($CFG_GLPI['root_doc']."/front/central.php");
      } else {
         Html::redirect($_SERVER['PHP_SELF']);
      }

   } else {
      Html::redirect(preg_replace("/entities_id=.*/","",$_SERVER['HTTP_REFERER']));
   }
}

// Manage entity change
if (isset($_GET["active_entity"])) {
   if (!isset($_GET["is_recursive"])) {
      $_GET["is_recursive"] = 0;
   }
   if (Session::changeActiveEntities($_GET["active_entity"],$_GET["is_recursive"])) {
      if ($_GET["active_entity"] == $_SESSION["glpiactive_entity"]) {
         Html::redirect(preg_replace("/entities_id.*/","",$_SERVER['HTTP_REFERER']));
      }
   }
}

// Redirect management
if (isset($_GET["redirect"])) {
   Toolbox::manageRedirect($_GET["redirect"]);
}

// redirect if no create ticket right
if (!Session::haveRight('ticket', CREATE)
    && !Session::haveRight('reminder_public', READ)
    && !Session::haveRight("rssfeed_public", READ)) {

   if (Session::haveRight('followup', TicketFollowup::SEEPUBLIC)
       || Session::haveRight('task', TicketTask::SEEPUBLIC)
       || Session::haveRightsOr('ticketvalidation', array(TicketValidation::VALIDATEREQUEST,
                                                          TicketValidation::VALIDATEINCIDENT))) {
      Html::redirect($CFG_GLPI['root_doc']."/front/ticket.php");

   } else if (Session::haveRight('reservation', ReservationItem::RESERVEANITEM)) {
      Html::redirect($CFG_GLPI['root_doc']."/front/reservationitem.php");

   } else if (Session::haveRight('knowbase', KnowbaseItem::READFAQ)) {
      Html::redirect($CFG_GLPI['root_doc']."/front/helpdesk.faq.php");
   }
}

Session::checkHelpdeskAccess();


if (isset($_GET['create_ticket'])) {
   Html::helpHeader(__('New ticket'), $_SERVER['PHP_SELF'], $_SESSION["glpiname"]);
   $ticket = new Ticket();
   $ticket->showFormHelpdesk(Session::getLoginUserID());

} else {
   Html::helpHeader(__('Home'), $_SERVER['PHP_SELF'], $_SESSION["glpiname"]);
   echo '<div class="row">';
   echo '<div class="col-lg-6">';
   if (Session::haveRight('ticket', CREATE)) {
      Ticket::showCentralCount(true);
      Ticket::showCentralList(0, "survey", false);
   }

   
   
   if (Session::haveRight("reminder_public", READ)) {
      Reminder::showListForCentral(false);
   }

   if (Session::haveRight("rssfeed_public", READ)) {
      RSSFeed::showListForCentral(false);
   }


   echo '</div>';
   echo '<div class="col-lg-6">';

   // Show KB items
   if (Session::haveRight('knowbase', KnowbaseItem::READFAQ)) {
      KnowbaseItem::showRecentPopular("popular");
      KnowbaseItem::showRecentPopular("recent");
      KnowbaseItem::showRecentPopular("lastupdate");
   }

   echo '</div>';

}

Html::helpFooter();
?>
