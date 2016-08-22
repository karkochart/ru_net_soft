<?php

class usercityRepository extends baseRepository
{
    private $tName = 'users_cities';
    private $cUserId = 'userId';
    private $cId = 'cityId';

    function find(array $primaryKeys)
    {
        if (
            !isset($primaryKeys[$this->cUserId]) ||
            !isset($primaryKeys[$this->cId])
        ) {
            throw new InvalidArgumentException(
                'InvalidArgumentException: Please set cityId and userId.'
            );
        }
        $stmt = $this->connection->prepare("
            SELECT \"$this->modelClass\", $this->tName.*
             FROM $this->tName 
             WHERE $this->cId = :$this->cId
              AND $this->cUserId = :$this->cUserId
        ");
        $stmt->bindParam(':' . $this->cId, $primaryKeys[$this->cId]);
        $stmt->bindParam(':' . $this->cUserId, $primaryKeys[$this->cUserId]);
        $stmt->execute();

        $stmt->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, $this->modelClass);
        return $stmt->fetch();
    }

    function findByCity($cityId)
    {
        $stmt = $this->connection->prepare("
            SELECT \"$this->modelClass\", $this->tName.*
             FROM $this->tName 
             WHERE $this->cId = :$this->cId
        ");
        $stmt->bindParam(':' . $this->cId, $cityId);
        $stmt->execute();

        $stmt->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, $this->modelClass);
        return $stmt->fetchAll();
    }

    function findAll()
    {
        $stmt = $this->connection->prepare("
            SELECT * FROM $this->tName
        ");
        $stmt->execute();

        $stmt->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, $this->modelClass);
        return $stmt->fetchAll();
    }

    function save(\baseModel $userCity)
    {
        $primaryKeys = array();
        if (
            empty($primaryKeys[$this->cUserId] = $userCity->getUserId()) ||
            empty($primaryKeys[$this->cId] = $userCity->getCityId())
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
            INSERT INTO $this->tName
                ($this->cUserId, $this->cId)
            VALUES
                (:$this->cUserId, :$this->cId)
        ");
        $userId = $primaryKeys[$this->cUserId];
        $cityId = $primaryKeys[$this->cId];
        $stmt->bindParam(':' . $this->cUserId, $userId);
        $stmt->bindParam(':' . $this->cId, $cityId);
        return $stmt->execute();
    }

    function update(\baseModel $usersCities)
    {
        return $usersCities;
    }

    public function delete(array $primaryKeys)
    {
        if (
            !isset($primaryKeys[$this->cUserId]) ||
            !isset($primaryKeys[$this->cId])
        ) {
            throw new \InvalidArgumentException(
                'InvalidArgumentException: Invalid arguments for userId and cityId.'
            );
        }
        if (!is_object($this->find(array($this->cUserId => $primaryKeys[$this->cUserId], $this->cId => $primaryKeys[$this->cId])))) {
            throw new \InvalidArgumentException(
                'InvalidArgumentException: Cannot DELETE user_city that does not yet exist in the database.'
            );
        }
        $stmt = $this->connection->prepare("
            DELETE FROM $this->tName
             WHERE $this->cUserId = :$this->cUserId
              AND $this->cId = :$this->cId
        ");
        $stmt->bindParam(':'.$this->cUserId, $primaryKeys[$this->cUserId]);
        $stmt->bindParam(':'.$this->cId, $primaryKeys[$this->cId]);
        return $stmt->execute();
    }
}