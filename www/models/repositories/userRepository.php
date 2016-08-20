<?php


//use \PDO;
class userRepository extends baseRepository
{
    private $tableName = 'users';
    private $columnId = 'id';
    private $columnName = 'name';
    private $columnQualificationId = 'qualificationId';

    public function find(array $primaryKeys)
    {
        if (!isset($primaryKeys[$this->columnId])) {
            throw new \InvalidArgumentException(
                'InvalidArgumentException: Please set user id.'
            );
        }
        $stmt = $this->connection->prepare("
            SELECT \"$this->modelClass\", $this->tableName.*
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

    public function save(\baseModel $user)
    {
        //Update User if exists
        if (!empty($user->getId())) {
            $findUser = $this->find(array($this->columnId => $user->getId()));
            if (is_object($findUser) && $findUser->getId() == $user->getId()) {
                return $this->update($user);
            }
        }
        //Add new User
        $stmt = $this->connection->prepare("
            INSERT INTO $this->tableName 
                ( $this->columnName, $this->columnQualificationId) 
            VALUES 
                ( :$this->columnName, :$this->columnQualificationId)
        ");
        $name = $user->getName();
        $qualificationId = $user->getQualificationId();

        $stmt->bindParam(':' . $this->columnName, $name);
        $stmt->bindParam(':' . $this->columnQualificationId, $qualificationId);
        return $stmt->execute();
    }

    public function update(\baseModel $user)
    {
        if (!$this->find(array($this->columnId => $user->getId()))) {
            throw new \InvalidArgumentException(
                'InvalidArgumentException: Cannot update user: ' . $user . ' that does not yet exist in the database.'
            );
        }
        $stmt = $this->connection->prepare("
            UPDATE $this->tableName
            SET $this->columnName = :$this->columnName,
                $this->columnQualificationId = :$this->columnQualificationId
            WHERE $this->columnId = :$this->columnId
        ");

        $id = $user->getId();
        $name = $user->getName();
        $qualificationId = $user->getQualificationId();

        $stmt->bindParam(':' . $this->columnId, $id);
        $stmt->bindParam(':' . $this->columnName, $name);
        $stmt->bindParam(':' . $this->columnQualificationId, $qualificationId);
        return $stmt->execute();
    }

    public function delete(array $primaryKeys)
    {
        if (!isset($primaryKeys[$this->columnId])) {
            throw new \InvalidArgumentException(
                'InvalidArgumentException: Please set user id.'
            );
        }
        if (!is_object($this->find(array($this->columnId => $primaryKeys[$this->columnId])))) {
            throw new \InvalidArgumentException(
                'InvalidArgumentException: Cannot DELETE user that does not yet exist in the database.'
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