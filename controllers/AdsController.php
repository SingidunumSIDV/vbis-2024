<?php

namespace app\controllers;

use app\core\Application;
use app\core\BaseController;
use app\models\AdsModel;
use app\models\ProductModel;
use app\models\UserModel;

class AdsController extends BaseController
{

    public function ads()
    {
        $model = new AdsModel();

//        $results = $model->all("");
        $results = $model->getAdsWithSiteData();

        $this->view->render('ads', 'main', $results);
    }

    public function update()
    {
        $model = new AdsModel();

        $model->mapData($_GET);

        $model->one("where id = $model->id");

        $this->view->render('updateAd', 'main', $model);
    }

    public function processUpdate()
    {
        $model = new AdsModel();

        $model->mapData($_POST);

        $model->validate();

        if ($model->errors) {
            Application::$app->session->set('errorNotification', 'Neuspesna promena!');
            $this->view->render('updateAd', 'main', $model);
            exit;
        }

        $model->update("where id = $model->id");

        Application::$app->session->set('successNotification', 'Uspesna promena!');

        header("location:" . "/ads");
    }

    public function accessRole(): array
    {
        return ['Korisnik', 'Administrator'];
    }
}