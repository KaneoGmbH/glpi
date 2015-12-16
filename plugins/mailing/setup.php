<?php

function plugin_version_mailing(){

    return array(
        'name'				=> "E-Mail Template",
        'version' 			=> '1.0',
        'author'			=> 'kaneo GmbH',
        'license'		 	=> 'GPLv2+',
        'homepage'			=> 'https://www.kaneo.gmbh.de',
        'minGlpiVersion'	=> '0.84');
}

function plugin_mailing_check_prerequisites(){
    if (GLPI_VERSION>=0.84){
        return true;
    } else {
        echo "GLPI version not compatible need 0.84";
    }
}

function plugin_mailing_check_config($verbose=false){
    return true;
}

function plugin_init_mailing() {
    global $PLUGIN_HOOKS;

    $PLUGIN_HOOKS['csrf_compliant']['report'] = true;

    $PLUGIN_HOOKS['pre_item_add']['mailing']['pre_item_add'] = '';
}

