<?php

class usercityRepository extends baseRepository
{
    private $tableName = 'users_cities';
    private $columnUserId = 'userId';
    private $columnCityId = 'cityId';

    function find(array $primaryKeys)
    {
        if (
            !isset($primaryKeys[$this->columnUserId]) ||
            !isset($primaryKeys[$this->columnCityId])
        ) {
            throw new InvalidArgumentException(
                'InvalidArgumentException: Please set cityId and userId.'
            );
        }
        $stmt = $this->connection->prepare("
            SELECT \"$this->modelClass\", $this->tableName.*
             FROM $this->tableName 
             WHERE $this->columnCityId = :$this->columnCityId
              AND $this->columnUserId = :$this->columnUserId
        ");
        $stmt->bindParam(':' . $this->columnCityId, $primaryKeys[$this->columnCityId]);
        $stmt->bindParam(':' . $this->columnUserId, $primaryKeys[$this->columnUserId]);
        $stmt->execute();

        $stmt->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, $this->modelClass);
        return $stmt->fetch();
    }

    function findByCity($cityId)
    {
        $stmt = $this->connection->prepare("
            SELECT \"$this->modelClass\", $this->tableName.*
             FROM $this->tableName 
             WHERE $this->columnCityId = :$this->columnCityId
        ");
        $stmt->bindParam(':' . $this->columnCityId, $cityId);
        $stmt->execute();

        $stmt->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, $this->modelClass);
        return $stmt->fetchAll();
    }

    function findAll()
    {
        $stmt = $this->connection->prepare("
            SELECT * FROM $this->tableName
        ");
        $stmt->execute();

        $stmt->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, $this->modelClass);
        return $stmt->fetchAll();
    }

    function save(\baseModel $userCity)
    {
        $primaryKeys = array();
        if (
            empty($primaryKeys[$this->columnUserId] = $userCity->getUserId()) ||
            empty($primaryKeys[$this->columnCityId] = $userCity->getCityId())
        ) {
            throw new InvalidArgumentException (
                'InvalidArgumentException: Invalid arguments for userId and cityId.'
            );
        }
        $findUsersCities = $this->find($primaryKeys);
        if (is_object($findUsersCities)) {
            throw new InvalidArgumentException (
                'InvalidArgumentException: This user_city already exists.'
            );
        }
        //Add new UserCity
        $stmt = $this->connection->prepare("
            INSERT INTO $this->tableName
                ($this->columnUserId, $this->columnCityId)
            VALUES
                (:$this->columnUserId, :$this->columnCityId)
        ");
        $userId = $primaryKeys[$this->columnUserId];
        $cityId = $primaryKeys[$this->columnCityId];
        $stmt->bindParam(':' . $this->columnUserId, $userId);
        $stmt->bindParam(':' . $this->columnCityId, $cityId);
        return $stmt->execute();
    }

    function update(\baseModel $usersCities)
    {
        return $usersCities;
    }

    public function delete(array $primaryKeys)
    {
        if (
            !isset($primaryKeys[$this->columnUserId]) ||
            !isset($primaryKeys[$this->columnCityId])
        ) {
            throw new \InvalidArgumentException(
                'InvalidArgumentException: Invalid arguments for userId and cityId.'
            );
        }
        if (!is_object($this->find(array($this->columnUserId => $primaryKeys[$this->columnUserId], $this->columnCityId => $primaryKeys[$this->columnCityId])))) {
            throw new \InvalidArgumentException(
                'InvalidArgumentException: Cannot DELETE user_city that does not yet exist in the database.'
            );
        }
        $stmt = $this->connection->prepare("
            DELETE FROM $this->tableName
             WHERE $this->columnUserId = :$this->columnUserId
              AND $this->columnCityId = :$this->columnCityId
        ");
        $stmt->bindParam(':'.$this->columnUserId, $primaryKeys[$this->columnUserId]);
        $stmt->bindParam(':'.$this->columnCityId, $primaryKeys[$this->columnCityId]);
        return $stmt->execute();
    }
}