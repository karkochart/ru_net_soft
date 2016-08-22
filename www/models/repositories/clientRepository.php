<?php

class clientRepository
{
    private $userInfoModelClass = 'userinfoModel';
    private $connection;

    public function __construct(PDO $connection = null)
    {
        $this->connection = $connection;
        if ($this->connection === null) {
            $this->connection = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=' . DB_CHARSET, DB_USER, DB_PASS);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->connection->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);


            $this->connection->setAttribute(
                PDO::ATTR_ERRMODE,
                PDO::ERRMODE_EXCEPTION
            );
        }

    }

    public function findUsers($filter)
    {
        $filterArr = json_decode($filter);
        $query = "SELECT u.id AS userId, 
                        u.name AS userName, 
                        q.id AS qualificationId, 
                        q.name AS qualificationName, 
                        GROUP_CONCAT(c.name SEPARATOR ',') AS citiesList
                    FROM users AS u
                    INNER JOIN users_cities AS uc
                        ON (u.id=uc.userId)
                    INNER JOIN cities AS c
                        ON (uc.cityId=c.id)
                    INNER JOIN qualifications AS q
                        ON (q.id=u.qualificationId)";
        if (isset($filterArr->cities)) {
            $cities = $filterArr->cities;
            $citiesIds = $this->getIdsFromObjectList(json_decode($cities));
            if (count($citiesIds) > 0) {
                $citiesIdsStr = implode(',', $citiesIds);
                $query .= " WHERE c.id IN ($citiesIdsStr)";
            }
        }
        if (isset($filterArr->qualifications)) {
            $qualifications = $filterArr->qualifications;
            $qualificationsIds = $this->getIdsFromObjectList(json_decode($qualifications));
            if (count($qualificationsIds) > 0) {
                $qualificationsIdsStr = implode(',', $qualificationsIds);
                $query .= (isset($filterArr->cities) && count($citiesIds) > 0) ? " AND" : " WHERE";
                $query .= " q.id IN ($qualificationsIdsStr)";
            }
        }
        $query .= " GROUP BY u.id";
//        echo "\n" . $query . "\n";
        $stmt = $this->connection->prepare($query);
        $stmt->execute();

        $stmt->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, $this->userInfoModelClass);
        return $stmt->fetchAll();
    }

    public function findUsersJson($filter)
    {
        $objList = $this->findUsers($filter);
        return $this->listToJsonArray($objList);
    }

    private function listToJsonArray($objList)
    {
        $result = '[';
        foreach ($objList as $k => $obj) {
            $result .= $obj . ', ';
        }
        $result = substr($result, 0, strlen($result) - 2);
        $result .= ']';
        return $result;
    }

    private function getIdsFromObjectList($list)
    {
        $arr = array();
        foreach ($list as $k => $item) {
            $arr[] = $item->id;
        }
        return $arr;
    }
}