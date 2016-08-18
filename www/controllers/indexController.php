<?php

class indexController extends baseController
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->load->model('posts');
        $vars['title'] = 'Empty project';
        $vars['posts'] = $this->posts->getEntries();
        $this->load->view('index', $vars);
    }
}
