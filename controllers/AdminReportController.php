<?php

namespace app\controllers;

use app\core\BaseController;
use app\models\ReportModel;

class AdminReportController extends BaseController
{
    public function adminReports()
    {
        $this->view->render('adminReports', 'main', null);
    }

    public function getPricePerUser()
    {
        $model = new ReportModel();
        $model->mapData($_GET);
        $model->getPricePerUser();
    }

    public function getClicksByGender()
    {
        $model = new ReportModel();
        $model->mapData($_GET);
        $model->getClicksByGender();
    }

    public function getViewsByGender()
    {
        $model = new ReportModel();
        $model->mapData($_GET);
        $model->getViewsByGender();
    }


    public function getClicksByAgeGroup()
    {
        $model = new ReportModel();
        $model->mapData($_GET);
        $model->getClicksByAgeGroup();
    }

    public function getViewsByAgeGroup()
    {
        $model = new ReportModel();
        $model->mapData($_GET);
        $model->getViewsByAgeGroup();
    }


    public function getClicksByAdOverTime()
    {
        $model = new ReportModel();
        $model->mapData($_GET);
        $model->getClicksByAdOverTime();
    }

    public function getViewsByAdOverTime()
    {
        $model = new ReportModel();
        $model->mapData($_GET);
        $model->getViewsByAdOverTime();
    }



    public function getClicksByUser()
    {
        $model = new ReportModel();
        $model->mapData($_GET);
        $model->getClicksByUser();
    }
    public function getViewsByUser()
    {
        $model = new ReportModel();
        $model->mapData($_GET);
        $model->getViewsByUser();
    }





    public function accessRole(): array
    {
        return ['Administrator'];
    }
}