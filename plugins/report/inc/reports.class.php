<?php

class PluginReportReports extends CommonDBTM {

    static function getMenuContent(){
        $menu['title']                              = __('Reports');
        $menu['page']                               = '/plugins/report/front/timereport.php';
        return $menu;

    }

}