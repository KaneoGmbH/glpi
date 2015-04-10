<?php

function plugin_version_mdknowbase() {

   	return array('name'           => "mdknowbase",
                 'version'        => '1.0.1',
                 'author'         => 'kaneo GmbH',
                 'license'        => 'GPLv2+',
                 'homepage'       => 'https://www.kaneo-gmbh.de',
                 'minGlpiVersion' => '0.84');
}

function plugin_mdknowbase_check_prerequisites() {
   	return true;
}

function plugin_mdknowbase_check_config() {

   	return true;
}

function plugin_init_mdknowbase() {

   	
   	global $PLUGIN_HOOKS;

	$PLUGIN_HOOKS['csrf_compliant']['mdknowbase'] = true;
        $PLUGIN_HOOKS['add_javascript']['mdknowbase'] = array("highlight.min.js","scripts.js");

        $PLUGIN_HOOKS['add_css']['mdknowbase']="highlight.min.css";
            
        //Plugin::registerClass('PluginMdKnowbase');
                

}