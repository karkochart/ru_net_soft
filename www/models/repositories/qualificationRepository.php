<?php

class qualificationRepository extends baseRepository
{
    private $tName = 'qualifications';
    private $cId = 'id';
    private $cName = 'name';

    function find(array $primaryKeys)
    {
        if (!isset($primaryKeys[$this->cId])) {
            throw new \InvalidArgumentException(
                'InvalidArgumentException: Please set qualification id.'
            );
        }
        $stmt = $this->connection->prepare("
            SELECT \"$this->modelClass\", $this->tName.*
             FROM $this->tName 
             WHERE id = :id
       ");
        $stmt->bindParam(':' . $this->cId, $primaryKeys[$this->cId]);
        $stmt->execute();

        $stmt->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, $this->modelClass);
        return $stmt->fetch();
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

    function save(\baseModel $qualification)
    {
        //Update qualification if exists
        if (!empty($qualification->getId())) {
            $findqualification = $this->find(array($this->cId => $qualification->getId()));
            if (is_object($findqualification) && $findqualification->getId() == $qualification->getId()) {
                return $this->update($qualification);
            }
        }
        //Add new qualification
        $stmt = $this->connection->prepare("
            INSERT INTO $this->tName 
                ($this->cName) 
            VALUES 
                (:$this->cName)
       ");
        $name = $qualification->getName();
        $stmt->bindParam(':' . $this->cName, $name);
        return $stmt->execute();
    }

    function update(\baseModel $qualification)
    {
        if (!$this->find(array($this->cId => $qualification->getId()))) {
            throw new \InvalidArgumentException(
                'InvalidArgumentException: Cannot update qualification: ' . $qualification . ' that does not yet exist in the database.'
            );
        }
        $stmt = $this->connection->prepare("
            UPDATE $this->tName
            SET $this->cName = :$this->cName
            WHERE $this->cId = :$this->cId
       ");
        $id = $qualification->getId();
        $name = $qualification->getName();
        $stmt->bindParam(':' . $this->cId, $id);
        $stmt->bindParam(':' . $this->cName, $name);

        return $stmt->execute();
    }

    public function delete(array $primaryKeys)
    {
        if (!isset($primaryKeys[$this->cId])) {
            throw new \InvalidArgumentException(
                'InvalidArgumentException: Please set qualification id.'
            );
        }
        if (!is_object($this->find(array($this->cId => $primaryKeys[$this->cId])))) {
            throw new \InvalidArgumentException(
                'InvalidArgumentException: Cannot DELETE qualification that does not yet exist in the database.'
            );
        }
        $stmt = $this->connection->prepare("
            DELETE FROM $this->tName
             WHERE $this->cId = :$this->cId
       ");
        $stmt->bindParam(':' . $this->cId, $primaryKeys[$this->cId]);
        return $stmt->execute();
    }
}