<?php


//use \PDO;
class userRepository extends baseRepository
{
    private $tName = 'users';
    private $cId = 'id';
    private $cName = 'name';
    private $cQualificationId = 'qualificationId';

    public function find(array $primaryKeys)
    {
        if (!isset($primaryKeys[$this->cId])) {
            throw new \InvalidArgumentException(
                'InvalidArgumentException: Please set user id.'
            );
        }
        $stmt = $this->connection->prepare("
            SELECT \"$this->modelClass\", $this->tName.*
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

    public function save(\baseModel $user)
    {
        //Update User if exists
        if (!empty($user->getId())) {
            $findUser = $this->find(array($this->cId => $user->getId()));
            if (is_object($findUser) && $findUser->getId() == $user->getId()) {
                return $this->update($user);
            }
        }
        //Add new User
        $stmt = $this->connection->prepare("
            INSERT INTO $this->tName 
                ( $this->cName, $this->cQualificationId) 
            VALUES 
                ( :$this->cName, :$this->cQualificationId)
        ");
        $name = $user->getName();
        $qualificationId = $user->getQualificationId();

        $stmt->bindParam(':' . $this->cName, $name);
        $stmt->bindParam(':' . $this->cQualificationId, $qualificationId);
        return $stmt->execute();
    }

    public function update(\baseModel $user)
    {
        if (!$this->find(array($this->cId => $user->getId()))) {
            throw new \InvalidArgumentException(
                'InvalidArgumentException: Cannot update user: ' . $user . ' that does not yet exist in the database.'
            );
        }
        $stmt = $this->connection->prepare("
            UPDATE $this->tName
            SET $this->cName = :$this->cName,
                $this->cQualificationId = :$this->cQualificationId
            WHERE $this->cId = :$this->cId
        ");

        $id = $user->getId();
        $name = $user->getName();
        $qualificationId = $user->getQualificationId();

        $stmt->bindParam(':' . $this->cId, $id);
        $stmt->bindParam(':' . $this->cName, $name);
        $stmt->bindParam(':' . $this->cQualificationId, $qualificationId);
        return $stmt->execute();
    }

    public function delete(array $primaryKeys)
    {
        if (!isset($primaryKeys[$this->cId])) {
            throw new \InvalidArgumentException(
                'InvalidArgumentException: Please set user id.'
            );
        }
        if (!is_object($this->find(array($this->cId => $primaryKeys[$this->cId])))) {
            throw new \InvalidArgumentException(
                'InvalidArgumentException: Cannot DELETE user that does not yet exist in the database.'
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