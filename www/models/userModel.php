<?php

class userModel extends baseModel
{
    private $id;
    private $name;
    private $qualificationId;

    public function __construct($data = null)
    {
        if (is_array($data)) {
            if (isset($data['id'])) $this->id = $data['id'];
            $this->name = $data['name'];
            $this->qualificationId = $data['qualificationId'];
        }
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getQualificationId()
    {
        return $this->qualificationId;
    }

    /**
     * @param mixed $qualificationId
     */
    public function setQualificationId($qualificationId)
    {
        $this->qualificationId = $qualificationId;
    }

    public function __toString()
    {
        return "{"
        . "\"id\" : \"$this->id\","
        . "\"name\" : \"$this->name\","
        . "\"qualificationId\" : \"$this->qualificationId\""
        . "}";
    }

}