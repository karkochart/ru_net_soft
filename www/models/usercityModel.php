<?php

class usercityModel extends baseModel
{
    private $userId;
    private $cityId;

    public function __construct($data = null)
    {
        $this->userId = $data['userId'];
        $this->cityId = $data['cityId'];
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
    public function getCityId()
    {
        return $this->cityId;
    }

    /**
     * @param mixed $cityId
     */
    public function setCityId($cityId)
    {
        $this->cityId = $cityId;
    }

    public function __toString()
    {
        return "{"
        . "\"userId\" : \"$this->userId\","
        . "\"cityId\" : \"$this->cityId\""
        . "}";
    }



}