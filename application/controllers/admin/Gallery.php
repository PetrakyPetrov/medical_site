<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once 'application/core/UI_Admin.php';

class Gallery extends UI_Admin {

    function __construct() {
        parent::__construct();
    }

    public function index() {
        $crud = new grocery_CRUD();
        $crud->set_table('up_gallery');
        $crud->set_subject('Галерия');
        $crud->required_fields('img_name', 'img_url', 'img_alt', 'is_active', 'order_id');
        $crud->columns('img_name', 'img_url', 'img_alt', 'is_active', 'order_id');

        $crud->display_as('img_name', 'Описание на снимка')
            ->display_as('img_url', 'Снимка')
            ->display_as('img_alt', 'Име на снимка')
            ->display_as('is_active', 'Активен')
            ->display_as('order_id', 'Номер по ред');

        $crud->set_field_upload('img_url','assets/uploads/images/gallery');

        $this->additionalConfig($crud);
        $output = $crud->render();
        $this->groceryOutput($output);
    }
}

