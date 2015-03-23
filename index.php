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

// Check PHP version not to have trouble
if (version_compare(PHP_VERSION, "5.3.0") < 0) {
   die("PHP >= 5.3.0 required");
}

define('DO_NOT_CHECK_HTTP_REFERER', 1);
// If config_db doesn't exist -> start installation
define('GLPI_ROOT', dirname(__FILE__));
include (GLPI_ROOT . "/config/based_config.php");

if (!file_exists(GLPI_CONFIG_DIR . "/config_db.php")) {
   include_once (GLPI_ROOT . "/inc/autoload.function.php");
   Html::redirect("install/install.php");
   die();
} else {
   $TRY_OLD_CONFIG_FIRST = true;
   include (GLPI_ROOT . "/inc/includes.php");
   $_SESSION["glpicookietest"] = 'testcookie';

   // For compatibility reason
   if (isset($_GET["noCAS"])) {
      $_GET["noAUTO"] = $_GET["noCAS"];
   }

   Auth::checkAlternateAuthSystems(true, isset($_GET["redirect"])?$_GET["redirect"]:"");

   // Send UTF8 Headers
   header("Content-Type: text/html; charset=UTF-8");

    $login = new Template();

    global $CFG_GLPI;

    $login->assign('pageTitle',__('GLPI - Authentication'));
    $login->assign('CFG_GLPI',$CFG_GLPI);
    $login->assign('loginText',nl2br(Toolbox::unclean_html_cross_side_scripting_deep($CFG_GLPI['text_login'])));
    $login->assign('formAction',$CFG_GLPI["root_doc"]."/front/login.php");
    
    $hiddenInputs = array();
    if (isset($_GET["noAUTO"])) {
        $hiddenInputs[] = '<input type="hidden" name="noAUTO" value="1" />';
    }

   if (isset($_GET["redirect"])) {
       Toolbox::manageRedirect($_GET["redirect"]);
       $hiddenInputs[] = '<input type="hidden" name="redirect" value="'.$_GET['redirect'].'"/>';
   }

    $login->assign('hiddenInputs',$hiddenInputs);

    $login->assign('lostPassword',false);
    if ($CFG_GLPI["use_mailing"] && countElementsInTable('glpi_notifications', "`itemtype`='User' AND `event`='passwordforget' AND `is_active`=1")) {
        $login->assign('lostPassword',true);
        $login->assign('lostPasswordLink', $CFG_GLPI['root_doc']."/front/lostpassword.php?lostpassword=1");
    }
    
    $login->assign('publicFAQ',false);
    if ($CFG_GLPI["use_public_faq"]) {
        $login->assign('publicFAQ',true);
        $login->assign('publicFAQLink', $CFG_GLPI['root_doc']."/front/helpdesk.faq.php");
    }

    if (isset($_GET['error'])) {

        $login->assign('error',true);

        switch ($_GET['error']) {
            case 1 : // cookie error
                $login->assign('errorMsg',__('You must accept cookies to reach this application'));
                break;

            case 2 : // GLPI_SESSION_DIR not writable
                $login->assign('errorMsg',__('Checking write permissions for session files'));
                break;

            case 3 :
                $login->assign('errorMsg',__('Invalid use of session ID'));
                break;
        }
    }

    $login->display('login.tpl.php');


}
// call cron
if (!GLPI_DEMO_MODE) {
   CronTask::callCronForce();
}
