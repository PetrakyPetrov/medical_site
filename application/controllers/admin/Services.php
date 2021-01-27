<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once 'application/core/UI_Admin.php';

class Services extends UI_Admin {

    function __construct() {
        parent::__construct();
    }

    public function index() {
        $crud = new grocery_CRUD();
        $crud->set_table('up_services');
        $crud->set_subject('Манипулации');
        $crud->required_fields('title', 'code', 'short_description', 'description', 'is_active', 'order_id');
        $crud->columns(
            'title', 'code', 'short_description', 'description', 'img_url', 'img_alt', 'is_active', 'order_id'
        );

        $crud->display_as('title', 'Име')
            ->display_as('code', 'Код')
            ->display_as('short_description', 'Кратко описание')
            ->display_as('description', 'Описание')
            ->display_as('img_url', 'Снимка')
            ->display_as('img_alt', 'Име на снимка')
            ->display_as('is_active', 'Активна манипулация')
            ->display_as('order_id', 'Номер по ред');

        $crud->set_field_upload('img_url','assets/uploads/images/services');

        $this->additionalConfig($crud);
        $output = $crud->render();
        $this->groceryOutput($output);
    }
}

