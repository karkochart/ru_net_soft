<?php

abstract class baseRepository
{

    protected $connection;
    protected $modelClass;

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
        $this->modelClass = str_replace('Repository', 'Model', static::class);
    }

    /**
     * @param $primaryKeys array
     * @return mixed
     */
    abstract public function find(array $primaryKeys);

    abstract public function findAll();

    abstract public function save(\baseModel $object);

    abstract public function update(\baseModel $object);

    abstract public function delete(array $primaryKeys);

    public function findAllJson()
    {
        $array = $this->findAll();
        $result = '[';
        foreach ($array as $k => $obj) {
            $result .= $obj . ', ';
        }
        $result = substr($result, 0, strlen($result) - 2);
        $result .= ']';
        return $result;
    }
}