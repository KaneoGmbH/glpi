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

if (!defined('GLPI_ROOT')) {
    die("Sorry. You can't access directly to this file");
}

include_once (GLPI_ROOT . "/lib/Savant3/Savant3.php");

/**
 * Template Class
 **/
class Template extends Savant3 {

    function __construct($config = null){
        global $CFG_GLPI;

        if (!isset($config['template_path'])) {
//            $config['template_path'][] = GLPI_ROOT.'/templates/core';
            $config['template_path'][] = GLPI_ROOT.'/themes/core/templates';

        }
        $plugins = glob(GLPI_ROOT.'/plugins/*/templates',GLOB_ONLYDIR);
        if($plugins){
            foreach($plugins as $plugin){
                $config['template_path'][] = $plugin;
            }
        }

        parent::__construct($config);

        $this->assign('CFG_GLPI',$CFG_GLPI);

    }

    public function __call($func, $args)
    {
        global $CFG_GLPI;
        $plugin = $this->plugin($func);

        if ($this->isError($plugin)) {
            return $plugin;
        }

        if($func == 'img'){
            if(file_exists(GLPI_ROOT.'/themes/custom/res/images/'.$args[0])){
                $args[0] = $CFG_GLPI['root_doc'].'/themes/custom/res/images/'.$args[0];
            }else{
                $args[0] = $CFG_GLPI['root_doc'].'/themes/core/res/images/'.$args[0];

            }
        }

        return parent::__call($func,$args);

    }

}
