<?php

    include ("../../../inc/includes.php");

    Session::checkRight("statistic", READ);

    Html::header('Timereport', $_SERVER['PHP_SELF'], "helpdesk", "stat");

    $DBread = DBConnection::getReadConnection();

    if(isset($_GET['startdate'])){
        $startDateObj = new DateTime($_GET['startdate']);
    }else{
        $startDateObj = new DateTime("first day of this month");
    }

    if(isset($_GET['enddate'])){
        $endDateObj = new DateTime($_GET['enddate']);
    }else{
        $endDateObj = new DateTime("today");
    }


    $template = new Template();
    $reportsClass = new PluginReportReports();
    $entity = new Entity();

    $entity->getFromDB($_SESSION['glpiactive_entity']);
    if($entity->canViewItem()){

      $reportsClass->entity = $_SESSION['glpiactive_entity'];
      $reportsClass->startDate = $startDateObj;
      $reportsClass->endDate = $endDateObj;

      $template->assign('customer',$entity->fields['name']);
      $template->assign('startdate',$startDateObj);
      $template->assign('enddate',$endDateObj);
      $template->assign('reports',$reportsClass);
      $template->display('timereport.tpl.php');

    }else{
      echo '<p class="alert alert-danger">you dont have access to this entity</p>';
    }

    Html::footer();
