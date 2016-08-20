<?php

class qualificationRepository extends baseRepository
{
    private $tableName = 'qualifications';
    private $columnId = 'id';
    private $columnName = 'name';

    function find(array $primaryKeys)
    {
        if (!isset($primaryKeys[$this->columnId])) {
            throw new \InvalidArgumentException(
                'InvalidArgumentException: Please set qualification id.'
            );
        }
        $stmt = $this->connection->prepare("
            SELECT \"$this->modelClass\", $this->tableName.*
             FROM $this->tableName 
             WHERE id = :id
       ");
        $stmt->bindParam(':' . $this->columnId, $primaryKeys[$this->columnId]);
        $stmt->execute();

        $stmt->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, $this->modelClass);
        return $stmt->fetch();
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

    function save(\baseModel $qualification)
    {
        //Update qualification if exists
        if (!empty($qualification->getId())) {
            $findqualification = $this->find(array($this->columnId => $qualification->getId()));
            if (is_object($findqualification) && $findqualification->getId() == $qualification->getId()) {
                return $this->update($qualification);
            }
        }
        //Add new qualification
        $stmt = $this->connection->prepare("
            INSERT INTO $this->tableName 
                ($this->columnName) 
            VALUES 
                (:$this->columnName)
       ");
        $name = $qualification->getName();
        $stmt->bindParam(':' . $this->columnName, $name);
        return $stmt->execute();
    }

    function update(\baseModel $qualification)
    {
        if (!$this->find(array($this->columnId => $qualification->getId()))) {
            throw new \InvalidArgumentException(
                'InvalidArgumentException: Cannot update qualification: ' . $qualification . ' that does not yet exist in the database.'
            );
        }
        $stmt = $this->connection->prepare("
            UPDATE $this->tableName
            SET $this->columnName = :$this->columnName
            WHERE $this->columnId = :$this->columnId
       ");
        $id = $qualification->getId();
        $name = $qualification->getName();
        $stmt->bindParam(':' . $this->columnId, $id);
        $stmt->bindParam(':' . $this->columnName, $name);

        return $stmt->execute();
    }

    public function delete(array $primaryKeys)
    {
        if (!isset($primaryKeys[$this->columnId])) {
            throw new \InvalidArgumentException(
                'InvalidArgumentException: Please set qualification id.'
            );
        }
        if (!is_object($this->find(array($this->columnId => $primaryKeys[$this->columnId])))) {
            throw new \InvalidArgumentException(
                'InvalidArgumentException: Cannot DELETE qualification that does not yet exist in the database.'
            );
        }
        $stmt = $this->connection->prepare("
            DELETE FROM $this->tableName
             WHERE $this->columnId = :$this->columnId
       ");
        $stmt->bindParam(':' . $this->columnId, $primaryKeys[$this->columnId]);
        return $stmt->execute();
    }
}