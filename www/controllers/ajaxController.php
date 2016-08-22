<?php

class ajaxController extends baseController
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {

    }

    public function getAllUsersWithCity()
    {
        $client = new clientRepository();
        echo $client->findUsersJson(null);
    }

    public function getAllCities()
    {
        $cityClient = new cityRepository();
        echo $cityClient->findAllJson();
    }

    public function getAllQualifications()
    {
        $qualificationClient = new qualificationRepository();
        echo $qualificationClient->findAllJson();
    }

    public function getUsers($filter)
    {
        $client = new clientRepository();
        echo $client->findUsersJson($filter);
    }
}
