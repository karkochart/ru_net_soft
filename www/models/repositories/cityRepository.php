<?php

class cityRepository extends baseRepository
{
    private $tableName = 'cities';
    private $columnId = 'id';
    private $columnName = 'name';

    public function find(array $primaryKeys)
    {
        if (!isset($primaryKeys[$this->columnId])) {
            throw new \InvalidArgumentException(
                'InvalidArgumentException: Please set city id.'
            );
        }
        $stmt = $this->connection->prepare("
            SELECT \"$this->modelClass \", $this->tableName.*
             FROM $this->tableName 
             WHERE $this->columnId = :$this->columnId
        ");
        $stmt->bindParam(':' . $this->columnId, $primaryKeys[$this->columnId]);
        $stmt->execute();

        $stmt->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, $this->modelClass);
        return $stmt->fetch();
    }

    public function findAll()
    {
        $stmt = $this->connection->prepare("
            SELECT * FROM $this->tableName
        ");
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, $this->modelClass);

        return $stmt->fetchAll();
    }

    public function save(\baseModel $city)
    {
        //Update City if exists
        if (!empty($city->getId())) {
            $findCity = $this->find(array($this->columnId => $city->getId()));
            if (is_object($findCity) && $findCity->getId() == $city->getId()) {
                return $this->update($city);
            }
        }
        //Add new City
        $stmt = $this->connection->prepare("
            INSERT INTO cities 
                ($this->columnName) 
            VALUES 
                (:$this->columnName)
        ");
        $name = $city->getName();
        $stmt->bindParam(':' . $this->columnName, $name);
        return $stmt->execute();
    }

    public function update(\baseModel $city)
    {
        if (!is_object($this->find(array($this->columnId => $city->getId())))) {
            throw new \InvalidArgumentException(
                'InvalidArgumentException: Cannot UPDATE ' . $city . ' that does not yet exist in the database.'
            );
        }

        $stmt = $this->connection->prepare("
            UPDATE cities
            SET $this->columnName = :$this->columnName
            WHERE $this->columnId = :$this->columnId
        ");
        $id = $city->getId();
        $name = $city->getName();
        $stmt->bindParam(':' . $this->columnId, $id);
        $stmt->bindParam(':' . $this->columnName, $name);
        return $stmt->execute();
    }

    public function delete(array $primaryKeys)
    {
        if (!isset($primaryKeys[$this->columnId])) {
            throw new \InvalidArgumentException(
                "InvalidArgumentException: Please set city id."
            );
        }
        if (!is_object($this->find(array($this->columnId => $primaryKeys[$this->columnId])))) {
            throw new \InvalidArgumentException(
                'InvalidArgumentException: Cannot DELETE city that does not yet exist in the database.'
            );
        }
        $stmt = $this->connection->prepare("
            DELETE FROM cities
             WHERE $this->columnId = :$this->columnId
        ");
        $stmt->bindParam(':' . $this->columnId, $primaryKeys[$this->columnId]);
        return $stmt->execute();
    }
}