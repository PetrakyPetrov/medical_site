<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once 'application/core/UI_Admin.php';

class Teams extends UI_Admin {

    function __construct() {
        parent::__construct();
    }

    public function index() {
        $crud = new grocery_CRUD();
        $crud->set_table('up_team');
        $crud->set_subject('Екип');
        $crud->required_fields('name', 'job_title', 'short_description', 'is_active', 'order_id');
        $crud->columns(
            'name', 'job_title', 'short_description', 'twitter_url', 'facebook_url', 
            'instagram_url', 'linkedin_url', 'img_url', 'is_active', 'order_id'
        );

        $crud->display_as('name', 'Име')
            ->display_as('job_title', 'Код')
            ->display_as('short_description', 'Кратко описание')
            ->display_as('twitter_url', 'Twitter профил')
            ->display_as('facebook_url', 'Facebook профил')
            ->display_as('instagram_url', 'Instagram профил')
            ->display_as('linkedin_url', 'LinkedIn профил')
            ->display_as('img_url', 'Снимка')
            ->display_as('is_active', 'Активен')
            ->display_as('order_id', 'Номер по ред');

        $crud->set_field_upload('img_url','assets/uploads/images/team');

        $this->additionalConfig($crud);
        $output = $crud->render();
        $this->groceryOutput($output);
    }
}

