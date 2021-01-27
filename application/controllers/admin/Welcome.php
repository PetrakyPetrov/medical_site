<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once 'application/core/UI_Admin.php';

class Welcome extends UI_Admin {

    function __construct() {
        parent::__construct();
    }

    public function index() {
        $this->layout('admin/home');
    }
}

