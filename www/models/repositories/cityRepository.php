<?php

class cityRepository extends baseRepository
{
    private $tName = 'cities';
    private $cId = 'id';
    private $cName = 'name';

    public function find(array $primaryKeys)
    {
        if (!isset($primaryKeys[$this->cId])) {
            throw new \InvalidArgumentException(
                'InvalidArgumentException: Please set city id.'
            );
        }
        $stmt = $this->connection->prepare("
            SELECT \"$this->modelClass \", $this->tName.*
             FROM $this->tName 
             WHERE $this->cId = :$this->cId
        ");
        $stmt->bindParam(':' . $this->cId, $primaryKeys[$this->cId]);
        $stmt->execute();

        $stmt->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, $this->modelClass);
        return $stmt->fetch();
    }

    public function findAll()
    {
        $stmt = $this->connection->prepare("
            SELECT * FROM $this->tName
        ");
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, $this->modelClass);

        return $stmt->fetchAll();
    }

    public function save(\baseModel $city)
    {
        //Update City if exists
        if (!empty($city->getId())) {
            $findCity = $this->find(array($this->cId => $city->getId()));
            if (is_object($findCity) && $findCity->getId() == $city->getId()) {
                return $this->update($city);
            }
        }
        //Add new City
        $stmt = $this->connection->prepare("
            INSERT INTO cities 
                ($this->cName) 
            VALUES 
                (:$this->cName)
        ");
        $name = $city->getName();
        $stmt->bindParam(':' . $this->cName, $name);
        return $stmt->execute();
    }

    public function update(\baseModel $city)
    {
        if (!is_object($this->find(array($this->cId => $city->getId())))) {
            throw new \InvalidArgumentException(
                'InvalidArgumentException: Cannot UPDATE ' . $city . ' that does not yet exist in the database.'
            );
        }

        $stmt = $this->connection->prepare("
            UPDATE cities
            SET $this->cName = :$this->cName
            WHERE $this->cId = :$this->cId
        ");
        $id = $city->getId();
        $name = $city->getName();
        $stmt->bindParam(':' . $this->cId, $id);
        $stmt->bindParam(':' . $this->cName, $name);
        return $stmt->execute();
    }

    public function delete(array $primaryKeys)
    {
        if (!isset($primaryKeys[$this->cId])) {
            throw new \InvalidArgumentException(
                "InvalidArgumentException: Please set city id."
            );
        }
        if (!is_object($this->find(array($this->cId => $primaryKeys[$this->cId])))) {
            throw new \InvalidArgumentException(
                'InvalidArgumentException: Cannot DELETE city that does not yet exist in the database.'
            );
        }
        $stmt = $this->connection->prepare("
            DELETE FROM cities
             WHERE $this->cId = :$this->cId
        ");
        $stmt->bindParam(':' . $this->cId, $primaryKeys[$this->cId]);
        return $stmt->execute();
    }
}