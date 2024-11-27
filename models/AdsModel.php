<?php

namespace app\models;

use app\core\BaseModel;

class AdsModel extends BaseModel
{
    public int $id;
    public string $text = '';
    public string $description = '';
    public int $site_id;
    public int $user_id;

    public function tableName()
    {
        return "ads";
    }

    public function readColumns()
    {
        return ["id", "text", "description", "site_id", "user_id"];
    }

    public function editColumns()
    {
        return ["text", "description"];
    }

    public function validationRules(): array
    {
        return [
            "text" => [self::RULE_REQUIRED],
            "description" => [self::RULE_REQUIRED],
        ];
    }

    /**
     * Get data from `ads` table and join it with data from `sites` table.
     *
     * @param string $where Optional WHERE clause for filtering.
     * @return array Combined data from `ads` and `sites` tables.
     */
    public function getAdsWithSiteData(string $where = "")
    {
        $adsTable = $this->tableName(); // `ads`
        $sitesTable = "sites"; // Assuming the table name is `sites`

        // Define the columns you want to fetch
        $adsColumns = $this->readColumns();
        $sitesColumns = ["name as site_name", "url as site_url"]; // Example columns from the `sites` table

        // Build the query
//        $query = "SELECT " . implode(",", $adsColumns) . ", " . implode(",", $sitesColumns) .
//            " FROM $adsTable
//                 INNER JOIN $sitesTable ON $adsTable.site_id = $sitesTable.id $where";

        $query = "SELECT ads.id, ads.text, ads.description, ads.site_id, ads.user_id, sites.url AS site_url FROM ads INNER JOIN sites ON ads.site_id = sites.id ";

        $dbResult = $this->con->query($query);

        $resultArray = [];
        while ($result = $dbResult->fetch_assoc()) {
            $resultArray[] = $result;
        }

        return $resultArray;
    }
}