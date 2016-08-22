<?php

class userinfoModel
{
    private $userId;
    private $userName;
    private $qualificationId;
    private $qualificationName;
    private $citiesList;

    public function __construct($data = null)
    {
        if (isset($data['userId'])) $this->userId = $data['userId'];
        if (isset($data['userName'])) $this->userName = $data['userName'];
        if (isset($data['qualificationId'])) $this->qualificationId = $data['qualificationId'];
        if (isset($data['qualificationName'])) $this->qualificationName = $data['qualificationName'];
        if (isset($data['citiesList'])) $this->citiesList = $data['citiesList'];
    }

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @param mixed $userId
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;
    }

    /**
     * @return mixed
     */
    public function getUserName()
    {
        return $this->userName;
    }

    /**
     * @param mixed $userName
     */
    public function setUserName($userName)
    {
        $this->userName = $userName;
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

    /**
     * @return mixed
     */
    public function getQualificationName()
    {
        return $this->qualificationName;
    }

    /**
     * @param mixed $qualificationName
     */
    public function setQualificationName($qualificationName)
    {
        $this->qualificationName = $qualificationName;
    }

    /**
     * @return mixed
     */
    public function getCitiesList()
    {
        return $this->citiesList;
    }

    /**
     * @param mixed $citiesList
     */
    public function setCitiesList($citiesList)
    {
        $this->citiesList = $citiesList;
    }

    function __toString()
    {
        return "{" .
        "\"userId\" : $this->userId, " .
        "\"userName\" : \"$this->userName\", " .
        "\"qualificationId\" : \"$this->qualificationId\", " .
        "\"qualificationName\" : \"$this->qualificationName\", " .
        "\"citiesList\" : \"$this->citiesList\" " .
        " }";
    }


}