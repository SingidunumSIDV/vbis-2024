<?php

namespace app\models;

use app\core\Application;
use app\core\BaseModel;
use DateTime;

class ReportModel extends BaseModel
{
    public string $from = '';
    public string $to = '';

    public function getNumberOfReservationsPerMonth()
    {
        $id_user = 0;
        $sessions = Application::$app->session->get('user');

        foreach ($sessions as $session) {
            $id_user = $session['id_user'];
        }

        $dbResult = $this->con->query("SELECT MONTHNAME(reservation_time) as 'month', count(id) as 'number_of_reservations' FROM reservations where id_user = $id_user group by MONTHNAME(reservation_time);");

        $resultArray = [];

        while ($result = $dbResult->fetch_assoc()) {
            $resultArray[] = $result;
        }

        echo json_encode($resultArray);
    }

    public function getPricePerMonth()
    {
        $id_user = 0;
        $sessions = Application::$app->session->get('user');

        foreach ($sessions as $session) {
            $id_user = $session['id_user'];
        }
        var_dump($id_user);
        exit;
        $dbResult = $this->con->query("SELECT MONTHNAME(reservation_time) as 'month',  sum(price) as 'price' FROM reservations where id_user = $id_user group by MONTHNAME(reservation_time);");

        $resultArray = [];

        while ($result = $dbResult->fetch_assoc()) {
            $resultArray[] = $result;
        }

        echo json_encode($resultArray);
    }

    public function getPricePerUser()
    {
        if (!$this->from || $this->from == '') {
            $fromDate = new DateTime('2024-01-01');
            $this->from = $fromDate->format('Y-m-d');
        }

        if (!$this->to  || $this->to == '') {
            $toDate = new DateTime();
            $this->to = $toDate->format('Y-m-d');
        }

        $dbResult = $this->con->query("select u.email,
                                                     sum(price) as price
                                              from reservations r
                                              left join users u on r.id_user = u.id
                                              where date(reservation_time) between  '$this->from' and  '$this->to'
                                              group by u.email;");

        $resultArray = [];

        while ($result = $dbResult->fetch_assoc()) {
            $resultArray[] = $result;
        }

        echo json_encode($resultArray);
    }

    public function getClicksByGender()
    {
        // Provera i postavljanje datuma 'from'
        if (!$this->from || $this->from == '') {
            $fromDate = new DateTime('2024-01-01');
            $this->from = $fromDate->format('Y-m-d');
        }

        // Provera i postavljanje datuma 'to'
        if (!$this->to || $this->to == '') {
            $toDate = new DateTime();
            $this->to = $toDate->format('Y-m-d');
        }

        // SQL upit za klikove po polu
        $dbResult = $this->con->query("SELECT 
                                       gender_id,
                                       COUNT(*) AS clicks
                                   FROM ad_clicks
                                   WHERE DATE(created_date) BETWEEN '$this->from' AND '$this->to'
                                   GROUP BY gender_id;");

        // Inicijalizacija niza za rezultate
        $resultArray = [];

        // Popunjavanje rezultata iz baze
        while ($result = $dbResult->fetch_assoc()) {
            $resultArray[] = $result;
        }

        // Vraćanje rezultata kao JSON
        echo json_encode($resultArray);
    }

    public function getViewsByGender()
    {
        // Provera i postavljanje datuma 'from'
        if (!$this->from || $this->from == '') {
            $fromDate = new DateTime('2024-01-01');
            $this->from = $fromDate->format('Y-m-d');
        }

        // Provera i postavljanje datuma 'to'
        if (!$this->to || $this->to == '') {
            $toDate = new DateTime();
            $this->to = $toDate->format('Y-m-d');
        }

        // SQL upit za klikove po polu
        $dbResult = $this->con->query("SELECT 
                                       gender_id,
                                       COUNT(*) AS views
                                   FROM ad_views
                                   WHERE DATE(created_date) BETWEEN '$this->from' AND '$this->to'
                                   GROUP BY gender_id;");

        // Inicijalizacija niza za rezultate
        $resultArray = [];

        // Popunjavanje rezultata iz baze
        while ($result = $dbResult->fetch_assoc()) {
            $resultArray[] = $result;
        }

        // Vraćanje rezultata kao JSON
        echo json_encode($resultArray);
    }
    public function getClicksByAgeGroup()
    {
        // Provera i postavljanje datuma 'from'
        if (!$this->from || $this->from == '') {
            $fromDate = new DateTime('2024-01-01');
            $this->from = $fromDate->format('Y-m-d');
        }

        // Provera i postavljanje datuma 'to'
        if (!$this->to || $this->to == '') {
            $toDate = new DateTime();
            $this->to = $toDate->format('Y-m-d');
        }

        // SQL upit za klikove po starosnim grupama
        $dbResult = $this->con->query("SELECT 
                                       CASE
                                           WHEN user_years BETWEEN 20 AND 30 THEN '20–30'
                                           WHEN user_years BETWEEN 31 AND 40 THEN '31–40'
                                           WHEN user_years BETWEEN 41 AND 50 THEN '41–50'
                                           WHEN user_years BETWEEN 51 AND 60 THEN '51–60'
                                           ELSE '61+'
                                       END AS age_group,
                                       COUNT(*) AS clicks
                                   FROM ad_clicks
                                   WHERE DATE(created_date) BETWEEN '$this->from' AND '$this->to'
                                   GROUP BY age_group
                                   ORDER BY age_group;");

        // Inicijalizacija niza za rezultate
        $resultArray = [];

        // Popunjavanje rezultata iz baze
        while ($result = $dbResult->fetch_assoc()) {
            $resultArray[] = $result;
        }

        // Vraćanje rezultata kao JSON
        echo json_encode($resultArray);
    }

    public function getViewsByAgeGroup()
    {
        // Provera i postavljanje datuma 'from'
        if (!$this->from || $this->from == '') {
            $fromDate = new DateTime('2024-01-01');
            $this->from = $fromDate->format('Y-m-d');
        }

        // Provera i postavljanje datuma 'to'
        if (!$this->to || $this->to == '') {
            $toDate = new DateTime();
            $this->to = $toDate->format('Y-m-d');
        }

        // SQL upit za klikove po starosnim grupama
        $dbResult = $this->con->query("SELECT 
                                       CASE
                                           WHEN user_years BETWEEN 20 AND 30 THEN '20–30'
                                           WHEN user_years BETWEEN 31 AND 40 THEN '31–40'
                                           WHEN user_years BETWEEN 41 AND 50 THEN '41–50'
                                           WHEN user_years BETWEEN 51 AND 60 THEN '51–60'
                                           ELSE '61+'
                                       END AS age_group,
                                       COUNT(*) AS views
                                   FROM ad_views
                                   WHERE DATE(created_date) BETWEEN '$this->from' AND '$this->to'
                                   GROUP BY age_group
                                   ORDER BY age_group;");

        // Inicijalizacija niza za rezultate
        $resultArray = [];

        // Popunjavanje rezultata iz baze
        while ($result = $dbResult->fetch_assoc()) {
            $resultArray[] = $result;
        }

        // Vraćanje rezultata kao JSON
        echo json_encode($resultArray);
    }

    public function getClicksByAdOverTime()
    {
        // Provera i postavljanje datuma 'from'
        if (!$this->from || $this->from == '') {
            $fromDate = new DateTime('2024-01-01');
            $this->from = $fromDate->format('Y-m-d');
        }

        // Provera i postavljanje datuma 'to'
        if (!$this->to || $this->to == '') {
            $toDate = new DateTime();
            $this->to = $toDate->format('Y-m-d');
        }

        // SQL upit za broj klikova po oglasu tokom vremena
        $dbResult = $this->con->query("SELECT 
                                       a.text AS ad_text,
                                       DATE(ac.created_date) AS click_date,
                                       COUNT(ac.id) AS click_count
                                   FROM ad_clicks ac
                                   JOIN ads a ON ac.ad_id = a.id
                                   WHERE DATE(ac.created_date) BETWEEN '$this->from' AND '$this->to'
                                   GROUP BY a.text, DATE(ac.created_date)
                                   ORDER BY a.text, click_date;");

        // Inicijalizacija niza za rezultate
        $resultArray = [];

        // Popunjavanje rezultata iz baze
        while ($result = $dbResult->fetch_assoc()) {
            $resultArray[] = $result;
        }

        // Vraćanje rezultata kao JSON
        echo json_encode($resultArray);
    }

    public function getViewsByAdOverTime()
    {
        // Provera i postavljanje datuma 'from'
        if (!$this->from || $this->from == '') {
            $fromDate = new DateTime('2024-01-01');
            $this->from = $fromDate->format('Y-m-d');
        }

        // Provera i postavljanje datuma 'to'
        if (!$this->to || $this->to == '') {
            $toDate = new DateTime();
            $this->to = $toDate->format('Y-m-d');
        }

        // SQL upit za broj klikova po oglasu tokom vremena
        $dbResult = $this->con->query("SELECT 
                                       a.text AS ad_text,
                                       DATE(ac.created_date) AS view_date,
                                       COUNT(ac.id) AS view_count
                                   FROM ad_views ac
                                   JOIN ads a ON ac.ad_id = a.id
                                   WHERE DATE(ac.created_date) BETWEEN '$this->from' AND '$this->to'
                                   GROUP BY a.text, DATE(ac.created_date)
                                   ORDER BY a.text, view_date;");

        // Inicijalizacija niza za rezultate
        $resultArray = [];

        // Popunjavanje rezultata iz baze
        while ($result = $dbResult->fetch_assoc()) {
            $resultArray[] = $result;
        }

        // Vraćanje rezultata kao JSON
        echo json_encode($resultArray);
    }
    public function getClicksByUser()
    {
        // Provera i postavljanje datuma 'from'
        if (!$this->from || $this->from == '') {
            $fromDate = new DateTime('2024-01-01');
            $this->from = $fromDate->format('Y-m-d');
        }

        // Provera i postavljanje datuma 'to'
        if (!$this->to || $this->to == '') {
            $toDate = new DateTime();
            $this->to = $toDate->format('Y-m-d');
        }

        // SQL upit za broj klikova po korisnicima
        $dbResult = $this->con->query("SELECT 
                                       CONCAT(u.first_name, ' ', u.last_name) AS user_name,
                                       COUNT(ac.id) AS click_count
                                   FROM ad_clicks ac
                                   JOIN ads a ON ac.ad_id = a.id
                                   JOIN users u ON a.user_id = u.id
                                   WHERE DATE(ac.created_date) BETWEEN '$this->from' AND '$this->to'
                                   GROUP BY u.id
                                   ORDER BY click_count DESC;");

        // Inicijalizacija niza za rezultate
        $resultArray = [];

        // Popunjavanje rezultata iz baze
        while ($result = $dbResult->fetch_assoc()) {
            $resultArray[] = $result;
        }

        // Vraćanje rezultata kao JSON
        echo json_encode($resultArray);
    }
    public function getViewsByUser()
    {
        // Provera i postavljanje datuma 'from'
        if (!$this->from || $this->from == '') {
            $fromDate = new DateTime('2024-01-01');
            $this->from = $fromDate->format('Y-m-d');
        }

        // Provera i postavljanje datuma 'to'
        if (!$this->to || $this->to == '') {
            $toDate = new DateTime();
            $this->to = $toDate->format('Y-m-d');
        }

        // SQL upit za broj klikova po korisnicima
        $dbResult = $this->con->query("SELECT 
                                       CONCAT(u.first_name, ' ', u.last_name) AS user_name,
                                       COUNT(ac.id) AS views_count
                                   FROM ad_views ac
                                   JOIN ads a ON ac.ad_id = a.id
                                   JOIN users u ON a.user_id = u.id
                                   WHERE DATE(ac.created_date) BETWEEN '$this->from' AND '$this->to'
                                   GROUP BY u.id
                                   ORDER BY views_count DESC;");

        // Inicijalizacija niza za rezultate
        $resultArray = [];

        // Popunjavanje rezultata iz baze
        while ($result = $dbResult->fetch_assoc()) {
            $resultArray[] = $result;
        }

        // Vraćanje rezultata kao JSON
        echo json_encode($resultArray);
    }

    public function tableName()
    {
        return '';
    }

    public function readColumns()
    {
        return [];
    }

    public function editColumns()
    {
        return [];
    }

    public function validationRules()
    {
        return [];
    }
}