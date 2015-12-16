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
* @since version 0.85
*/

// Direct access to file
if (strpos($_SERVER['PHP_SELF'],"searchrow.php")) {
   include ('../inc/includes.php');
   header("Content-Type: text/html; charset=UTF-8");
   Html::header_nocache();
}

Session::checkLoginUser();

// Non define case
if (isset($_POST["itemtype"])
    && isset($_POST["num"]) ) {

   $options  = Search::getCleanedOptions($_POST["itemtype"]);

   $randrow  = mt_rand();
   $rowid    = 'searchrow'.$_POST['itemtype'].$randrow;

   echo "<div id='$rowid'>";

   echo '<div class="row spaceafter">';
   echo '<div class="col-md-12">';
   // First line display add / delete images for normal and meta search items
   if ($_POST["num"] == 0) {
      $linked = Search::getMetaItemtypeAvailable($_POST["itemtype"]);
      echo '<button class="btn btn-info btn-xs" id="addsearchcriteria'.$randrow.'">';

      echo ' <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>';
            echo __s('Add a search criterion');
      echo '</button> ';


      $js = Html::jsGetElementbyID("addsearchcriteria$randrow").".on('click', function(e) {
            e.preventDefault();
               $.post( '".$CFG_GLPI['root_doc']."/ajax/searchrow.php',
                     { itemtype: '".$_POST["itemtype"]."', num: $nbsearchcountvar })
                        .done(function( data ) {
                        $('#".$rowid."').append(data);
                        });
            $nbsearchcountvar = $nbsearchcountvar +1;});";
      echo Html::scriptBlock($js);


      if (is_array($linked) && (count($linked) > 0)) {

          echo '<button class="btn btn-info btn-xs" id="addmetasearchcriteria'.$randrow.'">';
                  echo ' <span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span>';
                              echo __s('Add a global search criterion');

          echo '</button> ';

         $js = Html::jsGetElementbyID("addmetasearchcriteria$randrow").".on('click', function(e) {
             e.preventDefault();
                  $.post( '".$CFG_GLPI['root_doc']."/ajax/searchmetarow.php',
                        { itemtype: '".$_POST["itemtype"]."', num: $nbmetasearchcountvar })
                           .done(function( data ) {
                           $('#".$rowid."').append(data);
                           });
               $nbmetasearchcountvar = $nbmetasearchcountvar +1;});";
         echo Html::scriptBlock($js);

      }

      // Instanciate an object to access method
      $item = NULL;
      if ($_POST["itemtype"] != 'AllAssets') {
         $item = getItemForItemtype($_POST["itemtype"]);
      }
      if ($item && $item->maybeDeleted()) {
         echo "<input type='hidden' id='is_deleted' name='is_deleted' value='".$p['is_deleted']."'>";
         echo "<button class='btn btn-info btn-xs' onClick = \"toogle('is_deleted','','',''); document.forms['searchform".$_POST["itemtype"]."'].submit();\">";
          echo ' <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>';
         echo !$p['is_deleted']?__s('Show the dustbin'):__s("Don't show deleted items");
         echo '</button> ';
      }
   } else {
     echo '<button class="btn btn-info btn-xs" onclick="'.Html::jsGetElementbyID($rowid).'.remove();"> ';
      //echo __s('Add a search criterion');
      echo ' <span class="glyphicon glyphicon-minus" aria-hidden="true"></span>';
      echo __s('Delete a search criterion');
      echo '</button>';
   }
  echo '</div>';
  echo '</div>';

  echo '<div class="row spaceafter">';

   $criteria = array();

   if (isset($_SESSION['glpisearch'][$_POST["itemtype"]]['criteria'][$_POST["num"]])
       && is_array($_SESSION['glpisearch'][$_POST["itemtype"]]['criteria'][$_POST["num"]])) {
      $criteria = $_SESSION['glpisearch'][$_POST["itemtype"]]['criteria'][$_POST["num"]];
   } else {
      foreach ($options as $key => $val) {
         if (is_array($val)) {
            $criteria['field'] = $key;
            break;
         }
      }
   }

   // Display link item
   if ($_POST["num"] > 0) {
      $value = '';
      if (isset($criteria["link"])) {
         $value = $criteria["link"];
      }
      echo '<div class="col-md-1">';
      Dropdown::showFromArray("criteria[".$_POST["num"]."][link]",
                              Search::getLogicalOperators(),
                              array('value' => $value));

      echo '</div>';
      }

   $selected = $first = '';
   $values   = array();
   // display select box to define search item
   if ($CFG_GLPI['allow_search_view'] == 2) {
      $values['view'] = __('Items seen');
   }

   reset($options);
   $group = '';

   foreach ($options as $key => $val) {
      // print groups
      if (!is_array($val)) {
         $group = $val;
      } else {
         if (!isset($val['nosearch']) || ($val['nosearch'] == false)) {
            $values[$group][$key] = $val["name"];
         }
      }
   }
   if ($CFG_GLPI['allow_search_view'] == 1) {
      $values['view'] = __('Items seen');
   }
   if ($CFG_GLPI['allow_search_all']) {
      $values['all'] = __('All');
   }
   $value = '';

   if (isset($criteria['field'])) {
      $value = $criteria['field'];
   }
   echo '<div class="col-md-3">';
   $rand = Dropdown::showFromArray("criteria[".$_POST["num"]."][field]", $values,array('value' => $value));
   echo '</div>';

   $field_id = Html::cleanId("dropdown_criteria[".$_POST["num"]."][field]$rand");

   $spanid= 'SearchSpan'.$_POST["itemtype"].$_POST["num"];

   $used_itemtype = $_POST["itemtype"];

   // Force Computer itemtype for AllAssets to permit to show specific items
   if ($_POST["itemtype"] == 'AllAssets') {
      $used_itemtype = 'Computer';
   }
    echo '<span id="'.$spanid.'">';
   $_POST['itemtype']   = $used_itemtype;
   $_POST['field']      = $value;
   $_POST['searchtype'] = (isset($criteria['searchtype'])?$criteria['searchtype']:"" );
   $_POST['value']      = (isset($criteria['value'])?stripslashes($criteria['value']):"" );
   include (GLPI_ROOT."/ajax/searchoption.php");
   echo '</div>';


   $params = array('field'      => '__VALUE__',
                   'itemtype'   => $used_itemtype,
                   'num'        => $_POST["num"],
                   'value'      => $_POST["value"],
                   'searchtype' => $_POST["searchtype"]);

   Ajax::updateItemOnSelectEvent($field_id, $spanid,
                                 $CFG_GLPI["root_doc"]."/ajax/searchoption.php", $params);
    echo '</span>';
   echo "</div>";

}
?>
