<?php

function plugin_version_report(){

    return array(
        'name'				=> "Timereport",
        'version' 			=> '1.0',
        'author'			=> 'kaneo GmbH',
        'license'		 	=> 'GPLv2+',
        'homepage'			=> 'https://www.kaneo.gmbh.de',
        'minGlpiVersion'	=> '0.84');
}

function plugin_report_check_prerequisites(){
    if (GLPI_VERSION>=0.84){
        return true;
    } else {
        echo "GLPI version not compatible need 0.84";
    }
}

function plugin_report_check_config($verbose=false){
    return true;
}

function plugin_init_report() {
    global $PLUGIN_HOOKS;

    $PLUGIN_HOOKS['csrf_compliant']['report'] = true;
    Plugin::registerClass('PluginReportReports');
    $PLUGIN_HOOKS['menu_toadd']['report']['helpdesk'] = 'PluginReportReports';

}

