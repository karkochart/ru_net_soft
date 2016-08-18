<?php

class indexController extends baseController
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $vars['title'] = 'Rus net soft project';
        $this->load->view('index', $vars);
    }
}
