<?php

function plugin_mdknowbase_install() {
  
    CronTask::Register('PluginMdknowbaseCron', 'Parser', 60, $options=array('mode' => CronTask::MODE_INTERNAL,'allowmode' => 3));
    
    return true;
    
}

function plugin_mdknowbase_uninstall() {
    
    return true;
    
}




